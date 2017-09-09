@extends('layouts.sidenav')
@section('content')
    <div class="col-md-10">
            <h3>Total Stock</h3>
        <table class="table table-responsive">
            <tr>
                <th>Region</th>
                <th>Item</th>
                <th>Total-In</th>
                <th>Total-Out</th>
                <th>Total</th>
            </tr>
{{--            {{dd($regionStock)}}--}}
            @foreach($regionStock as $stock)
            <tr>
                <td>{{$stock->name}}/{{$stock->sub_name}}</td>
                <td>{{$stock->item_name}}</td>
                <td>{{$stock->totalIn}}</td>
                <td>{{$stock->totalOut}}</td>
                @if($stock->TOTAL)
                <td>{{$stock->TOTAL}}</td>
                    @else
                    <td>{{$stock->totalIn}}</td>
                    @endif
            </tr>
            @endforeach



            </table>
    </div>

@endsection
