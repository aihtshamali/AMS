@extends('admin.layout.admin')
@section('content')
    <div class="">
    <h3>Edit Region:</h3>

    <form action="{{route('region.update',$region->id)}}" method="post" role="form">
        {{method_field('PATCH')}}
        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Name </label>
            <input type="text" class="form-control" name="name" id="" value="{{$region->name}}">
        </div>

        <div class="form-group">
            <label for="display_name">Type</label>
            <input type="text" class="form-control" name="type" id="" value="{{$region->type}}">
        </div>
        <div class="form-group">
        <label>Account:</label>
        <input type="text" name="account" value={{$region->acccount}}>
        </div>
        <div class="form-group">
        <label>Sub-Name:</label>
        <input type="text" name="sub_name" value="{{$region->sub_name}}">
        </div>
        <div class="form-group">
            <label for="Category">Category</label>
            <select name="category" class="selectpicker" id="">
                <option  value="{{$region->category}}" selected>{{$region->category}}</option>
                <option  value="{{$region->category =='internal' ? 'external':'internal'}}">{{$region->category =='internal' ? 'external':'internal'}}</option>

            </select>
        </div>
        <div class="form-group">
            <label for="description">Status</label>
            <select name="is_active" class="selectpicker" id="">
                <option  value="{{$region->is_active}}" selected>{{$region->is_active =='1' ? 'Active':'Not Active'}}</option>
                <option  value="{{$region->is_active =='1' ? '0':'1'}}">{{$region->is_active =='1' ? 'Not Active':'Active'}}</option>

            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
@endsection
