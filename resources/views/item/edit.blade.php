@extends('layouts.sidenav')
@section('content')
    <div class="">>
        <h3>Create Items</h3>

        <form action="{{route('item.update',$item->id)}}" method="post" >
            {{csrf_field()}}
            {{method_field('PATCH')}}

            <div class="form-group">
                <label for="name">Code</label>
                <input type="text" class="form-control" name="code" id="" value="{{$item->code}}" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="" value="{{$item->name}}" required>
            </div>

            <div class="form-group">
                <label for="description">Display Name</label>
                <input type="text" class="form-control" name="display_name" id="" value="{{$item->display_name}}">
            </div>
            <div class="form-group">
                <label for="description">Item Group</label>
                <select name="item_group" id="">
                    <option value="Freezer">Freezer</option>
                    <option value="Pallet">Pallet</option>
                    <option value="Crate">Crate</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">For Customer</label>
                <input type="number" name="for_customer" value="{{$item->for_customer}}">
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="number" name="department" value="{{$item->department}}">
            </div>
            <div class="form-group">
                <label for="description">Color</label>
                <input type="color" name="color" value="{{$item->color}}">
            </div>
            <div class="form-group text-left">
                <label for="description">Status</label>
                <select name="is_active" id="">
                    <option value="{{$item->is_active =='1' ? '1' : '0' }}" selected>{{$item->is_active =='1' ? 'Active' : 'Not Active' }}</option>
                    <option value="{{$item->is_active !='1' ? '1' : '0' }}">{{$item->is_active !='1' ? 'Active' : 'Not Active' }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
@endsection
