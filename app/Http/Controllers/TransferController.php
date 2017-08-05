<?php

namespace App\Http\Controllers;
use App\Driver;
use App\Item;
use App\Region;
use App\Stock;
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

        $transfers= Transfer::where('status','Received')->get();
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
        $drivers=Driver::where('region_id',Auth::user()->region_id)->get();
        $vehicles =Vehicle::where('region_id',Auth::user()->region_id)->get();
        $regions=Region::all();
        $useritems=UserItem::where('user_id',Auth::user()->id)->get();
        $stock=Stock::where('region_id',Auth::user()->region_id)->get();
        return view('transfer.shipped',compact(['stock','drivers','vehicles','doc_no','regions','useritems']));
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
        $region_name=explode('/',$request->from_);
        $region=Region::where('name',$region_name)->first();
        $transfer->from_=$region->id;
        $transfer->status="Pending";
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


                $stock=Stock::where('region_id',$transfer->from_)->where('item_id',$transfer_detail->item_id)->first();

                if($stock) {
                    $quantity=$stock->quantity;
                    $stock->quantity= $quantity- $transfer_detail->quantity;
                    if($stock->quantity<0)
                    {
                        $stock->quantity=0;
                        Transfer::find($transfer->id)->delete();
                        return redirect()->route('transfer.index')->withMessage('Don\'t have much stock to complete this process ');
                    }
                    $stock->save();
                }
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

    public function transit(){
        $transfers= Transfer::where('status','Pending')->get();
        return view('transfer.transit',compact('transfers'));
    }

    public function transferReceived(Request $request , $id){



        $transfer= Transfers_Detail::where('transfer_id',$id)->get();
//        dd($transfer);
        $transfer[0]->transfer->status="Received";
        $transfer[0]->transfer->confirmed_by=Auth::user()->id;

        $reg=Region::find($transfer[0]->region_id);

        foreach($transfer as $t) {
            $stock=Stock::where('region_id',$reg->id)->where('item_id',$t->item_id)->first();

            if ($stock) {
                $quantity = $stock->quantity;
                $stock->quantity = $t->quantity + $quantity;
            } else {
                $stock = new Stock();
                $stock->item()->associate($t->item);
                $stock->region()->associate($t->region);
                $stock->quantity = $t->quantity;
            }
            $stock->save();
        }
            $transfer[0]->transfer->save();
        return redirect()->back()->withMessage("Transfered Successfully Received");
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
        $vehicles =Vehicle::where('region_id',Auth::user()->region_id)->get();
        $drivers=Driver::where('region_id',Auth::user()->region_id)->get();
        $useritems=UserItem::where('user_id',Auth::user()->id)->get();
        $stock=Stock::where('region_id',Auth::user()->region_id)->get();
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

        $transfer =  Transfer::find($id);
        $transfer->customer()->associate(Customer::find($request->customer));
        $transfer->ftn_no = $request->doc_no;
        $transfer->reference = $request->reference;
        $transfer->ftn_date = $request->ftn_date;
        $transfer->vehicle_id=$request->vehicle_id;
        $transfer->driver_id=$request->driver_id;
        $region_name=explode('/',$request->from_);
        $region=Region::where('name',$region_name)->first();
        $transfer->from_=$region->id;
        $transfer->placement_date = $request->placement_date;

        $i=0;
        Transfer_details::where('transfer_id',$id)->get()->delete();
        for(;$i<count($request->items);$i++) {
            if ($request->items[$i] != null) {
                $transfer_detail = new Transfers_Detail();
                $transfer_detail->item()->associate($request->getid[$i]);
                $transfer_detail->region()->associate($request->region_id);
                $transfer_detail->quantity = $request->items[$i];
                $transfer_detail->transfer()->associate($transfer);
                $transfer_detail->save();
//                $stock=Stock::where('region_id',$transfer->from_)->where('item_id',$transfer_detail->item_id)->first();
//
//                if($stock) {
//                    $quantity=$stock->quantity;
//                    $stock->quantity= $quantity- $transfer_detail->quantity;
//                    if($stock->quantity<0)
//                    {
//                        Transfer::find($transfer->id)->delete();
//                        return redirect()->route('transfer.index')->withMessage('Don\'t have much stock to complete this process ');
//                    }
//                    $stock->save();
//                }
            }
        }
        if ($i > 0) {
            $transfer->save();
            return redirect()->route('transfer.index')->withMessage('Items Updated Successfully');
        }else {
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
