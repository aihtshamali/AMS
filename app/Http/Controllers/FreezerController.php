<?php

namespace App\Http\Controllers;

use App\Dispatch;
use App\Dispatches_Detail;
use App\Faculty;
use App\Item;
use App\Region;
use App\Transfer;
use App\Customer;
use App\Transfers_Detail;
use App\Returns;
use App\Returns_Detail;
use Illuminate\Http\Request;

class FreezerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $freezers=Transfer::all();
        $transfer_details=Transfers_Detail::all();
        $returns=Returns_Detail::where('type','freezer')->get();
        return view('freezer.index',compact(['freezers','transfer_details','returns']));
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
        return view('freezer.create',compact(['customers','regions','faculty']));
    }


    public function createReturn(){
        $customers= Customer::all();
        $regions= Region::all();
        $faculty= Faculty::all();
        return view('freezer.return',compact(['customers','regions','faculty']));
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
        } else {
            $freezer = new Transfer();
            $doc_no = $this->getdocNo("Transfer", $request->ftn_no);
            $status='Transfered';
            $freezer->type = "freezer";
            $freezer->placement_date = $request->placement_date;
            $freezer->customer()->associate(Customer::find($request->customer));
        }

        //      Default Value



        $freezer->ftn_no = $doc_no;
        $freezer->reference = $request->reference;
        $freezer->ftn_date = $request->ftn_date;
        $freezer->to_= $request->delivery_address;

        $freezer->purpose = $request->purpose;

        // Loop for finding Faculty Type
        foreach ($request->faculty as $f) {
            $fac = Faculty::find($f);
            if($fac) {
                if ($fac->type == "TSO") {
                    $freezer->tso_id = $f;
                } else if ($fac->type == "NSM") {
                    $freezer->nsm_id = $f;
                } else if ($fac->type == "RSM") {
                    $freezer->rsm_id = $f;
                }
            }
        }

        $freezer->save();
        $counter = 0;
//        $item = Item::where('item_group', 'Freezer')->first();

        foreach ($request->region as $r) {
            if ($r == null) break;
            if ($request->ftn_no == "RTN.") {
                $transfer_detail = new Returns_Detail();
                $transfer_detail->returns()->associate($freezer);
                $transfer_detail->customer()->associate(Customer::find($request->customer));
            } else {
                $transfer_detail = new Transfers_Detail();
                $transfer_detail->transfer()->associate($freezer);
            }

            $transfer_detail->region()->associate($r);
            $item=Item::where('display_name',$request->type[$counter])->first();

            $transfer_detail->item()->associate($item);
            $transfer_detail->fr_model=$request->model[$counter];
            $transfer_detail->fr_condition=$request->condition[$counter];
            $transfer_detail->quantity = 1;
            $transfer_detail->freezer_type = $request->type[$counter];
            $transfer_detail->serialNumber = $request->serial_no[$counter];
            $transfer_detail->save();
            $counter++;
        }
        if ($counter > 0)
            return redirect()->route('freezer.index')->withMessage('Freezer '+$status+' Successfully');
        else {
            Transfer::find($freezer->id)->delete();
            return redirect()->route('freezer.index')->withMessage('Freezer Does Not '+$status );
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
        //
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

        return redirect()->route('freezer.index')->withMessage('Deleted Successfully');
    }
}
