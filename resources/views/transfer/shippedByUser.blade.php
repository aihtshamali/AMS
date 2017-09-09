@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center">
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="color: darkgreen;
    float: left;
    font-weight: bold ">AMS =>All Shipped List by {{Auth::user()->name}}</h3>
        <a href="{{route('transfer.create')}}" style="margin-top: 22px" class="btn btn-info pull-right ">Create
            transfer</a>

        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Document Number</th>
                <th>Date</th>
                <th>Reference</th>
                <th>Driver</th>
                <th>From</th>
                <th>To</th>
                <th>Status</th>
                <th>Actions</th>
                <th></th>

            </tr>

            @forelse($transfers as $transfer)
                <tr>
                    <td>{{$transfer->ftn_no}}</td>
                    <td>{{$transfer->ftn_date}}</td>
                    <td>{{$transfer->reference}}</td>
                    @if(!empty($transfer->driver_id))
                        <td>{{getDriver($transfer->driver_id)->name}}</td>
                    @else
                        <td>N/A</td>
                    @endif
                    @if(!empty($transfer->to_))
                        <td>{{getRegion($transfer->to_)->name}}/{{getRegion($transfer->to_)->sub_name}}</td>
                    @else
                        <td>{{getRegion($transfer->from_)->name}}/{{getRegion($transfer->from_)->sub_name}}</td>
                    @endif
                    <td>{{$transfer->getRegion($transfer->id)->region->name}}/{{$transfer->getRegion($transfer->id)->region->sub_name}}</td>
                    <td>{{$transfer->status}}</td>
                    <td>
                        <a href="{{route('transfer.edit',$transfer->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                    <td>
                        <form action="{{route('transfer.destroy',$transfer->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Cancel">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No transfer has Done</td>
            @endforelse
        </table>
    </div>
@endsection
