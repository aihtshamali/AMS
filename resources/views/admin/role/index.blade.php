@extends('admin.layout.admin')
@section('content')
  <h1>Roles</h1>
  <a href="{{route('role.create')}}" class="btn btn-success pull-right">Create Role</a>
  <table class="table table-responsive table-hover">
    <tr>
      <th>Name</th>
      <th>Display Name</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
    @forelse ($roles as $r)
      <tr align="left">
        <td>{{$r->name}}</td>
        <td>{{$r->display_name}}</td>
        <td>{{$r->description}}</td>
        <td><a href="{{route('role.edit',$r->id)}}" class="btn btn-s btn-primary">Edit</a></td>
        <td>
          <form action="{{route('role.destroy',$r->id)}}"  method="POST">
                                 {{csrf_field()}}
                                 {{method_field('DELETE')}}
                                 <input class="btn btn-sm btn-danger" type="submit" value="Delete">
                               </form>
                                     </td>
      </tr>
    @empty
      <tr>
        <td>No Roles</td>
      </tr>
    @endforelse
  </table>
@endsection
