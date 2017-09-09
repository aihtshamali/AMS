@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center">
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left ;color:green  ">Transfer Transit</h3>


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
            {{--{{dd($transfers)}}--}}
    {{--{{dd($transfers[0]->status=="Pending" || $transfers[0] ->transfer->region_id==Auth::user()->region_id)}}--}}
            @forelse($transfers as $transfer)
                @if($transfer->getRegion($transfer->id)->region_id==Auth::user()->region_id || $transfer->from_==Auth::user()->region->id)
                <tr>
                    <td>{{$transfer->ftn_no}}</td>
                    <td>{{$transfer->ftn_date}}</td>
                    <td>{{$transfer->reference}}</td>
                    <td>{{$transfer->driver->name}}</td>
                    <td>{{getRegion($transfer->from_)->name}}/{{getRegion($transfer->from_)->sub_name}}</td>
                    <td>{{$transfer->getRegion($transfer->id)->region->name}}/{{$transfer->getRegion($transfer->id)->region->sub_name}}</td>
                    <td>{{$transfer->status}}</td>
                    {{--<td>--}}
                        {{--<a href="{{route('transfer.edit',$transfer->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>--}}
                    {{--</td>--}}
                    @if($transfer->getRegion($transfer->id)->region_id==Auth::user()->region_id )
                    <td>
                        <form action="{{route('transferreceived',$transfer->id)}}" method="POST">

                            {{csrf_field()}}
                            <input type="submit" class="btn btn-sm btn-info" value="Received">
                        </form>
                    </td>
                    @endif
                    @if($transfer->from_==Auth::user()->region->id)
                    <td>
                        <form action="{{route('transfer.destroy',$transfer->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Cancel">
                        </form>
                    </td>
                        @endif
                </tr>
                @endif
            @empty
                <td>No transfer has Done</td>
            @endforelse
        </table>
    </div>
@endsection
