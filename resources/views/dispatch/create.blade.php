@extends('layouts.sidenav')
@section('content')

{{--    {{dd($stocktransfer->toArray())}}--}}
<?php
//
//        $arr[][]=null;
//        $rows=0;$cols=0;
//        foreach ($dispatch_detail as $dd)
//        {
//                $cols=0;
//                if($dd->dispatch->region_id==Auth::user()->region->id)
//                {
//                      $arr[$rows][$cols]=$dd->item_id;   // id in first column and quantity in second column
//                      $cols++;
//                      $arr[$rows][$cols]=$dd->quantity;
//                      $rows++;
//                }
//        }
//

//}

//$va=$stockpurchase->toArray();
//print_r(count($stocktransfer));
?>
<script type="text/javascript">
    var a = <?php echo json_encode($stock); ?>;
    var customer = <?php echo json_encode($customers);?>;
</script>

    <div class="">
        <h3 style="color: darkgreen;
    float: left;
    font-weight: bold ">Create Dispatch</h3>

        <form action="{{route('dispatch.store')}}" method="post" >
            {{csrf_field()}}
            <div style="position: relative;left:-10px;" class="dispatchHeader">
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
                        <label for="description">Date</label>
                    </td>
                    <td >
                      {{--<input type="text" class="form-control datepicker" data-provide="datepicker" name="cdate" id="" placeholder="Date" required>--}}
                        <input type="text" name="cdate" class="form-control datepicker" placeholder="dd-mm-yyyy" required/>
                    </td>
                </tr>
                <tr>
                    <td>  <label for="from_">From</label> </td>
                    <td>
                        <input type="text" class="form-control" name="from_" id="" value="{{Auth::user()->region->name}}/{{Auth::user()->region->sub_name}}" readonly>
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

                 <th>
                     <label class="" style="font-size:12px;" for="name">Customer Information</label>
                 </th>
                 @for($i =0; $i<10 ;$i++)
                    <td class="col-xs-3 " style=" padding: 0 0 0 5px; height: 30px;width: 200px">
                        <input type="text" style=" padding: 0 0 0 5px; height: 30px;width: 200px"  id="<?=$i?>customer" placeholder="Enter Customer.." class="form-control custs" name=" customer[<?=$i?>]" onchange="fillCustCode('<?=$i?>customer',<?=$i?>)" autocomplete="on">
                    </td>

                 @endfor
             </tr>
             <tr>
                 <th>
                     <label class="" style="font-size:12px;" for="name">Customer Code</label>

                 </th>
                 @for($i =0; $i<10 ;$i++)
                    <td class="col-xs-3 " style=" padding: 0 0 0 5px; height: 30px;width: 200px">
                        <input type="text" style=" padding: 0 0 0 5px; height: 30px;width: 200px"   placeholder="Customer Code..." class="form-control custsCode<?=$i?>" name=" customer_code[<?=$i?>]" readonly>
                    </td>
                 @endfor
             </tr>
                <tr>
                    <th>
                        <label style="font-size:12px;" for="name">Sales Invoice</label>
                    </th>
                    @for($i =0; $i<10 ;$i++)
                        <td class="col-xs-5" style="border-bottom: 1px solid white; ">
                            <input type="text"  class="form-control" name="sales_invoice[<?=$i?>]" id="<?=$i?>sales" placeholder="Sales Invoice...">
                        </td>
                    @endfor
                </tr>
                <?php $j=0; ?>
                @foreach($items as $item)
                    @if($item->item_group=="CRATE" && ($item->id=="6" ||$item->id=="7"))
                    <tr >
                        <th style="background-color: #{{$item->color}};border-right: 1px white solid">
                            <label style="font-size:12px; display: inline"  for="name">{{$item->display_name}}</label>
                            <span for="" class="totalstock{{$item->id}}" style="color:white;font-weight: bold"></span>
                        </th>
                        <input type="hidden"  name="getid[<?=$j++?>]" value="{{$item->id}}"> </input>
                        @for($i=0; $i<10 ;$i++)
                            <td style="border: none; padding:5px 0 0 5px;background-color: #{{$item->color}}">
                                <input type="number"  onchange="checkStock(<?=$i?>,a,{{$item->id}})" class="<?=$i?>qty <?=$item->id?>item form-control" min="0"  name= "item[<?=$i?>][{{$item->id}}]" onblur="getTotal(this,<?=$i?>,{{$item->id}});"   placeholder="{{$item->name}}">
                            </td>
                        @endfor
                    </tr>
                    @endif
                @endforeach
                <tr>
                    <th style="padding:0 0 0 10px; background-color: black;border-right: 1px white solid">
                        <label style="font-size:12px;" for="name">Total</label>
                    </th>
                    @for($i =0; $i<10 ;$i++)
                        <td style="background-color: black;">
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
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>

    <script>
        var searchCusts = [
            <?php $cnt=1;
            foreach($customers as $customer) {
                if($cnt==count($customers))
                    echo '"' . $customer->account_name . '"';
                else
                    echo '"' . $customer->account_name . '",';
                $cnt++;
            } ?>

        ];
        var searchCustomer = [
            <?php $cnt=1;
            foreach($customers as $customer) {
                if($cnt==count($customers))
                    echo '"'.$customer->account_no . '"';
                else
                    echo '"'.$customer->account_no . '",';
                $cnt++;
            } ?>
        ];

        $(function() {
            $(".custs").autocomplete({
                source: searchCusts
            });

        });
        function fillCustCode(id,colNo){
            var customer_name=$("#"+id).val();
//            console.log(searchCusts[0]);
            for (i = 0; i < searchCusts.length; i++) {
                if(customer_name==searchCusts[i])
                {
                    $(".custsCode"+colNo).val(searchCustomer[i]);
                    break;
                }
                else
                {
                    $(".custsCode"+colNo).val("");
                }
            }
        }
    </script>
@endsection
