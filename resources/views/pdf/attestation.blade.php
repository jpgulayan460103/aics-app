<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <title>Voucher</title>
    <style>
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
            font-weight: bold;
        }

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 50%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 95%;
}

th {
  text-align: center;
  padding: 5px;
}

tr:nth-child(even) {
  /* background-color: #f2f2f2; */
  border: solid 1px black;
}

.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
}

    </style>
</head>
@foreach ($clients as $key => $client)
    <body>
        <div style="height: 10%">
            <img src="{{ asset('images/new_logo.png') }}" alt="image" style="float: left;">
            <span style="font-size: 12px; float: right; margin-top: 15px;">DSWD-PMB-GF-015 | REV 02 | 08 JAN 2024</span>
        </div>
        <div style="margin-top: 10px;font-size: 20px; text-align: right; margin-right:12%;"><b>ANNEX A</b></div>
            <div style="margin-top: 40px;"></div>
            <div style="text-align: center;">
                <b style="font-size: 20px">Certificate of Attestation</b>
            </div>
            <div style="margin-left: 6%; margin-right: 6%; font-size: 16px;">
                <div style="margin-top: 50px; text-align: justify; text-indent: 40px;">
                    This is to certify that <b>Mr./Mrs. {{ $client['first_name'] }}@if(!empty($client['middle_name'])) {{ $client['middle_name'][0] }}.@endif {{ $client['last_name'] }}@if(!empty($client['ext_name'])) {{ $client['ext_name'] }}@endif</b>, {{ $client['age'] }} years old
                    residing at {{ $client['street_number'] }}, {{ $client['psgc']['brgy_name'] }}, {{ $client['psgc']['city_name'] }}, {{ $client['psgc']['province_name'] }} is currently working or has employment
                    history as {{ $client['occupation'] }} in {{ $client['psgc']['city_name'] }} earning Php {{ number_format($client['monthly_salary'], 2) }} per month.
                </div>
                <div style="margin-top: 30px; text-align: justify; text-indent: 40px;">
                    Based on the assessment and validation conducted by the undersigned, the
                    abovementioned income remains insufficient to meet the family's daily sustenance for
                    {{ $client['aics_type']['name']}} and currently experiencing financial difficulties due to rising
                    inflation.
                </div>
                <div style="margin-top: 30px; text-align: justify; text-indent: 40px;">
                    Issued this _______ day of ________________ {{ date('Y') }} at DSWD Field Office XI.
                </div>
            </div>
            <div style="margin-right: 10%; font-size: 16px;">
                <div style="margin-top: 100px; text-align: justify; text-indent: 30px; text-align: right;">
                    ____________________________
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="width: 80%;">
                <div style="border-bottom: solid 1px black;"></div>
                <img src="{{ asset('images/ISO-INSIGNIA.png') }}" alt="" style="float: right;" width="90px" height="55px">
                <p style="font-size: 11px; text-align: center;">Page 1 of 1<br>
                DSWD Field Office XI, Ramon Magsaysay Avenue corner Damaso Suazo Street, Davao City, Philippines 8000<br>
                Website: http://fo11.dswd.gov.ph Tel Nos.: (082)_227 1964 / (082) 227 8746 / (082)_227 1435 Telefax: (082) 226 2857</p>
            </div>
        </div>
    </body>
    

@endforeach

</html>
