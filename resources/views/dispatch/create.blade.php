@extends('layouts.app')
@section('content')
    <div class="container" >
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
                        <select name="vehicle_id" class="selectpicker show-tick">
                            <option></option>
                            @foreach($vehicles as $vehicle)
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
                    <td class="col-xs-3" >
                        <select name="customer[]" style="height: 30px;width: 200px">
                            <option></option>
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
