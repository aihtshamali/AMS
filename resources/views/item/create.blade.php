@extends('admin.layout.admin')
@section('content')
    <div class="">
        <h3>Create Items</h3>

        <form action="{{route('item.store')}}" method="post" >
            {{csrf_field()}}

            <div class="form-group">
                <label for="name">Code</label>
                <input type="text" class="form-control" name="code" id="" placeholder="Enter Code..." required>
            </div>
            <div class="form-group">
                <label for="display_name">Name</label>
                <input type="text" class="form-control" name="name" id="itemName" placeholder="name" required>
            </div>

            <div class="form-group">
                <label for="description">Display Name</label>
                <input type="text" class="form-control" name="display_name" id="" placeholder="Display Name">
            </div>
            <div class="form-group">
                <label for="description">Item Group</label>
                <select class="form-control"  name="item_group" id="">
                    <option value="Freezer">Freezer</option>
                    <option value="Pallet">Pallet</option>
                    <option value="Crate">Crate</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">For Customer</label>
                <input type="number" class="form-control" name="for_customer" placeholder="Enter Cusotmer Number">
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="number" class="form-control" name="department" placeholder="Enter Department Number">
            </div>
            <div class="form-group">
                <label for="description">Color</label>
                <input type="color" class="form-control" name="color" placeholder="Enter Color : ">
            </div>
            <div class="form-group text-left">
                <label for="description">Status</label>
                <select class="form-control" name="is_active" id="">
                    <option value="1" selected>Active</option>
                    <option value="0">Not Active</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

@endsection
