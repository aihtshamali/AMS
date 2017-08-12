<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Dispatch;
use App\Dispatches_Detail;
use App\Driver;
use App\Faculty;
use App\Item;
use App\Purchase;
use App\Region;
use App\Returns;
use App\Returns_Detail;
use App\Stock;
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

        $dispatches = Dispatch::all();
        return view('dispatch.index', compact('dispatches'));
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
            $part = explode(".", $doc_no);
            $no = intval($part[1]);
            $no++;
            $doc_no = "DOC." . substr("000000", 1, 6 - strlen($no)) . $no;
        } else {
            $doc_no = 'DOC.000001';
        }
//        ->leftJoin('transfer_details','transfers.id','=','transfer_details.transfer_id') '(purchases_detail.quantity - transfer_details.quantity) AS total'
        $items = Item::all();
        $customers = Customer::all();
        $drivers = Driver::where('region_id', Auth::user()->region_id)->get();
        $vehicles = Vehicle::where('region_id', Auth::user()->region_id)->get();

        $stockpurchase = DB::table('purchases')->select('purchases.region_id as P_region_id', 'purchases_detail.item_id as P_item_id', 'purchases_detail.quantity as P_quantity')
            ->leftJoin('purchases_detail', 'purchases_detail.purchase_id', '=', 'purchases.id')
            ->where('purchases.region_id', Auth::user()->region_id)
            ->get();
        $stocktransfer = DB::table('transfers')->select('transfers.from_ as T_from_region', 'transfer_details.region_id as T_to_region', 'transfer_details.item_id as T_item_id', 'transfer_details.quantity as T_quantity')
            ->leftJoin('transfer_details', 'transfers.id', '=', 'transfer_details.transfer_id')
            ->where('transfers.from_', Auth::user()->region_id)
            ->get();

        $stockout = DB::select('SELECT region,item_id,sum(stock.total) as total from (
 select purchases.region_id as region , sum(purchases_detail.quantity) as total,purchases_detail.item_id as item_id from purchases_detail
 left join purchases on(purchases.id=purchases_detail.purchase_id)
 GROUP BY purchases_detail.item_id

 union

 select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
 transfer_details.item_id as item_id from transfer_details
 GROUP BY transfer_details.item_id,transfer_details.region_id

 union

  select return_details.region_id as region , sum(return_details.quantity) as total ,
  return_details.item_id as item_id from return_details
  GROUP BY return_details.item_id,return_details.region_id
  )  stock
 GROUP BY stock.region,stock.item_id');

$stockin=DB::select('SELECT region_id,item_id,sum(total) as net from
(
    SELECT transfer_details.item_id,sum(transfer_details.quantity) as total,transfers.from_ as region_id
FROM transfers
LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
GROUP BY transfer_details.quantity,transfers.from_

UNION

SELECT dispatches_detail.item_id,SUM(dispatches_detail.quantity) as total,dispatches.region_id
from dispatches
LEFT JOIN
dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY dispatches.region_id,dispatches_detail.item_id

 )t
 GROUP BY region_id,item_id');
        $stock=DB::select('SELECT op.region,op.item_id,op.totalIn,lftjoin.totalOut , (op.totalIn-lftjoin.totalOut) as TOTAL from(
 SELECT region,item_id,sum(total) as totalIn from (
        select purchases.region_id as region , sum(purchases_detail.quantity) as total,purchases_detail.item_id as item_id from purchases_detail
 left join purchases on(purchases.id=purchases_detail.purchase_id)
 GROUP BY purchases_detail.item_id ,purchases.region_id
 

 union

 select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
 transfer_details.item_id as item_id from transfer_details
 GROUP BY transfer_details.item_id,transfer_details.region_id

 union

  select return_details.region_id as region , sum(return_details.quantity) as total ,
  return_details.item_id as item_id from return_details
  GROUP BY return_details.item_id,return_details.region_id
  )  stock
 GROUP BY stock.region,stock.item_id
) op 
 
 LEFT OUTER JOIN 
    
(
 SELECT region_id,item_id,sum(total) as totalOut from
  (
   SELECT transfer_details.item_id,sum(transfer_details.quantity) as total,transfers.from_ as region_id
FROM transfers
LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
GROUP BY transfer_details.item_id,transfers.from_

UNION

SELECT dispatches_detail.item_id,SUM(dispatches_detail.quantity) as total,dispatches.region_id
from dispatches
LEFT JOIN
 dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY  dispatches.region_id,dispatches_detail.item_id

  )t
  GROUP BY region_id,item_id
	)lftjoin
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id) where region_id='.Auth::user()->region_id.'');

//
//
//        SELECT region,item_id,(total) from(
//
//        SELECT region,item_id,sum(stock.total) as total from (
//        select purchases.region_id as region , sum(purchases_detail.quantity) as total,purchases_detail.item_id as item_id from purchases_detail
// left join purchases on(purchases.id=purchases_detail.purchase_id)
// GROUP BY purchases_detail.item_id
//
// union
//
// select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
// transfer_details.item_id as item_id from transfer_details
// GROUP BY transfer_details.item_id,transfer_details.region_id
//
// union
//
//  select return_details.region_id as region , sum(return_details.quantity) as total ,
//  return_details.item_id as item_id from return_details
//  GROUP BY return_details.item_id,return_details.region_id
//  )  stock
// GROUP BY stock.region,stock.item_id
//
// UNION
//
// SELECT region_id,item_id,sum(total) as net from
//    (
//        SELECT transfer_details.item_id,sum(transfer_details.quantity) as total,transfers.from_ as region_id
//FROM transfers
//LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
//GROUP BY transfer_details.quantity,transfers.from_
//
//UNION
//
//SELECT dispatches_detail.item_id,SUM(dispatches_detail.quantity) as total,dispatches.region_id
//from dispatches
//LEFT JOIN
//dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY dispatches.region_id,dispatches_detail.item_id
//
// )t
// GROUP BY region_id,item_id
//    )final
//    GROUP BY region,item_id
//

//        SELECT transfer_details.item_id,sum(transfer_details.quantity) as total,transfers.from_
//FROM transfers
//LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
//GROUP BY transfer_details.quantity,transfers.from_


//        dd($stock);
//        $stockdispatch=DB::table('dispatches')->select('')
//            ->get();
        //$stock= collect([$stockpurchase,$stocktransfer]);
//        dd($stockpurchase);
        $transfer = DB::table('purchases')->select('purchases.region_id', 'purchases_detail.item_id', 'purchases_detail.quantity')->leftJoin('purchases_detail', 'purchases_detail.purchase_id', '=', 'purchases.id')
            ->get();

        //        $stock=Stock::where('region_id',Auth::user()->region_id)->get();
        $dispatch_detail = Dispatches_Detail::all();
        return view('dispatch.create', compact(['drivers','stock', 'customers', 'stockout','stockin','vehicles', 'items', 'doc_no', 'stockpurchase', 'stocktransfer', 'dispatch_detail']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
//        dd($request->all());
        $dispatch = new Dispatch();
        $dispatch->doc_no = $request->doc_no;
        $dispatch->reference = $request->reference;
        $dispatch->cdate = $request->cdate;
        $region_name = explode('/', $request->from_);
        $region = Region::where('name', $region_name)->first();
        $dispatch->region()->associate($region->id);
        $dispatch->to_ = $region = Region::where('name', 'Customer')->first()->id;
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
                $it = $request->item[$counter];
                for ($i = 0; $i < count($request->getid); $i++) {
                    if ($it[$request->getid[$i]] && $it[$request->getid[$i]] > 0) {
                        $dispatch_detail = new Dispatches_Detail();
                        $custom=Customer::where('account_name',$cust)->first();
                        $dispatch_detail->customer()->associate($custom->id);
                        $dispatch_detail->quantity = $it[$request->getid[$i]];
                        $dispatch_detail->item()->associate(Item::find($request->getid[$i]));
                        $dispatch_detail->sales_invoice = $request->sales_invoice[$counter];
                        $dispatch_detail->dispatch()->associate($dispatch->id);
                        $dispatch_detail->save();
//                        // For region
//                        $stock = Stock::where('region_id', $dispatch->region_id)->where('item_id', $dispatch_detail->item_id)->first();
//                        if ($stock) {
//                            $quantity = $stock->quantity;
//                            $stock->quantity = $quantity - $dispatch_detail->quantity;
//                            if ($stock->quantity < 0)
//                                $stock->quantity = 0;
//                            $stock->save();
//                        }
//                        // For Customer
//                        $customer = Region::where('name', 'Customer')->first();
//                        $Custstock = Stock::where('region_id', 1)->where('customer_id', $dispatch_detail->customer_id)->where('item_id', $dispatch_detail->item_id)->first();
////                           dd($Custstock);
//                        if ($Custstock) {
//                            $quantity = $Custstock->quantity;
//                            $Custstock->quantity = $quantity + $dispatch_detail->quantity;
//                            $Custstock->save();
//                        } else {
//                            $Custstock = new Stock();
//                            $quantity = $Custstock->quantity;
//                            $Custstock->region()->associate($customer->id);
//                            $Custstock->customer()->associate($dispatch_detail->customer_id);
//                            $Custstock->item()->associate($dispatch_detail->item_id);
//                            $Custstock->quantity = $quantity + $dispatch_detail->quantity;
//                            $Custstock->save();
//                        }


                    }
                }
            }
            $counter++;
        }
        if ($i = 0) {
            Dispatch::find($dispatch->id)->delete();
            return redirect()->route('dispatch.index')->withMessage("Data Insertion Failed");

        } else
            return redirect()->route('dispatch.index')->withMessage('Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dispatch = Dispatch::find($id);
        $items = Item::all();
        $customers = Customer::all();
        $drivers = Driver::where('region_id', $dispatch->region_id)->get();
        $vehicles = Vehicle::where('region_id', $dispatch->region_id)->get();
        $dispatch_detail = Dispatches_Detail::where('dispatch_id', $dispatch->id)->get();
//        $dispatch_detail=DB::table('dispatches_detail')
//            ->select(DB::raw('count(*) as customer_count, dispatch_id'))
//            ->where('dispatch_id', '=', $dispatch->id)
//            ->groupBy('customer_id')
//            ->get();
        $regions = Region::all();

        $stock=DB::select('SELECT op.region,op.item_id,op.totalIn,lftjoin.totalOut , (op.totalIn-lftjoin.totalOut) as TOTAL from(
 SELECT region,item_id,sum(total) as totalIn from (
        select purchases.region_id as region , sum(purchases_detail.quantity) as total,purchases_detail.item_id as item_id from purchases_detail
 left join purchases on(purchases.id=purchases_detail.purchase_id)
 GROUP BY purchases_detail.item_id

 union

 select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
 transfer_details.item_id as item_id from transfer_details
 GROUP BY transfer_details.item_id,transfer_details.region_id

 union

  select return_details.region_id as region , sum(return_details.quantity) as total ,
  return_details.item_id as item_id from return_details
  GROUP BY return_details.item_id,return_details.region_id
  )  stock
 GROUP BY stock.region,stock.item_id
) op 
 
 LEFT OUTER JOIN 
    
(
 SELECT region_id,item_id,sum(total) as totalOut from
  (
   SELECT transfer_details.item_id,sum(transfer_details.quantity) as total,transfers.from_ as region_id
FROM transfers
LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
GROUP BY transfer_details.quantity,transfers.from_

UNION

SELECT dispatches_detail.item_id,SUM(dispatches_detail.quantity) as total,dispatches.region_id
from dispatches
LEFT JOIN
 dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY  dispatches.region_id,dispatches_detail.item_id

  )t
  GROUP BY region_id,item_id
	)lftjoin
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id)');

        return view('dispatch.show', compact(['regions', 'drivers', 'stock', 'customers', 'vehicles', 'items', 'dispatch', 'dispatch_detail']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function returnDispatch($id)
    {
        $doc_no = 0;

        if (Returns::all()->last()) {
            $doc_no = Returns::all()->last();
            $part = explode(".", $doc_no);
//            dd($part);
            $no = intval($part[1]);
            $no++;
            $doc_no = "RTN." . substr("000000", 1, 6 - strlen($no)) . $no;
        } else {
            $doc_no = 'RTN.000001';
        }

        $dispatch = Dispatch::find($id);
        $items = Item::all();
        $customers = Customer::all();
        $drivers = Driver::where('region_id', $dispatch->region_id)->get();
        $vehicles = Vehicle::where('region_id', $dispatch->region_id)->get();
        $dispatch_detail = Dispatches_Detail::where('dispatch_id', $dispatch->id)->get();
        $stock = Stock::where('region_id', $dispatch->region_id)->get();

        return view('dispatch.returnDispatch', compact(['stock', 'drivers', 'customers', 'vehicles', 'items', 'dispatch', 'doc_no', 'dispatch_detail']));
    }

    public function edit($id)
    {
        $dispatch = Dispatch::find($id);
        $items = Item::all();
        $customers = Customer::all();
        $drivers = Driver::where('region_id', $dispatch->region_id)->get();
        $vehicles = Vehicle::where('region_id', $dispatch->region_id)->get();
        $dispatch_detail = Dispatches_Detail::where('dispatch_id', $dispatch->id)->get();
//        $dispatch_detail=DB::table('dispatches_detail')
//            ->select(DB::raw('count(*) as customer_count, dispatch_id'))
//            ->where('dispatch_id', '=', $dispatch->id)
//            ->groupBy('customer_id')
//            ->get();
        $regions = Region::all();

        $stock=DB::select('SELECT op.region,op.item_id,op.totalIn,lftjoin.totalOut , (op.totalIn-lftjoin.totalOut) as TOTAL from(
 SELECT region,item_id,sum(total) as totalIn from (
        select purchases.region_id as region , sum(purchases_detail.quantity) as total,purchases_detail.item_id as item_id from purchases_detail
 left join purchases on(purchases.id=purchases_detail.purchase_id)
 GROUP BY purchases_detail.item_id

 union

 select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
 transfer_details.item_id as item_id from transfer_details
 GROUP BY transfer_details.item_id,transfer_details.region_id

 union

  select return_details.region_id as region , sum(return_details.quantity) as total ,
  return_details.item_id as item_id from return_details
  GROUP BY return_details.item_id,return_details.region_id
  )  stock
 GROUP BY stock.region,stock.item_id
) op 
 
 LEFT OUTER JOIN 
    
(
 SELECT region_id,item_id,sum(total) as totalOut from
  (
   SELECT transfer_details.item_id,sum(transfer_details.quantity) as total,transfers.from_ as region_id
FROM transfers
LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
GROUP BY transfer_details.quantity,transfers.from_

UNION

SELECT dispatches_detail.item_id,SUM(dispatches_detail.quantity) as total,dispatches.region_id
from dispatches
LEFT JOIN
 dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY  dispatches.region_id,dispatches_detail.item_id

  )t
  GROUP BY region_id,item_id
	)lftjoin
    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id)');

        return view('dispatch.edit', compact(['regions', 'drivers', 'stock', 'customers', 'vehicles', 'items', 'dispatch', 'dispatch_detail']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

//        dd($request->all());
        $dispatch = Dispatch::find($id);


        $dd = Dispatches_Detail::where('dispatch_id', $id)->get(); //to Get the Stock Back
        foreach ($dd as $d) {                                    //and then I'll Subtract it
            $stock = Stock::where('region_id', $dispatch->region_id)->where('item_id', $d->item_id)->first();
            if ($stock) {
                $quantity = $stock->quantity;
                $stock->quantity = $quantity + $d->quantity;
                $stock->save();
            }
            // For Customer
            $Custstock = Stock::where('region_id', 1)->where('customer_id', $d->customer_id)->where('item_id', $d->item_id)->first();
//                           dd($Custstock);
            if ($Custstock) {
                $quantity = $Custstock->quantity;
                $Custstock->quantity = $quantity - $d->quantity;
                $Custstock->save();
            }
        }

        Dispatches_Detail::where('dispatch_id', $id)->delete();  // Delete Old Dispatch_Detail of this Dispatch ID


        $dispatch->doc_no = $request->doc_no;
        $dispatch->reference = $request->reference;
        $dispatch->cdate = $request->cdate;
        $region_name = explode('/', $request->from_);
        $region = Region::where('name', $region_name)->first();
        $dispatch->region()->associate($region->id);
        $dispatch->to_ = Region::where('name', 'Customer')->first()->id;
        $dispatch->confirmed_by = 0;
        $dispatch->user_id = Auth::user()->id;
        $dispatch->vehicle_id = $request->vehicle_id;
        $dispatch->driver_id = $request->driver_id;
        $counter = 0;

        foreach ($request->customer as $cust) {
            if ($cust == null) {
                break;
            } else {
                $it = $request->item[$counter];
                for ($i = 0; $i < count($request->getid); $i++) {
                    if ($it[$request->getid[$i]] && $it[$request->getid[$i]] > 0) {
                        $dispatch_detail = new Dispatches_Detail();
                        $custom=Customer::where('account_name',$cust)->first();
                        $dispatch_detail->customer()->associate($custom->id);
                        $dispatch_detail->quantity = $it[$request->getid[$i]];
                        $dispatch_detail->item()->associate(Item::find($request->getid[$i]));
                        $dispatch_detail->sales_invoice = $request->sales_invoice[$counter];
                        $dispatch_detail->dispatch()->associate($dispatch->id);
                        $dispatch_detail->save();
//                        $stock = Stock::where('region_id', $dispatch->region_id)->where('item_id', $dispatch_detail->item_id)->first();
//                        if ($stock) {
//                            $quantity = $stock->quantity;
//                            $stock->quantity = $quantity - $dispatch_detail->quantity;
//                            if ($stock->quantity < 0)
//                                $stock->quantity = 0;
//                            $stock->save();
//                        }
//                        // For Customer
//                        $customer = Region::where('name', 'Customer')->first();
//                        $Custstock = Stock::where('region_id', $customer)->where('customer_id', $dispatch_detail->customer_id)->where('item_id', $dispatch_detail->item_id)->first();
////                           dd($Custstock);
//                        if ($Custstock) {
//                            $quantity = $Custstock->quantity;
//                            $Custstock->quantity = $quantity + $dispatch_detail->quantity;
//                            $Custstock->save();
//                        } else {
//                            $Custstock = new Stock();
//                            $quantity = $Custstock->quantity;
//
//                            $Custstock->region()->associate($customer->id);
//                            $Custstock->customer()->associate($dispatch_detail->customer_id);
//                            $Custstock->item()->associate($dispatch_detail->item_id);
//                            $Custstock->quantity = $quantity + $dispatch_detail->quantity;
//                            $Custstock->save();
//                        }
                    }
                }
            }
            $counter++;
        }
        if ($i = 0) {

            return redirect()->route('dispatch.index')->withMessage("Data Updated Failed");

        } else {
            $dispatch->save();
            return redirect()->route('dispatch.index')->withMessage('Data Updated Successfully');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Dispatch::find($id)->delete();
        return redirect()->route('dispatch.index')->withMessage('Deleted Successfully');
    }
}
