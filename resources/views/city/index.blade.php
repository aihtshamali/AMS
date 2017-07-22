@extends('admin.layout.admin')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left">Cities:</h3>
        <a href="{{route('city.create')}}" style="float:right" class="btn btn-success pull-right">Create city</a>

        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Name</th>
                <th>Region</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            @forelse($cities as $city)
                <tr>
                    <td>{{$city->name}}</td>
                    <td>
                        @if($city->getregion($city->region_id))
                            {{$city->getregion($city->region_id)->name}}
                        @endif
                    </td>
                    <td>{{$city->is_active}}</td>
                    <td>
                        <a href="{{route('city.edit',$city->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                    <td>
                        <form action="{{route('city.destroy',$city->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No citys</td>
            @endforelse
        </table>
    </div>
@endsection
