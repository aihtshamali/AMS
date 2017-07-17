@extends('admin.layout.admin')
@section('content')
    <div class="">
        <h3>Create Customers</h3>

        <form action="{{route('customer.update',$customer->id)}}" method="post" >
            {{csrf_field()}}
            {{method_field('PATCH')}}

            <div class="form-group">
                <label for="name">Account Number</label>
                <input type="text" class="form-control" name="account_no" id="" value="{{$customer->account_no}}" required>
            </div>
            <div class="form-group">
                <label for="display_name">Account Name</label>
                <input type="text" class="form-control" name="account_name" id="" value="{{$customer->account_name}}" required>
            </div>

            <div class="form-group">
                <label for="description">Address</label>
                <input type="text" class="form-control" name="address" id="" value="{{$customer->address}}">
            </div>
            <div class="form-group">
                <label for="description">Phone</label>
                <input type="text" class="form-control" name="phone" id="" value="{{$customer->phone}}">
            </div>

            <div class="form-group">
                <label for="description">City Name</label>
                <select name="city" class="select" id="">
                    @foreach($cities as $city)
                        @if($city->id == $customer->city_id)
                            <option value="{{$city->id}}" selected>{{$city->name}}</option>

                        @else
                                <option value="{{$city->id}}">{{$city->name}}</option>
                        @endif
                     @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Location</label>
                <select name="region" class="select" id="">
                    @foreach($regions as $region)
                        @if($region->id == $customer->region_id)
                            <option value="{{$region->id}}" selected>{{$region->name}}</option>

                        @else
                            <option value="{{$region->id}}">{{$region->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">Category</label>
                <select name="customer_group" class="select" id="">
                    @foreach($categories as $category)
                        @if($category->id == $customer->customer_group)
                            <option value="{{$category->code}}" selected>{{$category->name}}</option>
                        @else
                            <option value="{{$category->code}}">{{$category->name}}</option>
                        @endif

                    @endforeach
                </select>
            </div>
            <div class="form-group text-left">
                <label for="description">Status</label>
                <select name="is_active" id="">
                    <option value="{{$customer->is_active =='1' ? '1' : '0' }}" selected>{{$customer->is_active =='1' ? 'Active' : 'Not Active' }}</option>
                    <option value="{{$customer->is_active !='1' ? '1' : '0' }}">{{$customer->is_active !='1' ? 'Active' : 'Not Active' }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
@endsection
