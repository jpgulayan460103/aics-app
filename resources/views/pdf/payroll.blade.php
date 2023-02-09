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
</body>

</html>
