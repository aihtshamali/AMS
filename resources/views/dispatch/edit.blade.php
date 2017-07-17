@extends('layouts.sidenav')
@section('content')
    <div class="">
        <h3>Edit Dispatch</h3>


        <form action="{{route('dispatch.update',$dispatch->id)}}" method="post" >
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table">
                    <tr>
                        <td>  <label for="name">Document Num.</label> </td>
                        <td>
                            <input type="text" class="form-control" name="doc_no" id="ref" value="{{$dispatch->doc_no}}" readonly>
                        </td>
                        <td>
                            <label for="reference">Reference num.</label>
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
                            <label for="vehicle_id">Vehicle Num.</label>
                        </td>
                        <td>
                            <select name="vehicle_id" class="selectpicker show-tick">
                                <option></option>
                                @foreach($vehicles as $vehicle)
                                    if({{$vehicle->id}}=={{$dispatch->vehicle_id}})
                                        <option value="{{$vehicle->id}}" selected>{{$vehicle->name}}</option>
                                    else
                                        <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <label for="description">Address</label>    </td>
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


<?php $i=0;?>
            <div class="table-wrapper row customer">
                <table class="table">
                    <tr>
                        <th>
                            <label class="col-xs-7" for="name">Customer Information</label>
                        </th>
                        @for(;$i<($dispatch->countDispatchDetails($dispatch->id))/2;$i++)
                            <td class="col-xs-3" >
                                <select name="customer[<?=$i?>]" style="height: 30px;width: 200px">
                                    <option></option>
                                    @foreach($customers as $customer)
                                        if({{$customer->id}}=={{$dispatch_detail[$i]->customer_id}}){
                                        <option type="text"  value="{{$customer->id}}"  selected>{{$customer->account_name }} / {{$customer-> account_no}}</option>
                                        }else{
                                        <option type="text"  value="{{$customer->id}}"  >{{$customer->account_name }} / {{$customer-> account_no}}</option>
                                    }
                                    @endforeach
                                </select>
                            </td>
                        @endfor
                        @for($i=$dispatch->countDispatchDetails($dispatch->id)-1; $i<10 ;$i++)
                            <td class="col-xs-3" >

                                <select name="customer[<?=$i?>]" style="height: 30px;width: 200px">
                                    <option></option>
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
                            <td class="col-xs-5">
                                <input type="text" class="form-control" name="sales_invoice[<?=$i?>]" id="<?=$i?>sales" placeholder="Sales Invoice...">
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
                                <input type="hidden" name="getid[<?=$j++?>]" value="{{$item->id}}"> </input>
                                @for($i=0; $i<10 ;$i++)
                                    <td>
                                        <input type="number" class="<?=$i?>qty form-control" min="0"  name= "item[<?=$i?>][{{$item->id}}]" onchange="getTotal(this,<?=$i?>,{{$item->id}});"   placeholder="{{$item->name}}">
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


            <button type="submit" class=" pull-right btn btn-lg btn-warning" id="submit" name="submit">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        </form>
    </div>
@endsection
