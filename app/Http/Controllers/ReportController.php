<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Item;
use App\Region;
use Illuminate\Http\Request;
use DB;
use PDF;

class ReportController extends Controller
{
    /*
     * Return Report for Balance List
     * @return \Illuminate\Http\Response
     */
    public function pdfview(Request $request)
    {
//        dd($request);
            $stock=DB::select('SELECT fu.region,fu.item_id,fu.totalIn,fu.totalOut ,sum(fu.totalIn) as totalIn , sum(fu.TOTAL) as TOTAL from (
        SELECT op.region,op.item_id,op.totalIn,lftjoin.totalOut , (op.totalIn-lftjoin.totalOut) as TOTAL from(
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
        ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id)  ORDER BY op.region ASC 
    )fu
        LEFT OUTER  JOIN
         items 
    	ON (items.id=fu.item_id)
    where(items.item_group = "Freezer")
    GROUP BY region
    ORDER BY region ASC');
            $custstock=DB::select('select *,(k.TotalIn-k.TotalOut) as Net from(
select ok.customer_id,ok.region_id,sum(ok.TotalI) as TotalIn , sum(ok.TotalO) as TotalOut, ok.item_id from(
 SELECT t.customer_id , t.region_id ,t.item_id,t.total as TotalI ,ret.total as TotalO from(
SELECT  dispatches_detail.customer_id,dispatches_detail.item_id,SUM(dispatches_detail.quantity) as total,dispatches.region_id
from dispatches
LEFT JOIN
 dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY  dispatches.region_id,dispatches_detail.item_id,
 dispatches_detail.customer_id
 UNION
 SELECT transfers.customer_id, transfer_details.item_id,sum(transfer_details.quantity) as total,transfer_details.region_id 
FROM transfers
LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
GROUP BY transfer_details.item_id,transfer_details.region_id,transfers.customer_id)t

LEFT OUTER JOIN
(
select return_details.region_id , sum(return_details.quantity) as total , return_details.customer_id,
  return_details.item_id as item_id from return_details
  GROUP BY return_details.item_id,return_details.region_id,return_details.customer_id
    )ret ON (t.region_id=ret.region_id AND t.customer_id=ret.customer_id AND t.item_id = ret.item_id)
    WHERE t.customer_id is not null 
   ORDER BY region_id ASC
   )ok
   LEFT OUTER JOIN
   items on(ok.item_id=items.id) WHERE (items.item_group=\'Freezer\')
   GROUP BY ok.customer_id,ok.region_id
    )k');
//        $items = DB::table("items")->get();
//        $data['transfer'] = DB::table("transfer_details")->get();
        $data['stock'] = $stock;
        $data['custstock'] = $custstock;
        view()->share('data',$data);

        if($request->has('download')){
            $pdf = PDF::loadView('reports.show');
            return $pdf->download('reports.pdf');
        }
        return view('reports.show');
    }
    public function index(){
        $items=Item::all();
        $transfers = DB::table("transfer_details")->get();
        $regions=Region::all();
        return view('reports.index',compact(['regions','transfers']));
    }
}
//SELECT lftjoin.*,op.customer_id, op.region,op.total as totalOut, (lftjoin.totalIn-op.total) as TOTAL from(
//    select return_details.region_id as region , sum(return_details.quantity) as total , return_details.customer_id,
//  return_details.item_id as item_id from return_details
//  GROUP BY return_details.item_id,return_details.region_id,return_details.customer_id
//
//) op
//
// Right OUTER JOIN
//
//(
//    SELECT region_id,item_id,sum(total) as totalIn,customer_id  from
//(
//    SELECT transfers.customer_id, transfer_details.item_id,sum(transfer_details.quantity) as total,transfer_details.region_id as region_id
//FROM transfers
//LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
//GROUP BY transfer_details.item_id,transfer_details.region_id,transfers.customer_id
//
//UNION
//
//SELECT  dispatches_detail.customer_id,dispatches_detail.item_id,SUM(dispatches_detail.quantity) as total,dispatches.region_id
//from dispatches
//LEFT JOIN
// dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY  dispatches.region_id,dispatches_detail.item_id,
// dispatches_detail.customer_id
//  )t
//  GROUP BY region_id,item_id
//	)lftjoin
//    ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id )