@extends('admin.layout.admin')
@section('content')
    <h3>Users</h3>

    <table class="table table-bordered">
        <tr>
            <th>Name</th>

            <th>Action</th>
        </tr>
        @forelse($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>
                    <!-- Button trigger modal -->
                    <a type="button" class="btn btn-info btn-sm" href="{{route('useredit',$user->id)}}">
                         Edit
                    </a>
                    <a type="button" class="btn btn-primary btn-sm" href="{{route('userpermission.edit',$user->id)}}">
                        Show & Edit Permissions
                    </a>
                    <a type="button" class="btn btn-info btn-sm" href="{{route('useritem.edit',$user->id)}}">
                        Show & Edit Allowed  Items
                    </a>


                </td>
            </tr>
        @empty
            <td>no users</td>
        @endforelse
    </table>
    <!-- Modal -->


@endsection
