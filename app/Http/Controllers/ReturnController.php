<?php

namespace App\Http\Controllers;
use App\Returns;
use App\Customer;
use App\Region;
use App\Driver;
use App\Returns_Detail;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Item;
class ReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $returns=Returns_Detail::all();
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
            $doc_no = "RET.".substr("000000", 1, 6 - strlen($no)).$no;
        }
        else {
            $doc_no = 'RET.000001';
        }

        $customers= Customer::all();
        $drivers=Driver::all();
        $vehicles=Vehicle::all();
        $items=Item::all();
        return view('returns.create',compact(['drivers','customers','vehicles','doc_no','items']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
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
        Returns::find($id)->delete();
        return redirect()->route('return.index')->withMessage('Deleted Successfully');
    }
}
