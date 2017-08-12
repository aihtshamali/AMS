@extends('layouts.sidenav')
@section('content')

    <?php

    $arr[][]=null;
    $rows=0;
    foreach ($transfer_detail as $dd)
    {
            $arr[$rows][0]=$dd->item_id;   // id in first column and quantity is in second
            $arr[$rows][1]=$dd->quantity;
            $arr[$rows][2]=$dd->region_id;
            $rows++;
    }

    ?>
    <script type="text/javascript">
        var transferarr = <?php echo json_encode($stock); ?>;
    </script>

{{--{{dd($arr)}}--}}


    <div class="" style="">
        <div  >
            <h3 style="color: darkgreen;
    float: left;
    font-weight: bold ">Dispatch Freezer</h3>
        <form action="{{route('freezer.store')}}" method="post">
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table table-sm">
                    <tr>
                        <td><label for="ftn_no">FTN #</label></td>
                        <td>
                            <input type="text" class="form-control" style="" name="ftn_no" id="ref" value="FTN."
                                   readonly>
                        </td>
                        <td>
                            <label for="reference">Reference Number.</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="reference" id=""
                                   placeholder="Reference Number.." required>
                        </td>
                        <td align="center">
                            <label for="ftn_date">FTN Date</label>
                        </td>
                        <td>
                            <input type="date" class="form-control datepicker" data-provide="datepicker" name="ftn_date"
                                   id="" placeholder="Date" required>
                        </td>
                        <td></td>

                    </tr>
                    <tr>

                        <td><label for="customer">Customer</label></td>
                        <td>
                            <select name="customer" class="selectpicker" data-live-search="true"
                                    data-width="" required>
                                <option selected value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option type="text" value="{{$customer->id}}">{{$customer->account_name }}
                                        / {{$customer-> account_no}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><label for="customer">Delivery Address</label></td>
                        <td><input type="text" class="form-control" name="delivery_address" data-width="100%" required></td>
                        <td></td><td></td><td></td>
                    </tr>
                    <tr>

                    </tr>

                    <tr style="background-color: rgb(160, 17, 78);color: white;">
                        <td colspan="7"><label for="">Freezer Information</label></td>
                    </tr>
                    <tr>
                        <td><label for="ftn_date">Date of Placement</label></td>
                        <td><input type="date" class="form-control datepicker" data-provide="datepicker"
                                   name="placement_date" id="" placeholder="Date" required></td>
                        <td><label for="ftn_date">Purpose</label></td>
                        <td>
                            <select name="purpose" class="selectpicker " required>
                                <option selected value="">--Choose Purpose--</option>
                                <option value="new">New</option>
                                <option value="expansion">Expansion</option>
                                <option value="new_branch">New Branch</option>
                                <option value="replacement">Replacement</option>
                            </select>
                        </td>

                    </tr>
                    <tr style="background-color: rgb(160, 17, 78);color: white;">
                        <td width="25px">Sr. No.</td>
                        <td width="">Transfer From</td>
                        <td width="">Freezer Type</td>
                        <td width="">Model</td>
                        <td width="">Condition</td>
                        <td width="">Serial No.</td>
                        <td width="">Quantity</td>
                    </tr>
                    @for($i=0;$i<10;$i++)
                        <tr>
                            <td><?=$i?></td>
                            <td>
                                    <select onchange="changeFreezerTotal(this,<?=$i?>,transferarr)" name="region[<?=$i?>]"
                                        class="form-control <?=$i?>freezer freezerlocation" data-live-search="true"
                                        id="<?=$i?>region"
                                        data-width="100%">
                                    <option selected value="" style="color:rgb(0,0,0)" value="">Choose Location</option>
                                    @foreach($regions as $region)
                                        <option type="text" value="{{$region->id}}">{{$region->name }}/{{$region->sub_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="type[<?=$i?>]" class="<?=$i?>freezer form-control " onchange="checkFreezerStock(this,<?=$i?>,transferarr)" data-live-search="true"
                                        id="<?=$i?>type" data-width="100%">
                                    <option selected value="" style="color:rgb(0,0,0)">Choose Type</option>
                                    @foreach($items as $item)
                                    <option type="text" value="{{$item->id}}">{{$item->display_name}}</option>
                                    @endforeach


                                </select>
                            </td>
                            <td>
                                <input name="model[<?=$i?>]" type="text" class="<?=$i?>freezer form-control" id="<?=$i?>model"
                                       placeholder="Enter Model...">
                            </td>
                            <td>
                                <select name="condition[<?=$i?>]" class="<?=$i?>freezer selectpicker " data-live-search="true"
                                        id="<?=$i?>condition" data-width="100%">
                                    <option selected disabled hidden style="color:rgb(0,0,0)">Choose Condition</option>
                                    <option type="text" value="new">New</option>
                                    <option type="text" value="used">Used</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="<?=$i?>freezer form-control" name="serial_no[<?=$i?>]"
                                       placeholder="Serial Number... ">
                            </td>
                            <td>
                                <input type="number" id="<?=$i?>freezerqty" class="<?=$i?>freezer form-control <?=$i?>freezerqty freezer" name="qty[<?=$i?>]" readonly
                                       style="background-color: white; ">
                            </td>
                        </tr>
                    @endfor
                    <tr style="background-color: rgb(160, 17, 78);color: white;">
                        <td colspan="7"><label for="">Authorize Information</label></td>
                    </tr>
                    <tr style="width:40%">
                            <td align="center" style="padding: 0px;margin:0px">
                                <label for="">NSM</label>
                            </td>
                            <td style="padding: 0px;margin:0px">
                                <select class="form-control" name="nsm" id="" required>
                                    @foreach($faculty as $fac)
                                        @if($fac->type=="NSM")
                                            <option value="{{$fac->id}}" selected>{{$fac->name}}</option>
                                        @endif
                                    @endforeach
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
            <button type="submit" style="position: relative;left: 0px;" class=" pull-right btn btn-md btn-info" id="submit" name="submit">Save Data</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        </form>
        </div>
    </div>
@endsection
