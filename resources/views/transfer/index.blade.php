@extends('layouts.app')
@section('content')
    <div class="container">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left  ">Transfers</h3>
        <a href="{{route('transfer.create')}}"  style="margin-top: 22px"class="btn btn-success pull-right ">Create transfer</a>

        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Document Number</th>
                <th>Date</th>
                <th>Reference</th>
                <th><Driver></Driver></th>
                <th>From</th>
                <th>To</th>
                <th>Actions</th>
                <th></th>

            </tr>
            @forelse($transfers as $transfer)
                <tr>
                    <td>{{$transfer->doc_no}}</td>
                    <td>{{$transfer->cdate}}</td>
                    <td>{{$transfer->refernce}}</td>
                    <td>{{$transfer->from_}}</td>
                    <td>{{$transfer->to_}}</td>
                    <td>
                        <a href="{{route('transfer.edit',$transfer->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                    </td>

                    <td>
                        <form action="{{route('transfer.destroy',$transfer->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No transfer has Done</td>
            @endforelse
        </table>
    </div>
@endsection
