<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <title>Payroll</title>
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
            border: solid 1px #dedede;
        }



        table tr.page {
            page-break-before: always
        }



        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            background-color: lightblue;
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
    </style>
</head>

<body>

    <!--<footer>
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
                    <p>I certify on my official oath that I have this ____ day of ________, 20____ paid this to each man
                        whose names appears
                        on the amount set opposite his/her name, he/she having presented himself/herself,
                        established her identity, and his/her signature/thumbmark on this space provided.
                    </p>

                </td>

            </tr>
            <tr style="text-align: center;">
                <td> { $data->certified_by1 } </td>
                <td> { $data->certified_by2 } </td>
                <td> { $data->approved_by } </td>
                <td> { $data->sdo } <br> SDO </td>
            </tr>
        </table>
    </footer>-->



    <main>
      
      
              
        <table id="payroll" cellpadding=7 cellspacing=0>
            @foreach ($data->clients as $key => $item)
            <span style="display:none;">{{ $index = $key + 1 }}</span>
           
               
                @if ($key == 0 || $key % 10 == 0)
                    <tr @if ($key != 0 && $key % 10 == 0) class="page" @endif>
                        <td style="text-align:center; border: 0px;" colspan="7">Republic of the Philippines <br />
                            DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT <br>
                            Field Office XI, Davao City
                            <h3> {{ $data->title }} </h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:left; border: 0px;">
                            City/Municipality: {{ $data->psgc->city_name }}
                            <br>
                            Barangay: {{ $data->psgc->brgy_name }}
                        </td>
                        <td colspan="3" style="text-align:right; border: 0px; text-transform:uppercase;">
                            {{ date_format(date_create($data->schedule), 'F Y') }}

                        </td>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Amount</th>
                        <th>Signature</th>
                        <th>Date Paid</th>
                    </tr>
                @endif

                <tr style="text-align:center;">
                    <td style="text-align:center; width:20px;">{{ $index }} </td>
                    <td> {{ $item->last_name }} {{ $item->ext_name }}</td>
                    <td>{{ $item->first_name }}</td>
                    <td >{{ $item->middle_name }}</td>
                    <td style="width:100px">{{number_format($data->amount)}}</td>
                    <td style="width:200px"></td>
                    <td style="width:100px;"></td>
                </tr>
                @if($index %10 == 0)
                <tr> <td colspan="4" style="text-align:center; font-weight:bold;" >Sub Total</td>
                    <td ></td>
                    <td colspan="2"></td>
                </tr>
                @endif

               @if(sizeof($data->clients) == $index)
                <tr >
                    <td colspan="4" style="text-align:center; font-weight:bold;" >Grand Total</td>
                    
                    <td style="text-align:center; font-weight:bold;">{{number_format($grand_total)}}</td>
                    <td colspan="2"></td>
                </tr>
                <!--<tr style="text-align:center;font-size:6pt">
                    <td colspan="7">** NOTHING FOLLOWS **</td>
                </tr>-->
                @endif

            @endforeach
        </table>
    </main>
</body>

</html>
