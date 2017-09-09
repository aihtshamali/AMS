@extends('layouts.sidenav')
@section('content')
    <?php
    $returndetails[][]=null;
    //            print_r ($returndetails);
    $row=0;$col=0;
    foreach ($return_detail as $dd)
    {
        if ($row==0 && $col==0)
        {
            $returndetails[$row][$col]=$dd->customer_id;$col++;
            $returndetails[$row][$col]=$dd->sales_invoice;$col++;
            $returndetails[$row][$col]=$dd->item_id;$col++;
            $returndetails[$row][$col]=$dd->quantity;$col++;

        }
        else if($returndetails[($row)][0]==$dd->customer_id){
            $returndetails[$row][$col]=$dd->item_id;$col++;
            $returndetails[$row][$col]=$dd->quantity;$col++;

        }
        else if($returndetails[($row)][0]!=$dd->customer_id)
        {
            $row++;
            $col=0;
            $returndetails[$row][$col]=$dd->customer_id;$col++;
            $returndetails[$row][$col]=$dd->sales_invoice;$col++;
            $returndetails[$row][$col]=$dd->item_id;$col++;
            $returndetails[$row][$col]=$dd->quantity;$col++;
        }

    }
    ?>
    <script type="text/javascript">
        var a = <?php echo json_encode($stock); ?>;
    </script>
    <div class="">

        <h3 style="color: darkgreen;
    float: left;
    font-weight: bold ">Edit Return</h3>


        <form action="{{route('returns.update',$return->id)}}" method="post" >
            {{ method_field('PUT') }}
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table">
                    <tr>
                        <td>  <label for="name">Document Number.</label> </td>
                        <td>
                            <input type="text" class="form-control" name="doc_no" id="ref" value="{{$return->ftn_no}}" readonly>
                        </td>
                        <td>
                            <label for="reference">Reference Number.</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="reference" id="" value="{{$return->reference}}" required>
                        </td>
                        <td>
                            <label for="description">Date</label>    </td>
                        <td><input  class="form-control datepicker" placeholder="dd-mm-yyyy" data-provide="datepicker" name="cdate" id="" value="{{$return->ftn_date}}"> </td>

                    </tr>
                    <tr>
                        <td>  <label for="to_">To</label> </td>
                        <td>
                            <input type="text" class="form-control" name="to_" id="" value="{{$return_detail[0]->region->name}}/{{$return_detail[0]->region->sub_name}}" readonly>
                        </td>
                        <td>
                            <label for="vehicle_id">Vehicle Number.</label>
                        </td>
                        <td>
                            <select name="vehicle_id" class="selectpicker show-tick">
                                <option value=""></option>
                                @foreach($vehicles as $vehicle)
                                    if({{$vehicle->id}}=={{$return->vehicle_id}})
                                    <option value="{{$vehicle->id}}" selected>{{$vehicle->name}}</option>
                                    else
                                    <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <label for="description">Driver</label>    </td>
                        <td>
                            <select name="driver_id" class="selectpicker show-tick">
                                <option></option>
                                @foreach($drivers as $driver)
                                    if({{$driver->id}}=={{$return->driver_id}})
                                    <option value="{{$driver->id}}" selected>{{$driver->name}}</option>
                                    else
                                    <option value="{{$driver->id}}">{{$driver->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            {{--<datalist id="customer">--}}
                {{--@foreach($customers as $customer)--}}
                    {{--<option value="{{$customer->id}}">{{$customer->account_name }} / {{$customer-> account_no}}</option>--}}
                {{--@endforeach--}}
            {{--</datalist>--}}
            <div class="table-wrapper row customer"  style="margin-right: 0px;">
                <table class="table">
                    <tr>
                        <th>
                            <label class="col-xs-7" for="name">Customer Information</label>
                        </th>
                        <?php $col=0;$row=0;?>
                        @for($i=0; $i<10 ;$i++)
                            <td class="col-xs-3" >
                                @if($i<(count($returndetails)))
                                    <input type="text" style=" padding: 0 0 0 5px; height: 30px;width: 200px"  name="customer[<?=$i?>]" class="form-control custs" value="{{getCustomer($returndetails[$row][$col])->account_name}}">
                                @else
                                    <input type="text" style=" padding: 0 0 0 5px; height: 30px;width: 200px"  class="form-control custs" name="customer[<?=$i?>]">
                                @endif
                                {{--<select name="customer[<=$i?>]" style="height: 30px;width: 200px">--}}
                                    {{--<option></option>--}}
                                    {{--@foreach($customers as $customer)--}}
                                        {{--@if($i<(count($returndetails)) && ($customer->id==$returndetails[$row][$col]))--}}
                                            {{--<option type="text"  value="{{$customer->id}}" selected >{{$customer->account_name }} / {{$customer-> account_no}}</option>--}}

                                        {{--@else--}}
                                            {{--<option type="text"  value="{{$customer->id}}"  >{{$customer->account_name }} / {{$customer-> account_no}}</option>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                                <?php $row+=1?>
                            </td>
                        @endfor
                    </tr>
                    <tr>
                        <th>
                            <label for="name">Sales Invoice</label>
                        </th>
                        <?php $row=0; $col=1?>
                        @for($i =0; $i<10 ;$i++)
                            <td class="col-xs-5">
                                @if($i<(count($returndetails)))
                                    <input type="text" class="form-control" name="sales_invoice[<?=$i?>]" id="<?=$i?>sales" value="{{$returndetails[$i][$col]}}">
                                @else
                                    <input type="text" class="form-control" name="sales_invoice[<?=$i?>]" id="<?=$i?>sales" placeholder="Enter SalesInvoice #...">
                                @endif
                            </td>
                            <?php $row+=1;?>
                        @endfor
                    </tr>
                    <?php $j=0; $row=0;$col=1;?>
                    @foreach($items as $item)
                        @if($item->item_group=="CRATE" && ($item->id=="6" ||$item->id=="7"))
                            <?php $col++; ?>
                            <tr>
                                <th style="background-color: #{{$item->color}};border-right: 1px white solid">
                                    <label style="font-size:12px; display: inline"  for="name">{{$item->display_name}}</label>
                                    <span for="" class="totalstock{{$item->id}}" style="color:white;font-weight: bold"></span>
                                </th>
                                <input type="hidden" name="getid[<?=$j++?>]" value="{{$item->id}}">
                                @for($i=0; $i<10 ;$i++)
                                    <td style="background-color: #{{$item->color}};">
                                        @if($i<count($returndetails))
                                            @if($returndetails[$row][$col]==$item->id)
                                                <input type="number" class="<?=$i?>qty <?=$item->id?>item form-control" min="0"  name= "item[<?=$i?>][{{$item->id}}]" onchange="checkStock(<?=$i?>,a,{{$item->id}})" onblur="getTotal(this,<?=$i?>,{{$item->id}});"   value="{{$returndetails[$row][$col+1]}}">
                                                <?php $row++;?>
                                            @endif
                                        @else
                                            <input type="number" class="<?=$i?>qty <?=$item->id?>item form-control" min="0"  name= "item[<?=$i?>][{{$item->id}}]" onchange="checkStock(<?=$i?>,a,{{$item->id}})" onblur="getTotal(this,<?=$i?>,{{$item->id}});"   placeholder="{{$item->name}}">
                                        @endif
                                    </td>
                                @endfor
                                <?php $col++;$row=0;?>
                            </tr>
                        @endif

                    @endforeach
                    <tr>
                        <th style="background-color: black;border-right: 1px white solid">
                            <label for="name">Total</label>
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
            console.log(searchCusts[0]);
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
