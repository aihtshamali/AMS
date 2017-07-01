@extends('layouts.app')
@section('content')
    <div class="container" >
        <h3>Purchase Shipped</h3>


        <form action="" method="post" >
            {{csrf_field()}}
            <div class="">
                <table class="table-responsive table">
                    <tr>
                        <td>  <label for="name">Document Num.</label> </td>
                        <td>
                            <input type="text" class="form-control" name="doc_no" id="ref" value="{{$doc_no}}" readonly>
                        </td>

                        <td>  <label for="name">Date</label> </td>
                        <td>
                            <input type="date" class="form-control" name="date" >
                        </td>


                        <td>
                            <label for="reference">Reference num.</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="reference" id="" placeholder="Reference Number.." required>
                        </td>

                    </tr>
                    <tr>
                        <td>  <label for="from_">From</label> </td>
                        <td>
                            <input type="text" class="form-control" name="from_" id="" value="WareHouse" readonly>
                        </td>
                        <td>
                            <label for="vehicle_id">Vehicle Num.</label>
                        </td>
                        <td>
                            <select name="vehicle_id" class="selectpicker show-tick">
                                <option selected disabled hidden ></option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <label for="description">Address</label>    </td>
                        <td>
                            <select name="driver_id" class="selectpicker show-tick">
                                <option selected disabled hidden> </option>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">{{$driver->name}}</option>
                                @endforeach
                            </select>
                        </td>

                    </tr>
                </table>
            </div>
            <hr size="3px">
            <table class="table-responsive table">
                <tr style="margin:0px;padding:0px">
                    <td>
                        <h3 style="margin:0px;padding:0px;color: #000;">Freezer</h3>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td><label for="">Right Up Freezer</label></td>
                    <td><input type="text" class="form-control"></td>
                </tr><tr>
                    <td><label for="">Top Glass (Waves)</label></td>
                    <td><input type="text" class="form-control"></td>
                </tr><tr>
                    <td><label for="">Right Up (Caravell)</label></td>
                    <td><input type="text" class="form-control"></td>
                </tr>
                <tr style="margin:0px;padding:0px">
                    <td>
                        <h3 style="margin:0px;padding:0px;color: #000;">Pallet</h3>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td><label for="">Plastic Pallet</label></td>
                    <td><input type="text" class="form-control"></td>
                </tr>
                <tr>
                    <td><label for="">Wooden Pallet</label></td>
                    <td><input type="text" class="form-control"></td>
                </tr>
                <tr style="margin:0px;padding:0px">
                    <td>
                        <h3 style="margin:0px;padding:0px;color: #000;" >Crate</h3>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td><label for="">Green Crate</label></td>
                    <td><input type="text" class="form-control"></td>
                </tr>
                <tr>
                    <td><label for="">Yellow With Blue Handle</label></td>
                    <td><input type="text" class="form-control"></td>
                </tr>
                <tr>
                    <td><label for=""><strong style="color: #000;">Total</strong></label></td>
                    <td><input type="text" class="form-control"></td>
                </tr>
            </table>

            <button type="submit" class=" pull-right btn btn-lg btn-warning" name="submit">Purchase</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        </form>
    </div>
    <script >
        {{--$(document).ready(function() {--}}
        {{--var val = 0;--}}
        {{--if ($ref == '0')--}}
        {{--val = 'DOC.000001';--}}
        {{--else {--}}
        {{--$part = explode(".","Doc.000001");--}}
        {{--$no = intval($part[1]);--}}
        {{--$no++;--}}
        {{--val = "DOC.".substr("000000", 1, 6 - strlen($no)).$no;--}}
        {{--}--}}
        {{--$ref = {!!json_encode($ref)!!};--}}
        {{--document.getElementById('ref').setAttribute('value', val);--}}
        {{--});--}}
    </script>
@endsection
