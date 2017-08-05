@extends('layouts.sidenav')
@section('content')
<div class="col-md-5 col-sm-8">
    <table class="table table-responsive">
        <div align="center">
            <a href="{{ route('pdfview',['download'=>'pdf']) }}">Download PDF</a>
        </div>
    </table>
</div>
@endsection