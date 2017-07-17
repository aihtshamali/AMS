@extends('layouts.sidenav')
@section('content')
    <div class="">
        <form  class="form " action="{{route('city.store')}}" method="post">
            {{csrf_field()}}
            <div class="from-group" style="margin: 10px">
                <label for="">Enter City name</label>
            <input type="text" name="name" required>
            </div>
            <div class="form-group" style="margin: 10px">
                <label for="">Select Location</label>
            <select name="regions" id="">
                @forelse($regions as $r)
                    <option value="{{$r->id}}">{{$r->name}}</option>
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