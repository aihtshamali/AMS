<?php

namespace App\Http\Controllers;

use App\Dispatch;
use App\Dispatches_Detail;
use App\Faculty;
use App\Item;
use App\Region;
use App\Stock;
use App\Transfer;
use App\Customer;
use App\Transfers_Detail;
use App\Returns;
use App\Returns_Detail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FreezerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd($request->all());
        $sql='';
        $retsql='';
        if($request->all()){
            // Converting in the Date Format for Comparison
            $from=Carbon::parse($request->from)->format('Y-m-d');
            $to=Carbon::parse($request->to)->format('Y-m-d');
            if($request->region) {
                $sql.='AND transfer_details.region_id="'.$request->region.'"';
                $retsql='AND return_details.region_id="'.$request->region.'"';
            }
            if($request->from && $request->to){

                $sql.='AND str_to_date(transfers.ftn_date,"%d-%m-%Y") between   "'.$from.'" AND "'.$to.'" ';
                $retsql.='AND str_to_date(returns.ftn_date,"%d-%m-%Y") between   "'.$from.'" AND "'.$to.'" ';
            }
            else if($request->from && (!$request->to)){
                $sql.='AND str_to_date(transfers.ftn_date,"%d-%m-%Y") between   "'.$from.'" AND "'.date("Y-m-d").'" ';
                $retsql.='AND str_to_date(returns.ftn_date,"%d-%m-%Y") between   "'.$from.'" AND "'.date("Y-m-d").'" ';
            }
            else if((!$request->from) && $request->to){
                $sql.='AND str_to_date(transfers.ftn_date,"%d-%m-%Y") between 0000-00-00 AND "'.$to. '" ';
                $retsql.='AND str_to_date(returns.ftn_date,"%d-%m-%Y") between 0000-00-00 AND "'.$to. '" ';
            }
            if($request->doc_no)
            {
                $sql.='AND transfers.ftn_no = "'.$request->doc_no.'" ';
                $retsql.='AND returns.ftn_no = "'.$request->doc_no.'" ';
            }
            if($request->status)
            {
                $sql.='AND status= "'.$request->status.'" ';
            }
//            if($request->customer_code)
//            {
//                $sql.='AND transfer_details.customer_id = "'.$request->customer_code.'" ';
//                $retsql.='AND return_details.customer_id = "'.$request->customer_code.'" ';
//            }

//            $date=$request->from;


//                    dd($returns);
        }


//        if ($request->all()){
//            if($request->from && $request->to && $request->region) {
//                $freezers = DB::table('transfers')->select('transfers.*','transfer_details.region_id as region')->where('transfers.ftn_date', '>=', $request['from'])
//                    ->where('transfers.ftn_date', '<=', $request['to'])
//                    ->leftJoin('transfer_details', 'transfer_details.transfer_id', '=', 'transfers.id')
//                    ->where('region_id', $request->region)->distinct()
//                    ->distinct()
//                    ->get();
//                $returns = DB::table('returns')->select('returns.*')->where('returns.ftn_date', '>=', $request['from'])
//                    ->where('returns.ftn_date', '<=', $request['to'])
//                    ->leftJoin('return_details', 'return_details.returns_id', '=', 'returns.id')
//                    ->where('region_id', $request->region)->where('type','Freezer')
//                    ->distinct()
//                    ->get();
//            }
//            else if($request->from && $request->to) {
//                $freezers = DB::table('transfers')->select('transfers.*','transfer_details.region_id as region')->where('transfers.ftn_date', '>=', $request['from'])
//                    ->leftJoin('transfer_details', 'transfer_details.transfer_id', '=', 'transfers.id')
//                    ->where('transfers.ftn_date', '<=', $request['to'])
//                    ->distinct()
//                    ->get();
//                $returns = DB::table('returns')->select('returns.*')->where('returns.ftn_date', '>=', $request['from'])
//                    ->leftJoin('return_details', 'return_details.returns_id', '=', 'returns.id')
//                    ->where('returns.ftn_date', '<=', $request['to'])
//                    ->distinct()
//                    ->get();
//            }
//            else if($request->region) {
//                $freezers = DB::table('transfers')->select('transfers.*','transfer_details.region_id as region','return_details.region_id as region')
//                    ->leftJoin('transfer_details', 'transfer_details.transfer_id', '=', 'transfers.id')
//                    ->where('transfer_details.region_id',$request->region)
//                    ->distinct()
//                    ->get();
//                $returns =  $returns = DB::table('returns')->select('returns.*' , 'return_details.customer_id','return_details.type','return_details.region_id as region')
//                    ->leftJoin('return_details', 'return_details.returns_id', '=', 'returns.id')->where('type','Freezer')
//                    ->where('return_details.region_id', '=', $request['region'])
//                    ->distinct()
//                    ->get();
//
//            }
//
//        }

//            $freezers = Transfer::select('transfers.*','transfer_details.region_id as region')
//                ->leftJoin('transfer_details','transfer_details.transfer_id','=','transfers.id')
//                ->where('type','Freezer')->get();
            $freezers=DB::select('SELECT transfers.*,transfer_details.region_id,sum(transfer_details.quantity) as qty ,transfer_details.region_id as region FROM transfers 
  left JOIN transfer_details on transfers.id=transfer_details.transfer_id
  WHERE type="Freezer " '.$sql.' AND region_id="'.Auth::user()->region_id.'" GROUP by transfer_details.transfer_id  order By created_at Desc ');
            $returns=DB::select('SELECT returns.* ,return_details.region_id as region,return_details.customer_id,sum(return_details.quantity) as qty FROM returns 
left JOIN return_details on returns.id=return_details.returns_id
WHERE type="Freezer" '.$retsql.' AND region_id="'.Auth::user()->region_id.'"
GROUP by return_details.returns_id ORDER BY created_at Desc');

//        $returns = DB::table('returns')->select('returns.*' , 'return_details.customer_id','return_details.type','return_details.region_id as region')
//            ->leftJoin('return_details', 'return_details.returns_id', '=', 'returns.id')->where('type','Freezer')
//            ->distinct()
//            ->where('type', 'Freezer')->get();


        $counttransfer=DB::table('transfer_details')->select('transfer_id',DB::raw("sum(quantity) as total"))->groupBy('transfer_id')->get();
        $countreturn=DB::table('return_details')->select('returns_id',DB::raw("sum(quantity) as total"))->groupBy('returns_id')->where('type','FREEZER')->get();

//        $stock=$stock=Stock::where('region_id',Auth::user()->region_id)->get();
        $regions=Region::all();
        return view('freezer.index',compact(['freezers','counttransfer','returns','countreturn','regions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers= Customer::all();
        $regions= Region::all();
        $faculty= Faculty::where('region_id',Auth::user()->region_id)->get();
        $nsm= Faculty::where('type','NSM')->first();
        $transfer_detail=Transfers_Detail::all();
        $items=Item::where('item_group','Freezer')->get();
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
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id) ');
        return view('freezer.create',compact(['stock','customers','regions','faculty','transfer_detail','items','nsm']));
    }


    public function createReturn(){
        $customers= Customer::all();
        $regions= Region::all();
        $faculty= Faculty::where('region_id',Auth::user()->region_id)->get();
        $nsm= Faculty::where('type','NSM')->first();
        $items=Item::where('item_group','Freezer')->get();
        $stock=Stock::where('region_id',Auth::user()->region_id)->get();
        return view('freezer.return',compact(['stock','customers','regions','faculty','items','nsm']));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function getdocNo($modelName,$ftn_no){
        $doc_no = 0;
        if($modelName=="Transfer") {
            if (Transfer::all()->last()) {
                $doc_no = Transfer::all()->last();
                $part = explode(".", $doc_no);
                $no = intval($part[1]);
                $no++;
                return ($ftn_no . substr("000000", 1, 6 - strlen($no)) . $no);
            }
        }
        elseif ($modelName=="Return"){
            if (Returns::all()->last()){
                $doc_no = Returns::all()->last();
                $part = explode(".", $doc_no);
                $no = intval($part[1]);
                $no++;
                return ($ftn_no.substr("000000", 1, 6 - strlen($no)) . $no);
            }
        }
                return ($ftn_no . '000001');


    }
    public function store(Request $request)
    {

        $doc_no = 0;
        $status='';
        if ($request->ftn_no == "RTN.") {
            $freezer = new Returns();
            $doc_no = $this->getdocNo("Return", $request->ftn_no);
            $freezer->return_date = $request->placement_date;
            $status='Returned';
//            $freezer->return
            $freezer->from_= $request->delivery_address;

        }
        else {
            $freezer = new Transfer();
            $doc_no = $this->getdocNo("Transfer", $request->ftn_no);
            $status='Transfered';
            $freezer->type = "Freezer";
            $freezer->to_= $request->delivery_address;
            $freezer->send_by=Auth::user()->id;
            $freezer->placement_date = $request->placement_date;
            $freezer->customer()->associate(Customer::find($request->customer));
        }

        $freezer->ftn_no = $doc_no;
        $freezer->reference = $request->reference;
        $freezer->ftn_date = $request->ftn_date;

        $freezer->purpose = $request->purpose;

        $freezer->nsm_id=$request->nsm;
        $freezer->rsm_id=$request->rsm;
        $freezer->tso_id=$request->tso;

        $freezer->save();
        $counter = 0;

        foreach ($request->region as $r) {
            if ($r == null) break;
            if ($request->ftn_no == "RTN.") {
                $transfer_detail = new Returns_Detail();
                $transfer_detail->returns()->associate($freezer);
                $transfer_detail->type="Freezer";
                $transfer_detail->customer()->associate(Customer::find($request->customer));
            } else {
                $transfer_detail = new Transfers_Detail();
                $transfer_detail->transfer()->associate($freezer);
            }
            $transfer_detail->region()->associate($r);
            $transfer_detail->item()->associate($request->type[$counter]);
            $transfer_detail->fr_model=$request->model[$counter];
            $transfer_detail->fr_condition=$request->condition[$counter];
            $transfer_detail->quantity = 1;
            $transfer_detail->freezer_type = $request->type[$counter];
            $transfer_detail->serialNumber = $request->serial_no[$counter];
//
//            $stock=Stock::where('region_id',$r)->where('item_id',$transfer_detail->item_id)->first();
//            if($stock) {
//                if ($request->ftn_no == "FTN.") {
//                    $quantity = $stock->quantity;
//                    $stock->quantity = $quantity - $transfer_detail->quantity;
//                    if ($stock->quantity < 0) {
//                        Transfer::find($freezer->id)->delete();
//                        return redirect()->route('freezer.index')->withMessage('Don\'t have much stock to complete this process ');
//                    }
//                    $stock->save();
//
//
//                    // For Customer
//                    $customer=Region::where('name','Customer')->first();
//                    $Custstock=Stock::where('region_id',$customer)->where('customer_id',$freezer->customer_id)->where('item_id',$transfer_detail->item_id)->first();
//                    //     dd($Custstock);
//                    if($Custstock){
//                        $quantity=$Custstock->quantity;
//                        $Custstock->quantity= $quantity+$transfer_detail->quantity;
//                        $Custstock->save();
//                    }
//                    else{
//                        $Custstock= new Stock();
//                        $quantity=$Custstock->quantity;
//
//                        $Custstock->region()->associate($customer->id);
//                        $Custstock->customer()->associate($freezer->customer_id);
//                        $Custstock->item()->associate($transfer_detail->item_id);
//                        $Custstock->quantity= $quantity+$transfer_detail->quantity;
//                        $Custstock->save();
//                    }
//
//
//                }
//                else{
//                    $quantity = $stock->quantity;
//                    $stock->quantity = $quantity + $transfer_detail->quantity;
//                    $stock->save();
//                    $customer=Region::where('name','Customer')->first();
//                    $Custstock=Stock::where('region_id',$customer->id)->where('customer_id',$transfer_detail->customer_id)->where('item_id',$transfer_detail->item_id)->first();
////                           dd($Custstock);
//                    if($Custstock){
//                        $quantity=$Custstock->quantity;
//                        $Custstock->quantity= $quantity-$transfer_detail->quantity;
//                        $Custstock->save();
//                    }
//                }
//            }
//            elseif ((!$stock) && $request->ftn!="FTN.")
//            {
//                $stock= new Stock();
//                $stock->item()->associate($transfer_detail->item_id);
//                $stock->region()->associate($transfer_detail->region_id);
//                $stock->quantity = $transfer_detail->quantity;
//                $stock->save();
//
//
//                // For Customer
//                $customer=Region::where('name','Customer')->first();
//                $Custstock=Stock::where('region_id',$customer)->where('customer_id',$transfer_detail->customer_id)->where('item_id',$transfer_detail->item_id)->first();
////                           dd($Custstock);
//                if($Custstock){
//                    $quantity=$Custstock->quantity;
//                    $Custstock->quantity= $quantity-$transfer_detail->quantity;
//                    $Custstock->save();
//                }
//            }

            $transfer_detail->save();
            $counter++;
        }
        if ($counter > 0)
            return redirect()->route('freezer.index')->withMessage('Freezer '+$status+' Successfully');
        else {
            if($status=="Transfered")
                Transfer::find($freezer->id)->delete();
            else
                Returns::find($freezer->id)->delete();
            return redirect()->route('freezer.index')->withMessage("Operation Failed");
        }
    }
    public function returnPrint($id){

        $freezers= Returns_Detail::where('returns_id',$id)->get();
        return view('freezer.print.FreezerReturnPrint',compact('freezers'));
    }
    public function gatePassInPrint($id)
    {
        $freezers= Returns_Detail::where('returns_id',$id)->get();
        return view('freezer.print.GatePassInPrint',compact('freezers'));
    }
    public function transferPrint($id){

        $freezers= Transfers_Detail::where('transfer_id',$id)->get();
        return view('freezer.print.FreezerTransferPrint',compact('freezers'));
    }

    public function gatePassOutPrint($id)
    {
        $freezers= Transfers_Detail::where('transfer_id',$id)->get();
        return view('freezer.print.GatePassOutPrint',compact('freezers'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { $freezer=Transfers_Detail::where('transfer_id',$id)->get();
        $customers= Customer::all();
        $regions= Region::all();
        $faculty= Faculty::where('region_id',Auth::user()->region_id)->get();
        $nsm= Faculty::where('type','NSM')->first();
        $transfer_detail=Transfers_Detail::where('region_id',Auth::user()->region_id);
        $items=Item::where('item_group','Freezer')->get();
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
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id)');
        return view('freezer.show',compact(['freezer','stock','customers','regions','faculty','transfer_detail','items','nsm']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $freezer=Transfers_Detail::where('transfer_id',$id)->get();
        $customers= Customer::all();
        $regions= Region::all();
        $faculty= Faculty::where('region_id',Auth::user()->region_id);
        $nsm= Faculty::where('type','NSM')->first();
        $transfer_detail=Transfers_Detail::all();
        $items=Item::where('item_group','Freezer')->get();
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
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id)');
        return view('freezer.edit',compact(['freezer','stock','customers','regions','faculty','transfer_detail','items','nsm']));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $transfer= Transfer::find($id)->delete();

//       Checking if Transfer_Detail has only one row linked with Transfer_main then Delete Both
//        if(count(Transfers_Detail::where('transfer_id',$transfer->transfer_id)->get())<2){
  //          Transfer::find($transfer->transfer_id)->delete();
    //    }
      //  else
        //   Transfers_Detail::find($id)->delete();

        return redirect()->back()->withMessage('Deleted Successfully');
    }
}
