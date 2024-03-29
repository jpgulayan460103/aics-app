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
        th {
            font-size: 10pt;
            font-family: Arial, sans-serif
        }

        h2 {
            font-size: 12pt
        }

        h1>small,
        h2>small {
            font-size: 10pt;
            font-weight: normal;
        }

        .sig {
            width: 90%;
            margin: 0 auto;
           
            text-transform: uppercase;
            vertical-align: bottom;
        }

        .sig-underline { border-top: solid 1px #000;}

        .table {
            width: 100%;
        }

        .underline {
            text-decoration: underline;
            text-transform: uppercase;
        }

        .dotted-table
        {   padding-bottom: 10px;
            border-bottom: dashed 1px #000;
        }

        @page {
            size: 8.5in 13in;
            margin: 0.5in;
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
            font-size: 10pt;
            text-align: center;
            font-family: 'Times New Roman', Times, serif
        }

        .signatories .sig {
            font-size: 1vw;
            vertical-align: bottom
        }

        ul {
            list-style: none;
            padding: 5px; margin: 0;

        }

        ul li {
            display: inline;
        }

        p {
            margin-top: 5px;
            margin-bottom: 5px;
        }

       
    </style>
</head>

@foreach ($aics_beneficiaries as $aics_beneficiary)

    <body>
        @for ($i = 0; $i < 2; $i++)
        
            <table style="width:100%">
                <tr>
                    <td><img src='{{ public_path('images/DSWD-DVO-LOGO_01.png') }}' style="width: 130px;">
                    </td>
                    <td style="text-align: right;">
                        <img src='{{ public_path('images/DSWD-DVO-LOGO_02.png') }}' style="width: 100px;">
                        <div style="font-family: 'Times New Roman', Times, serif; font-size: 6pt;">DSWD-PMB-GF-013 | REV
                            01
                            | 30 SEPT 2022</div>
                    </td>
                </tr>
            </table>

            <div class="text-center">
                <h2 style="padding: 0px; margin:0px"> CERTIFICATE OF ELIGIBILITY <br>
                    <small>
                        (Financial Assistance)
                    </small>
                </h2>
            </div>
            <table class="table" style="table-layout:fixed; vertical-align:bottom;">
                <tr>
                    <th style="text-align: left;">QN:
                        <span style="border: solid 1px #000; width:40%; ">
                            {{ $aics_beneficiary['payroll_client']['sequence'] }}</span>
                    </th>
                    <th style="text-align:center">
                        <span style="border: solid 1px #000; font-family: DejaVu Sans, sans-serif;">✔</span>
                        Offsite

                    </th>
                    <th style="text-align:right"> Date:
                        <span style="border: solid 1px #000; width:40%; padding:2px">
                            {{ \Carbon\Carbon::parse($aics_beneficiary['payroll_client']['created_at'])->timeZone('Asia/Manila')->format('m-d-Y') }}
                        </span>
                    </th>
                </tr>
            </table>

            <p style="text-align: center; line-height:1.5em">

                This is to certify that



                <span class="underline">
                    {{ $aics_beneficiary['first_name'] . ' ' . $aics_beneficiary['middle_name'] . ' ' . $aics_beneficiary['last_name'] . ' ' . $aics_beneficiary['ext_name'] }}</span>,
                <span class="underline">{{ $aics_beneficiary['gender'] }}</span>, <span
                    class="underline">{{ $aics_beneficiary['age'] }}</span>
                year/s

                and presently residing at
                <span class="underline">
                    @if ($aics_beneficiary['street_number'])
                        {{ $aics_beneficiary['street_number'] . ', ' }}
                    @endif
                    {{ 'BRGY ' . $aics_beneficiary['psgc']['brgy_name'] . ', ' . $aics_beneficiary['psgc']['city_name'] . ', ' . $aics_beneficiary['psgc']['province_name'] }}
                </span>
                has been found eligible for assistance after assessment and validation conducted, for his/herself.

            </p>

            <table class="table table-bordered " cellpadding=0 cellspacing=0>
                <thead>
                    <tr>
                        <td class="text-center" style="font-size:8pt;">
                            RECORDS OF THE CASE SUCH AS THE FOLLOWING
                            ARE CONFIDENTIALLY FILED AT THE CRISIS INTERVENTION SECTION</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div>
                                <ul class="records">
                                    <li> <span style="font-family: DejaVu Sans, sans-serif;">✔</span> General Intake
                                        Sheet
                                    </li>
                                    <li> <span style="font-family: DejaVu Sans, sans-serif;">✔</span> Barangay
                                        Certificate
                                    </li>
                                    <li> <span style="font-family: DejaVu Sans, sans-serif;">✔</span> Valid ID
                                        Presented:
                                        @if ($aics_beneficiary['valid_id_presented'])
                                            <span class="sig"> {{ $aics_beneficiary['valid_id_presented'] }}</span>
                                        @else
                                            __________________________
                                        @endif
                                    </li>

                                </ul>
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>

            <p class="text-center" style="line-height:1.5em;">
                The client is hereby recommended to receive <span class="underline">
                    {{ $aics_beneficiary['aics_type']['name'] }} </span>
                in the amount of
                <span class="underline" style="text-transform:uppercase">{{ $amount_in_words }} PESOS
                    ONLY</span>,
                PHP <span class="underline">
                    {{ number_format($amount, 2) }} </span>
                CHARGABLE AGAINST: PSP<span
                    class="underline">{{ \Carbon\Carbon::parse($aics_beneficiary['payroll_client']['created_at'])->timeZone('Asia/Manila')->format('Y') }}

            </p>

            <table class="signatories table text-center " style="table-layout: fixed; margin-bottom:10px ">
                <tbody>
                    <tr>
                        <td style="text-align: left; width: 33%">Conforme:</td>
                        <td style="text-align: left; width: 33%">Prepared by:</td>
                        <td style="text-align: left; width: 33%">Approved by:</td>
                    </tr>
                    <tr>
                        <td style="height: 15px;"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="sig">
                                {{ $aics_beneficiary['first_name'] . ' ' . $aics_beneficiary['middle_name'] . ' ' . $aics_beneficiary['last_name'] . ' ' . $aics_beneficiary['ext_name'] }}
                            </div>
                        </td>
                        <td>
                            <div class="sig">

                            </div>
                        </td>
                        <td>
                            <div class="sig">
                                {{ $approved_by }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sig-underline"><b>Beneficiary/Representative</b><br><small>Signature Over Printed Name</small></td>
                        <td class="sig-underline"><b>Social Worker</b><br><small>Signature Over Printed Name</small></td>
                        <td class="sig-underline"><b>Approving Authority</b><br><small>Signature Over Printed Name</small></td>
                    </tr>
                </tbody>
            </table>
            <br>
        @endfor;
    </div>
<br>
        <div class="text-center" style="width: 100%; background: #787878; color: #fff; margin-top:-5px">
            <b> Acknowledgement Receipt</b>
        </div>
     
        <table class="table ">
            <tr>
                <td> Financial Assistance:
                    <span class="underline" style="text-transform:uppercase">
                        {{ $amount_in_words }} PESOS ONLY</span>,
                    PHP <span class="underline">
                        {{ number_format($amount, 2) }}
                    </span>
                </td>
                <td style="text-align:right; width:200px"> Date:
                    {{ \Carbon\Carbon::parse($aics_beneficiary['payroll_client']['created_at'])->timeZone('Asia/Manila')->format('m-d-Y') }}
                </td>
            </tr>
            <tr>
                <td> <ul>
                    <li> <span style="font-family: DejaVu Sans, sans-serif;">✔</span>
                        {{ $aics_beneficiary['aics_type']['name'] }}</li>
                </ul></td>
                <td></td>
            </tr>
        </table>

        <table class="table signatories text-center" style="table-layout: fixed">
            <tbody>
                <tr>
                    <td style="text-align: left; width: 33%">Accepted by:<br></td>
                    <td style="text-align: left; width: 33%">Paid by:<br></td>
                    <td style="text-align: left; width: 33%">Witnessed by:<br></td>
                </tr>
                <tr>
                    <td style="height: 5px;"></td>
                    <td></td>
                    <td></td>
                </tr>
               
                <tr>
                    <td>
                        <div class="sig" style="height: ">
                            {{ $aics_beneficiary['first_name'] . ' ' . $aics_beneficiary['middle_name'] . ' ' . $aics_beneficiary['last_name'] . ' ' . $aics_beneficiary['ext_name'] }}
                        </div>
                    </td>
                    <td>
                        <div class="sig">{{ $SDO }}</div>
                    </td>
                    <td>
                        <div class="sig">

                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sig-underline"><b>Beneficiary/Representative</b><br><small>Signature Over Printed Name</small></td>
                    <td class="sig-underline"><b>Special Disbursing Officer</b><br><small>Signature Over Printed Name</small></td>
                    <td class="sig-underline"><b>Social Worker</b><br><small>Signature Over Printed Name</small></td>
                </tr>
               
                
            </tbody>
        </table>

        <table class="table footer-ds" cellpadding=0 cellspacing=0>
            <tr>
                <td  style="text-align: center; border-bottom: 1px solid #000"> Page 1 of 1</td>
                <td style=" border-bottom: 1px solid #000"><small>*E.O 163 series
                    2022</small></td>
            </tr>
            <tr>
                <td>DSWD Field Office XI, Ramon Magsaysay Avenue Corner Damaso Suazo Street, Davao City <br>
                    Email: fo11@dswd.gov.ph Tel. No. (082) 227-1964 Website: http://www.dswd.gov.ph
                </td>
                <td>
                    <img src='{{ public_path('images/ISO-INSIGNIA.png') }}' style="width:75px">
                </td>
            </tr>
        </table>




        <!--END -->



    </body>
@endforeach

</html>
