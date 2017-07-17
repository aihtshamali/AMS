@extends('admin.layout.admin')
@section('content')
    <h4 class="modal-title" id="myModalLabel">{{$user->name}}'s Allowed Items</h4>
    <table class="table">
        <thead>
        <tr>
            <th>Item's Name</th>
            <th>Un-assign</th>
        </tr>
        </thead>
        <tbody>
        @forelse($user_items as $user_item)
            <tr>
                <td><label for="">{{$user_item->item->name}}</label></td>
                <td>
                    <form action="{{route('useritem.destroy',$user_item->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                    </form>
                </td>
            </tr>
        @empty
            <td>No Items Assigned</td>
        @endforelse
        <tr>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#myModal-1">
                    Assign new Items
                </button>
            </td>
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
                    <h4 class="modal-title" id="myModalLabel">Items for {{$user->name}}</h4>
                </div>
                <div class="modal-body">

                    <table class="table">

                        <tbody>
                        <form action="{{route('useritem.store')}}" method="POST">
                            {{csrf_field()}}
                            <tr>
                                <td><input type="hidden" name="user_id" value="{{$user->id}}"></td>
                                <td>
                                    <select id="dates-field2" name="useritems[]" class="form-control" multiple="multiple">
                                        @forelse($items as $item)
                                            <?php /**/ $var = 0 /**/ ?>
                                            @foreach($user_items as $user_item)
                                                @if($user_item->item_id == $item->id)
                                                    <?php /**/ $var = 1 /**/ ?>
                                                @endif
                                            @endforeach
                                            @if($var==0)
                                                <option value="{{$item->id}}">
                                                    {{$item->name}}
                                                </option>
                                            @endif

                                        @empty
                                            No Items Assigned

                                        @endforelse
                                    </select>
                                </td>
                            </tr>
                            <tr class="modal-footer">
                                <td><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></td>
                                <td><button type="submit" class="btn btn-primary">Save changes
                                    </button></td>
                            </tr>
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection