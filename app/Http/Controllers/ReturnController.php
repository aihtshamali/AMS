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
            $doc_no = "RTN.".substr("000000", 1, 6 - strlen($no)).$no;
        }
        else {
            $doc_no = 'RTN.000001';
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



        $return = new Returns();

        $return->ftn_no = $request->ftn_no;
        $return->reference = $request->reference;
        $return->ftn_date = $request->cdate;

        //     Return from Customers
        //         To WareHouse


        $return->region_to = 2;
//        $return->customer()->associate($request->customer);
//        $return->to_ = $request->delivery_address;
//        $return->placement_date = $request->placement_date;
//        $return->purpose = $request->purpose;

        $return->save();
        $counter = 0;
        foreach ($request->customer as $cust) {
            if ($cust == null) break;
            $it = $request->item[$counter];
            for ($i = 0; $i < count($request->getid); $i++) {
                if ($it[$request->getid[$i]] && $it[$request->getid[$i]] > 0) {

                    $transfer_detail = new Returns_Detail();
                    $transfer_detail->customer  ()->associate($cust);
                    $transfer_detail->quantity = $it[$request->getid[$i]];
                    $transfer_detail->item()->associate(Item::find($request->getid[$i]));
                    $transfer_detail->sales_invoice = $request->sales_invoice[$counter];
                    $transfer_detail->region_id = 1;
                    $transfer_detail->returns()->associate($return->id);
                    $transfer_detail->save();
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
        $returns= Returns_Detail::find($id);

//       Checking if Transfer_Detail has only one row linked with Transfer_main then Delete Both
        if(count(Returns_Detail::where('returns_id',$returns->transfer_id)->get())<2){
            Returns::find($returns->returns_id)->delete();
        }
        else
            Returns_Detail::find($id)->delete();
        return redirect()->route('returns.index')->withMessage('Deleted Successfully');
    }
}
