@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left  ">Freezer Dispatched</h3>
        <a href="{{route('freezer.create')}}"  style="margin-top: 22px"class="btn btn-success pull-right ">Dispatch freezer</a>
        <a href="{{route('freezer.return')}}"  style="margin-top: 22px"class="btn btn-success pull-right ">Return freezer</a>
        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>FTN Number</th>
                <th>FTN Date</th>
                <th>Reference #</th>
                <th>Customer Code</th>
                <th>Delivery Address</th>
                <th>Type</th>
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
                    <td>Freezer</td>
                    {{--<td>{{$freezer->type}}</td>--}}
                    <td>{{$freezer->countTransferDetails($freezer->id)}}</td>
                    <td>
                        <a href="{{route('freezer.transferPrint',$freezer->id)}}">Print</a>
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

            @forelse($returns as $return)
                <tr>
                    <td>{{$return->returns->ftn_no}}</td>
                    <td>{{$return->returns->ftn_date}}</td>
                    <td>{{$return->returns->reference}}</td>
                    <td>{{$return->customer_id}}</td>
                    <td>{{$return->returns->from_}}</td>
                    <td>{{$return->type}}</td>
                    {{--<td>{{$freezer->type}}</td>--}}
                    <td>{{$return->returns->countReturnDetails($return->returns->id)}}</td>
                    <td>
                        <a href="{{route('freezer.transferPrint',$freezer->id)}}">Print</a>
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
            {{--<tr><td colspan="4">{{ $freezers->rendor() }}</td></tr>--}}
        </table>
    </div>
@endsection
