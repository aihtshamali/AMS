@extends('layouts.sidenav')
@section('content')
    <div class="" style="width:400px;align:left">
        <form action="{{route('faculty.store')}}">
            <div class="form-group">
                <label for="name" >Name</label>
                <input type="text" class="form-control" name="name" id="" placeholder="Enter Name..." required>
            </div>
            <div class="form-group">
                <label for="father_name">Father Name</label>
                <input type="text" class="form-control" name="father_name" id="" placeholder="Enter Father Name..." required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
            </div>
            <div class="form-group">
                <select name="type" class="selectpicker" id="" required>
                    <option disabled hidden selected>--Select Post--</option>
                    <option value="TSO">TSO</option>
                    <option value="TSO">RSM</option>
                    <option value="TSO">NSM</option>
                </select>
            </div>
            <div class="form-group">
                <label for="region_id">Region</label>
            </div>
            <div class="form-group">
                <select name="region_id" class="selectpicker" id="">
                    <option disabled hidden selected required>--Select Region--</option>
                    @foreach($regions as $region)
                        <option value="{{$region->id}}">{{$region->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="is_active">Status</label>
            </div>
            <div class="form-group">
                <select name="is_active" class="selectpicker" id="">
                    <option value="1" selected>Active</option>
                    <option value="0">Not Active</option>
                </select>
            </div>
            <button type="submit" class=" pull-right btn btn-lg btn-success" id="submit" name="submit">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
@endsection