<html lang="" class="gr__localhost">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> .</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/printing.css') }}" rel="stylesheet">

</head>


<body data-gr-c-s-loaded="true" style="">
<div style="padding:10px 10px 0px 50px ">
    <table>
        <tbody>
        <tr>
            <td>
                <table border="0" width="100%">
                    <tbody>
                    <tr>
                        <td valign="top" rowspan="2" width="100px;"><img src="{{ asset('images/logo.jpg') }}"
                                                                         width="100px" height="96px"></td>
                        <td colspan="3" style="text-align:center;padding-right: 90px;">
                            <div style="font-size:20px;font-weight:700;"> Big Bird Foods (PVT) LTD.
                            </div>
                            <div style="font-size:16px;">FREEZER RETURN NOTE</div>
                        </td>
                    </tr>
                    <tr >
                        <td align="right" colspan="3" style="position: relative;top:30px">
                            <div style="width:80%;float:left;font:15px;"> Ref No.:</div>
                            <div style="width:30%;margin-bottom: 10px;"class="tbl-data">{{$freezers[0]->returns->ftn_no}}</div>
                            <div style="width:80%;float:left;font:15px;" > Date:</div>
                            <div style="width:30%;margin-top:12px;" class="tbl-data">{{date("d/m/Y")}}</div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <div class="sub-head header-box"  > Customer Information</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table class="header-box round-border" style="margin-top:4px; border: 1px solid #000000;" cellpadding="5" width="100%">

                                <tbody>
                                <tr>
                                    <td class="tbl-head">Customer Name:</td>
                                    <td class="tbl-data">{{$freezers[0]->customer->account_name}}</td>
                                    <td class="tbl-head">Customer Code:</td>
                                    <td class="tbl-data">{{$freezers[0]->customer->account_no}}</td>
                                </tr>

                                <tr>
                                    <td class="tbl-head">Segment:</td>
                                    <td class="tbl-data">{{$freezers[0]->customer->getregion($freezers[0]->customer->region_id)->name}}</td>
                                    <td class="tbl-head">Sub segment:</td>
                                    <td class="tbl-data">{{$freezers[0]->customer->getcity($freezers[0]->customer->city_id)->name}}</td>
                                </tr>
                                <tr>
                                    <td class="tbl-head">Delivery Address:</td>
                                    <td colspan="3" class="tbl-data">{{$freezers[0]->returns->from_}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>

        <tr>
            <td class="gap">
                <div style="float:left;" class="sub-head tbl-head"> Freezer Information</div>
                <div style=" margin-top: 10px;margin-left: 440px;" class="tbl-data"> Purpose of Placement:<span class="tbl-head">{{$freezers[0]->returns->purpose}}</span></div>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" width="100%" style="margin-top:4px; border: 1px solid #000000;font-size:12px;" class="freezer_information">


                    <tbody>
                    <tr>
                        <th class="thb tr_header">Sr.No.</th>
                        <th class="thb tr_header">Freezer Type</th>
                        <th class="thb tr_header">Model</th>
                        <th class="thb tr_header">Condition</th>
                        <th class="thb tr_header">Placement Date</th>
                        <th class="thb tr_header">Return Date</th>
                        <th class="thb tr_header">Serial No.</th>
                        <th class="thb tr_header" align="center">Quantity</th>
                    </tr>
                    <?php $i=1;?>
                    @foreach($freezers as $freezer)
                        <tr>
                            <td class="tdb" align="center"> <?= $i++;?></td>
                            <td class="tdb">{{$freezer->freezer_type}}</td>
                            <td class="tdb">{{$freezer->fr_model}}</td>
                            <td class="tdb">{{$freezer->fr_condition}}</td>
                            <td class="tdb">{{$freezer->returns->ftn_date}}</td>
                            <td class="tdb">{{$freezer->returns->return_date}}</td>
                            <td class="tdb">{{$freezer->serialNumber}}</td>
                            <td class="tdb" align="center">{{$freezer->quantity}}</td>
                        </tr>
                    @endforeach
                    @for($i =count($freezers)+1;$i<=10;$i++)
                        <tr>
                            <td class="tdb" align="center"><?= $i; ?></td>
                            <td class="tdb"></td>
                            <td class="tdb"></td>
                            <td class="tdb"></td>
                            <td class="tdb"></td>
                            <td class="tdb"></td>
                            <td class="tdb"></td>
                            <td class="tdb" align="center"></td>
                        </tr>
                    @endfor
                    <tr>

                        <th colspan="7" style="padding-left:10px;">Total</th>

                        <th align="center" style="padding-left:30px">1</th>
                    </tr>

                    </tbody>
                </table>

            </td>
        </tr>
        <tr>
            <td>
                <div class=""></div>
                <div class="gap sub-head"> Terms &amp; Condition:</div>
                <ol style="font-size:12px;">
                    <li>Freezers provided to Customer is property of Company and Customer has no ownership right over
                        it.
                    </li>
                    <li>In case of any fault in freezer customer will report to Sale Officer or Contact at 111-111-220
                    </li>
                    <li>In case freezer is lift backed by company customer must ask for FRN and will show in case of any
                        query.
                    </li>
                    <li>Freezers would be used for BIG BIRD's Products only.
                    </li>
                    <li>Customer can not sale or returns this freezer to anyone and would be charged in case of
                        violence.
                    </li>

                </ol>

            </td>
        </tr>
        <tr>
            <td>
                <table border="0" width="100%">
                    <tbody>
                    <tr>
                        <td colspan="6">
                            <div class="gap sub-head"> Approval:
                                {{--<div class="gap"></div>--}}
                            </div>
                        </td>
                    </tr>
                    <tr >
                        <td class="tbl-head" width="20%">Sales Officer:</td>
                        <td class="tbl-data" width="30%">{{$freezers[0]->returns->getFaculty($freezers[0]->returns->tso_id)->name}}</td>
                        <td class="tbl-head" width="10%">RSM:</td>
                        <td class="tbl-data" width="30%">{{$freezers[0]->returns->getFaculty($freezers[0]->returns->rsm_id)->name}}</td>
                        <td class="tbl-head" width="10%"> NSM:</td>
                        <td class="tbl-data" width="30%">{{$freezers[0]->returns->getFaculty($freezers[0]->returns->nsm_id)->name}}</td>
                    </tr>
                    </tbody>
                </table>

            </td>
        </tr>
        <tr>
            <td>
                <div class="gap sub-head">
                    Company Receiving
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <table class="header-box round-border" style="margin-top:3px; border: 1px solid #000000; font-size:12px;padding:18px 0 10px 0" width="100%" cellpadding="5">
                    <tbody>
                    <tr>
                        <td>Name:</td>
                        <td>_____________________</td>
                        <td> Signature/Thumb Expression</td>
                        <td>_________________________</td>
                    </tr>
                    <tr>
                        <td>CNIC:</td>
                        <td>_____________________</td>
                        <td> Phone Number:</td>
                        <td>_________________________</td>
                    </tr>

                    </tbody>
                </table>

            </td>
        </tr>

        <tr>


            <td style="font-size:10px;margin: 0;padding: 0;"> Head office Address: 2-A Ahmad Block New Garden Town, Lahore UAN: 111-111-220
          <span style="padding-left: 200px">{{ date("h:i:sa")}}</span>
            </td>

        </tr>
        <tr>

        </tr>
        </tbody>
    </table>
</div>
</body>
</html>