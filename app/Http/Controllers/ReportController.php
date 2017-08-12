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
//        $items = DB::table("items")->get();
//        $data['transfer'] = DB::table("transfer_details")->get();
//        $data['purchase'] = DB::table("purchases_detail")->get();
//        view()->share('data',$data);
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
