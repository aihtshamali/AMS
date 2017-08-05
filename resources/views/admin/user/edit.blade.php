@extends('admin.layout.admin')
@section('content')
    <h3>Edit User</h3>

    <form action="/admin/<?php echo $user->id; ?>/user" method="post" role="form">

        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Name of User</label>
            <input type="text" class="form-control" name="name" id="" value="{{$user->name}}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="" value="{{$user->email}}">
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
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="" placeholder="Enter Password..." minlength="6">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
