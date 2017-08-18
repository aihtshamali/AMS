@extends('layouts.sidenav')
@section('content')
    <div class="col-md-5 col-sm-8">
        <form class="form-group" action="{{route('pdfview')}}" method="get">
            <table class="table table-responsive">
                <div align="center">
                    <input type="date" name="cdate" placeholder="Enter Date...">
                    <select class="form-control" name="region">
                        <option value="">Select Region</option>
                        @foreach ($regions as $r)
                            <option value="{{$r->id}}">{{$r->name}}</option>
                        @endforeach
                    </select>

                    <select class="form-control" name="sub_region">
                        <option value="">Select Sub-Region</option>
                        @foreach ($regions as $r)
                            <option value="{{$r->id}}">{{$r->sub_name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="download" value="pdf">
                    <button class="btn " name="submit" type="submit">Download PDF</button>
                </div>
            </table>
        </form>
    </div>

@endsection
