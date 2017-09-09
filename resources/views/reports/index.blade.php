@extends('layouts.sidenav')
@section('content')
    <div class="col-md-10">
        <form class="form-group" action="{{route('pdfview')}}" method="get">
            {{csrf_field()}}
            <table class="table table-responsive">
                <tr>
                    <td colspan="5">
                        <label for="" ><h3 style="color: green;margin:0;">Select Report</h3></label>
                    </td>

                    <td >
                        <button class="btn pull-right " value="submit" name="submit" type="submit">Download PDF</button>
                    </td>

                </tr>
                <?php $redund='';?>
                <tr align="center">
                    <td><input type=""  class="form-control datepicker" name="cdate" placeholder="Enter Date...(dd-mm-yyyy)"></td>
                    <td><select class="form-control" name="region">
                        <option value="">Select Region</option>
                        @foreach ($regions as $r)
                            @if($redund!=$r->name && $r->name!="Customer")
                                <option value="{{$r->name}}">{{$r->name}}</option>
                                <?php $redund=$r->name;?>
                                @endif
                        @endforeach
                    </select>
                    </td>
                    <td>
                    <select class="form-control" name="sub_region">
                        <option value="">Select Sub-Region</option>
                        @foreach ($regions as $r)
                            @if($r->sub_name)
                            <option value="{{$r->id}}">{{$r->name}}/{{$r->sub_name}}</option>
                            @endif
                        @endforeach
                    </select>
                    </td>
                    <td>
                        <select name="type" class="form-control" id="">
                            <option value="">All</option>
                            <option value="Warehouse">Warehouse</option>
                        </select>
                    </td>
                    <?php $redund='';?>
                    <td><select name="item_name" class="form-control" id="">
                            @foreach($items as $item)
                                @if($redund!=$item->item_group)
                                    <option value="{{$item->item_group}}">{{$item->item_group}}</option>
                                    <?php $redund=$item->item_group;?>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <input type="hidden" name="download" value="pdf">
                </tr>
            </table>
        </form>
    </div>

@endsection
