<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <title>COE</title>
    <style>
        .text-center {
            text-align: center
        }

        h1 {
            font-size: 22pt;

        }

        body,
        th,
        td {
            font-size: 9pt;
            font-family: Arial, sans-serif
        }

        h2 {
            font-size: 10pt padding:0;
            margin: 0;
        }

        h1>small,
        h2>small {
            font-size: 9pt;
            font-weight: normal;
        }

        .sig {
            width: 90%;
            margin: 0 auto;
            /*  border-bottom: solid 1px #000;*/
            text-transform: uppercase;
            vertical-align: bottom;
        }

        .table {
            width: 100%;
        }

        .underline {
            text-decoration: underline;
            text-transform: uppercase;
        }

        .dotted-table {
            padding-bottom: 10px;
            border-bottom: dashed 1px #000;
        }

        @page {
            size: 8.5in 13in;
            margin: 0.1in 0.4in;
            opacity: 0.75;
            padding: 0 !important;
            font-size: 10pt;
            font-family: Arial, sans-serif
        }

        .table-bordered {
            border: solid 1px;
        }

        .col-md-6 {
            width: 50%;
            display: inline-block
        }


        table.table-bordered td,
        {
        border: solid 1px #000
        }

        .footer-ds {
            font-size: 6pt;
            text-align: center;
            font-family: 'Times New Roman', Times, serif !important;
        }

        .signatories .sig {
            font-size: 1vw;
            vertical-align: bottom
        }

        ul {
            list-style: none;
            padding: 5px;
            margin: 0;
        }

        p {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .sub-label {
            font-size: 7pt !important;
            text-align: center;
        }

        .sub-label td {
            font-size: 7pt !important;

        }


        .sub-label td.underlined {

            border-top: solid 1px #000;
        }

        input[type="checkbox"] {
            margin-bottom: -5;
            padding: 0;
        }

        input[type="radio"] {
            margin-bottom: -3;
            padding: 0;
        }

        .chk {
            display: inline-flex;
            vertical-align: middle;
        }

        .boxed {
            border: solid 1px #000;
            padding: 0px 5px;
        }

        .sig-underline {
            line-height: 1em;
        }

        .bold {
            font-weight: bold
        }
    </style>
</head>

@foreach ($aics_beneficiaries as $aics_beneficiary)
    @php
        $my_records = [];
        $my_records = json_decode($aics_beneficiary['records']);

    @endphp

    <body>


        @for ($i = 0; $i < 2; $i++)
            <table style="width:100%">
                <tr>
                    <td><img src='{{ public_path('images/DSWD-DVO-LOGO_01.png') }}' style="width: 130px;">
                    </td>
                    <td style="text-align: right;">
                        <img src='{{ public_path('images/DSWD-DVO-LOGO_02.png') }}' style="width: 100px;">
                        <div style="font-family: 'Times New Roman', Times, serif; font-size: 6pt;">DSWD-PMB-GF-014 | REV 02 | 08 JAN 2024</div>
                    </td>
                </tr>
            </table>

            <div class="text-center" style="line-height: 1em;">
                <h2 style="font-size:12pt;"> CERTIFICATE OF ELIGIBILITY </h2>
                <p>(Financial Assistance)</p>
            </div>


            <table class="table" style="table-layout:fixed;" cellpadding=0 cellspacing=0>
                <tr class="sub-label">
                    <td style="width:15%">
                        <table class="table" style="table-layout: fixed;" cellspacing=0 cellpadding=0>
                            <td style="width:25%"><b> QN: </b></td>
                            <td style="border:solid 1px ; text-align:center; font-size:8pt !important"> <b>
                                    {{ $aics_beneficiary['payroll_client']['sequence'] }}</b></td>
                        </table>
                    </td>
                    <td style="width:50%">
                        <table class="table  text-center" style="table-layout: fixed;" cellspacing=0 cellpadding=0>
                            <td style="width:15%"><b> PCN: </b></td>
                            @for ($ii = 0; $ii < 14; $ii++)
                                <td style="border:solid 1px"></td>
                            @endfor

                        </table>
                    </td>
                    <td>
                        <table class="table  text-center" cellspacing=0 cellpadding=0>
                            <tr>
                                <td><b> Date: </b></td>
                                <td style="border:solid 1px">
                                    {{ date('m', strtotime($aics_beneficiary['payroll_client']['created_at'])) }}</td>
                                <td style="border:solid 1px">
                                    {{ date('d', strtotime($aics_beneficiary['payroll_client']['created_at'])) }}</td>
                                <td style="border:solid 1px">
                                    {{ date('Y', strtotime($aics_beneficiary['payroll_client']['created_at'])) }}</td>
                            </tr>

                        </table>


                    </td>
                </tr>
                <tr class="subl-label">
                    <td colspan="3" style="font-size: 8pt !important;">
                        <input type="checkbox">New
                        <input type="checkbox">Returning
                        <input type="radio">On-site
                        <input type="checkbox">Walk-in
                        <input type="checkbox">Referral
                        <input type="radio" checked>Off-site
                    </td>

                </tr>
            </table>

            <br>

            <table class="table " cellpadding=0 cellspacing=0>
                <tr>
                    <td style="width:120px">This is to certify that,</td>
                    <td class="text-center bold">
                        {{ $aics_beneficiary['first_name'] . ' ' . $aics_beneficiary['middle_name'] . ' ' . $aics_beneficiary['last_name'] . ' ' . $aics_beneficiary['ext_name'] }}
                    </td>
                    <td style="width:110px">,
                        <div class="chk"> <input type="checkbox"
                                @if ($aics_beneficiary['gender'] == 'Lalake') checked="true" @endif>Male
                        </div>
                        <div class="chk"><input type="checkbox"
                                @if ($aics_beneficiary['gender'] == 'Babae') checked="true" @endif>Female</label>
                    </td>
                    <td class="text-center bold">{{ $aics_beneficiary['age'] }} year/s</td>
                </tr>
                <tr class="sub-label">
                    <td></td>
                    <td class="underlined"><b> Kumpletong Pangalan</b> <i>(First name, Middle name, Last name)</i></td>
                    <td> <b> Kasarian</b> <i> (Sex)</i></td>
                    <td class="underlined"><b>Edad </b><i> (Age)</i></td>
                </tr>
            </table>

            <table class="table" cellpadding=0 cellspacing=0>
                <tr>
                    <td style="width: 22%">and presently residing at</td>
                    <td class="bold" style="font-size:8pt; ">
                        @if ($aics_beneficiary['street_number'])
                            {{ $aics_beneficiary['street_number'] . ', ' }}
                        @endif
                        {{ 'BRGY ' . $aics_beneficiary['psgc']['brgy_name'] . ', ' . $aics_beneficiary['psgc']['city_name'] . ', ' . $aics_beneficiary['psgc']['province_name'] }}
                    </td>
                </tr>
                <tr class="sub-label">
                    <td> </td>
                    <td class="underlined"><b> Kumpletong Tirahan</b> <i>(Complete Address)</i></td>
                </tr>
            </table>

            <table class="table" style="table-layout: fixed" cellpadding=0 cellspacing=1>
                <tr>
                    <td colspan="2">
                        has been found eligible for the assessment and the validation conducted for his/herself or
                        through the representation of his/her
                    </td>
                </tr>
                <tr>
                    <td style="height: 10px;"></td>
                    <td>

                    </td>
                </tr>
                <tr class="sub-label">
                    <td class="underlined"><b>Relasyon ng Kinatawan sa Benepisyaryo </b><i> (Relationship of the
                            Representative
                            to the Beneficiary)</i></td>
                    <td class="underlined"><b>Buong Pangalan ng Benepisyaryo</b> <i>(Name of the Beneficiary)</i></td>
                </tr>
            </table>
            <br>
            <table class="table" style=" border:solid #000 1px;" cellpadding=0 cellspacing=0>
                <thead>
                    <tr>
                        <td class="text-center" style=" background:#dedede; font-size:8pt; border:solid #000 1px;">
                            <b>Records of the case such as the following are confidentially filed at the Crisis
                                Intervention
                                Division (CID) </b>

                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-size:8pt; ">

                            @foreach ($record_options as $index => $record_option)
                                <div style="width:24% ; display:inline-block;">
                                    @if ($index != 8)
                                        <input type="checkbox" name="" id=""
                                            @if ($my_records && in_array($record_option, $my_records)) checked @endif>
                                        {{ $record_option }}
                                    @elseif (isset($aics_beneficiary['valid_id_presented']))
                                        <span
                                            style="text-decoration:underline;">{{ $aics_beneficiary['valid_id_presented'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                            {{ $aics_beneficiary['records_others'] }}
                        </td>
                    </tr>


                </tbody>
            </table>

            <p class="text-center" style="line-height:1.2em">
                The Client is hereby recommended to receive
                <span class="underline bold"> {{ $assistance_type }} </span> for
                <span class="underline bold"> {{ $assistance_type_subcategory }} </span> <br>
                in the amount of <span class="underline bold" style="text-transform:uppercase">{{ $amount_in_words }}
                    PESOS
                    ONLY</span>
                Php. <span class="underline bold"> {{ number_format($amount, 2) }}</span>
                CHARGABLE AGAINST:PSP <span class="underline bold">
                    {{ \Carbon\Carbon::parse($aics_beneficiary['payroll_client']['created_at'])->timeZone('Asia/Manila')->format('Y') }}
                </span>

            </p><br>

            <table class="table text-center" style="table-layout: fixed ; line-height:1em" cellpadding=0 cellspacing=1>
                <tbody>
                    <tr>
                        <td style="text-align: left; font-size:8pt;"><b>Conforme:</b></td>
                        <td style="text-align: left; font-size:8pt;"><b>Prepared by:</b></td>
                        <td style="text-align: left; font-size:8pt;"><b>Approved by:</b></td>
                    </tr>
                    <tr>
                        <td class="bold" style="padding-top:10px; font-size:8pt;">

                            {{ $aics_beneficiary['first_name'] . ' ' . $aics_beneficiary['middle_name'] . ' ' . $aics_beneficiary['last_name'] . ' ' . $aics_beneficiary['ext_name'] }}

                        <td>
                            <div class="sig bold"></div>
                        </td>
                        <td class="bold" style="padding-top:10px; font-size:8pt;">

                            {{ $approved_by }}

                        </td>
                    </tr>
                    <tr style=" line-height:1em; font-size:8pt ">
                        <td style="border-top:solid 1px;">
                            <b>Beneficiary/Representative</b> <br>
                            <i style="font-size: 6pt;">(Signature Over Printed Name)</i>
                        </td>
                        <td style="border-top:solid 1px;">
                            <b>Social Worker</b><br>
                            <i style="font-size: 6pt;">(Signature OverPrinted Name) </i>
                        </td>
                        <td style="border-top:solid 1px;">
                            <b>Approving Authority</b><br>
                            <i style="font-size: 6pt;">
                                (Signature Over Printed Name)
                            </i>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
        @endfor
        </div>



        <table class="table"
            style="table-laylout:fixed; width: 100%; background: #787878; color: #fff; margin-top:-5px ;" cellpadding=0
            cellspacing=0>
            <tr>
                <td style="width: 33%; font-size:8pt;"></td>
                <td style="width: 33% ; font-size:8pt;" class="text-center"><b> Acknowledgement Receipt</b></td>
                <td style="width: 33% ; font-size:7pt;"></td>
            </tr>
        </table>


        <table class="table" style="table-layout:fixed; font-size:8pt ; line-height:1em;">
            <tr class="sub-label">
                <td style="text-align: left !important"> <b> QN: </b> <b>
                    {{ $aics_beneficiary['payroll_client']['sequence'] }}
                    
                </td>
                <td></td>
                <td>
                    <table class="table  text-center" cellspacing=0 cellpadding=0>

                        <tr >
                            <td><b> Date: </b></td>
                            <td style="border:solid 1px">
                                {{ date('m', strtotime($aics_beneficiary['payroll_client']['created_at'])) }}</td>
                            <td style="border:solid 1px">
                                {{ date('d', strtotime($aics_beneficiary['payroll_client']['created_at'])) }}</td>
                            <td style="border:solid 1px">
                                {{ date('Y', strtotime($aics_beneficiary['payroll_client']['created_at'])) }}</td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td style="width:15%;  font-size: 8pt;">
                    Financial Assistance:
                </td>
                <td class="bold" style="width:50%; text-transform:uppercase;  font-size: 8pt;">
                    {{ $amount_in_words }} PESOS ONLY
                </td>
                <td>
                    Php <span class="bold"> {{ number_format($amount, 2) }}</span>
                </td>

            <tr class="sub-label">
                <td></td>
                <td class="underlined" style="font-size: 5pt;"><i>(Amount in Words)</i></td>
                <td class="underlined"></td>

            </tr>
            <tr>

                <td colspan="3">
                    <table cellpadding=0 cellspacing=0>
                        <tr>
                            <td style="font-size: 8pt;">
                                @foreach ($assistance_options as $options)
                                @php
                               
                                    $pos = strpos($options, $assistance_type);
                                    $checked=false;
                                    if ($pos === false) 
                                    $checked=false;
                                    else $checked=true;                          

                                @endphp
                                    <div style="width:30%; display:inline-block;">
                                        <input type="checkbox" name="" id="" @if($checked) checked @endif >{{$options }}
                                    </div>
                                @endforeach
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

            </tr>

        </table>



        <table class="table  text-center" style="table-layout: fixed; font-size:8pt " cellpadding=0 cellspacing=1>
            <tbody>
                <tr>
                    <td style="text-align: left; font-size:8pt;"><b>Tinangap ni:</b><br></td>
                    <td style="text-align: left;font-size:8pt; "><b>Binayaran ni:</b><br></td>
                    <td style="text-align: left; font-size:8pt; "><b>Sinaksihan ni:</b><br></td>
                </tr>
                <tr>
                    <td class="bold" style="padding-top:10px; ">
                        <div class="sig" style="font-size:8pt;">
                            {{ $aics_beneficiary['first_name'] . ' ' . $aics_beneficiary['middle_name'] . ' ' . $aics_beneficiary['last_name'] . ' ' . $aics_beneficiary['ext_name'] }}
                        </div>
                    </td>
                    <td class="bold" style="font-size:8pt; padding-top:10px; ">
                        {{ $SDO }}
                    </td>
                    <td style="font-size:8pt; padding-top:10px; ">

                    </td>
                </tr>
                <tr style="line-height: 1em; font-size:8pt ">

                    <td style="border-top:solid 1px; font-size:8pt; ">
                        <b>Beneficiary/Representative</b><br>
                        <i style="font-size: 6pt;">
                            (Signature Over Printed Name)
                        </i>
                    </td>

                    <td style="border-top:solid 1px; font-size:8pt;">
                        <b>RDO/SDO</b><br>
                        <i style="font-size: 6pt;">
                            (Signature Over Printed Name)
                        </i>
                    </td>

                    <td style="border-top:solid 1px; font-size:8pt;">
                        <b>Approving Authority</b><br>
                        <i style="font-size: 6pt;">
                            (Signature Over Printed Name)
                        </i>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 6pt; text-align: center; border-bottom: 1px solid #000"></td>
                    <td style="font-size: 6pt; text-align: center; border-bottom: 1px solid #000"> Page 1 of 1 </td>
                    <td style="font-size: 6pt;text-align: right; border-bottom: 1px solid #000"><small>*E.O 163 series
                            2022</small></td>
                </tr>
                <tr>

                    <td style="font-size: 6pt; font-family: 'Times New Roman', Times, serif " colspan="3">DSWD
                        Field Office
                        XI, Ramon Magsaysay Avenue Corner Damaso Suazo Street, Davao City<br>
                        Email: fo11@dswd.gov.ph Tel. No. (082) 227-1964 Website: http://www.dswd.gov.ph
                        <img src='{{ public_path('images/ISO-INSIGNIA.png') }}'
                            style="margin-top:-10px; width: auto; height:30px; text-align:right !important; float:right;">
                    </td>

                </tr>

            </tbody>
        </table>


        <table class="table footer-ds" cellpadding=0 cellspacing=0 style="font-size: 6pt;">
            <tr>


            </tr>
            <tr>
                <td style="font-size: 6pt;">
                </td>
                <td>

                </td>
            </tr>
        </table>




        <!--END -->



    </body>
@endforeach

</html>
