<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\Customer;
use App\Region;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $customers= Customer::paginate(7);
        return view('customer.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions=Region::all();
        $cities=City::all();
        $categories=Category::all();
        return view('customer.create',compact(['regions','cities','categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer= new customer();
        $customer->account_name= $request->account_name;
        $customer->account_no= $request->account_no;
        $customer->address = $request->address;
        $customer->phone= $request->phone;
        $customer->is_active= $request->is_active;
        $customer->city_id=$request->city;
        $customer->customer_group=$request->customer_group;

        $customer->region_id=$request->region;

        $customer->save();
        return redirect()->route('customer.index')->withMessage('Data Inserted Successfully');
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
        $regions=Region::all();
        $cities=City::all();
        $categories=Category::all();
        $customer= Customer::find($id);
        return view('customer.edit',compact(['regions','cities','categories','customer']));

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
        Customer::find($id)->delete();
        $customer= new customer();
        $customer->account_name= $request->account_name;
        $customer->account_no= $request->account_no;
        $customer->address = $request->address;
        $customer->phone= $request->phone;
        $customer->is_active= $request->is_active;
        $customer->city_id=$request->city;
        $customer->customer_group=$request->customer_group;
        $customer->region_id=$request->region;
        $customer->save();
        return redirect()->route('customer.index')->withMessage('Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('Customer.index')->withMessage('Customer Data Deleted Successfully');
    }
}
