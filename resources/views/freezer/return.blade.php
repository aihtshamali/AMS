@extends('layouts.sidenav')
@section('content')
    <div class="container">
        <h3 style="color: darkgreen;
    float: left;
    font-weight: bold ">AMS=>Return Freezer</h3>


        <form action="{{route('freezer.store')}}" method="post" >
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table table-sm">
                    <tr>
                        <td>  <label for="ftn_no">FTN Number</label> </td>
                        <td>
                            <input type="text" class="form-control" name="ftn_no" id="ref"  value="RTN." readonly>
                        </td>
                        <td>
                            <label for="reference">Reference num.</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="reference" id="" placeholder="Reference Number.." required>
                        </td>
                        <td align="center">
                            <label for="ftn_date">FTN Date</label>
                        </td>
                        <td>
                            <input  class="form-control datepicker" data-provide="datepicker" name="ftn_date" id="" placeholder="dd-mm-yyyy">
                        </td>

                    </tr>
                    <tr>

                        <td><label for="customer">Customer</label></td>
                        <td>
                            <select name="customer" class="selectpicker" data-live-search="true"    >
                                <option selected hidden>Select Customer</option>
                                @foreach($customers as $customer)
                                    <option type="text"  value="{{$customer->id}}"  >{{$customer->account_name }} / {{$customer-> account_no}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><label for="customer">Transfer From</label></td>
                        <td><input type="text" class="form-control" name="delivery_address" data-width="100%"></td>
                    </tr>
                    <tr>

                    </tr>

                    <tr style="background-color: rgb(160, 17, 78);color: white;"><td colspan="7"><label for="" >Freezer Information</label></td></tr>
                    <tr>
                        <td><label for="ftn_date">Date of Return</label></td>
                        <td><input type="" class="form-control datepicker" data-provide="datepicker" name="placement_date" id="" placeholder="Date"> </td>
                        <td><label for="ftn_date">Purpose</label></td>
                        <td>
                            <select name="purpose" class="selectpicker show-tick">
                                <option selected disabled hidden>--Choose Purpose--</option>
                                <option value="repairing">Repairing</option>
                            </select>
                        </td>

                    </tr>
                    <tr style="background-color: rgb(160, 17, 78);color: white;">
                        <td width="25px">Sr. No.</td>
                        <td width="">Transfer To</td>
                        <td width="">Freezer Type</td>
                        <td width="">Model</td>
                        <td width="">Condition</td>
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

                                        <option type="text"  value="{{$region->id}}"  >{{$region->name }}/{{$region->sub_name }}</option>
                                        <?php $redund=$region->name;?>

                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="type[<?=$i?>]" class="form-control " data-live-search="true" id="<?=$i?>type"  data-width="100%" >
                                    <option selected disabled hidden style="color:rgb(0,0,0)">Choose Type</option>
                                    @foreach($items as $item)
                                        <option type="text" value="{{$item->id}}">{{$item->display_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input name="model[<?=$i?>]" type="text" class="form-control" id="<?=$i?>model"   >
                            </td>
                            <td>
                                <select name="condition[<?=$i?>]" class="selectpicker " data-live-search="true" id="<?=$i?>condition"  data-width="100%" >
                                    <option selected disabled hidden style="color:rgb(0,0,0)">Choose Condition</option>
                                    <option type="text"  value="new"  >New</option>
                                    <option type="text"  value="used">Used</option>
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
                    <tr style="background-color: rgb(160, 17, 78);color: white;" ><td colspan="7"><label for="" >Authorize Information</label></td></tr>
                    <tr style="width:40%">
                        <?php $i = 0 ?>
                        <td align="center" style="padding: 0px;margin:0px">
                            <label for="">NSM</label>
                        </td>
                        <td style="padding: 0px;margin:0px">
                            <select class="form-control" name="nsm" id="" required>
                                 <option value="{{$nsm->id}}" selected>{{$nsm->name}}</option>
                            </select>
                        </td>

                        <td align="center" style="padding: 0px;margin:0px">
                            <label for="">RSM</label>
                        </td>
                        <td style="padding: 0px;margin:0px">
                            <select class="form-control" name="rsm" id="" required>
                                @foreach($faculty as $fac)
                                    @if($fac->type=="RSM" && $fac->region_id==Auth::user()->region_id)
                                        <option value="{{$fac->id}}" selected>{{$fac->name}}</option>
                                    @elseif($fac->type=="RSM")
                                        <option value="{{$fac->id}}">{{$fac->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                        <td align="center" style="padding: 0px;margin:0px">
                            <label for="">TSO</label>
                        </td>
                        <td style="padding: 0px;margin:0px">
                            <select class="form-control" name="tso" id="" required>
                                <option value="" selected>--Select Faculty--</option>
                                @foreach($faculty as $fac)
                                    @if($fac->type=="TSO"))
                                    <option value="{{$fac->id}}">{{$fac->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <button type="submit" class=" pull-right btn btn-md btn-info" name="submit">Save Data</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        </form>
    </div>
@endsection
