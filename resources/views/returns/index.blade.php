@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="color: darkgreen;
    float: left;
    font-weight: bold ">AMS => All Crate Return List</h3>
        <a href="{{route('returns.create')}}"  style="margin-top: 22px"class="btn btn-info pull-right "> Add Return</a>
        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Date</th>
                <th>Ref.No.</th>
                <th>From</th>
                <th>To</th>
                <th>Reference</th>
                <th>Customer Name</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Actions</th>
                <th></th>

            </tr>
            {{--{{dd($returns)}}--}}
            @forelse($returns as $return)
                <tr>
                    <td>{{$return->ftn_date}}</td>
                    <td>{{$return->ftn_no}}</td>
                    <td>Customer</td>
                    <td>{{getRegion($return->region_to)->name}}/{{getRegion($return->region_to)->sub_name}}</td>
                    <td>{{$return->reference}}</td>
                    <td>{{getCustomer($return->customer_id)->account_name}}</td>
                    <td>{{$return->type}}</td>
                    <td>{{$return->qty}}</td>
                    <td>
                        <a href="{{route('returns.edit',$return->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
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
                <td>No freezer has Dispatched</td>
            @endforelse

        </table>
    </div>
@endsection
