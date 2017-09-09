@extends('admin.layout.admin')
@section('content')
    <h4 class="modal-title" id="myModalLabel">{{$user->name}}'s Permissions</h4>
    <span class="pull-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                data-target="#myModal-1">
            Add New Permission
        </button>
    </span>
    <table class="table">
        <thead>
        <tr>
            <th>Permissions</th>
            <th>Description</th>
            <th>Un-assign</th>
        </tr>
        </thead>
        <tbody>
        @forelse($permissions as $permission)
            <tr>
                <td style="text-align: left"><label for="">{{$permission->permission->name}}</label></td>
                <td style="text-align: left">{{$permission->permission->description}}</td>
                <td style="text-align: left">
                    <form action="{{route('userpermission.destroy',$permission->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                    </form>
                </td>
            </tr>
        @empty
            <td>No Permissions Assigned</td>
        @endforelse
        <tr>
            <td></td>
            <td>{{$permissions->links()}}</td>
        </tr>
        </tbody>

    </table>


    <div class="modal fade" id="myModal-1" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Permission for {{$user->name}}</h4>
                </div>
                <div class="modal-body">

                    <table class="table">
                        <tbody>
                        <form action="{{route('userpermission.store')}}" method="POST">
                            {{csrf_field()}}
                            <tr>
                                <td><input type="hidden" name="user_id" value="{{$user->id}}"></td>
                                <td>
                                    <label>
                                        <select name="userpermission[]" class="js-example-basic-multiple"
                                                multiple="multiple" style="width:200px">
                                            @forelse($allpermission as $perm)
                                                <?php  $var = 0;  ?>
                                                @foreach($userpermissions as $permission)
                                                    @if($permission->permission_id == $perm->id)
                                                            <?php  $var = 1;?>
                                                    @endif
                                                @endforeach
                                                @if($var==0)
                                                    <option value="{{$perm->id}}">{{$perm->name}}</option>
                                                @endif
                                            @empty
                                                No Permissions Assigned
                                            @endforelse
                                        </select>
                                    </label>
                                </td>

                            </tr>
                            <tr class="modal-footer">
                                <td>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </td>
                                <td>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-primary">Save changes
                                    </button>
                                </td>
                            </tr>
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection