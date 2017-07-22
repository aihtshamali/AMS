<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Dispatch;
use App\Dispatches_Detail;
use App\Driver;
use App\Faculty;
use App\Item;
use App\Returns_Detail;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $dispatches =Dispatch::paginate(7);
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
        $dispatch_detail=Dispatches_Detail::all();
       return view('dispatch.create',compact(['drivers','customers','vehicles','items','doc_no','dispatch_detail']));
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
        if($i=0) {
            Dispatch::find($dispatch->id)->delete();
            return redirect()->route('dispatch.index')->withMessage("Data Insertion Failed");

        }else
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
        $faculty= Faculty::find($id);
        return view('faculty.edit',compact('faculty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function returnedit($id){

    }
    public function edit($id)
    {
        $dispatch=Dispatch::find($id);
        $items=Item::all();
        $customers= Customer::all();
        $drivers=Driver::all();
        $vehicles=Vehicle::all();
        $dispatch_detail=Dispatches_Detail::where('dispatch_id',$dispatch->id)->get();
//        $dispatch_detail=DB::table('dispatches_detail')
//            ->select(DB::raw('count(*) as customer_count, dispatch_id'))
//            ->where('dispatch_id', '=', $dispatch->id)
//            ->groupBy('customer_id')
//            ->get();
       return view('dispatch.edit',compact(['drivers','customers','vehicles','items','dispatch','dispatch_detail']));
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
        if($i=0) {
            Dispatch::find($dispatch->id)->delete();
            return redirect()->route('dispatch.index')->withMessage("Data Updated Failed");

        }else
            return redirect()->route('dispatch.index')->withMessage('Data Updated Successfully');
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
