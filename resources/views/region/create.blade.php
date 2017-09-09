@extends('admin.layout.admin')
@section('content')
    <div class="">
        <form action="{{route('region.store')}}" method="post">
            {{csrf_field()}}
            <label for="">Region-Name:</label>
            <input type="text" name="name" placeholder="Name.." required>
            <label>Type:</label>
            <input type="text" name="type" value="WareHouse" placeholder="type" required>
            <label>Account:</label>
            <input type="text" name="account"  placeholder="Account" required>
            <label>Sub-Name:</label>
            <input type="text" name="sub_name" placeholder="E.g. HeadOffice ..." required>


            <button type="submit" class="btn btn-sm btn-success">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
@endsection
