@extends('layouts.sidenav')
@section('content')
    <div class="">
        <h3>Transfer Shipped</h3>


        <form action="{{route('transfer.store')}}" method="post" >
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table">
                    <tr>
                        <td>  <label for="name">Document Num.</label> </td>
                        <td>
                            <input type="text" class="form-control" name="doc_no" id="ref" value="{{$doc_no}}" readonly>
                        </td>

                        <td>  <label for="name">Date</label> </td>
                        <td>
                            <input type="date" class="form-control" name="ftn_date" >
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
                            <input type="text" class="form-control" style="width:inherit" name="from_" id="" value="{{Auth::user()->region->name}}" readonly>
                        </td>
                        <td>
                            <label for="region_id">TO</label>
                        </td>
                        <td>
                            <select name="region_id" class="selectpicker show-tick">
                                <option selected disabled hidden ></option>
                                @foreach($regions as $region)
                                    <option value="{{$region->id}}">{{$region->name}}</option>
                                @endforeach
                            </select>
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
                    </tr>
                    <tr>
                        <td>
                            <label for="description">Driver</label>    </td>
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
            <?php $redund=null; $i=0?>     <!--  Forced to appear header only once. and $i is counter -->
           <table class="table-responsive table">
               @foreach($useritems as $alloweditem)
                   @if($redund!=$alloweditem->item->item_group)
                   <tr style="margin:0px;padding:0px">
                       <td>
                           <?php $redund=$alloweditem->item->item_group?>
                           <h3 style="margin:0px;padding:0px;color: #000;">{{$alloweditem->item->item_group}}</h3>
                       </td>
                       <td></td>
                   </tr>
                   @endif
                   <tr>
                       <td><label for="">{{$alloweditem->item->display_name}}</label></td>
                       <input type="hidden" name="getid[<?=$i?>]" value="{{$alloweditem->item_id}}">
                       <td><input name="items[<?=$i?>]" type="number" min="0" class="form-control qty" onchange="setTotal();"></td>
                   </tr>
                    <?php $i++?>
               @endforeach
               <tr>
                   <td><label for=""><strong style="color: #000;">Total</strong></label></td>
                   <td><input type="number" name="total" id="total" min="0" class="form-control total"></td>
               </tr>
           </table>

            <button type="submit" class=" pull-right btn btn-lg btn-warning" name="submit">Submit</button>
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
