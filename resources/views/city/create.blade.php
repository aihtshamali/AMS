@extends('layouts\app')
@section('content')
    <div class="container">
        <form action="{{route('city.store')}}" method="post">
            <input type="text" name="name" required>
            <select name="regions" id="">
                @forelse($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                @empty
                    No Location Found
                @endforelse

            </select>
            <button type="submit" class="btn btn-sm btn-success">Submit</button>
        </form>
    </div>
@endsection