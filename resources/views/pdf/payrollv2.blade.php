<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <title>Document</title>
    <style>
        body {
            font-size: 9pt;
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;

        }

        #payroll th,
        #payroll td {
            border: solid 1px #a0a0a0;
        }



        table tr.page {
            page-break-before: always
        }



        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;

            height: auto;
        }

        footer table td {
            vertical-align: top;
        }

        p {
            page-break-after: always;
        }

        p:last-child {
            page-break-after: never;
        }

        .sig {
            width: 80%;
            border-bottom: solid 1px #000;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <main>
        <div style="text-align: right; font-size:8pt">{{ $clients->currentPage() }}</div>

        <table id="payroll" cellpadding=8 cellspacing=0>
            <tr>
                <td style="text-align:center; border: 0px;" colspan="7">Republic of the Philippines <br />
                    DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT <br>
                    Field Office XI, Davao City
                    <h3> {{ $payroll->title }} </h3>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:left; border: 0px;">
                    City/Municipality: {{ $payroll->psgc->city_name }}
                    <br>
                    Barangay: {{ $payroll->psgc->brgy_name }}
                </td>
                <td colspan="3" style="text-align:right; border: 0px; text-transform:uppercase;">
                    {{ date_format(date_create($payroll->schedule), 'F Y') }}

                </td>
            </tr>
            <tr>
                <th>No. </th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Amount</th>
                <th>Signature</th>
                <th>Date Paid</th>
            </tr>
            <span style="display:none;">{{ $sum = 0 }}</span>
            @foreach ($clients as $key => $client)
                <tr>
                    <!-- PAGINATOR DEFAULT INDEXING-->
                    <!--  <td style="text-align:center; width:20px;">
                        { ($clients->currentPage() - 1) * $clients->links()->paginator->perPage() + $loop->iteration }}
                    </td>-->

                    <td style="text-align:center; width:20px;">
                        {{ $client->sequence }}
                    </td>

                    <td>{{ $client->last_name }} {{ $client->ext_name }}</td>
                    <td>{{ $client->first_name }}</td>
                    <td>{{ $client->middle_name }}</td>
                    <td style="width:100px; text-align:right;">{{ number_format($payroll->amount) }}</td>
                    <td style="width:200px"></td>
                    <td style="width:100px;"></td>
                    <span style="display:none;">{{ $sum += $payroll->amount }}</span>
                </tr>
            @endforeach
            <tr style="font-weight:bold;">
                <td colspan="4">Sub Total</td>
                <td style=" text-align:right;">{{ number_format($sum) }}</td>
                <td colspan="2"> </td>
            </tr>
            @if ($clients->onLastPage() && (isset($_GET['gt']) && $_GET['gt'] == 1))
                <tr style="font-weight:bold;">
                    <td colspan="4">Grand Total</td>
                    <td style=" text-align:right;">{{ number_format($grand_total) }}</td>
                    <td colspan="2"> </td>
                </tr>
            @endif

        </table>
        <div style="text-align: right; font-size:8pt">{{ $clients->currentPage() }}</div>

        @if (isset($_GET['gt']) && $_GET['gt'] == 1)
            <footer>
                <table style="table-layout:fixed; font-size:8pt;">
                    <tr>
                        <td>
                            <p>I hereby certify that each person whose names appear on this roll are entitled to each
                                assistance.</p>
                        </td>
                        <td>
                            <ol>
                                <li>Adequate available funds in the amount of Php</li>
                                <li>Expenditure property certified</li>
                                <li>Supported by documents appearing legal and proper</li>
                                <li>Account codes proper</li>
                            </ol>

                        </td>
                        <td style="text-align: center;">
                            <p>Approved by:</p>

                        </td>
                        <td>
                            <p>I certify on my official oath that I have this ____ day of ________, 20____ paid this to
                                each man
                                whose names appears
                                on the amount set opposite his/her name, he/she having presented himself/herself,
                                established her identity, and his/her signature/thumbmark on this space provided.
                            </p>

                        </td>

                    </tr>
                    <tr style="text-align: center;">
                        <td>
                            <div class="sig">{{ $payroll->certified_by1 }} </div>
                        </td>
                        <td>
                            <div class="sig">{{ $payroll->certified_by2 }}</div>
                        </td>
                        <td>
                            <div class="sig">{{ $payroll->approved_by }}</div>
                        </td>
                        <td>
                            <div class="sig">{{ $payroll->sdo }}</div>
                            <br> SDO
                        </td>
                    </tr>
                </table>
            </footer>
        @endif



    </main>




</body>

</html>
