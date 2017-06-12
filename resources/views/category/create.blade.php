@extends('layouts\app')
@section('content')
    <div class="container">
        <form action="{{route('category.store')}}" method="post">
            <input type="text" name="name" required>
            <input type="text" name="code" id="">
            <select name="is_active" id="">
                <option value="1">Active</option>
                <option value="0">Not Active</option>
            </select>
            <button type="submit" class="btn btn-sm btn-success">Submit</button>
        </form>
    </div>
@endsection
