<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    {{--<link href="{{ asset('css/reports.css') }}" rel="stylesheet">--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css">--}}
    <style>
        .reportHeader {
            font-weight: bold;
            font-family: Arial Black;
            margin-bottom: 5px;
        }

        .reportHeadersection {
            border-bottom: 3px double black;
            width: 190px;
            margin: 0 auto 0 auto;
            /*margin-left: auto ;
            margin-right: auto ;*/
        }

        .dataTable .table-header td {
            border: 1px solid black;
            padding: 0 0 0 10px;
            background-color: lightgray;
        }

        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }

        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }

        /* For table*/

        table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            /*margin:40px;*/
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            /*border-top: 1px solid #eceeef;*/
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #eceeef;
        }

        .table tbody + tbody {
            /*border-top: 2px solid #eceeef;*/
        }

        .table .table {
            background-color: #fff;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #eceeef;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #eceeef;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-active,
        .table-active > th,
        .table-active > td {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover > td,
        .table-hover .table-active:hover > th {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-success,
        .table-success > th,
        .table-success > td {
            background-color: #dff0d8;
        }

        .table-hover .table-success:hover {
            background-color: #d0e9c6;
        }

        .table-hover .table-success:hover > td,
        .table-hover .table-success:hover > th {
            background-color: #d0e9c6;
        }

        .table-info,
        .table-info > th,
        .table-info > td {
            background-color: #d9edf7;
        }

        .table-hover .table-info:hover {
            background-color: #c4e3f3;
        }

        .table-hover .table-info:hover > td,
        .table-hover .table-info:hover > th {
            background-color: #c4e3f3;
        }

        .table-warning,
        .table-warning > th,
        .table-warning > td {
            background-color: #fcf8e3;
        }

        .table-hover .table-warning:hover {
            background-color: #faf2cc;
        }

        .table-hover .table-warning:hover > td,
        .table-hover .table-warning:hover > th {
            background-color: #faf2cc;
        }

        .table-danger,
        .table-danger > th,
        .table-danger > td {
            background-color: #f2dede;
        }

        .table-hover .table-danger:hover {
            background-color: #ebcccc;
        }

        .table-hover .table-danger:hover > td,
        .table-hover .table-danger:hover > th {
            background-color: #ebcccc;
        }

        .thead-inverse th {
            color: #fff;
            background-color: #292b2c;
        }

        .thead-default th {
            color: #464a4c;
            background-color: #eceeef;
        }

        .table-inverse {
            color: #fff;
            background-color: #292b2c;
        }

        .table-inverse th,
        .table-inverse td,
        .table-inverse thead th {
            border-color: #fff;
        }

        .table-inverse.table-bordered {
            border: 0;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }

        .table-responsive.table-bordered {
            border: 0;
        }
    </style>
</head>

{{--profeesor MIT linear algebra kilbert prank 12--}}
{{--intro to prob joseph tlitz ftine 12--}}


<body>
<div class="container">
    <div align="center">
        <h2 class="reportHeader">BIG BIRD FOODS (PVT) LTD.</h2>
        <h3 class="reportHeadersection reportHeader">{{$data['item_name']}} Balance List</h3>
        <p style="margin:5px;">Balance as on {{$data['cdate']}}</p>
    </div>
    {{--{{dd($data)}}--}}
    <table align="center" class="table dataTable" cellspacing="0" cellpadding="0">
        <tr class="table-header">
            <td>Sr.No</td>
            <td>Type</td>
            <td>Account</td>
            <td>Name</td>
            <td>Qty</td>
        </tr>
        <?php $redund = '';$sr = 0;$custsr = 0;$counter = 0;$change = 0;$regclas = 0;$cusclas = 0; $subregion=0;$subcust=0;$index=0 ; $regiont=0; $customert=0; $subregiont=0;$subcustomert=0;$subtotal=[]?>
        @if($data['stock'])
        @foreach($data['stock'] as $stock)
            @if($redund!=getRegion($stock->region)->name)
                <?php $redund = getRegion($stock->region)->name; ?>
                <tr>
                    <td colspan="5" style="padding-bottom:0;padding-left:0;padding-top: 30px"><h3 style="margin:0;">{{$redund}}:</h3></td>
                </tr>

                <?php $sr = 0; ?>
            @endif
            @if(count($data['stock'])>$counter+1)
                @if(getRegion($data['stock'][$counter+1]->region)->name!=$redund)
                    <?php $change++;?>
                @endif
            @endif
            <tr>
                <td style="padding:0;">{{++$sr}}</td>
                <td style="padding:0;">{{getRegion($stock->region)->type}}</td>
                <td style="padding:0;">{{getRegion($stock->region)->account}}</td>
                <td style="padding:0;">{{getRegion($stock->region)->sub_name}}</td>
{{--                {{dd($stock)}}--}}
                @if($stock->TOTAL==null)
                    <td class="regionqty<?=$index?>" id="region<?=$regclas++?><?=$index?>">{{$stock->totalIn}}</td>
                    <?php $regiont+= $stock->totalIn;?>
                @else
                    <td class="regionqty<?=$index?>" id="region<?=$regclas++?><?=$index?>" >{{$stock->TOTAL}}  </td>
                    <?php $regiont+= $stock->TOTAL; ?>
                @endif

            </tr>
            @if($change || count($data['stock'])==$counter+1)

                <tr style="font-weight: bold;">
                    <td colspan="4" style=" border-top:2px solid black; padding-bottom: 38px;padding-top: 0px;padding-left: 110px;" class="subqty">Sub Total</td>
                    <td style="border-top:2px solid black ;padding-top: 0px;" class="subregionqty" id="subregion<?=$subregion++?>">{{$regiont}}</td>
                </tr>
                    <?php $regclas=0;$subregiont=$regiont; $regiont=0;?>
                @if($data['custstock'])
                    @foreach($data['custstock'] as $customer)
                    @if(getRegion($stock->region)->name==getRegion($customer->region)->name )
                        <tr>
                            <td style="padding:3px 0px 3px 0px">{{++$custsr}} </td>
                            <td style="padding:3px 0px 3px 0px">Customer</td>
                            <td style="padding:3px 0px 3px 0px">{{getCustomer($customer->customer_id)->account_no}}</td>
                            <td style="padding:3px 0px 3px 0px">{{getCustomer($customer->customer_id)->account_name}} / {{$customer->item_id}}</td>
                            @if($customer->Net!=null)
                                <td style="padding:5px 0px 3px 10px" class="customerqty<?=$index?>" id="customer<?=$cusclas++;?><?=$index?>">{{$customer->Net}}</td>
                                <?php $customert+=$customer->Net?>
                            @else
                                <td class="customerqty<?=$index?>" style="padding:5px 0px 3px 10px" id="customer<?=$cusclas++?><?=$index?>">{{$customer->TotalIn}}</td>
                                <?php $customert+=$customer->TotalIn?>
                            @endif
                        </tr>
                    @endif

                    @endforeach

                <?php $custsr=0;?>
                <tr style="font-weight: bold;">
                    <td colspan="4" style="border-top:2px solid black;padding-bottom: 10px;padding-top: 0px;padding-left: 110px;">Sub Total</td>
                    <td style=" border-top:2px solid black;padding-bottom: 10px;padding-top: 0px;" class="subcusttotal" id="subcustomer<?=$subcust++?>">{{$customert}}</td>
                </tr>
                <tr style="outline: thin solid black;border:1px solid black;background-color:lightgray">
                    <td colspan="4" style="padding:0 0 0 30px">Total - {{getRegion($stock->region)->name}}</td>
                    <td style="padding:0 0 0 10px" class="total<?=$index;?>" id="totalID<?=$index;?>">{{$customert+$subregiont}}</td>
                </tr>
                        {{--<php $index++;?>--}}
                    @endif
                @endif
                <?php $subcustomert+=$customert+$subregiont?>
                <?php $change=0;$customert=0;?>
                <?php $counter++?>
        @endforeach
@endif

        {{--  Grand Total--}}
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="outline: thin solid black;border:1px solid black;background-color:lightgray">
            <td colspan="4" style="padding:0 0 0 30px; font-weight:bold;font-size:20px;">Grand-Total</td>
            <td style="padding:0 0 0 10px;font-weight:bold;font-size:20px" class="grandtotal">{{$subcustomert}}</td>
        </tr>
    </table>
</div>
</body>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
{{--<script src="{{ asset('js/utility.js') }}"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>--}}
{{--</html>--}}
{{--<script>--}}
{{--//        var subregion,subclass,subtotal=0,regionc=0;--}}
{{--//    $('.subregionqty').each(function(i) {--}}
{{--//--}}
{{--//        subregion = 0;subclass=0;--}}
{{--//        $('.regionqty'+i).each(function (id) {--}}
{{--//--}}
{{--//            if($("#region"+id+""+i).hasClass('regionqty'+i)) {--}}
{{--//                subregion += parseInt($("#region" + id + "" + i).text());--}}
{{--//                console.log($("#region" + id + "" + i).text());--}}
{{--//            }--}}
{{--//        });--}}
{{--//        $('#subregion'+i).html(subregion);--}}
{{--//--}}
{{--//        $('.customerqty'+i).each(function (id) {--}}
{{--//--}}
{{--//            if($('#customer'+id+''+i).hasClass('customerqty'+i)) {--}}
{{--//--}}
{{--//                subclass += parseInt($("#customer"+id+""+i).text());--}}
{{--//--}}
{{--//            }--}}
{{--//        });--}}
{{--//--}}
{{--//        $('#subcustomer'+i).html(subclass);--}}
{{--//        subtotal+=(subclass+subregion);--}}
{{--//        $('.total'+i).html(subclass+subregion);--}}
{{--//--}}
{{--//    });--}}
{{--//        $('.grandtotal').html(subtotal);--}}
    {{--//    console.log(id);--}}
    {{--//    alert(val);--}}
{{--</script>--}}
