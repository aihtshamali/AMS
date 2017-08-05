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
        }
        .reportHeadersection {
            border-bottom: 3px double black;
            margin-left:280px;
        }
        .dataTable .table-header td{
            border: 1px solid black;
            padding: 0 0 0 10px;
            background-color: lightgray;
        }


    </style>
</head>
<body>

<div class="container">
    <div align="center">
        <h3 class="reportHeader">BIG BIRD FOODS (PVT) LTD.</h3>
        <h4 class="reportHeadersection reportHeader" >Freezer Balance List</h4>
        <p >Balance as on {{date('d/m/Y')}}</p>
    </div>
    <table class="table table-responsive dataTable">
        <tr class="table-header">
            <td >Sr.No</td>
            <td >Type</td>
            <td >Account</td>
            <td colspan="2" >Name</td>
            <td>Qty</td>
        </tr>
        {{--@foreach($data['transfer'] as $transfer)--}}

        {{--@endforeach--}}
        <tr><td>6</td></tr>
        <tr style="border-top:2px solid black ">
            <td colspan="5">Sub Total</td>
            <td>5</td>
        </tr>
    </table>

</div>
</body>
</html>