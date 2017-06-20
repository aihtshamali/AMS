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
                        <input type="text" class="form-control" name="doc_no" value="HardCoded" disabled>
                    </td>
                    <td>
                        <label for="display_name">Reference num.</label>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="reference" id="" placeholder="Display name" required>
                    </td>
                    <td>
                    <label for="description">Date</label>    </td>
                    <td><input type="date" class="form-control datepicker" data-provide="datepicker" name="cdate" id="" placeholder="Date"> </td>

                </tr>
                <tr>
                    <td>  <label for="name">From</label> </td>
                    <td>
                        <input type="text" class="form-control" name="from_" id="" value="WareHouse" disabled>
                    </td>
                    <td>
                        <label for="display_name">Vehicle Num.</label>
                    </td>
                    <td>
                        <select name="vehicle_id" id="">
                            @foreach($vehicles as $vehicle)
                              <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    <label for="description">Address</label>    </td>
                    <td>
                        <select name="driver_id" id="">
                            @foreach($drivers as $driver)
                                <option value="{{$driver->id}}">{{$driver->name}}</option>
                            @endforeach
                        </select>
                    </td>

                </tr>
                </table>
            </div>



        <div class="table-wrapper row">
            <table class="table">
             <tr>

                     <th >
                           <label class="col-xs-7" for="name">Customer Information</label>
                    </th>

                 @for($i =0; $i<10 ;$i++)
                    <td class="col-xs-5">
                        <input type="text"  name="customer[]" id="<?=$i?>" placeholder="Customers...">
                    </td>
                 @endfor
             </tr>
                <tr>

                    <th>
                        <label for="name">Sales Invoice</label>
                    </th>
                    @for($i =0; $i<10 ;$i++)
                        <td class="col-xs-5">
                            <input type="text"  name="sales_invoice[]" id="<?=$i?>" placeholder="Sales Invoice...">
                        </td>
                    @endfor
                </tr>

                <tr>
                    <th >
                        <label  for="name">Green Crate</label>
                    </th>
                    @for($i =0; $i<10 ;$i++)
                        <td>
                            <input type="number"  name="green[]" id="<?=$i?>" class="greenqty" placeholder="Green Caret...">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <th >
                        <label for="name">Yellow ,Blue Handle Crate</label>
                    </th>
                    @for($i =0; $i<10 ;$i++)
                        <td>
                            <input type="number"  name="blue[]" id="<?=$i?>" class="yellowqty" placeholder="Blue Handle...">
                        </td>
                    @endfor
                </tr>
                <tr>
                    <th >
                        <label for="name">Total</label>
                    </th>
                    @for($i =0; $i<10 ;$i++)
                        <td>
                            <input type="number"  name="total[]" id="total<?=$i?>" >
                        </td>
                    @endfor
                </tr>
            </table>
        </div>


            <button type="submit" class=" pull-right btn btn-lg btn-warning" name="submit">Submit</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

        </form>
    </div>
@endsection
