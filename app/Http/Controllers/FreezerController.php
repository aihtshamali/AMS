<?php

namespace App\Http\Controllers;

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

        $freezers=Transfers_Detail::all();
        return view('freezer.index',compact('freezers'));
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
        return view('freezer.return',compact(['customers','regions']));
    }

    public function storeReturn(Request $request)
    {


//        $driver= Driver::find($request->driver);
//        $freezer->driver()->associate($driver);


        dd($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $doc_no = 0;

        if (Transfer::all()->last()) {
            $doc_no = Transfer::all()->last();
            $part = explode(".",$doc_no);
            $no = intval($part[1]);
            $no++;
            $doc_no = $request->ftn_no.substr("000000", 1, 6 - strlen($no)).$no;
        }
        else {
            $doc_no = $request->ftn_no.'.000001';
        }
        if($request->ftn_no=="RTN."){
            $freezer= new Returns();
        }
        else
        {
            $freezer= new Transfer();
        }
        $freezer->ftn_no=$doc_no;
        $freezer->reference=$request->reference;
        $freezer->ftn_date=$request->ftn_date;
        $freezer->customer()->associate($request->customer);
        $freezer->to_=$request->delivery_address;
        $freezer->placement_date=$request->placement_date;
        $freezer->purpose=$request->purpose;
        $freezer->save();
        $counter=0;
        $item= Item::where('item_group','Freezer')->first();

        foreach ($request->region as $r){
            if($r == null) break;
            if($request->ftn_no=="RTN."){
                $transfer_detail= new Returns_Detail();
                $transfer_detail->returns()->associate($freezer);
            }
            else
            {
                $transfer_detail= new Transfers_Detail();
                $transfer_detail->transfer()->associate($freezer);
            }

            $transfer_detail->region()->associate($r);
            $transfer_detail->item()->associate($item);
            $transfer_detail->quantity=1;
            $transfer_detail->type=$request->type[$counter];
            $transfer_detail->serialNumber=$request->serial_no[$counter];

            $transfer_detail->save();
            $counter++;
        }
        return redirect()->route('freezer.index')->withMessage('Freezer Dispatched Successfully');
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
       $transfer= Transfers_Detail::find($id);

//       Checking if Transfer_Detail has only one row linked with Transfer_main then Delete Both
        if(count(Transfers_Detail::where('transfer_id',$transfer->transfer_id)->get())<2){
            Transfer::find($transfer->transfer_id)->delete();
        }
        else
           Transfers_Detail::find($id)->delete();

        return redirect()->route('freezer.index')->withMessage('Deleted Successfully');
    }
}
