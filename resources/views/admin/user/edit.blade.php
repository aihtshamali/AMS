@extends('admin.layout.admin')
@section('content')
    <h3>Create Roles</h3>

    <form action="{{route('user.update',$user->id)}}" method="post" role="form">
        {{method_field('PATCH')}}
        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Name of User</label>
            <input type="text" class="form-control" name="name" id="" value="{{$user->name}}">
        </div>
        <div class="form-group">
            <label for="display_name">Display name</label>
            <input type="text" class="form-control" name="display_name" id="" value="{{$user->email}}">
        </div>
        <div class="form-group">
            <label for="description">Region</label>
            <select name="region_id" class="form-control" id="">
            @foreach($regions as $region)
                @if($user->region_id==$region->id)
                <option value="{{$region->id}}" selected>{{$region->name}}</option>
                @else
                <option value="{{$region->id}}">{{$region->name}}</option>
                @endif
                @endforeach
            </select>
        </div>





        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
