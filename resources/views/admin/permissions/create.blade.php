@extends('admin.layout.admin')
@section('content')
    <h3>Create Roles</h3>

    <form action="{{route('permission.store')}}" method="post" role="form">
        {{csrf_field()}}

    	<div class="form-group">
    		<label for="name">Name of Permission</label>
    		<input type="text" class="form-control" name="name" id="" placeholder="Name of Permission..">
    	</div>
        <div class="form-group">
    		<label for="display_name">Display name</label>
    		<input type="text" class="form-control" name="display_name" id="" placeholder="Display name">
    	</div>
        <div class="form-group">
    		<label for="description">Description</label>
    		<input type="text" class="form-control" name="description" id="" placeholder="Description">
    	</div>

		{{--<select name="id" id="" multiple>--}}
			{{--<option value="1">men</option>--}}
			{{--<option value="2">men2</option>--}}
		{{--</select>--}}








    	<button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
