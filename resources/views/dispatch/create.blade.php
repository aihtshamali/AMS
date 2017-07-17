@extends('layouts.sidenav')
@section('content')
    <div class="">
        <h3>Create Dispatch</h3>


        <form action="{{route('dispatch.store')}}" method="post" >
            {{csrf_field()}}
            <div classs="dispatchHeader">
                <table class="table-responsive table">
                <tr>
                    <td>  <label for="name">Document Num.</label> </td>
                    <td>
                        <input type="text" class="form-control" name="doc_no" id="ref" value="{{$doc_no}}" readonly>
                    </td>
                    <td>
                        <label for="reference">Reference num.</label>
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
                        <input type="text" class="form-control" name="from_" id="" value="WareHouse" readonly>
                    </td>
                    <td>
                        <label for="vehicle_id">Vehicle Num.</label>
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



        <div class="table-wrapper row customer">
            <table class="table">
             <tr>
                    <th >
                           <label class="col-xs-7" for="name">Customer Information</label>
                    </th>
                 @for($i =0; $i<10 ;$i++)
                    <td class="col-xs-3 form-control" style="border: none; padding:5px 0 0 5px;">
                        <select name="customer[]" style="height: 30px;width: 200px">
                            <option value="">--Select Customer--</option>
                            @foreach($customers as $customer)
                                <option type="text"  value="{{$customer->id}}"  >{{$customer->account_name }} / {{$customer-> account_no}}</option>
                            @endforeach  data-live-search="true" id="<?=$i?>customer"   >
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
                            <td style="border: none; padding:5px 0 0 5px;">
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
    <script >

    </script>
@endsection
