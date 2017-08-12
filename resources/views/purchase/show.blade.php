@extends('layouts.sidenav')
@section('content')
    <div class="">
        <h3 style="color: #000;">Purchase</h3>

            <div classs="dispatchHeader">
                <table class="table-responsive table">
                    <tr>
                        <td>  <label for="name">Document Number.</label> </td>
                        <td>
                            <input type="text" class="form-control" name="doc_no" id="ref" value="{{$purchases[0]->purchase->doc_no}}" readonly>
                        </td>

                        <td>  <label for="name">Date</label> </td>
                        <td>
                            <input type="date" class="form-control" name="ftn_date" value="{{$purchases[0]->purchase->cdate}}" required >
                        </td>


                        <td>
                            <label for="reference">Reference Number.</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="reference" id="" value="{{$purchases[0]->purchase->reference}}" required>
                        </td>

                    </tr>
                    <tr>
                        <td>  <label for="to_">To</label> </td>
                        <td>
                            <input type="text" class="form-control" style="width:inherit" name="region" id="" value="{{$purchases[0]->purchase->region->name}}" readonly>
                        </td>
                        <td>
                            <label for="vehicle">Vehicle Number.</label>
                        </td>
                        <td>
                            <select name="vehicle" class="selectpicker">
                                <option selected value="" ></option>
                                @foreach($vehicles as $vehicle)
                                    @if($purchases[0]->purchase->vehicle_id==$vehicle->id)
                                        <option value="{{$vehicle->id}}"selected>{{$vehicle->name}} </option>
                                    @else
                                        <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="driver">Driver</label>    </td>
                        <td>
                            <select name="driver" class="selectpicker" required>
                                <option selected value =""> </option>
                                @foreach($drivers as $driver)
                                    @if($purchases[0]->purchase->driver_id==$driver->id)
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

        <?php $redund=null; $i=0?>     <!--  Forced to appear header only once. and $i is counter -->
            <table class="table-responsive table">
                @foreach($items as $alloweditem)
                    @if($redund!=$alloweditem->item_group)
                        <tr style="margin:0px;padding:0px;background-color: #bd2355;color:white;">
                            <td>
                                <?php $redund=$alloweditem->item_group?>
                                <h3 style="margin:0px;padding:0px">{{$alloweditem->item_group}}</h3>
                            </td>
                            <td></td>
                        </tr>
                    @endif
                    <tr>
                        <td><label for="">{{$alloweditem->display_name}}</label></td>
                        <input type="hidden" name="getid[<?=$i?>]" value="{{$alloweditem->id}}">
                        @if($i<count($purchases))
                            @if($purchases[$i]->item_id==$alloweditem->id)
                                <td><input name="item[<?=$i?>][{{$alloweditem->id}}]" value="{{$purchases[$i]->quantity}}" type="number" min="0" class="form-control qty" style="width:200px;" onchange="setTotal();"></td>
                            @else
                                <td><input name="item[<?=$i?>][{{$alloweditem->id}}]"  type="number" min="0" class="form-control qty" style="width:200px;" onchange="setTotal();"></td>
                            @endif
                        @else
                            <td><input name="item[<?=$i?>][{{$alloweditem->id}}]"  type="number" min="0" class="form-control qty" style="width:200px;" onchange="setTotal();"></td>
                        @endif
                    </tr>
                    <?php $i++?>
                @endforeach
                <tr>
                    <td><label for=""><strong style="color: #000;">Total</strong></label></td>
                    <td><input type="number" name="total" id="total" min="0" class="form-control total"  style="width:200px;"></td>
                </tr>
            </table>

    </div>

@endsection
