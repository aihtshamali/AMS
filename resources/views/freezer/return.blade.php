@extends('layouts.app')
@section('content')
    <div class="container" >
        <h3>Create Dispatch</h3>


        <form action="{{route('freezer.store')}}" method="post" >
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table">
                    <tr>
                        <td>  <label for="ftn_no">RTN Number</label> </td>
                        <td>
                            <input type="text" class="form-control" name="ftn_no" id="ref" value="RTN." readonly>
                        </td>
                        <td>
                            <label for="reference">Reference num.</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="reference" id="" placeholder="Reference Number.." required>
                        </td>
                        <td>
                            <label for="ftn_date">FTN Date</label>    </td>
                        <td><input type="date" class="form-control datepicker" data-provide="datepicker" name="ftn_date" id="" placeholder="Date"> </td>

                    </tr>
                    <tr>

                        <td><label for="customer">Customer</label></td>
                        <td>
                            <select name="customer" class="selectpicker " data-live-search="true"   data-width="" >
                                @foreach($customers as $customer)
                                    <option type="text"  value="{{$customer->id}}"  >{{$customer->account_name }} / {{$customer-> account_no}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="customer">Delivery Address</label></td>
                        <td><input type="text" class="form-control" name="delivery_address" data-width="100%"></td>
                    </tr>

                    <tr style="background-color:rgba(179, 136, 160, 0.5);"><td colspan="5"><label for="" >Freezer Information</label></td></tr>
                    <tr>
                        <td><label for="ftn_date">Date of Return</label></td>
                        <td><input type="date" class="form-control datepicker" data-provide="datepicker" name="placement_date" id="" placeholder="Date"> </td>
                        <td><label for="ftn_date">Purpose</label></td>
                        <td>
                            <select name="purpose" class="selectpicker show-tick">
                                <option selected value="Repairing">Repairing</option>
                            </select>
                        </td>
                    </tr>
                    <tr style="background-color: rgb(160, 17, 78);color: white;">
                        <td width="25px">Sr. No.</td>
                        <td width="">Transfer From</td>
                        <td width="">Freezer Type</td>
                        <td width="">Serial No.</td>
                        <td width="">Quantity</td>
                    </tr>
                    @for($i=0;$i<10;$i++)
                        <tr>
                            <td ><?=$i?></td>
                            <td>
                                <select onchange="changeFreezerTotal(this,<?=$i?>)" name="region[<?=$i?>]" class="selectpicker freezerlocation" data-live-search="true" id="<?=$i?>region"  data-width="100%" >
                                    <option selected  hidden style="color:rgb(0,0,0)"value="">Choose Location</option>
                                    @foreach($regions as $region)
                                        <option type="text"  value="{{$region->id}}"  >{{$region->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="type[<?=$i?>]" class="selectpicker " data-live-search="true" id="<?=$i?>type"  data-width="100%" >
                                    <option selected disabled hidden style="color:rgb(0,0,0)">Choose Type</option>
                                    <option type="text"  value="W-Right Up"  >W-Right Up</option>
                                    <option type="text"  value="Top Glass"  >Top Glass</option>

                                </select>
                            </td>
                            <td>
                                <input type="text"  class="form-control" name="serial_no[<?=$i?>]"  placeholder="Serial Number... ">
                            </td>
                            <td>
                                <input type="number"  class="form-control <?=$i?>freezerqty" name="qty[<?=$i?>]" readonly style="background-color: white; ">
                            </td>
                        </tr>
                    @endfor
                    <tr style="background-color: rgb(160, 17, 78);color: white;" ><td colspan="5"><label for="" >Authorize Information</label></td></tr>
                    <tr>
                        <td>
                            <label for="">TSO:</label>
                        </td><td>
                            <select name="faculty" id="">
                                <option disabled hidden>Select Faculty</option>
                                <option value="">none</option>
                            </select>
                        </td>
                        <td>
                            <label for="">RSM:</label>
                        </td><td><select name="faculty" id="">
                                <option disabled hidden>Select Faculty</option>
                                <option value="">none</option>
                            </select>
                        </td>
                        <td>
                            <label for="">NSM:</label></td>
                        <td>
                            <select name="faculty" id="">
                                <option disabled hidden>Select Faculty</option>
                                <option value="">none</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <button type="submit" class=" pull-right btn btn-md btn-success" name="submit">Save Data</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        </form>
    </div>
@endsection
