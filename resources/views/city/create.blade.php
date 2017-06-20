@extends('layouts\app')
@section('content')
    <div class="container text-center" style= "margin-top: 10%">
        <form  class="form " action="{{route('city.store')}}" method="post">
            {{csrf_field()}}
            <div class="from-group" style="margin: 10px">
            <input type="text" name="name" required>
            </div>
            <div class="form-group" style="margin: 10px">
            <select name="regions" id="">Select Location
                @forelse($regions as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                @empty
                   <option value="No Location"> No Location Found </option>
                @endforelse

            </select>
            </div>

            <div class="from-group " style="margin: 10px;margin-left: 80px">
            <button type="submit" class="btn btn-sm btn-success ">Submit</button>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </div>
        </form>
    </div>
@endsection