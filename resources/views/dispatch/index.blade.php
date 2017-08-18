@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left ;color: darkgreen;
    font-weight: bold ">AMS =>All Dispatches List:</h3>
        <a href="{{route('dispatch.create')}}"  style="margin-top: 22px"class="btn btn-info pull-right ">Create Dispatch</a>

        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Date</th>
                <th>Ref.No.</th>
                <th>From</th>
                <th>To</th>
                <th>Reference</th>
                <th>Driver</th>
                <th >Actions</th>
                <th></th>

            </tr>
            @forelse($dispatches as $dispatch)
                <tr>
                    <td>{{$dispatch->cdate}}</td>
                    <td>{{$dispatch->doc_no}}</td>
                    <td>{{$dispatch->region->name}}/{{$dispatch->region->sub_name}}</td>
                    <td>{{getRegion($dispatch->to_)->name}}</td>
                    <td>{{$dispatch->reference}}</td>
                    <td>{{$dispatch->driver->name}}</td>
                   <td style="width: 140px">
                       <a href="{{route('returnDispatch',$dispatch->id)}}" type="button" ><img src="{{asset('images\returns.png')}}" class="icon" style="height:30px;width:30px;margin-left:10px;"></a>
                       <a href="{{route('dispatch.edit',$dispatch->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                       <a href="{{route('dispatch.show',$dispatch->id)}}">
                           <img src="{{asset('images/show.png')}}" alt="ShowPage" class="icon"
                                style=" margin:0 0 0 7px;height: 29px;width: auto">
                       </a>
                   </td>

                    <td>

                        <form action="{{route('dispatch.destroy',$dispatch->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Cancel">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No Dispatch has Done</td>
            @endforelse
        </table>
    </div>
@endsection
