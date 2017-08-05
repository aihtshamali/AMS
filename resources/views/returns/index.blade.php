@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left  ">Returns</h3>
        <a href="{{route('returns.create')}}"  style="margin-top: 22px"class="btn btn-info pull-right "> Add Return</a>
        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>FTN Number</th>
                <th>FTN Date</th>
                <th>Reference #</th>
                <th>Customer Code</th>
                <th>From</th>
                <th>To</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Actions</th>
                <th></th>

            </tr>
            {{--{{dd($returns)}}--}}
            @forelse($returns as $return)
                <tr>
                    <td>{{$return->ftn_no}}</td>
                    <td>{{$return->ftn_date}}</td>
                    <td>{{$return->reference}}</td>
                    <td>{{getCustomer($return->customer_id)}}</td>
                    <td>Customer</td>
                    <td>{{getRegionName($return->region_to)}}</td>
                    <td>{{$return->type}}</td>
                    <td>{{$return->id}}</td>
                    <td>
                        <a href="{{route('returns.edit',$return->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
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
                <td>No freezer has Dispatched</td>
            @endforelse
            <tr><td colspan="9" align="center">{{$returns->render()}}</td></tr>
        </table>
    </div>
@endsection
