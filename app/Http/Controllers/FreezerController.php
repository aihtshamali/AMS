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

        if ($request->all()){
            if($request->from && $request->to && $request->region) {
                $freezers = DB::table('transfers')->select('transfers.*')->where('transfers.ftn_date', '>=', $request['from'])
                    ->where('transfers.ftn_date', '<=', $request['to'])
                    ->leftJoin('transfer_details', 'transfer_details.transfer_id', '=', 'transfers.id')
                    ->where('region_id', $request->region)->distinct()
                    ->distinct()
                    ->get();
                $returns = DB::table('returns')->select('returns.*')->where('returns.ftn_date', '>=', $request['from'])
                    ->where('returns.ftn_date', '<=', $request['to'])
                    ->leftJoin('return_details', 'return_details.returns_id', '=', 'returns.id')
                    ->where('region_id', $request->region)->where('type','FREEZER')
                    ->distinct()
                    ->get();
            }
            else if($request->from && $request->to) {
                $freezers = DB::table('transfers')->select('transfers.*')->where('transfers.ftn_date', '>=', $request['from'])
                    ->leftJoin('transfer_details', 'transfer_details.transfer_id', '=', 'transfers.id')
                    ->where('transfers.ftn_date', '<=', $request['to'])
                    ->distinct()
                    ->get();
                $returns = DB::table('returns')->select('returns.*')->where('returns.ftn_date', '>=', $request['from'])
                    ->leftJoin('return_details', 'return_details.returns_id', '=', 'returns.id')
                    ->where('returns.ftn_date', '<=', $request['to'])
                    ->distinct()
                    ->get();
            }
            else if($request->region) {
                $freezers = DB::table('transfers')->select('transfers.*')
                    ->leftJoin('transfer_details', 'transfer_details.transfer_id', '=', 'transfers.id')
                    ->where('transfer_details.region_id',$request->region)
                    ->distinct()
                    ->get();
                $returns =  $returns = DB::table('returns')->select('returns.*' , 'return_details.customer_id','return_details.type')
                    ->leftJoin('return_details', 'return_details.returns_id', '=', 'returns.id')->where('type','FREEZER')
                    ->where('return_details.region_id', '=', $request['region'])
                    ->distinct()
                    ->get();

            }

        }
        else {
            $freezers = Transfer::where('type','FREEZER')->paginate(8);
            $returns = DB::table('returns')->select('returns.*' , 'return_details.customer_id','return_details.type')
                ->leftJoin('return_details', 'return_details.returns_id', '=', 'returns.id')->where('type','FREEZER')
                ->distinct()
            ->where('type', 'FREEZER')->paginate(8);

        }
        $counttransfer=DB::table('transfer_details')->select('transfer_id',DB::raw("sum(quantity) as total"))->groupBy('transfer_id')->get();
        $countreturn=DB::table('return_details')->select('returns_id',DB::raw("sum(quantity) as total"))->groupBy('returns_id')->where('type','FREEZER')->get();

        $stock=$stock=Stock::where('region_id',Auth::user()->region_id)->get();
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
        $faculty= Faculty::all();
        $transfer_detail=Transfers_Detail::all();
        $items=Item::where('item_group','FREEZER')->get();
        $stock=Stock::all();
        return view('freezer.create',compact(['stock','customers','regions','faculty','transfer_detail','items']));
    }


    public function createReturn(){
        $customers= Customer::all();
        $regions= Region::all();
        $faculty= Faculty::all();
        $items=Item::where('item_group','FREEZER')->get();
        $stock=Stock::where('region_id',Auth::user()->region_id)->get();
        return view('freezer.return',compact(['stock','customers','regions','faculty','items']));
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
            $freezer->from_= $request->delivery_address;

        }
        else {
            $freezer = new Transfer();
            $doc_no = $this->getdocNo("Transfer", $request->ftn_no);
            $status='Transfered';
            $freezer->type = "FREEZER";
            $freezer->to_= $request->delivery_address;
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
                $transfer_detail->type="FREEZER";
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

            $stock=Stock::where('region_id',$r)->where('item_id',$transfer_detail->item_id)->first();
            if($stock) {
                if ($request->ftn_no == "FTN.") {
                    $quantity = $stock->quantity;
                    $stock->quantity = $quantity - $transfer_detail->quantity;
                    if ($stock->quantity < 0) {
                        Transfer::find($freezer->id)->delete();
                        return redirect()->route('freezer.index')->withMessage('Don\'t have much stock to complete this process ');
                    }
                    $stock->save();


                    // For Customer
                    $customer=Region::where('name','Customer')->first();
                    $Custstock=Stock::where('region_id',$customer)->where('customer_id',$freezer->customer_id)->where('item_id',$transfer_detail->item_id)->first();
                    //     dd($Custstock);
                    if($Custstock){
                        $quantity=$Custstock->quantity;
                        $Custstock->quantity= $quantity+$transfer_detail->quantity;
                        $Custstock->save();
                    }
                    else{
                        $Custstock= new Stock();
                        $quantity=$Custstock->quantity;

                        $Custstock->region()->associate($customer->id);
                        $Custstock->customer()->associate($freezer->customer_id);
                        $Custstock->item()->associate($transfer_detail->item_id);
                        $Custstock->quantity= $quantity+$transfer_detail->quantity;
                        $Custstock->save();
                    }


                }
                else{
                    $quantity = $stock->quantity;
                    $stock->quantity = $quantity + $transfer_detail->quantity;
                    $stock->save();
                    $customer=Region::where('name','Customer')->first();
                    $Custstock=Stock::where('region_id',$customer->id)->where('customer_id',$transfer_detail->customer_id)->where('item_id',$transfer_detail->item_id)->first();
//                           dd($Custstock);
                    if($Custstock){
                        $quantity=$Custstock->quantity;
                        $Custstock->quantity= $quantity-$transfer_detail->quantity;
                        $Custstock->save();
                    }
                }
            }
            elseif ((!$stock) && $request->ftn!="FTN.")
            {
                $stock= new Stock();
                $stock->item()->associate($transfer_detail->item_id);
                $stock->region()->associate($transfer_detail->region_id);
                $stock->quantity = $transfer_detail->quantity;
                $stock->save();


                // For Customer
                $customer=Region::where('name','Customer')->first();
                $Custstock=Stock::where('region_id',$customer)->where('customer_id',$transfer_detail->customer_id)->where('item_id',$transfer_detail->item_id)->first();
//                           dd($Custstock);
                if($Custstock){
                    $quantity=$Custstock->quantity;
                    $Custstock->quantity= $quantity-$transfer_detail->quantity;
                    $Custstock->save();
                }
            }

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
            return redirect()->route('freezer.index')->withMessage('Freezer Does Not '+$status+"ed" );
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
    {
        //
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
        $faculty= Faculty::all();
        $transfer_detail=Transfers_Detail::all();
        $items=Item::where('item_group','FREEZER')->get();
        $stock=Stock::all();
        return view('freezer.edit',compact(['freezer','stock','customers','regions','faculty','transfer_detail','items']));
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
