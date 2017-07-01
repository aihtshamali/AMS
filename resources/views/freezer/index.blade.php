@extends('layouts.app')
@section('content')
    <div class="container">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left  ">Freezer Dispatched</h3>
        <a href="{{route('freezer.create')}}"  style="margin-top: 22px"class="btn btn-success pull-right ">Dispatch freezer</a>
        <a href="{{route('return')}}"  style="margin-top: 22px"class="btn btn-success pull-right ">Return freezer</a>
        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>FTN Number</th>
                <th>FTN Date</th>
                <th>Reference #</th>
                <th>Customer Code</th>
                <th>Delivery Address</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Actions</th>
                <th></th>

            </tr>
            @forelse($freezers as $freezer)
                <tr>
                    <td>{{$freezer->transfer->ftn_no}}</td>
                    <td>{{$freezer->transfer->ftn_date}}</td>
                    <td>{{$freezer->transfer->reference}}</td>
                    <td>{{$freezer->transfer->customer_id}}</td>
                    <td>{{$freezer->region->name}}</td>
                    <td>{{$freezer->type}}</td>
                    <td>{{$freezer->quantity}}</td>
                    <td>
                        <a href="{{route('freezer.edit',$freezer->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
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
        </table>
    </div>
@endsection
