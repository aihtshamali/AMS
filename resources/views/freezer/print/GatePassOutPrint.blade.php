<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>.</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/printing.css') }}" rel="stylesheet">
    <style>
        th {
            text-align: center;
        }
    </style>
</head>

<body class="prt-body" data-gr-c-s-loaded="true">
<div class="" style="width:90%;padding-left:80px;margin-bottom: 100px">

    <table border="0">
        <tbody>
        <tr>
            <td>
                <table border="0">

                    <tbody>
                    <tr>
                        <td colspan="2" width="10%">
                            <div style="padding-bottom:10px;font-size:20px;text-align:center;font-weight:700;"><span
                                        style="border-bottom: 3px double;"> GATE OUTWARD </span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="font-size:16px;text-align:center;">Big Bird Foods (PVT) LTD.</div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3"><span style="float:left;"
                                              class="tbl-head"> Ref #. : {{$freezers[0]->transfer->ftn_no}}</span>
                            <span style="float:right" class="tbl-head">	Date: {{date("d-m-Y")}}</span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table border="0" width="100%"
                                   style="margin-top:10px; border: 1px solid #000000;font-size:12px;">


                                <tbody>
                                <tr>
                                    <th class="thb" width="30">Sr.#</th>
                                    <th class="thb">Freezer Type</th>
                                    <th class="thb">Made</th>
                                    <th class="thb">Serial No.</th>
                                    <th class="thb">Moved From</th>
                                    <th class="thb">Moved To</th>

                                    <th class="thb" align="center" width="30">Quantity</th>
                                </tr>
                                <?php $i = 1; $total = 0;?>
                                @foreach($freezers as $freezer)
                                    <tr>
                                        <td class="tdb" align="center"> <?= $i++;?></td>
                                        <td class="tdb">{{$freezer->freezer_type}}</td>
                                        <td class="tdb">{{$freezer->item->made}}</td>
                                        <td class="tdb">{{$freezer->serialNumber}}</td>
                                        <td class="tdb">{{$freezer->region->name}}</td>
                                        <td class="tdb">{{$freezer->transfer->to_}}</td>
                                        <td class="tdb">{{$freezer->quantity}}</td>
                                        <?php $total += ($freezer->quantity)?>
                                    </tr>
                                @endforeach
                                @for($i =count($freezers)+1;$i<=10;$i++)
                                    <tr>
                                        <td class="tdb" align="center"><?= $i?></td>
                                        <td class="tdb">&nbsp;</td>
                                        <td class="tdb">&nbsp;</td>

                                        <td class="tdb">&nbsp;</td>
                                        <td class="tdb">&nbsp;</td>
                                        <td class="tdb">&nbsp;</td>
                                        <td class="tdb">&nbsp;</td>

                                    </tr>
                                @endfor
                                <tr>

                                    <th colspan="6 " style="text-align:left">Total</th>

                                    <th><?= $total ?></th>
                                </tr>

                                </tbody>
                            </table>

                        </td>
                    </tr>
                    </tbody>
                </table>



                <br><br>
                <div>
	<span align="left">
		Prepared by:________________
</span>


                    <span style="float:right;">
	Approved by:________________
</span>
                </div>


            </td>
        </tr>
        </tbody>
    </table>
</div>

<div width="50%" style="border-bottom: 1px dotted black;margin-bottom:40px;">

</div>

    <div class="" style="width:90%;padding-left:80px;margin-bottom: 100px">

        <table border="0">
            <tbody>
            <tr>
                <td>
                    <table border="0">

                        <tbody>
                        <tr>
                            <td colspan="2" width="10%">
                                <div style="padding-bottom:10px;font-size:20px;text-align:center;font-weight:700;"><span
                                            style="border-bottom: 3px double;"> GATE OUTWARD </span></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-size:16px;text-align:center;">Big Bird Foods (PVT) LTD.</div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3"><span style="float:left;"
                                                  class="tbl-head"> Ref #. : {{$freezers[0]->transfer->ftn_no}}</span>
                                <span style="float:right" class="tbl-head">	Date: {{date("d-m-Y")}}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <table border="0" width="100%"
                                       style="margin-top:10px; border: 1px solid #000000;font-size:12px;">


                                    <tbody>
                                    <tr>
                                        <th class="thb" width="30">Sr.#</th>
                                        <th class="thb">Freezer Type</th>
                                        <th class="thb">Made</th>
                                        <th class="thb">Serial No.</th>
                                        <th class="thb">Moved From</th>
                                        <th class="thb">Moved To</th>

                                        <th class="thb" align="center" width="30">Quantity</th>
                                    </tr>
                                    <?php $i = 1; $total = 0;?>
                                    @foreach($freezers as $freezer)
                                        <tr>
                                            <td class="tdb" align="center"> <?= $i++;?></td>
                                            <td class="tdb">{{$freezer->freezer_type}}</td>
                                            <td class="tdb">{{$freezer->item->made}}</td>
                                            <td class="tdb">{{$freezer->serialNumber}}</td>
                                            <td class="tdb">{{$freezer->region->name}}</td>
                                            <td class="tdb">{{$freezer->transfer->to_}}</td>
                                            <td class="tdb">{{$freezer->quantity}}</td>
                                            <?php $total += ($freezer->quantity)?>
                                        </tr>
                                    @endforeach
                                    @for($i =count($freezers)+1;$i<=10;$i++)
                                        <tr>
                                            <td class="tdb" align="center"><?= $i?></td>
                                            <td class="tdb">&nbsp;</td>
                                            <td class="tdb">&nbsp;</td>

                                            <td class="tdb">&nbsp;</td>
                                            <td class="tdb">&nbsp;</td>
                                            <td class="tdb">&nbsp;</td>
                                            <td class="tdb">&nbsp;</td>

                                        </tr>
                                    @endfor
                                    <tr>

                                        <th colspan="6 " style="text-align:left">Total</th>

                                        <th><?= $total ?></th>
                                    </tr>

                                    </tbody>
                                </table>

                            </td>
                        </tr>
                        </tbody>
                    </table>



                    <br><br>
                    <div>
	<span align="left">
		Prepared by:________________
</span>


                        <span style="float:right;">
	Approved by:________________
</span>
                    </div>


                </td>
            </tr>
            </tbody>
        </table>
    </div>



</body>
</html>