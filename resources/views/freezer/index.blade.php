@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center">
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3>Filter Results</h3>
        <table class="table-responsive table">
            <tr>
                <form action="{{route('freezer.index')}}" method="get">
                    <td><input type="text" class="form-control" name="doc_no" placeholder="Reference No"></td>
                    <td><label for="">From</label></td>
                    <td><input class="form-control datepicker" placeholder="dd-mm-yyyy" type="text" name="from"></td>
                    <td><label for="">To</label></td>
                    <td><input class="form-control datepicker" placeholder="dd-mm-yyyy" type="text" name="to"></td>
                    <td><label for="">Region</label></td>
                    <td>
                        <select name="region" id="" class="form-control">
                            <option selected value="">--Select Region--</option>
                            @foreach($regions as $region)
                                <option value="{{$region->id}}">{{$region->name}}/{{$region->sub_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    {{--<td><label for="status">Status</label></td>--}}
                    {{--<td>--}}
                        {{--<select name="status" class="form-control" id="">--}}
                            {{--<option value="" selected>--Select Status--</option>--}}
                            {{--<option value="Received">Received</option>--}}
                            {{--<option value="Pending">Pending</option>--}}
                        {{--</select>--}}
                    {{--</td>--}}
                    {{--<td><input type="text" name="customer_code" class="form-control" placeholder="Customer_Code...">--}}
                    {{--</td>--}}
                    <td>
                        <button class="btn btn-info" type="submit">Submit</button>
                    </td>
                </form>
            </tr>
        </table>
        <h3 style="color: darkgreen;
    float: left;
    font-weight: bold ">AMS =>All Freezer List</h3>
        <a href="{{route('freezer.return')}}" style="margin-top: 22px" class="btn btn-info pull-right ">Return
            Freezer</a>
        <a href="{{route('freezer.create')}}" style="margin-top: 22px" class="btn btn-info pull-right ">Transfer
            Freezer</a>
        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Ref.No.</th>
                <th>Date</th>
                <th>Reference</th>
                <th>Customer Name</th>
                <th>Region</th>
                <th>City</th>
                <th>Qty</th>
                <th colspan="2" style="text-align: center">Actions</th>
                <th></th>

            </tr>
            {{--{{dd($freezers)}}--}}
            @forelse($freezers as $freezer)
                <tr>

                    <td>{{$freezer->ftn_no}}</td>
                    <td>{{$freezer->ftn_date}}</td>
                    <td>{{$freezer->reference}}</td>
                    <td>{{getCustomer($freezer->customer_id)->account_name}}</td>
                    <td>{{getRegion($freezer->region)->name}}</td>
                    <td>{{getRegion($freezer->region)->sub_name}}</td>

                    <td>{{$freezer->qty}}</td>
                    <td width="175px">
                        <a href="{{route('freezer.transferPrint',$freezer->id)}}" title="Print Transfer Form"><img
                                    src="{{asset('images/print.png')}}" class="icon"
                                    style="height: 20px;width: auto"></a>
                        <a href="{{route('freezer.gateOutPrint',$freezer->id)}}" title="Print GateOut Form"><img
                                    src="{{asset('images/gatepass.png')}}" class="icon"
                                    style=" margin:0 0 0 10px;height: 30px;width: auto "></a>
                        <a href="{{route('freezer.show',$freezer->id)}}">
                            <img src="{{asset('images/show.png')}}" alt="ShowPage" class="icon"
                                 style=" margin:0 0 0 7px;height: 20px;width: auto">
                        </a>

                        <a href="{{route('freezer.edit',$freezer->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                    <td>
                        <form action="{{route('freezer.destroy',$freezer->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Cancel">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No freezer has Dispatched</td>
            @endforelse
            @forelse($returns as $return)
                <tr>
                    <td>{{$return->ftn_no}}</td>
                    <td>{{$return->ftn_date}}</td>
                    <td>{{$return->reference}}</td>
                    <td>{{getCustomer($return->customer_id)->account_name}}</td>
                    <td>{{getRegion($return->region)->name}}</td>
                    <td>{{getRegion($return->region)->sub_name}}</td>
                    <td>{{$return->qty}}</td>
                    <td width="110px">
                        <a href="{{route('freezer.returnPrint',$return->id)}}" title="Print Return Form"><img
                                    src="{{asset('images/print.png')}}" class="icon"
                                    style="height: 20px;width: auto"></a>
                        <a href="{{route('freezer.gateInPrint',$return->id)}}" title="Print GateInForm Form"><img
                                    src="{{asset('images/gatepass.png')}}" class="icon"
                                    style=" margin:0 0 0 10px;height: 30px;width: auto"></a>
                        <a href="{{route('returns.show',$return->id)}}">
                            <img src="{{asset('images/show.png')}}" alt="ShowPage" class="icon"
                                 style=" margin:0 0 0 7px;height: 20px;width: auto">
                        </a>
                        {{--<a href="{{route('returns.edit',$return->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>--}}

                    </td>
                    <td>

                        <form action="{{route('returns.destroy',$return->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Cancel">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No Freezer has Returned</td>
            @endforelse

        </table>
    </div>
@endsection
