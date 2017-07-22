@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left  ">Dispatch:</h3>
        <a href="{{route('dispatch.create')}}"  style="margin-top: 22px"class="btn btn-info pull-right ">Create Dispatch</a>

        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Document Number</th>
                <th>Date</th>
                <th>Reference</th>
                <th>Driver</th>
                <th>From</th>
                <th>To</th>
                <th>Actions</th>
                <th></th>

            </tr>
            @forelse($dispatches as $dispatch)
                <tr>
                    <td>{{$dispatch->doc_no}}</td>
                    <td>{{$dispatch->cdate}}</td>
                    <td>{{$dispatch->reference}}</td>
                    <td>{{$dispatch->driver->name}}</td>
                    <td>{{$dispatch->region->name}}</td>
                    <td>{{$dispatch->to_}}</td>
                   <td>
                        <a href="{{route('dispatch.edit',$dispatch->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                   </td>

                    <td>
                        <form action="{{route('dispatch.destroy',$dispatch->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No Dispatch has Done</td>
            @endforelse
            <tr><td colspan="4"><?php echo $dispatches->render(); ?></td></tr>
        </table>
    </div>
@endsection
