@extends('layouts.sidenav')
@section('content')
    <div class="">
        <span align="center" >
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
        </span>
        <h3 style="float:left">Categories:</h3>
        <a href="{{route('category.create')}}" style="float:right" class="btn btn-success pull-right">Create category</a>

        <table class="table table-striped table-responsive table-hover">
            <tr style="background-color:white;">
                <th>Name</th>
                <th>Code</th>
                <th>Is Active</th>
                <th>Actions</th>
            </tr>
            @forelse($categories as $category)
                <tr>
                    <td>{{$category->name}}</td>
                    <td>{{$category->code}}</td>
                    <td>{{$category->is_active}}</td>
                    <td>
                        <a href="{{route('category.edit',$category->id)}}" type="button" class="btn btn-sm btn-primary">Edit</a>
                    </td>

                    <td>
                        <form action="{{route('category.destroy',$category->id)}}" method="post">
                            {{csrf_field()}}
                            {{method_field('DELETE')}}
                            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                        </form>
                    </td>
                </tr>
            @empty
                <td>No category</td>
            @endforelse
            <tr><td colspan="4"><?php echo $categories->render(); ?></td></tr>
        </table>
    </div>
@endsection
