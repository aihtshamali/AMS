@extends('layouts.sidenav')
@section('content')
    <div class="half_body" style="">
        <h3 style="color: darkgreen;
    float: left;
    font-weight: bold ">AMS=>Show Shipped</h3>



            <div class="dispatchHeader">
                <table class="table-responsive table">
                    <tr>
                        <td><label for="name">Document #</label></td>
                        <td>
                            <input type="text" class="form-control" name="doc_no" id="ref"
                                   value="{{$transfers[0]->transfer->ftn_no}}" readonly>
                        </td>

                        <td><label for="name">Date</label></td>
                        <td>
                            <input class="form-control  datepicker" style="width: unset;" placeholder="dd-mm-yyyy" name="ftn_date" value="{{$transfers[0]->transfer->ftn_date}}">
                        </td>


                        <td>
                            <label for="reference">Reference Number</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" style="width:200px" name="reference" id=""
                                   value="{{$transfers[0]->transfer->reference}}" required>
                        </td>

                    </tr>
                    <tr>
                        <td><label for="from_">From</label></td>
                        <td>
                            @if($transfers[0]->transfer->type!="Freezer")
                                <input type="text" class="form-control" style="width:220px" name="from_" id=""
                                       value="{{getRegion($transfers[0]->transfer->from_)->name}}/{{getRegion($transfers[0]->transfer->from_)->sub_name}}" readonly>
                            @else
                                <input type="text" class="form-control" style="width:220px;" name="from_" id=""
                                       value="{{$transfers[0]->region->name}}/{{$transfers[0]->region->sub_name}}" readonly>
                            @endif
                        </td>
                        <td>
                            <label for="region_id">TO</label>
                        </td>
                        <td>
                            <select name="region_id" class="form-control " required>
                                <option selected value="">Select Region</option>
                                @foreach($regions as $region)
                                    @if($transfers[0]->region_id==$region->id)
                                        <option value="{{$region->id}}" selected>{{$region->name}}</option>
                                    @else
                                        <option value="{{$region->id}}">{{$region->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <label for="vehicle_id">Vehicle Number</label>
                        </td>
                        <td>
                            <select name="vehicle_id" class="form-control" required>
                                <option selected value="">Select Vehicle</option>
                                @foreach($vehicles as $vehicle)
                                    @if($transfers[0]->transfer->vehicle_id==$vehicle->id)
                                        <option value="{{$vehicle->id}}" selected>{{$vehicle->name}}</option>
                                    @else
                                        <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="description">Driver</label></td>
                        <td>
                            <select name="driver_id" class="form-control" >
                                <option selected value="">Select Driver</option>
                                @foreach($drivers as $driver)
                                    @if($driver->id==$transfers[0]->transfer->driver_id)
                                        <option value="{{$driver->id}}" selected>{{$driver->name}}</option>
                                    @else
                                        <option value="{{$driver->id}}">{{$driver->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>

                    </tr>
                </table>
            </div>
            <hr size="3px">
        <?php $redund = null; $i = 0; $it = 0?>     <!--  Forced to appear header only once. and $i is counter -->
            <table class="table-responsive table">
                @foreach($useritems as $alloweditem)
                    @if($redund!=$alloweditem->item->item_group)
                        <tr style="margin:0px;padding:0px;background-color: #bd2355;color:white;">
                            <td>
                                <?php $redund = $alloweditem->item->item_group?>
                                <h3 style="margin:0px;padding:0px;">{{$alloweditem->item->item_group}}</h3>
                            </td>
                            <td></td>
                        </tr>
                    @endif
                    {{--{{dd($transfers)}}--}}
                    <tr>
                        <td><label for="">{{$alloweditem->item->display_name}}</label></td>
                        <input type="hidden" name="getid[<?=$i?>]" value="{{$alloweditem->item_id}}">

                        @if($it<count($transfers) && $transfers[$it]->item_id==$alloweditem->item->id)
                            <td><input name="items[<?=$i?>]" type="number" min="0" class="form-control qty"
                                       value="{{$transfers[$it]->quantity}}" onchange="setTotal();"></td>
                            <?php $it++?>
                        @else
                            <td><input name="items[<?=$i?>]" type="number" min="0" class="form-control qty"
                                       onchange="setTotal();"></td>
                        @endif
                    </tr>
                    <?php $i++;?>
                @endforeach
                <tr>
                    <td><label for=""><strong style="color: #000;">Total</strong></label></td>
                    <td><input type="number" name="total" id="total" min="0" class="form-control total"></td>
                </tr>
            </table>
    </div>
@endsection
