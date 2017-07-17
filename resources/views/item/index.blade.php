@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left  ">Items</h3>
        <a href="{{route('item.create')}}"  style="margin-top: 22px"class="btn btn-success pull-right ">Create item</a>

        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Code</th>
                <th>Name</th>
                <th>Display Name</th>
                <th>Item Group</th>
                <th>Customer</th>
                <th>Department</th>
                <th>Color</th>
                <th>Status</th>
                <th>Actions</th>
                <th></th>

            </tr>
            @forelse($items as $item)
                <tr>
                    <td>{{$item->code}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->display_name}}</td>
                    <td>{{$item->item_group}}</td>
                    <td>{{$item->for_customer}}</td>
                    <td>{{$item->department}}</td>
                    <td>{{$item->color}}</td>
                    <td>{{$item->is_active=="1" ? "Active" : "Not Active"}}</td>
                    <td>
                        <a href="{{route('item.edit',$item->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                    </td>

                    <td>
                        <form action="{{route('item.destroy',$item->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No item</td>
            @endforelse
            {{--<tr><td colspan="4"><?php echo $items->render(); ?></td></tr>--}}
        </table>
    </div>
@endsection
