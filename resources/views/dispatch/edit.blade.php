@extends('layouts.sidenav')
@section('content')
    <?php
            $dispatchdetails[][]=null;
//            print_r ($dispatchdetails);
            $row=0;$col=0;
            foreach ($dispatch_detail as $dd)
            {
                if ($row==0 && $col==0)
                    {
                        $dispatchdetails[$row][$col]=$dd->customer_id;$col++;
                        $dispatchdetails[$row][$col]=$dd->sales_invoice;$col++;
                        $dispatchdetails[$row][$col]=$dd->item_id;$col++;
                        $dispatchdetails[$row][$col]=$dd->quantity;$col++;

                    }
                    else if($dispatchdetails[($row)][0]==$dd->customer_id){
                        $dispatchdetails[$row][$col]=$dd->item_id;$col++;
                        $dispatchdetails[$row][$col]=$dd->quantity;$col++;

                    }
                    else if($dispatchdetails[($row)][0]!=$dd->customer_id)
                        {
                            $row++;
                            $col=0;
                            $dispatchdetails[$row][$col]=$dd->customer_id;$col++;
                            $dispatchdetails[$row][$col]=$dd->sales_invoice;$col++;
                            $dispatchdetails[$row][$col]=$dd->item_id;$col++;
                            $dispatchdetails[$row][$col]=$dd->quantity;$col++;
                        }

            }
            ?>

    <div class="">
        <h3>Edit Dispatch</h3>


        <form action="{{route('dispatch.update',$dispatch->id)}}" method="post" >
            {{ method_field('PUT') }}
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table">
                    <tr>
                        <td>  <label for="name">Document Number.</label> </td>
                        <td>
                            <input type="text" class="form-control" name="doc_no" id="ref" value="{{$dispatch->doc_no}}" readonly>
                        </td>
                        <td>
                            <label for="reference">Reference Number.</label>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="reference" id="" value="{{$dispatch->reference}}" required>
                        </td>
                        <td>
                            <label for="description">Date</label>    </td>
                        <td><input type="date" class="form-control datepicker" data-provide="datepicker" name="cdate" id="" value="{{$dispatch->cdate}}"> </td>

                    </tr>
                    <tr>
                        <td>  <label for="from_">From</label> </td>
                        <td>
                            <input type="text" class="form-control" name="from_" id="" value="{{Auth::user()->region->name}}" readonly>
                        </td>
                        <td>
                            <label for="vehicle_id">Vehicle Number.</label>
                        </td>
                        <td>
                            <select name="vehicle_id" class="selectpicker show-tick">
                                <option value=""></option>
                                @foreach($vehicles as $vehicle)
                                    if({{$vehicle->id}}=={{$dispatch->vehicle_id}})
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
                                    if({{$driver->id}}=={{$dispatch->driver_id}})
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
                                        @if($i<(count($dispatchdetails)) && ($customer->id==$dispatchdetails[$row][$col]))
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
                                @if($i<(count($dispatchdetails)))
                                    <input type="text" class="form-control" name="sales_invoice[<?=$i?>]" id="<?=$i?>sales" value="{{$dispatchdetails[$i][$col]}}">
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
                                        @if($i<count($dispatchdetails))
                                            @if($dispatchdetails[$row][$col]==$item->id)
                                                <input type="number" class="<?=$i?>qty form-control" min="0"  name= "item[<?=$i?>][{{$item->id}}]" onchange="getTotal(this,<?=$i?>,{{$item->id}});"   value="{{$dispatchdetails[$row][$col+1]}}">
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
