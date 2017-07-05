<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Dispatch;
use App\Dispatches_Detail;
use App\Driver;
use App\Item;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $dispatches =Dispatch::all();
        return view('dispatch.index',compact('dispatches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doc_no = 0;

        if (Dispatch::all()->last()) {
            $doc_no = Dispatch::all()->last();
            $part = explode(".",$doc_no);
            $no = intval($part[1]);
            $no++;
            $doc_no = "DOC.".substr("000000", 1, 6 - strlen($no)).$no;
        }
        else {
            $doc_no = 'DOC.000001';
        }

        $items=Item::all();
        $customers= Customer::all();
        $drivers=Driver::all();
        $vehicles=Vehicle::all();
       return view('dispatch.create',compact(['drivers','customers','vehicles','items','doc_no']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function store(Request $request)
    {
//        dd($request->all());
        $dispatch = new Dispatch();
        $dispatch->doc_no = $request->doc_no;
        $dispatch->reference = $request->reference;
        $dispatch->cdate = $request->cdate;
        $dispatch->region_id = 2;

        $dispatch->to_ = 1;
        $dispatch->confirmed_by = 0;
        $dispatch->user_id = Auth::user()->id;
        $dispatch->vehicle_id = $request->vehicle_id;
        $dispatch->driver_id = $request->driver_id;
        $dispatch->save();
        $counter = 0;
        foreach ($request->customer as $cust) {
            if ($cust == null) {
                break;
            } else {
                $it=$request->item[$counter];
                    for ($i = 0; $i < count($request->getid); $i++) {
                        if ($it[$request->getid[$i]] && $it[$request->getid[$i]] > 0) {
                            $dispatch_detail = new Dispatches_Detail();
                            $dispatch_detail->customer()->associate($cust);
                            $dispatch_detail->quantity = $it[$request->getid[$i]];
                            $dispatch_detail->item()->associate(Item::find($request->getid[$i]));
                            $dispatch_detail->sales_invoice = $request->sales_invoice[$counter];
                            $dispatch_detail->dispatch()->associate($dispatch->id);
                            $dispatch_detail->save();
                        }
                    }
                }
            $counter++;
        }
        return redirect()->route('dispatch.index')->withMessage('Data Inserted Successfully');
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
        Dispatch::find($id)->delete();
        $dispatch = new Dispatch();
        $dispatch->doc_no = $request->doc_no;
        $dispatch->reference = $request->reference;
        $dispatch->cdate = $request->cdate;
        $dispatch->region_id = 2;

        $dispatch->to_ = 1;
        $dispatch->confirmed_by = 0;
        $dispatch->user_id = Auth::user()->id;
        $dispatch->vehicle_id = $request->vehicle_id;
        $dispatch->driver_id = $request->driver_id;
        $dispatch->save();
        $counter = 0;
        foreach ($request->customer as $cust) {
            if ($cust == null) {
                break;
            } else {
                $it=$request->item[$counter];
                for ($i = 0; $i < count($request->getid); $i++) {
                    if ($it[$request->getid[$i]] && $it[$request->getid[$i]] > 0) {
                        $dispatch_detail = new Dispatches_Detail();
                        $dispatch_detail->customer()->associate($cust);
                        $dispatch_detail->quantity = $it[$request->getid[$i]];
                        $dispatch_detail->item()->associate(Item::find($request->getid[$i]));
                        $dispatch_detail->sales_invoice = $request->sales_invoice[$counter];
                        $dispatch_detail->dispatch()->associate($dispatch->id);
                        $dispatch_detail->save();
                    }
                }
            }
            $counter++;
        }
        return redirect()->route('dispatch.index')->withMessage('Data Inserted Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Dispatch::find($id)->delete();
        return redirect()->route('dispatch.index')->withMessage('Deleted Successfully');
    }
}
