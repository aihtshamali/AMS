@extends('layouts.sidenav')
@section('content')
    <div class="">
        <h3 style="color: #000;">Purchase</h3>

        <form action="{{route('purchase.store')}}" method="post" >
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
                        <td>  <label for="to_">To</label> </td>
                        <td>
                            <input type="text" class="form-control" style="width:inherit" name="region" id="" value="{{Auth::user()->region->name}}" readonly>
                        </td>
                        <td>
                            <label for="vehicle">Vehicle Num.</label>
                        </td>
                        <td>
                            <select name="vehicle" class="selectpicker show-tick">
                                <option selected disabled hidden ></option>
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
                            <select name="driver" class="selectpicker show-tick">
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
                @foreach($items as $alloweditem)
                    @if($redund!=$alloweditem->item_group)
                        <tr style="margin:0px;padding:0px">
                            <td>
                                <?php $redund=$alloweditem->item_group?>
                                <h3 style="margin:0px;padding:0px;color: #000;">{{$alloweditem->item_group}}</h3>
                            </td>
                            <td></td>
                        </tr>
                    @endif
                    <tr>
                        <td><label for="">{{$alloweditem->display_name}}</label></td>
                        <input type="hidden" name="getid[<?=$i?>]" value="{{$alloweditem->id}}">
                        <td><input name="item[<?=$i?>][{{$alloweditem->id}}]" type="number" min="0" class="form-control qty" onchange="setTotal();"></td>
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

    </script>
@endsection
