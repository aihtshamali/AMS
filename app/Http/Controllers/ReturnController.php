<?php

namespace App\Http\Controllers;
use App\Returns;
use App\Customer;
use App\Region;
use App\Driver;
use App\Returns_Detail;
use App\Stock;
use App\Transfers_Detail;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $returns=Returns::paginate(5);
//        $returns = Returns::paginate(8);
        $returns = DB::table('returns')->select('returns.*' , 'return_details.customer_id',DB::raw('sum(return_details.quantity) as qty') ,'return_details.type')
            ->leftJoin('return_details', 'return_details.returns_id', '=', 'returns.id')
            ->distinct()
            ->where('type', 'Crate')->groupBy('customer_id')->get();
//        dd($returns);
        return view('returns.index',compact('returns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doc_no = 0;

        if (Returns::all()->last()) {
            $doc_no = Returns::all()->last();
            $part = explode(".",$doc_no);
//            dd($part);
            $no = intval($part[1]);
            $no++;
            $doc_no = "RTN.".substr("000000", 1, 6 - strlen($no)).$no;
        }
        else {
            $doc_no = 'RTN.000001';
        }

        $customers= Customer::all();
        $drivers=Driver::where('region_id',Auth::user()->region_id)->get();
        $vehicles=Vehicle::where('region_id',Auth::user()->region_id)->get();
        $items=Item::all();
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
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id) where region_id='.Auth::user()->region_id.'');
        return view('returns.create',compact(['stock','drivers','customers','vehicles','doc_no','items']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $return = new Returns();
        $return->ftn_no = $request->ftn_no;
        $return->reference = $request->reference;
        $return->ftn_date = $request->cdate;
        $return->return_date = $request->cdate;

        $region_name=explode('/',$request->to_);
        $region=Region::where('name',$region_name)->first();
//        dd($region);
        $return->region_to = $region->id;
        $return->save();
        $counter = 0;
        foreach ($request->customer as $cust) {
            if ($cust == null) break;
            $it = $request->item[$counter];
            for ($i = 0; $i < count($request->getid); $i++) {
                if ($it[$request->getid[$i]] && $it[$request->getid[$i]] > 0) {

                    $return_detail = new Returns_Detail();
                    $custom=Customer::where('account_name',$cust)->first();
                    $return_detail->customer()->associate($custom->id);
                    $return_detail->quantity = $it[$request->getid[$i]];
                    $return_detail->item()->associate(Item::find($request->getid[$i]));
                    $return_detail->sales_invoice = $request->sales_invoice[$counter];
                    $return_detail->region()->associate($region);
                    $itm=Item::find($request->getid[$i]);
                    $return_detail->type=$itm->item_group;
                    $return_detail->returns()->associate($return->id);
                    $stock=Stock::where('region_id',$return_detail->region_id)->where('item_id',$return_detail->item_id)->first();

                    if($stock) {
                        $quantity=$stock->quantity;
                        $stock->quantity= $return_detail->quantity+$quantity;
                        $stock->save();
                    }
                    else {
                        $stock = new Stock();
                        $stock->item()->associate($return_detail->item);
                        $stock->region()->associate($return_detail->region_id);
                        $stock->quantity = $return_detail->quantity;
                        $stock->save();
                    }
                    // For Customer
                    $customer=Region::where('name','Customer')->first();
                    $Custstock=Stock::where('region_id',$customer->id)->where('customer_id',$return_detail->customer_id)->where('item_id',$return_detail->item_id)->first();
//                           dd($Custstock);
                    if($Custstock){
                        $quantity=$Custstock->quantity;
                        $Custstock->quantity= $quantity-$return_detail->quantity;
                        $Custstock->save();
                    }

                    $return_detail->save();
                }
            }
            $counter++;
        }
            if ($counter > 0)
                return redirect()->route('returns.index')->withMessage('Return Successfully');
            else {
                Transfer::find($return->id)->delete();
                return redirect()->route('returns.index')->withMessage('Return Does Not Happened');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $return=Returns::find($id);
        $items=Item::all();
        $customers= Customer::all();
        $drivers=Driver::where('region_id',$return->region_to)->get();
        $vehicles=Vehicle::where('region_id',$return->region_to)->get();
        $return_detail=Returns_Detail::where('returns_id',$return->id)->get();
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
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id) where region_id='.Auth::user()->region_id.'');
        return view('returns.show',compact(['stock','items','customers','drivers','vehicles','return_detail','return']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $return=Returns::find($id);
        $items=Item::all();
        $customers= Customer::all();
        $drivers=Driver::where('region_id',$return->region_to)->get();
        $vehicles=Vehicle::where('region_id',$return->region_to)->get();
        $return_detail=Returns_Detail::where('returns_id',$return->id)->get();
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
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id) where region_id='.Auth::user()->region_id.'');
        return view('returns.edit',compact(['stock','items','customers','drivers','vehicles','return_detail','return']));
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
        $return = Returns::find($id);

        $rd=Returns_Detail::where('returns_id',$id)->get();
        foreach ($rd as $d){
            $stock = Stock::where('region_id', $d->region_id)->where('item_id', $d->item_id)->first();
            if ($stock) {
                $quantity = $stock->quantity;
                $stock->quantity = $quantity + $d->quantity;
                $stock->save();
            }
            $Custstock=Stock::where('region_id',1)->where('customer_id',$d->customer_id)->where('item_id',$d->item_id)->first();
//                           dd($Custstock);
            if($Custstock){
                $quantity=$Custstock->quantity;
                $Custstock->quantity= $quantity-$d->quantity;
                if($Custstock->quantity<0)
                    $Custstock->quantity=0;
                $Custstock->save();
            }
        }


        $return->ftn_no = $request->doc_no;
        $return->reference = $request->reference;
        $return->ftn_date = $request->cdate;
        $return->return_date = $request->cdate;
        //     Return from Customers
        //         To WareHouse
        $region_name=explode('/',$request->to_);
        $region=Region::where('name',$region_name)->first();

        $return->region_to = $region->id;
//        $return->customer()->associate($request->customer);
//        $return->to_ = $request->delivery_address;
//        $return->placement_date = $request->placement_date;
//        $return->purpose = $request->purpose;
        Returns_Detail::where('returns_id',$return->id)->delete();
        $counter = 0;
        foreach ($request->customer as $cust) {
            if ($cust == null) break;
            $it = $request->item[$counter];
            for ($i = 0; $i < count($request->getid); $i++) {
                if ($it[$request->getid[$i]] && $it[$request->getid[$i]] > 0) {
                    $return_detail = new Returns_Detail();
                    $custom=Customer::where('account_name',$cust)->first();
                    $return_detail->customer()->associate($custom->id);
                    $return_detail->quantity = $it[$request->getid[$i]];
                    $return_detail->item()->associate(Item::find($request->getid[$i]));
                    $return_detail->sales_invoice = $request->sales_invoice[$counter];
                    $return_detail->region()->associate($region);
                    $itm=Item::find($request->getid[$i]);
                    $return_detail->type=$itm->item_group;
                    $return_detail->returns()->associate($return->id);
//                    dd($return_detail);
                    $stock = Stock::where('region_id', $return_detail->region_id)->where('item_id', $return_detail->item_id)->first();
//                   dd($stock);
                    if ($stock) {
                        $quantity = $stock->quantity;
                        $stock->quantity = $quantity - $return_detail->quantity;
                        $stock->save();
                    }
                    // For Customer
                    $customer=Region::where('name','Customer')->first();
                    $Custstock=Stock::where('region_id',1)->where('customer_id',$return_detail->customer_id)->where('item_id',$return_detail->item_id)->first();
//                           dd($Custstock);
                    if($Custstock){
                        $quantity=$Custstock->quantity;
                        $Custstock->quantity= $quantity-$return_detail->quantity;
                        if($Custstock->quantity<0)
                            $Custstock->quantity=0;
                        $Custstock->save();
                    }
                    $return_detail->save();
                }
            }
            $counter++;
        }
        if ($counter > 0) {
            $return->save();
            return redirect()->route('returns.index')->withMessage('Return Successfully');
        }else {
            return redirect()->route('returns.index')->withMessage('Return Does Not Happened');
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
        Returns::find($id)->delete();
//        $returns= Returns_Detail::find($id);
//
////       Checking if Transfer_Detail has only one row linked with Transfer_main then Delete Both
//        if(count(Returns_Detail::where('returns_id',$returns->transfer_id)->get())<2){
//            Returns::find($returns->returns_id)->delete();
//        }
//        else
//            Returns_Detail::find($id)->delete();
        return redirect()->back()->withMessage('Deleted Successfully');
    }
}
