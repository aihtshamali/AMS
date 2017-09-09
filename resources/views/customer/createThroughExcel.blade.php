@extends('admin.layout.admin')
@section('content')
<div class="row">
    <div class="col-md-8" style="color: green">
        <h3>Upload Customer Through Excel File</h3>
    </div>
</div>
<br>
<br>
<div class="row">
    <div class="col-md-7 col-md-offset-3">
        <div class="row">
            <form action="{{route('CreateCustomer_Excel')}}" method="post" enctype="multipart/form-data">
                <div class="col-md-7">
                    {{csrf_field()}}
                    <input class="form-control"  type="file"  accept=".xls,.xlsx" name="imported-file"/>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" type="submit">Import</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-2">
        {{--<button class="btn btn-success">Export</button>--}}
    </div>
</div>
@endsection