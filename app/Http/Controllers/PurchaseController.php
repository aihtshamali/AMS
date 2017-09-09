<?php

namespace App\Http\Controllers;
use App\Purchase;
use App\Driver;
use App\Purchase_Detail;
use App\Region;
use App\Stock;
use App\UserItem;
use App\Vehicle;
use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase=Purchase::all();
        $purchases=DB::select('SELECT DISTINCT purchases.* FROM purchases
inner join (
select purchases_detail.* FROM purchases_detail
        INNER JOIN(
        SELECT user_items.* from user_items
        WHERE user_items.user_id='.Auth::user()->id.'
        )td on(purchases_detail.item_id=td.item_id)
    ) v on (v.purchase_id=purchases.id)
  ');
        return view('purchase.index',compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doc_no=0;
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
        $drivers=Driver::where('region_id',Auth::user()->region_id)->get();
        $vehicles =Vehicle::where('region_id',Auth::user()->region_id)->get();
        $regions= Region::all();

        $allowed=UserItem::where('user_id',Auth::user()->id)->get();
        $items= DB::select('
        SELECT items.* from items
INNER JOIN(
SELECT user_items.user_id,user_items.item_id as item FROM
    user_items
    where(user_items.user_id='.Auth::user()->id.')
)td ON (td.item=items.id)
        ');


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
        $region_name = explode('/', $request->region);
        $region = Region::where('name', $region_name)->first();
        $purchase->region()->associate($region);
        $purchase->vehicle()->associate($request->vehicle);
        $purchase->cdate=$request->ftn_date;
        $purchase->user()->associate(Auth::user());
        $purchase->save();

        for($i=0;$i<count($request->item);$i++) {
            $it = $request->item[$i];
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
        $purchases=Purchase_Detail::where('purchase_id',$id)->get();
        $drivers=Driver::where('region_id',Auth::user()->region_id)->get();
        $vehicles =Vehicle::where('region_id',Auth::user()->region_id)->get();
        $regions= Region::all();
        $items= DB::select('
        SELECT items.* from items
INNER JOIN(
SELECT user_items.user_id,user_items.item_id as item FROM
    user_items
    where(user_items.user_id='.Auth::user()->id.')
)td ON (td.item=items.id)
        ');
        return view('purchase.show',compact(['drivers','vehicles','items','regions','purchases']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchases=Purchase_Detail::where('purchase_id',$id)->get();
        $drivers=Driver::where('region_id',Auth::user()->region_id)->get();
        $vehicles =Vehicle::where('region_id',Auth::user()->region_id)->get();
        $regions= Region::all();
        $items= DB::select('
        SELECT items.* from items
INNER JOIN(
SELECT user_items.user_id,user_items.item_id as item FROM
    user_items
    where(user_items.user_id='.Auth::user()->id.')
)td ON (td.item=items.id)
        ');
        return view('purchase.edit',compact(['drivers','vehicles','items','regions','purchases']));
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

        $purchase = Purchase::find($id);

        $pd=Purchase_Detail::where('purchase_id',$id)->get(); //to Get the Stock Back
        foreach ($pd as $d){                                    //and then I'll Subtract it
            $stock = Stock::where('region_id', $purchase->region_id)->where('item_id', $d->item_id)->first();
            if ($stock) {
                $quantity = $stock->quantity;
                $stock->quantity = $quantity - $d->quantity;
                if($stock->quantity<0)
                    $stock->quantity=0;
                $stock->save();
            }
        }


        $purchase->doc_no=$request->doc_no;
        $purchase->reference=$request->reference;
        $purchase->driver()->associate($request->driver);
        $region= Region::where('name',$request->region)->first();
        $purchase->region()->associate($region);
        $purchase->vehicle()->associate($request->vehicle);
        $purchase->cdate=$request->ftn_date;
        $purchase->user()->associate(Auth::user());

        Purchase_Detail::where('purchase_id',$id)->delete();

        for($i=0;$i<count(Item::all());$i++){
            $it=$request->item[$i];
            if ($it[$request->getid[$i]] && $it[$request->getid[$i]] > 0) {
                $purchase_detail = new Purchase_Detail();
                $purchase_detail->quantity = $it[$request->getid[$i]];
                $purchase_detail->item()->associate(Item::find($request->getid[$i]));
                $purchase_detail->purchase()->associate($purchase->id);
                $stock=Stock::where('region_id',$purchase->region_id)->where('item_id',$purchase_detail->item_id)->first();
                if($stock) {
                    $quantity=$stock->quantity;
                    $stock->quantity= $purchase_detail->quantity+$quantity;
                }
                else {
                    $stock = new Stock();
                    $stock->item()->associate($purchase_detail->item);
                    $stock->region()->associate($purchase->region);
                    $stock->quantity = $purchase_detail->quantity;
                }
                $stock->save();
                $purchase_detail->save();
            }

        }
        if($i=0) {
            return redirect()->route('purchase.index')->withMessage("Data Updation Failed");
        }
        else {
            $purchase->save();
            return redirect()->route('purchase.index')->withMessage("Data Updated Successfully");
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
        Purchase::find($id)->delete();
        return redirect()->route('purchase.index')->withMessage('Deleted Successfully');
    }
}
