@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3>Filter Results</h3>
        <table class="table-responsive table">
            <tr>
                <form action="{{route('freezer.index')}}" method="get">
                    <td><label for="">From</label></td><td><input class="form-control" type="date" name="from"></td>
                    <td><label for="">to</label></td><td><input class="form-control" type="date" name="to"></td>
                    <td><label for="">Region</label></td>
                    <td>
                        <select name="region" id="" class="form-control">
                            <option selected value="">--Select Region--</option>
                            @foreach($regions as $region)
                                <option value="{{$region->id}}">{{$region->name}}</option>
                                @endforeach
                        </select>
                    </td>
                    <td><button class="btn btn-info" type="submit">Submit</button></td>
                </form>
            </tr>
        </table>
        <h3 style="float:left  ">Freezer Dispatched</h3>
        <a href="{{route('freezer.create')}}"  style="margin-top: 22px"class="btn btn-info pull-right ">Dispatch freezer</a>
        <a href="{{route('freezer.return')}}"  style="margin-top: 22px"class="btn btn-info pull-right ">Return freezer</a>
        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>FTN Number</th>
                <th>FTN Date</th>
                <th>Reference #</th>
                <th>Customer Code</th>
                <th>Delivery Address</th>
                <th>Type</th>
                <th>Status</th>
                <th>Qty</th>
                <th colspan="2" style="text-align: center">Actions</th>
                <th></th>

            </tr>
            @forelse($freezers as $freezer)
                <tr>

                    <td>{{$freezer->ftn_no}}</td>
                    <td>{{$freezer->ftn_date}}</td>
                    <td>{{$freezer->reference}}</td>
                    <td>{{$freezer->customer_id}}</td>
                    <td>{{$freezer->to_}}</td>
                    <td>{{$freezer->type}}</td>
                    <td>{{$freezer->status}}</td>

                    @foreach($counttransfer as $c)
                        @if($c->transfer_id==$freezer->id)
                            <td>{{$c->total}}</td>
                        @endif
                    @endforeach
                    <td width="100px">
                        <a href="{{route('freezer.transferPrint',$freezer->id)}}" title="Print Transfer Form"><img src="{{asset('images/print.png')}}" class="icon" style="height: 20px;width: auto"></a>
                        <a href="{{route('freezer.gateOutPrint',$freezer->id)}}" title="Print GateOut Form"><img src="{{asset('images/gatepass.png')}}" class="icon" style=" margin:0 0 0 10px;height: 30px;width: auto "></a>

                        {{--<a href="{{route('freezer.edit',$freezer->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>--}}
                    </td>
                    <td>
                        <form action="{{route('freezer.destroy',$freezer->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
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
                    <td>{{$return->customer_id}}</td>
                    <td>{{$return->from_}}</td>
                    <td>{{$return->type}}</td>
                    <td>Return</td>
                    @foreach($countreturn as $c)
                        @if($c->returns_id==$return->id)
                            <td>{{$c->total}}</td>
                        @endif
                    @endforeach
                    <td width="100px">
                        <a href="{{route('freezer.returnPrint',$return->id)}}" title="Print Return Form"><img src="{{asset('images/print.png')}}" class="icon" style="height: 20px;width: auto"></a>
                        <a href="{{route('freezer.gateInPrint',$return->id)}}" title="Print GateInForm Form" ><img src="{{asset('images/gatepass.png')}}" class="icon" style=" margin:0 0 0 10px;height: 30px;width: auto"></a>
                        {{--<a href="{{route('returns.edit',$return->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>--}}

                    </td>
                    <td>

                        <form action="{{route('returns.destroy',$return->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No Freezer has Returned</td>
            @endforelse

        </table>
    </div>
@endsection
