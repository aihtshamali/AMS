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
    font-weight: bold ">AMS =>All Purchases List</h3>
        <a href="{{route('purchase.create')}}"  style="margin-top: 22px"class="btn btn-info pull-right ">Create Purchase</a>

        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Document Number</th>
                <th>Date</th>
                <th>Reference</th>
                <th>Driver</th>
                <th>To</th>
                <th>Actions</th>
                <th></th>

            </tr>
            {{--{{dd($purchases)}}--}}
            @forelse($purchases as $purchase)
                <tr>
                    <td>{{$purchase->doc_no}}</td>
                    <td>{{$purchase->cdate}}</td>
                    <td>{{$purchase->reference}}</td>
                    <td>{{getDriver($purchase->driver_id)->name}}</td>
                    <td>{{getRegion($purchase->region_id)->name}}/{{getRegion($purchase->region_id)->sub_name}}</td>
                    <td style="width: 95px">
                        <a href="{{route('purchase.edit',$purchase->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                        <a href="{{route('purchase.show',$purchase->id)}}" >
                            <img src="{{asset('images/show.png')}}" alt="ShowPage" class="icon"
                                 style=" margin:0 0 0 7px;height: 30px;width: auto">
                        </a>
                    </td>

                    <td>
                        <form action="{{route('purchase.destroy',$purchase->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Cancel">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No purchase has Done</td>
            @endforelse
        </table>
    </div>
@endsection
