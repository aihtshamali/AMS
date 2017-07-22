@extends('admin.layout.admin')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
    <h3 style="float:left">Regions:</h3>
        <a href="{{route('region.create')}}" style="float:right" class="btn btn-success pull-right">Create Region</a>

    <table class="table table-striped table-responsive table-hover">
        <tr style="background-color:white;">
            <th>Name</th>
            <th>Cateogry</th>
            <th>Is Active</th>
            <th>Actions</th>
        </tr>
        @forelse($regions as $region)
            <tr>
                <td>{{$region->name}}</td>
                <td>{{$region->category}}</td>
                <td>{{$region->is_active}}</td>
                <td>
                    <a href="{{route('region.edit',$region->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                </td>

                <td>
                    <form action="{{route('region.destroy',$region->id)}}" method="post">
                        {{csrf_field()}}
                            {{method_field('DELETE')}}
                        <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                    </form>
                </td>
            </tr>
        @empty
            <td>No Regions</td>
        @endforelse
    </table>
    </div>
@endsection
