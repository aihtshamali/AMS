@extends('admin.layout.admin')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left  ">Faculties:</h3>
        <a href="{{route('faculty.create')}}"  style="margin-top: 22px"class="btn btn-success pull-right ">Create Faculty</a>

        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Name</th>
                <th>Father's Name</th>
                <th>Post</th>
                <th>Region</th>
                <th>Status</th>
                <th>Actions</th>
                <th></th>

            </tr>
            @forelse($faculties as $faculty)
                <tr>
                    <td>{{$faculty->name}}</td>
                    <td>{{$faculty->father_name}}</td>
                    <td>{{$faculty->type}}</td>
                    <td>{{$faculty->region->name}}</td>
                    <td>{{$faculty->region->name}}</td>
                    <td>{{$faculty->is_active=="1" ? "Active" : "Not Active"}}</td>
                    <td>
                        <a href="{{route('faculty.edit',$faculty->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                    </td>

                    <td>
                        <form action="{{route('faculty.destroy',$faculty->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No Faculty Added</td>
            @endforelse
            <tr><td colspan="4"><?php echo $faculties->render(); ?></td></tr>
        </table>
    </div>
@endsection
