<?php

namespace App\Http\Controllers;
use App\Purchase;
use App\Driver;
use App\Vehicle;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases=Purchase::all();
        return view('purchase.index',compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Purchase::all()->last()) {
            $doc_no = Purchase::all()->last()->pluck('reference');
            $part = explode(".",$doc_no);
            $no = intval($part[1]);
            $no++;
            $doc_no = "DOC.".substr("000000", 1, 6 - strlen($no)).$no;
        }
        else {
            $doc_no = 'DOC.000001';
        }
        $drivers=Driver::all();
        $vehicles =Vehicle::all();
        return view('purchase.create',compact(['drivers','vehicles','doc_no']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        Purchase::find($id)->delete();
        return redirect()->route('purchase.index')->withMessage('Deleted Successfully');
    }
}
