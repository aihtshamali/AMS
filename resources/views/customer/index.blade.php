@extends('admin.layout.admin')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left  ">Customers:</h3>
        <a href="{{route('customer.create')}}"  style="margin-top: 22px"class="btn btn-success pull-right ">Create customer</a>

        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Account Numbers</th>
                <th>Account Names</th>
                <th>Groups</th>
                <th>Cities</th>
                <th>Regions</th>
                {{--<th>Address</th>--}}
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
                <th></th>

            </tr>
            @forelse($customers as $customer)
                <tr>
                    <td>{{$customer->account_no}}</td>
                    <td>{{$customer->account_name}}</td>
                    <td>{{$customer->customer_group}}</td>
                    {{--<td>{{$customer->city->name}}</td>--}
                    {{-- <td>{{$customer->region->name}}</td>--}}
                    {{--<td>{{$customer->address}}</td>--}}
                    <td>{{$customer->phone}}</td>
                    <td>{{$customer->is_active=="1" ? "Active" : "Not Active"}}</td>
                    <td>
                        <a href="{{route('customer.edit',$customer->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                    </td>

                    <td>
                        <form action="{{route('customer.destroy',$customer->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No Customer</td>
            @endforelse
            <tr><td colspan="4"><?php echo $customers->render(); ?></td></tr>
        </table>

    </div>
@endsection
