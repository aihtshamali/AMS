@extends('layouts.sidenav')
@section('content')
    <div class="">
        <h3 style="color: Green;">Purchase</h3>

        <form action="{{route('purchase.store')}}" method="post" >
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table">
                    <tr>
                        <td>  <label for="name">Document Number.</label> </td>
                        <td>
                            <input type="text" class="form-control" name="doc_no" id="ref" value="{{$doc_no}}" readonly>
                        </td>

                        <td>  <label for="name">Date</label> </td>
                        <td>
                            <input  class="form-control datepicker" placeholder="dd-mm-yyyy" name="ftn_date" >
                        </td>


                        <td>
                            <label for="reference">Reference Number.</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="reference" id="" placeholder="Reference Number.." required>
                        </td>

                    </tr>
                    <tr>
                        <td>  <label for="to_">To</label> </td>
                        <td>
                            <input type="text" class="form-control" style="width:250px" name="region" id="" value="{{Auth::user()->region->name}}/{{Auth::user()->region->sub_name}}" readonly>
                        </td>
                        <td>
                            <label for="vehicle">Vehicle Number.</label>
                        </td>
                        <td>
                            <select name="vehicle" class="selectpicker">
                                <option selected value="" ></option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
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
                                    <option value="{{$driver->id}}">{{$driver->name}}</option>
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
                        <td><input name="item[<?=$i?>][{{$alloweditem->id}}]" type="number" min="0" class="form-control qty" style="width:200px;" onchange="setTotal();"></td>
                    </tr>
                    <?php $i++?>
                @endforeach
                <tr>
                    <td><label for=""><strong style="color: #000;">Total</strong></label></td>
                    <td><input type="number" name="total" id="total" min="0" class="form-control total"  style="width:200px;"></td>
                </tr>
            </table>

            <button type="submit" class=" pull-right btn btn-lg btn-info" name="submit">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        </form>
    </div>
    <script >

    </script>
@endsection
