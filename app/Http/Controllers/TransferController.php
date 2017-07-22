<?php

namespace App\Http\Controllers;
use App\Driver;
use App\Item;
use App\Region;
use App\Transfers_Detail;
use App\UserItem;
use App\Vehicle;
use App\Transfer;
use Illuminate\Http\Request;
use Auth;
use App\Customer;
class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $transfers= Transfer::whereNULL('type')->get();
//        dd($transfers);
        return view('transfer.index',compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Transfer::all()->last()) {
            $doc_no = Transfer::all()->last()->pluck('ftn_no');
            $part = explode(".",$doc_no);
            $no = intval($part[1]);
            $no++;
            $doc_no = "TO.".substr("000000", 1, 6 - strlen($no)).$no;
        }
        else {
            $doc_no = 'TO.000001';
        }
        $drivers=Driver::all();
        $vehicles =Vehicle::all();
        $regions=Region::all();
        $useritems=UserItem::where('user_id',Auth::user()->id)->get();
        return view('transfer.shipped',compact(['drivers','vehicles','doc_no','regions','useritems']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transfer = new Transfer();
        $transfer->customer()->associate(Customer::find($request->customer));
        $transfer->ftn_no = $request->doc_no;
        $transfer->reference = $request->reference;
        $transfer->ftn_date = $request->ftn_date;
        $transfer->vehicle_id=$request->vehicle_id;
        $transfer->driver_id=$request->driver_id;
        $transfer->from_=$request->from_;
        $transfer->placement_date = $request->placement_date;
        $transfer->save();
        $i=0;
        for(;$i<count($useritems=UserItem::where('user_id',Auth::user()->id)->get());$i++) {
            if ($request->items[$i] != null) {
                $transfer_detail = new Transfers_Detail();
                $transfer_detail->item()->associate($request->getid[$i]);
                $transfer_detail->region()->associate($request->region_id);
                $transfer_detail->quantity = $request->items[$i];
                $transfer_detail->transfer()->associate($transfer);
                $transfer_detail->save();
            }
        }
        if ($i > 0)
            return redirect()->route('transfer.index')->withMessage('Items Transfered Successfully');
        else {
            Transfer::find($transfer->id)->delete();
            return redirect()->route('transfer.index')->withMessage('Items Does Not Dispatched');
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
        $transfers=Transfers_Detail::where('transfer_id',$id)->get();
        $regions=Region::all();
        $vehicles =Vehicle::all();
        $drivers=Driver::all();
        $useritems=UserItem::where('user_id',Auth::user()->id)->get();
        return view('transfer.edit',compact(['transfers','regions','vehicles','drivers','useritems']));
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

//        dd($request->all());
        Transfer::find($id)->delete();
        $transfer = new Transfer();
        $transfer->customer()->associate(Customer::find($request->customer));
        $transfer->ftn_no = $request->doc_no;
        $transfer->reference = $request->reference;
        $transfer->ftn_date = $request->ftn_date;
        $transfer->vehicle_id=$request->vehicle_id;
        $transfer->driver_id=$request->driver_id;
        $transfer->from_=$request->from_;
        $transfer->placement_date = $request->placement_date;
        $transfer->save();
        $i=0;

        for(;$i<count($request->items);$i++) {
            if ($request->items[$i] != null) {
                $transfer_detail = new Transfers_Detail();
                $transfer_detail->item()->associate($request->getid[$i]);
                $transfer_detail->region()->associate($request->region_id);
                $transfer_detail->quantity = $request->items[$i];
                $transfer_detail->transfer()->associate($transfer);
                $transfer_detail->save();
            }
        }
        if ($i > 0)
            return redirect()->route('transfer.index')->withMessage('Items Updated Successfully');
        else {
            Transfer::find($transfer->id)->delete();
            return redirect()->route('transfer.index')->withMessage('Updation Failed');
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
        Transfer::find($id)->delete();
        return redirect()->back()->withMessage('Deleted Successfully');
    }
}
