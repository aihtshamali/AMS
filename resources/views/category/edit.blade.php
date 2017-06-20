@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Edit Category:</h3>

        <form action="{{route('category.update',$category->id)}}" method="post" role="form">
            {{method_field('PATCH')}}
            {{csrf_field()}}
            <div class="form-group">
                <label for="name">Name </label>
                <input type="text" class="form-control" name="name" id="" value="{{$category->name}}">
            </div>

            <div class="form-group">
                <label for="display_name">Code</label>
                <input type="text" class="form-control" name="code" id="" value="{{$category->code}}">
            </div>
            <div class="form-group">
                <label for="description">Status</label>
                <select name="is_active" class="selectpicker" id="">
                    <option  value="{{$category->is_active}}" selected>{{$category->is_active =='1' ? 'Active':'Not Active'}}</option>
                    <option  value="{{$category->is_active =='1' ? '0':'1'}}">{{$category->is_active =='1' ? 'Not Active':'Active'}}</option>

                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
