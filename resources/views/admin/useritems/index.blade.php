@extends('admin.layout.admin')
@section('content')
    <h3>Users</h3>

    <table class="table table-bordered">
        <tr>
            <th>User</th>

            <th>Item</th>
        </tr>
        @forelse($useritems as $useritem)
            <tr>
                <td>{{$useritem->user->name}}</td>
                <td>{{$useritem->item->name}}</td>
                <td>
                    <!-- Button trigger modal -->
                    <a type="button" class="btn btn-primary btn-sm" href="{{route('userpermission.edit',$useritem->id)}}">
                        Show & Edit
                    </a>
                </td>
            </tr>
        @empty
            <td>no users</td>
        @endforelse
    </table>
    <!-- Modal -->


@endsection
