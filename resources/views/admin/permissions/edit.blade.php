@extends('admin.layout.admin')
@section('content')
    <h3>Create Roles</h3>

    <form action="{{route('admin.update',$permission->id)}}" method="post" role="form">
      {{method_field('PATCH')}}
        {{csrf_field()}}
    	<div class="form-group">
    		<label for="name">Name of role</label>
    		<input type="text" class="form-control" name="name" id="" value="{{$permission->name}}">
    	</div>
        <div class="form-group">
    		<label for="display_name">Display name</label>
    		<input type="text" class="form-control" name="display_name" id="" value="{{$permission->display_name}}">
    	</div>
        <div class="form-group">
    		<label for="description">Description</label>
    		<input type="text" class="form-control" name="description" id="" value="{{$permission->description}}">
    	</div>

		{{--<select name="id" id="" multiple>--}}
			{{--<option value="1">men</option>--}}
			{{--<option value="2">men2</option>--}}
		{{--</select>--}}

        {{--<div class="form-group text-left">--}}
            {{--<h3>Permissions</h3>--}}
            {{--@foreach($permissions as $permission)--}}
    		{{--<input type="checkbox" {{in_array($permission->id,$role_permissions) ? "checked" : ""}}  name="permission[]" value="{{$permission->id}}" > {{$permission->name}} <br>--}}
            {{--@endforeach--}}
    	{{--</div>--}}




		<input type="hidden" name="_token" value="{{ csrf_token() }}">

    	<button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
