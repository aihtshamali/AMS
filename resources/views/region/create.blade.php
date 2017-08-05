@extends('admin.layout.admin')
@section('content')
    <div class="">
        <form action="{{route('region.store')}}" method="post">
            {{csrf_field()}}
            <label for="">Region-Name:</label>
            <input type="text" name="name" value="WareHouse" required>
            <label>Type:</label>
            <input type="text" name="type" required>
            <label>Account:</label>
            <input type="text" name="account" value="WareHouse" required>
            <label>Sub-Name:</label>
            <input type="text" name="sub_name" placeholder="E.g. HeadOffice ..." required>

            <label for="">Category:</label>
            <select name="category" id="" required>
                <option value="internal" selected>Internal</option>
                <option value="external">External</option>
            </select>
            <button type="submit" class="btn btn-sm btn-success">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>
@endsection
