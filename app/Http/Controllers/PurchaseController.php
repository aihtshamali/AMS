<?php

namespace App\Http\Controllers;
use App\Purchase;
use App\Driver;
use App\Purchase_Detail;
use App\Region;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Facades\Auth;

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
            $doc_no = Purchase::all()->last();
            $part = explode(".",$doc_no);
            $no = intval($part[1]);
            $no++;
            $doc_no = "POC.".substr("000000", 1, 6 - strlen($no)).$no;

        }
        else {
            $doc_no = 'POC.000001';
        }
        $drivers=Driver::all();
        $vehicles =Vehicle::all();
        $regions= Region::all();
        $items= Item::all();
        return view('purchase.create',compact(['drivers','vehicles','doc_no','regions','items']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->item[1][$request->getid[1]]);
        $purchase= new Purchase();
        $purchase->doc_no=$request->doc_no;
        $purchase->reference=$request->reference;
        $purchase->driver()->associate($request->driver);
        $region= Region::where('name',$request->region)->first();
        $purchase->region()->associate($region);
        $purchase->vehicle()->associate($request->vehicle);
        $purchase->cdate=$request->ftn_date;
        $purchase->user()->associate(Auth::user());
        $purchase->save();
        for($i=0;$i<count(Item::all());$i++){
                $it=$request->item[$i];
                if ($it[$request->getid[$i]] && $it[$request->getid[$i]] > 0) {
                    $purchase_detail = new Purchase_Detail();
                    $purchase_detail->quantity = $it[$request->getid[$i]];
                    $purchase_detail->item()->associate(Item::find($request->getid[$i]));
                    $purchase_detail->purchase()->associate($purchase->id);
                    $purchase_detail->save();
                }
            }
        if($i=0) {
            Purchase::find($purchase->id)->delete();
            return redirect()->route('purchase.index')->withMessage("Data Insertion Failed");
        }
        else
                return redirect()->route('purchase.index')->withMessage("Data Inserted Successfully");
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
