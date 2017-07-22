@extends('layouts.sidenav')
@section('content')
<?php

        $arr[][]=null;
        $rows=0;$cols=0;
        foreach ($dispatch_detail as $dd)
            {
                $cols=0;
                if($dd->dispatch->region_id==Auth::user()->region->id)
                {
                      $arr[$rows][$cols]=$dd->item_id;   // id in first column and quantity in second column
                      $cols++;
                      $arr[$rows][$cols]=$dd->quantity;
                      $rows++;
                }
            }
?>
<script type="text/javascript">
    var a = <?php echo json_encode($arr); ?>;
</script>


    <div class="">
        <h3>Create Dispatch</h3>


        <form action="{{route('dispatch.store')}}" method="post" >
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table">
                <tr>
                    <td>  <label for="name">Document Number.</label> </td>
                    <td>
                        <input type="text" class="form-control" name="doc_no" id="ref" value="{{$doc_no}}" readonly>
                    </td>
                    <td>
                        <label for="reference">Reference Number.</label>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="reference" id="" placeholder="Reference Number.." required>
                    </td>
                    <td>
                    <label for="description">Date</label>    </td>
                    <td><input type="date" class="form-control datepicker" data-provide="datepicker" name="cdate" id="" placeholder="Date"> </td>

                </tr>
                <tr>
                    <td>  <label for="from_">From</label> </td>
                    <td>
                        <input type="text" class="form-control" name="from_" id="" value="{{Auth::user()->region->name}}" readonly>
                    </td>
                    <td>
                        <label for="vehicle_id">Vehicle Number</label>
                    </td>
                    <td>
                        <select name="vehicle_id"  style="width: 80%;"  class="selectpicker form-control show-tick" required>
                            <option value="">--Select Vehicle--</option>
                            @foreach($vehicles as $vehicle)
                              <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    <label for="description">Driver</label>    </td>
                    <td>
                        <select name="driver_id"  style="width: 60%;"  class="selectpicker form-control show-tick" required>
                            <option value="">--Select Driver--</option>
                            @foreach($drivers as $driver)
                                <option value="{{$driver->id}}">{{$driver->name}}</option>
                            @endforeach
                        </select>
                    </td>

                </tr>
                </table>
            </div>



        <div class="table-wrapper row customer" style="margin-right: 0px">
            <table class="table">
             <tr>
                    <th >
                           <label class="col-xs-7" for="name">Customer Information</label>
                    </th>
                 @for($i =0; $i<10 ;$i++)
                    <td class="col-xs-3 form-control" style="border: none; padding:5px 0 0 5px;">
                        <select name="customer[<?=$i?>]" style="height: 30px;width: 200px">
                            <option value="">--Select Customer--</option>
                            @foreach($customers as $customer)
                                <option type="text"  value="{{$customer->id}}"  >{{$customer->account_name }} / {{$customer-> account_no}}</option>
                            @endforeach
                        </select>
                    </td>
                 @endfor
             </tr>
                <tr>
                    <th>
                        <label for="name">Sales Invoice</label>
                    </th>
                    @for($i =0; $i<10 ;$i++)
                        <td class="col-xs-5" style="border: none; padding:0 0 5px 5px;">
                            <input type="text"  class="form-control" name="sales_invoice[<?=$i?>]" id="<?=$i?>sales" placeholder="Sales Invoice...">
                        </td>
                    @endfor
                </tr>
                <?php $j=0; ?>
                @foreach($items as $item)
                    @if($item->item_group=="CRATE" && ($item->id=="6" ||$item->id=="7"))
                    <tr>
                        <th >
                            <label  for="name">{{$item->display_name}}</label>
                        </th>
                        <input type="hidden"  name="getid[<?=$j++?>]" value="{{$item->id}}"> </input>
                        @for($i=0; $i<10 ;$i++)
                            <td style="border: none; padding:5px 0 0 5px;">
                                <input type="number"  onblur="checkStock(<?=$i?>,a,{{$item->id}})" class="<?=$i?>qty item form-control" min="0"  name= "item[<?=$i?>][{{$item->id}}]" onchange="getTotal(this,<?=$i?>,{{$item->id}});"   placeholder="{{$item->name}}">
                            </td>
                        @endfor
                    </tr>
                    @endif
                @endforeach
                <tr>
                    <th >
                        <label for="name">Total</label>
                    </th>
                    @for($i =0; $i<10 ;$i++)
                        <td>
                            <input  type="number" class="form-control" min="0" name="total[<?=$i?>]" id="<?=$i?>qtytotal" readonly placeholder="Total...">
                        </td>
                    @endfor
                </tr>
            </table>
        </div>


            <button type="submit" class=" pull-right btn btn-lg btn-info" id="submit" name="submit">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        </form>
    </div>
    <script >

    </script>
@endsection
