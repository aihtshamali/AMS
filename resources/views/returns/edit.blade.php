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

    <div class="">
        <h3>Edit Dispatch</h3>


        <form action="{{route('dispatch.update',$return->id)}}" method="post" >
            {{ method_field('PUT') }}
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table">
                    <tr>
                        <td>  <label for="name">Document Number.</label> </td>
                        <td>
                            <input type="text" class="form-control" name="doc_no" id="ref" value="{{$return->doc_no}}" readonly>
                        </td>
                        <td>
                            <label for="reference">Reference Number.</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="reference" id="" value="{{$return->reference}}" required>
                        </td>
                        <td>
                            <label for="description">Date</label>    </td>
                        <td><input type="date" class="form-control datepicker" data-provide="datepicker" name="cdate" id="" value="{{$return->cdate}}"> </td>

                    </tr>
                    <tr>
                        <td>  <label for="from_">From</label> </td>
                        <td>
                            <input type="text" class="form-control" name="from_" id="" value="{{$return ->from_}}" readonly>
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
            <div class="table-wrapper row customer"  style="margin-right: 0px;">
                <table class="table">
                    <tr>
                        <th>
                            <label class="col-xs-7" for="name">Customer Information</label>
                        </th>
                        <?php $col=0;$row=0;?>
                        @for($i=0; $i<10 ;$i++)
                            <td class="col-xs-3" >

                                <select name="customer[<?=$i?>]" style="height: 30px;width: 200px">
                                    <option></option>
                                    @foreach($customers as $customer)
                                        @if($i<(count($returndetails)) && ($customer->id==$returndetails[$row][$col]))
                                            <option type="text"  value="{{$customer->id}}" selected >{{$customer->account_name }} / {{$customer-> account_no}}</option>

                                        @else
                                            <option type="text"  value="{{$customer->id}}"  >{{$customer->account_name }} / {{$customer-> account_no}}</option>
                                        @endif
                                    @endforeach
                                </select>
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
                                <th >
                                    <label  for="name">{{$item->display_name}}</label>
                                </th>
                                <input type="hidden" name="getid[<?=$j++?>]" value="{{$item->id}}">
                                @for($i=0; $i<10 ;$i++)
                                    <td>
                                        @if($i<count($returndetails))
                                            @if($returndetails[$row][$col]==$item->id)
                                                <input type="number" class="<?=$i?>qty form-control" min="0"  name= "item[<?=$i?>][{{$item->id}}]" onchange="getTotal(this,<?=$i?>,{{$item->id}});"   value="{{$returndetails[$row][$col+1]}}">
                                                <?php $row++;?>
                                            @endif
                                        @else
                                            <input type="number" class="<?=$i?>qty form-control" min="0"  name= "item[<?=$i?>][{{$item->id}}]" onchange="getTotal(this,<?=$i?>,{{$item->id}});"   placeholder="{{$item->name}}">
                                        @endif
                                    </td>
                                @endfor
                                <?php $col++;$row=0;?>
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
@endsection
