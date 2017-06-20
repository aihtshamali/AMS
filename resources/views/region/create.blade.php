@extends('layouts\app')
@section('content')
    <div class="container">
        <form action="{{route('region.store')}}" method="post">
            {{csrf_field()}}
            <label for="">Name:</label>
            <input type="text" name="name" required>
            <lable>Type:</lable>
            <input type="text" name="type" id="">
            <label for="">Category:</label>
            <select name="category" id="">
                <option value="internal">Internal</option>
                <option value="external">External</option>
            </select>
            <button type="submit" class="btn btn-sm btn-success">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
@endsection
