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
        .reportHeader{
            font-weight:bold;
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
        .dataTable .table-header td{
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
<body>

<div class="container">
    <div align="center">
        <h2 class="reportHeader">BIG BIRD FOODS (PVT) LTD.</h2>
        <h3 class="reportHeadersection reportHeader" >Freezer Balance List</h3>
        <p style="margin:5px;">Balance as on {{date('d/m/Y')}}</p>
    </div>
    <table align="center" class="table dataTable" cellspacing="0" cellpadding="0">
        <tr class="table-header">
            <td >Sr.No</td>
            <td >Type</td>
            <td >Account</td>
            <td  >Name</td>
            <td>Qty</td>
        </tr>
        {{--@foreach($data['transfer'] as $transfer)--}}
        <tr >
            <td colspan="5" style="padding-bottom:0;padding-left:0"><h3 style="margin:0;" >Central Region:</h3></td>
        </tr>
        <tr>
            <td style="padding:0;margin:0">lorem</td>
            <td style="padding:0;margin:0">ipsum</td>
            <td style="padding:0;margin:0">fsdfdsfsd</td>
            <td style="padding:0;margin:0">dsfdsffsdfsdfsdfsdfsdfsdfghghjjhgj  </td>
            <td style="padding:0;margin:0">55 </td>
        </tr>

        {{--@endforeach--}}
        <tr><td>6</td></tr>
        <tr >
            <td colspan="4" style="border-top:2px solid black">Sub Total</td>
            <td style="border-top:2px solid black">5</td>
        </tr>
        {{-- Customer td --}}
        <tr>
            <td>C</td>
            <td>U</td>
            <td>S</td>
            <td>T</td>
            <td>O</td>

        </tr>
        <tr >
            <td colspan="4" style="border-top:2px solid black">Sub Total</td>
            <td style="border-top:2px solid black">5</td>
        </tr>

        <tr style="outline: thin solid black;border:1px solid black;background-color:lightgray">
            <td colspan="4" style="padding:0 0 0 30px">Total</td>
            <td style="padding:0 0 0 10px">5</td>
        </tr>


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
            <td style="padding:0 0 0 10px;font-weight:bold;font-size:20px">5</td>
        </tr>
    </table>
</div>
</body>
</html>
