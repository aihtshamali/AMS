@extends('admin.layout.admin')
@section('content')
    <div class="">
    <h3>Create Customers</h3>

    <form action="{{route('customer.store')}}" method="post" >
        {{csrf_field()}}

        <div class="form-group">
            <label for="name">Account Number</label>
            <input type="text" class="form-control" name="account_no" id="" placeholder="Account Number" required>
        </div>
        <div class="form-group">
            <label for="display_name">Account Name</label>
            <input type="text" class="form-control" name="account_name" id="" placeholder="Display name" required>
        </div>

        <div class="form-group">
            <label for="description">Address</label>
            <input type="text" class="form-control" name="address" id="" placeholder="Address">
        </div>
        <div class="form-group">
            <label for="description">Phone</label>
            <input type="text" class="form-control" name="phone" id="" placeholder="Phone">
        </div>

        <div class="form-group">
            <label for="description">City Name</label>
            <select name="city"  class="form-control" id="" required>
                <option value="">--Choose City--</option>
                @foreach($cities as $city)
                    <option value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="description">Location</label>
            <select name="region"  class="form-control" id="" required>
                <option value="">--Choose Region--</option>
                @foreach($regions as $region)
                    <option value="{{$region->id}}">{{$region->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="description">Category</label>
            <select name="customer_group" class="form-control" id="" required>
                <option value="">--Choose Category--</option>
                @foreach($categories as $category)
                    <option value="{{$category->code}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group text-left">
            <label for="description">Status</label>
            <select name="is_active" class="form-control" id="" required>
                <option value="1" selected>Active</option>
                <option value="0">Not Active</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
    </div>
@endsection
