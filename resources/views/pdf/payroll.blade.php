<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <title>Document</title>
    <style>
        table {
            width: 100%;
        }
        body {font-size: 10pt;}
        #payroll th ,#payroll  td{border:solid 1px #dedede;}
    </style>
</head>

<body>
    <table>
        <tr>
            <td style="text-align:center;">Republic of the Philippines <br />
                DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT <br>
                Field Office XI, Davao City

            </td>

        </tr>
        <tr>
            <td style="text-align:center;">
                <h3> {{ $data->title }} </h3>

            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td>Municipality: {{ $data->muni_city }}</td>
            <td style="text-align: right;">{{ $data->schedule }}</td>
        </tr>
        <tr>
            <td>Barangay: {{ $data->brangay }}</td>
        </tr>
    </table>


    <table id="payroll" cellpadding=5 cellspacing=0>
        <tr>
            <th>No.</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Amount</th>
            <th>Signature</th>
            <th>Date Paid</th>
        </tr>
        @foreach ($data->clients as $item)
            <tr>
                <td>No.</td>
                <td> {{ $item->last_name }}</td>
                <td>{{ $item->first_name }}</td>
                <td>{{ $item->middle_name }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </table>




</body>

</html>
