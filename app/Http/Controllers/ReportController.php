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

//        dd($request->submit);
        $sql='';$reg='';$sqlr='';
        // For dates
        $tftn_date='';$rftn_date='';$pc_date='';$dc_date='';$dat='';$stock_cd='';$cd='';
        $it='';
        $data['cdate']=date('d/m/Y');
        if($request->cdate)
        {
            $tftn_date='transfers.ftn_date<="'.$request->cdate.'"';
            $rftn_date='returns.ftn_date<="'.$request->cdate.'"';
            $pc_date='purchases.cdate<="'.$request->cdate.'"';
            $dc_date='dispatches.cdate<="'.$request->cdate.'"';
            $stock_cd=',stock.cdate';
            $cd=',cdate';
            //$dat='AND (cdate between str_to_date("08-08-1000","%d-%m-%Y") and str_to_date("'.$request->cdate.'","%d-%m-%Y")) ';
            $data['cdate']=$request->cdate;

        }
        if($request->item_name)
            $it='where items.item_group = "'.$request->item_name.'"';

        if($request->region) {
            $reg = 'SELECT reg.* from(';
            $sql=')reg
    
    LEFT OUTER JOIN 
    regions ON(regions.id=region)
    where regions.name="'.$request->region.'"';
        }

        else if($request->sub_region)
            $sqlr.='And region='.$request->sub_region;

        if($request->cdate) {
            $stock = DB::select($reg . 'SELECT fu.region,fu.item_id,sum(fu.totalIn) as totalIn,sum(fu.totalOut) as totalOut , sum(fu.TOTAL) as TOTAL,fu.cdate from ( SELECT op.region,op.item_id,op.totalIn,lftjoin.totalOut , (op.totalIn-lftjoin.totalOut) as TOTAL ,op.cdate from(
      SELECT region,sum(total) as totalIn ,item_id, stock.cdate from (
         select temp.region,sum(temp.quantity) as total ,temp.item_id, temp.cdate from(
         select purchases.region_id as region ,purchases_detail.item_id as item_id, purchases.cdate,purchases_detail.quantity from purchases_detail
           left join purchases on(purchases.id=purchases_detail.purchase_id)
        where  ' . $pc_date . '
          )  temp 
         GROUP BY temp.item_id ,temp.region,temp.cdate    
         
     UNION
     
          select temp.region,sum(temp.quantity) as total , temp.item_id, temp.cdate from(
		select transfer_details.region_id as region,transfer_details.quantity,
         transfer_details.item_id as item_id, transfers.ftn_date as cdate from transfer_details
          LEFT OUTER JOIN
          transfers on transfers.id=transfer_details.transfer_id
          where transfers.from_ is not null
  		And	 ' . $tftn_date . '
          )temp 
         GROUP BY temp.item_id ,temp.region,temp.cdate 

         union

          select temp.region , sum(temp.total),temp.item_id, temp.cdate from(
    		select return_details.region_id as region , sum(return_details.quantity) as total ,
         	 return_details.item_id as item_id, returns.ftn_date as cdate from return_details
                    left OUTER JOIN returns on returns.id=return_details.returns_id
      		where  ' . $rftn_date . '
          )temp 
     
         GROUP BY temp.item_id ,temp.region,temp.cdate
           
          )  stock
         GROUP BY stock.region,stock.item_id ,stock.cdate
        ) op 

         LEFT OUTER JOIN

        (
            SELECT region_id,item_id,sum(total) as totalOut, cdate from
        (
            
    select temp.region_id,sum(temp.quantity) as total , temp.item_id, temp.cdate from(  
		select transfers.from_ as region_id,transfer_details.quantity,
         transfer_details.item_id as item_id , transfers.ftn_date as cdate from transfer_details
          LEFT OUTER JOIN
          transfers on transfers.id=transfer_details.transfer_id
          where transfers.from_ is not null And	  ' . $tftn_date . '
        
         )temp 
     	GROUP BY temp.item_id ,temp.region_id,temp.cdate        
    UNION
           select temp.region_id,sum(temp.quantity) as total , temp.item_id, temp.cdate from(   
         select transfer_details.region_id,transfer_details.quantity,
         transfer_details.item_id as item_id , transfers.ftn_date as cdate from transfer_details
          LEFT OUTER JOIN
          transfers on transfers.id=transfer_details.transfer_id
          where transfers.from_ is null
         And ' . $tftn_date . '
        
         )temp 
     GROUP BY temp.item_id ,temp.region_id,temp.cdate
       

        UNION

        select temp.region_id,sum(temp.quantity) as total , temp.item_id, temp.cdate from(   
         
        SELECT dispatches_detail.item_id,dispatches_detail.quantity,dispatches.region_id ,dispatches.cdate
        from dispatches
        LEFT JOIN
         dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) 
        where ' . $dc_date . '
    
         )temp 
     GROUP BY temp.item_id ,temp.region_id,temp.cdate
          )t
          GROUP BY region_id,item_id ,cdate )lftjoin ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id) )fu
            LEFT OUTER  JOIN
             items
            ON (items.id=fu.item_id) 
            ' . $it . ' ' . $sqlr . '
                   GROUP BY items.id,region ,cdate
        ORDER BY cdate DESC ' . $sql);
        $custstock=DB::select($reg.'select *,(k.TotalIn-k.TotalOut) as Net from(
select ok.customer_id,ok.region_id as region,sum(ok.TotalI) as TotalIn , sum(ok.TotalO) as TotalOut, ok.item_id,ok.cdate from(

    SELECT t.customer_id , t.region_id ,t.item_id,t.total as TotalI ,ret.total as TotalO,ret.cdate from(
        
        
select temp.customer_id,temp.item_id,sum(temp.quantity) as total , temp.region_id, temp.cdate from(   
	SELECT dispatches_detail.customer_id,dispatches_detail.item_id,dispatches_detail.quantity,dispatches.region_id,dispatches.cdate
from dispatches
LEFT JOIN
     dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) 
     
     where '.$dc_date.'
    
         )temp 
     GROUP BY  temp.region_id,temp.item_id,
 temp.customer_id,temp.cdate
 UNION
select temp.customer_id,temp.item_id,sum(temp.quantity) as total , temp.region_id, temp.cdate from(   
	  
     SELECT transfers.customer_id, transfer_details.item_id,(transfer_details.quantity) ,transfer_details.region_id  , transfers.ftn_date as cdate
FROM transfers
LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
     Where '.$tftn_date.'
    
         )temp 
     GROUP BY  temp.region_id,temp.item_id,
 temp.customer_id,temp.cdate    
    )t

LEFT OUTER JOIN
(
    
    
select temp.customer_id,temp.item_id,sum(temp.quantity) as total , temp.region_id, temp.cdate from(   
	  
   select return_details.region_id , return_details.quantity , return_details.customer_id,
  return_details.item_id as item_id, returns.ftn_date as cdate from return_details
    LEFT outer JOIN returns on returns.id = return_details.returns_id
 
     Where '.$rftn_date.'
    
         )temp 
     GROUP BY  temp.region_id,temp.item_id,
 temp.customer_id,temp.cdate    )ret ON (t.region_id=ret.region_id AND t.customer_id=ret.customer_id AND t.item_id = ret.item_id)
    WHERE t.customer_id is not null 
   ORDER BY region_id ASC
   )ok
   LEFT OUTER JOIN
   items on(ok.item_id=items.id) '.$it.'
   GROUP BY ok.customer_id,ok.region_id,ok.cdate
    )k'.$sql);
        }
        else{
            $stock=DB::select($reg.'SELECT fu.region,fu.item_id,sum(fu.totalIn) as totalIn,sum(fu.totalOut) as totalOut , sum(fu.TOTAL) as TOTAL,fu.cdate from ( SELECT op.region,op.item_id,op.totalIn,lftjoin.totalOut , (op.totalIn-lftjoin.totalOut) as TOTAL ,op.cdate from(
                SELECT region,item_id,sum(total) as totalIn , cdate from (
            select purchases.region_id as region , sum(purchases_detail.quantity) as total,purchases_detail.item_id as item_id, purchases.cdate from purchases_detail
         left join purchases on(purchases.id=purchases_detail.purchase_id)
         GROUP BY purchases_detail.item_id ,purchases.region_id      
         union
         select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
         transfer_details.item_id as item_id, transfers.ftn_date as cdate from transfer_details
          LEFT OUTER JOIN
          transfers on transfers.id=transfer_details.transfer_id
          where transfers.from_ is not null
         GROUP BY transfer_details.item_id,transfer_details.region_id 

         union

          select return_details.region_id as region , sum(return_details.quantity) as total ,
          return_details.item_id as item_id, returns.ftn_date as cdate from return_details
                    left OUTER JOIN returns on returns.id=return_details.returns_id
          GROUP BY return_details.item_id,return_details.region_id 
          )  stock
         GROUP BY stock.region,stock.item_id
        ) op 

         LEFT OUTER JOIN

        (
            SELECT region_id,item_id,sum(total) as totalOut, cdate from
        (
            select transfers.from_ as region_id,sum(transfer_details.quantity) as total,
         transfer_details.item_id as item_id , transfers.ftn_date as cdate from transfer_details
          LEFT OUTER JOIN
          transfers on transfers.id=transfer_details.transfer_id
          where transfers.from_ is not null
         GROUP BY transfer_details.item_id,transfers.from_ 
            UNION
          select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
         transfer_details.item_id as item_id , transfers.ftn_date as cdate from transfer_details
          LEFT OUTER JOIN
          transfers on transfers.id=transfer_details.transfer_id
          where transfers.from_ is null
         GROUP BY transfer_details.item_id,transfer_details.region_id 

        UNION

        SELECT  dispatches.region_id ,SUM(dispatches_detail.quantity) as total,dispatches_detail.item_id,dispatches.cdate
        from dispatches
        LEFT JOIN
         dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY  dispatches.region_id,dispatches_detail.item_id 
          )t
          GROUP BY region_id,item_id  )lftjoin ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id) )fu
            LEFT OUTER  JOIN
             items
            ON (items.id=fu.item_id) 
           '.$it.' '.$sqlr.'
          
        GROUP BY items.item_group,region 

        ORDER BY region  ASC'.$sql);
            $custstock=DB::select($reg.'select *,(k.TotalIn-k.TotalOut) as Net from(
select ok.customer_id,ok.region_id as region,sum(ok.TotalI) as TotalIn , sum(ok.TotalO) as TotalOut, ok.item_id,ok.cdate from(
 SELECT t.customer_id , t.region_id ,t.item_id,t.total as TotalI ,ret.total as TotalO,ret.cdate from(
SELECT  dispatches_detail.customer_id,dispatches_detail.item_id,SUM(dispatches_detail.quantity) as total,dispatches.region_id,dispatches.cdate
from dispatches
LEFT JOIN
 dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY  dispatches.region_id,dispatches_detail.item_id,
 dispatches_detail.customer_id
 UNION
 SELECT transfers.customer_id, transfer_details.item_id,sum(transfer_details.quantity) as total,transfer_details.region_id  , transfers.ftn_date as cdate
FROM transfers
LEFT JOIN transfer_details on transfer_details.transfer_id=transfers.id
GROUP BY transfer_details.item_id,transfer_details.region_id,transfers.customer_id)t

LEFT OUTER JOIN
(
select return_details.region_id , sum(return_details.quantity) as total , return_details.customer_id,
  return_details.item_id as item_id, returns.ftn_date as cdate from return_details
    LEFT outer JOIN returns on returns.id = return_details.returns_id
  GROUP BY return_details.item_id,return_details.region_id,return_details.customer_id
    )ret ON (t.region_id=ret.region_id AND t.customer_id=ret.customer_id AND t.item_id = ret.item_id)
    WHERE t.customer_id is not null 
   ORDER BY region_id ASC
   )ok
   LEFT OUTER JOIN
   items on(ok.item_id=items.id) '.$it.'
   GROUP BY ok.customer_id,ok.region_id
    )k
    '.$sql);
        }
//        dd($stock);
//            dd($custstock);
//        $items = DB   ::table("items")->get();
//        $data['transfer'] = DB::table("transfer_details")->get();
//        $stock=null;
        $data['stock'] = $stock;
//        dd($data['stock']);
//        dd($custstock);
        $data['custstock'] = $custstock;
        if($request->type)
        $data['custstock'] = null;

        $data['item_name']=$request->item_name;
        view()->share('data',$data);
    $k=1;
        if($request->has('download') &&$k!=1){
            $pdf = PDF::loadView('reports.show');
            return $pdf->download('FreezerBalanceList.pdf');
        }
        return view('reports.show');
    }
    public function all(){
        $stock=DB::select('  select* from(  SELECT fu.region,fu.item_id,sum(fu.totalIn) as totalIn,sum(fu.totalOut) as totalOut , sum(fu.TOTAL) as TOTAL,items.name as item_name,fu.cdate from (
    SELECT op.region,op.item_id,op.totalIn,lftjoin.totalOut , (op.totalIn-lftjoin.totalOut) as TOTAL ,op.cdate from(

                SELECT region,item_id,sum(total) as totalIn , cdate from (
            select purchases.region_id as region , sum(purchases_detail.quantity) as total,purchases_detail.item_id as item_id, purchases.cdate from purchases_detail
         left join purchases on(purchases.id=purchases_detail.purchase_id)
         GROUP BY purchases_detail.item_id ,purchases.region_id      
         union
         select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
         transfer_details.item_id as item_id, transfers.ftn_date as cdate from transfer_details
          LEFT OUTER JOIN
          transfers on transfers.id=transfer_details.transfer_id
          where transfers.from_ is not null
         GROUP BY transfer_details.item_id,transfer_details.region_id

         union

          select return_details.region_id as region , sum(return_details.quantity) as total ,
          return_details.item_id as item_id, returns.ftn_date as cdate from return_details
                    left OUTER JOIN returns on returns.id=return_details.returns_id
          GROUP BY return_details.item_id,return_details.region_id
          )  stock
         GROUP BY stock.region,stock.item_id
        ) op 

         LEFT OUTER JOIN

        (
            SELECT region_id,item_id,sum(total) as totalOut, cdate from
        (
            select transfers.from_ as region_id,sum(transfer_details.quantity) as total,
         transfer_details.item_id as item_id , transfers.ftn_date as cdate from transfer_details
          LEFT OUTER JOIN
          transfers on transfers.id=transfer_details.transfer_id
          where transfers.from_ is not null
         GROUP BY transfer_details.item_id,transfers.from_
            UNION
          select transfer_details.region_id as region,sum(transfer_details.quantity) as total,
         transfer_details.item_id as item_id , transfers.ftn_date as cdate from transfer_details
          LEFT OUTER JOIN
          transfers on transfers.id=transfer_details.transfer_id
          where transfers.from_ is null
         GROUP BY transfer_details.item_id,transfer_details.region_id


        UNION

        SELECT dispatches.region_id ,SUM(dispatches_detail.quantity) as total ,dispatches_detail.item_id,dispatches.cdate
        from dispatches
        LEFT JOIN
         dispatches_detail ON(dispatches.id = dispatches_detail.dispatch_id) GROUP BY  dispatches.region_id,dispatches_detail.item_id 
          )t
          GROUP BY region_id,item_id
            )lftjoin
            ON(lftjoin.region_id=op.region AND lftjoin.item_id=op.item_id)
         )fu
            LEFT OUTER  JOIN
             items
            ON (items.id=fu.item_id) 
           
        GROUP BY items.id,region)reg
        LEFT OUTER JOIN
             regions
             on(regions.id=reg.region)

        ORDER BY region ASC');
        $custstock=DB::select(' select *,(k.TotalIn-k.TotalOut) as Net from(
select ok.customer_id,ok.region_id as region,sum(ok.TotalI) as TotalIn , sum(ok.TotalO) as TotalOut, ok.item_id from(
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
   items on(ok.item_id=items.id) 
   GROUP BY ok.customer_id,ok.region_id
    )k
    ');

        return view('reports.stockreport')->with('regionStock',$stock);

    }
    public function index(){
        $items=Item::all();
        $transfers = DB::table("transfer_details")->get();
        $regions=Region::all();
        return view('reports.index',compact(['regions','transfers','items']));
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