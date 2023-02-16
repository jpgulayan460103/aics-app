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
                    <p>I certify on my official oath that I have this ____ day of ________, 20____ paid this to each man
                        whose names appears
                        on the amount set opposite his/her name, he/she having presented himself/herself,
                        established her identity, and his/her signature/thumbmark on this space provided.
                    </p>

                </td>

            </tr>
            <tr style="text-align: center;">
                <td> {{ $data->certified_by1 }} </td>
                <td> {{ $data->certified_by2 }} </td>
                <td> {{ $data->approved_by }} </td>
                <td> {{ $data->sdo }} <br> SDO </td>
            </tr>
        </table>
    </footer>



    
</body>

</html>
