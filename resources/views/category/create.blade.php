@extends('layouts\app')
@section('content')
    <div class="container">
        <form action="{{route('category.store')}}" method="post">
            <div class="from-group" style="margin: 10px">
                <input type="text" name="name" required>
            </div>
            <div class="from-group" style="margin: 10px">
                <input type="text" name="code" id="">
            </div>
            <div class="from-group" style="margin: 10px">
            <select name="is_active" id="">
                <option value="1">Active</option>
                <option value="0">Not Active</option>
            </select>
            </div>
            <div class="from-group" style="margin: 10px">
            <button type="submit" class="btn btn-sm btn-success">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        </form>
    </div>
@endsection
