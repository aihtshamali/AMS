<?php

namespace App\Http\Controllers;
use App\Driver;
use App\Item;
use App\Region;
use App\Stock;
use App\Transfers_Detail;
use App\UserItem;
use App\Vehicle;
use App\Transfer;
use Illuminate\Http\Request;
use Auth;
use App\Customer;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        SELECT DISTINCT transfers.* from transfers
//LEFT JOIN
//    (
//        select transfer_details.* FROM transfer_details
//        INNER JOIN(
//        SELECT user_items.* from user_items
//        WHERE user_items.user_id='20'
//        )td on(transfer_details.item_id=td.item_id)
//)v on(v.transfer_id==transfers.id)
//        $transfers=Transfer::all();
        $transfers= DB::select('SELECT DISTINCT transfers.*,v.region_id as region_to from transfers
    INNER JOIN
    (
        select transfer_details.* FROM transfer_details
      INNER JOIN(
        SELECT user_items.* from user_items
        WHERE user_items.user_id='.Auth::user()->id.'
        )td on(transfer_details.item_id=td.item_id)
    )v on(v.transfer_id=transfers.id)
    where(status = \'Received\' AND  type is Null AND (transfers.from_='.Auth::user()->region_id.' OR v.region_id='.Auth::user()->region_id.'))
    ORDER BY  created_at DESC
      ');
        return view('transfer.index',compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (Transfer::where('ftn_no','Like','TO%')->first()) {
            $doc_no = Transfer::where('ftn_no','Like','TO%')->orderBy('ftn_no','desc')->pluck('ftn_no');
//            dd(Transfer::where('ftn_no','Like','TO%')->first());
            $part = explode(".",$doc_no);
            $no = intval($part[1]);
            $no++;
            $doc_no = "TO.".substr("000000", 1, 6 - strlen($no)).$no;
        }
    else {
            $doc_no = 'TO.000001';
        }

        $drivers=Driver::where('region_id',Auth::user()->region_id)->get();
        $vehicles =Vehicle::where('region_id',Auth::user()->region_id)->get();
        $regions=Region::all();
        $useritems=UserItem::where('user_id',Auth::user()->id)->get();
        $stock=DB::select('SELECT op.region,op.item_id,op.totalIn,lftjoin.totalOut , (op.totalIn-lftjoin.totalOut) as TOTAL from(
 SELECT region,item_id,sum(total) as totalIn from (
        select purchases.region_id as region , sum(purchases_detail.quantity) as total,purchases_detail.item_id as item_id from purchases_detail
 left join purchases on(purchases.id=purchases_detail.purchase_id)
 GROUP BY purchases_detail.item_id ,purchases.region_id
 

 union

 select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
 transfer_details.item_id as item_id from transfer_details
 GROUP BY transfer_details.item_id,transfer_details.region_id

 union

  select return_details.region_id as region , sum(return_details.quantity) as total ,
  return_details.item_id as item_id from return_details
  GROUP BY return_details.item_id,return_details.region_id
  )  stock
 GROUP BY stock.region,stock.item_id
) op 
 
 LEFT OUTER JOIN 
    
(
 SELECT region_id,item_id,sum(total) as totalOut from
  (
   SELECT transfer_details.item_id,sum(transfer_details.quantity) as total,transfers.from_ as region_id
FROM transfers
LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
GROUP BY transfer_details.item_id,transfers.from_

UNION

SELECT dispatches_detail.item_id,SUM(dispatches_detail.quantity) as total,dispatches.region_id
from dispatches
LEFT JOIN
 dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY  dispatches.region_id,dispatches_detail.item_id

  )t
  GROUP BY region_id,item_id
	)lftjoin
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id) where region='.Auth::user()->region_id);
//        dd($stock);
        return view('transfer.shipped',compact(['stock','drivers','vehicles','doc_no','regions','useritems']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transfer = new Transfer();
        $transfer->customer()->associate(Customer::find($request->customer));
        $transfer->ftn_no = $request->doc_no;
        $transfer->reference = $request->reference;
        $transfer->ftn_date = $request->ftn_date;
        $transfer->vehicle_id=$request->vehicle_id;
        $transfer->driver_id=$request->driver_id;
        $region_name=explode('/',$request->from_);
        $region=Region::where('name',$region_name)->first();
        $transfer->from_=$region->id;
        $transfer->status="Pending";
        $transfer->send_by=Auth::user()->id;
        $transfer->placement_date = $request->placement_date;
        $transfer->save();
        $i=0;
        for(;$i<count($useritems=UserItem::where('user_id',Auth::user()->id)->get());$i++) {
            if ($request->items[$i] != null) {
                $transfer_detail = new Transfers_Detail();
                $transfer_detail->item()->associate($request->getid[$i]);
                $transfer_detail->region()->associate($request->region_id);
                $transfer_detail->quantity = $request->items[$i];
                $transfer_detail->transfer()->associate($transfer);
                $transfer_detail->save();
            }
        }
        if ($i > 0)
            return redirect()->route('transfer.index')->withMessage('Items Transfered Successfully');
        else {
            Transfer::find($transfer->id)->delete();
            return redirect()->route('transfer.index')->withMessage('Transfer Failed');
        }
    }

    public function transit(){
        $transfers= Transfer::where('status','=','Pending')->whereNull('type')->get();
        return view('transfer.transit',compact('transfers'));
    }

    public function transferReceived(Request $request , $id){



        $transfer= Transfers_Detail::where('transfer_id',$id)->get();
//        dd($transfer);
        $transfer[0]->transfer->status="Received";
        $transfer[0]->transfer->confirmed_by=Auth::user()->id;

        $reg=Region::find($transfer[0]->region_id);

        foreach($transfer as $t) {
            $stock=Stock::where('region_id',$reg->id)->where('item_id',$t->item_id)->first();

            if ($stock) {
                $quantity = $stock->quantity;
                $stock->quantity = $t->quantity + $quantity;
            } else {
                $stock = new Stock();
                $stock->item()->associate($t->item);
                $stock->region()->associate($t->region);
                $stock->quantity = $t->quantity;
            }
            $stock->save();
        }
            $transfer[0]->transfer->save();
        return redirect()->back()->withMessage("Transfered Successfully Received");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transfers=Transfers_Detail::where('transfer_id',$id)->get();
        $regions=Region::all();
        $vehicles =Vehicle::where('region_id',Auth::user()->region_id)->get();
        $drivers=Driver::where('region_id',Auth::user()->region_id)->get();
        $useritems=UserItem::where('user_id',Auth::user()->id)->get();
        $stock=Stock::where('region_id',Auth::user()->region_id)->get();
        return view('transfer.show',compact(['transfers','regions','vehicles','drivers','useritems']));
    }

    public function shipbyUser($id){
        $transfers= Transfer::where('send_by','=',Auth::user()->id)->whereNull('type')->get();
//        dd($transfers);
        return view('transfer.shippedByUser',compact('transfers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transfers=Transfers_Detail::where('transfer_id',$id)->get();
        $regions=Region::all();
        $vehicles =Vehicle::where('region_id',Auth::user()->region_id)->get();
        $drivers=Driver::where('region_id',Auth::user()->region_id)->get();
        $useritems=UserItem::where('user_id',Auth::user()->id)->get();
        $stock=DB::select('SELECT op.region,op.item_id,op.totalIn,lftjoin.totalOut , (op.totalIn-lftjoin.totalOut) as TOTAL from(
 SELECT region,item_id,sum(total) as totalIn from (
        select purchases.region_id as region , sum(purchases_detail.quantity) as total,purchases_detail.item_id as item_id from purchases_detail
 left join purchases on(purchases.id=purchases_detail.purchase_id)
 GROUP BY purchases_detail.item_id ,purchases.region_id
 

 union

 select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
 transfer_details.item_id as item_id from transfer_details
 GROUP BY transfer_details.item_id,transfer_details.region_id

 union

  select return_details.region_id as region , sum(return_details.quantity) as total ,
  return_details.item_id as item_id from return_details
  GROUP BY return_details.item_id,return_details.region_id
  )  stock
 GROUP BY stock.region,stock.item_id
) op 
 
 LEFT OUTER JOIN 
    
(
 SELECT region_id,item_id,sum(total) as totalOut from
  (
   SELECT transfer_details.item_id,sum(transfer_details.quantity) as total,transfers.from_ as region_id
FROM transfers
LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
GROUP BY transfer_details.item_id,transfers.from_

UNION

SELECT dispatches_detail.item_id,SUM(dispatches_detail.quantity) as total,dispatches.region_id
from dispatches
LEFT JOIN
 dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY  dispatches.region_id,dispatches_detail.item_id

  )t
  GROUP BY region_id,item_id
	)lftjoin
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id) where region='.Auth::user()->region_id);
        return view('transfer.edit',compact(['transfers','regions','vehicles','drivers','useritems']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

//        dd($request->all());

        $transfer =  Transfer::find($id);
        $transfer->customer()->associate(Customer::find($request->customer));
        $transfer->ftn_no = $request->doc_no;
        $transfer->reference = $request->reference;
        $transfer->ftn_date = $request->ftn_date;
        $transfer->vehicle_id=$request->vehicle_id;
        $transfer->driver_id=$request->driver_id;
        $region_name=explode('/',$request->from_);
        $region=Region::where('name',$region_name)->first();
        $transfer->from_=$region->id;
        $transfer->placement_date = $request->placement_date;

        $i=0;
        Transfer_details::where('transfer_id',$id)->get()->delete();
        for(;$i<count($request->items);$i++) {
            if ($request->items[$i] != null) {
                $transfer_detail = new Transfers_Detail();
                $transfer_detail->item()->associate($request->getid[$i]);
                $transfer_detail->region()->associate($request->region_id);
                $transfer_detail->quantity = $request->items[$i];
                $transfer_detail->transfer()->associate($transfer);
                $transfer_detail->save();
            }
        }
        if ($i > 0) {
            $transfer->save();
            return redirect()->route('transfer.index')->withMessage('Items Updated Successfully');
        }else {

            return redirect()->route('transfer.index')->withMessage('Updation Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transfer::find($id)->delete();
        return redirect()->back()->withMessage('Deleted Successfully');
    }
}
