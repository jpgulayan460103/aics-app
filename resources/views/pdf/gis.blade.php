<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <title>GIS</title>
    <style>
        @page {
            size: 8.27in 11.69in;
            /* size: 8.5in 13in; */
            font-size: 8pt;
            margin: 5%;
            opacity: 0.75;
            padding: 0 !important;
            /* background: url("{{ public_path('images/watermark.png') }}") no-repeat 0 0; */
        }

        .data-textbox {
            position: absolute;
            /* font-weight: bold;
             border: 1px solid black; */
            line-height: 0.8;
            color: blue;

        }

        #aics-type-name {
            left: 160pt;
            top: 138pt;
            width: 370pt;
        }


        #aics-beneficiary-last-name {
            left: 5pt;
            top: 185pt;
            width: 165pt;
            text-align: center;
        }

        #aics-beneficiary-first-name {
            left: 160pt;
            top: 185pt;
            width: 165pt;
            text-align: center;
        }

        #aics-beneficiary-middle-name {
            left: 315pt;
            top: 185pt;
            width: 165pt;
            text-align: center;
        }

        #aics-beneficiary-ext-name {
            left: 470pt;
            top: 185pt;
            width: 60pt;
            text-align: center;
        }


        #aics-beneficiary-street-number {
            left: 5pt;
            top: 213pt;
            width: 145pt;
            text-align: center;
        }

        #aics-beneficiary-psgc-brgy {
            left: 140pt;
            top: 213pt;
            width: 110pt;
            text-align: center;
        }

        #aics-beneficiary-psgc-city {
            left: 240pt;
            top: 213pt;
            width: 120pt;
            text-align: center;
        }

        #aics-beneficiary-psgc-province {
            left: 350pt;
            top: 213pt;
            width: 130pt;
            text-align: center;
        }

        #aics-beneficiary-psgc-region {
            left: 470pt;
            top: 213pt;
            width: 60pt;
            text-align: center;
        }


        #aics-beneficiary-mobile-number {
            left: 5pt;
            top: 243pt;
            width: 135pt;
            text-align: center;
        }

        #aics-beneficiary-birth-month {
            left: 140pt;
            top: 243pt;
            width: 25pt;
            text-align: center;
        }

        #aics-beneficiary-birth-day {
            left: 165pt;
            top: 243pt;
            width: 25pt;
            text-align: center;
        }

        #aics-beneficiary-birth-year {
            left: 190pt;
            top: 243pt;
            width: 40pt;
            text-align: center;
        }

        #aics-beneficiary-age {
            left: 230pt;
            top: 243pt;
            width: 40pt;
            text-align: center;
        }

        #aics-beneficiary-gender {
            left: 270pt;
            top: 243pt;
            width: 60pt;
            text-align: center;
        }

        #aics-beneficiary-occupation {
            left: 330pt;
            top: 243pt;
            width: 105pt;
            text-align: center;
        }

        #aics-beneficiary-monthly-salary {
            left: 430pt;
            top: 243pt;
            width: 100pt;
            text-align: center;
        }


        #aics-client-last-name {
            left: 5pt;
            top: 288pt;
            width: 165pt;
            text-align: center;
        }

        #aics-client-first-name {
            left: 160pt;
            top: 288pt;
            width: 165pt;
            text-align: center;
        }

        #aics-client-middle-name {
            left: 315pt;
            top: 288pt;
            width: 165pt;
            text-align: center;
        }

        #aics-client-ext-name {
            left: 470pt;
            top: 288pt;
            width: 60pt;
            text-align: center;
        }


        #aics-client-street-number {
            left: 5pt;
            top: 314pt;
            width: 145pt;
            text-align: center;
        }

        #aics-client-psgc-brgy {
            left: 140pt;
            top: 314pt;
            width: 110pt;
            text-align: center;
        }

        #aics-client-psgc-city {
            left: 240pt;
            top: 314pt;
            width: 120pt;
            text-align: center;
        }

        #aics-client-psgc-province {
            left: 350pt;
            top: 314pt;
            width: 130pt;
            text-align: center;
        }

        #aics-client-psgc-region {
            left: 470pt;
            top: 314pt;
            width: 60pt;
            text-align: center;
        }


        #aics-client-mobile-number {
            left: 5pt;
            top: 350pt;
            width: 130pt;
            text-align: center;
        }

        #aics-client-birth-month {
            left: 135pt;
            top: 350pt;
            width: 25pt;
            text-align: center;
        }

        #aics-client-birth-day {
            left: 160pt;
            top: 350pt;
            width: 25pt;
            text-align: center;
        }

        #aics-client-birth-year {
            left: 185pt;
            top: 350pt;
            width: 40pt;
            text-align: center;
        }

        #aics-client-rel-client {
            left: 225pt;
            top: 350pt;
            width: 180pt;
            text-align: center;
        }
    </style>
</head>

<body>
    
    <div style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; text-align: center;z-index: -1000; ">
        <img src="{{ public_path('images/gis-min-2.jpg') }}" style="width: 95%;">
    </div>


    <div id="aics-type-name" class="data-textbox">{{ strtoupper($aics_beneficiary['aics_type']['name']) }}</div>
    <div class="data-textbox"
        style=" font-weight:bold; text-align:center;top:50pt;right:20pt; width:10px;height:10px;padding:10px; border: dotted 1px; border-radius:50%; ">
        {{ $aics_beneficiary['payroll_client']['sequence'] }}</div>
    <div class="data-textbox" style="top:86pt;right:20pt;">
        {{ \Carbon\Carbon::parse($aics_beneficiary['payroll_client']['created_at'])->timeZone('Asia/Manila')->format('m-d-Y') }}</div>
    <div class="data-textbox" style="top:103pt;right:20pt;">
        {{ \Carbon\Carbon::parse($aics_beneficiary['payroll_client']['created_at'])->timeZone('Asia/Manila')->format('h:i a')}}</div>


    <div id="aics-beneficiary-last-name" class="data-textbox">{{ strtoupper($aics_beneficiary['last_name']) }}</div>
    <div id="aics-beneficiary-first-name" class="data-textbox">{{ strtoupper($aics_beneficiary['first_name']) }}</div>
    <div id="aics-beneficiary-middle-name" class="data-textbox">{{ strtoupper($aics_beneficiary['middle_name']) }}</div>
    <div id="aics-beneficiary-ext-name" class="data-textbox">{{ strtoupper($aics_beneficiary['ext_name']) }}</div>

    <div id="aics-beneficiary-street-number" class="data-textbox">{{ strtoupper($aics_beneficiary['street_number']) }}
    </div>
    <div id="aics-beneficiary-psgc-brgy" class="data-textbox">{{ strtoupper($aics_beneficiary['psgc']['brgy_name']) }}
    </div>
    <div id="aics-beneficiary-psgc-city" class="data-textbox">{{ strtoupper($aics_beneficiary['psgc']['city_name']) }}
    </div>
    <div id="aics-beneficiary-psgc-province" class="data-textbox">
        {{ strtoupper($aics_beneficiary['psgc']['province_name']) }}</div>
    <div id="aics-beneficiary-psgc-region" class="data-textbox">
        {{ strtoupper($aics_beneficiary['psgc']['region_name_short']) }}</div>

    <div id="aics-beneficiary-mobile-number" class="data-textbox">{{ strtoupper($aics_beneficiary['mobile_number']) }}
    </div>
    <div id="aics-beneficiary-birth-month" class="data-textbox">
        {{ date('d', strtotime($aics_beneficiary['birth_date'])) }}</div>
    <div id="aics-beneficiary-birth-day" class="data-textbox">
        {{ date('m', strtotime($aics_beneficiary['birth_date'])) }}</div>
    <div id="aics-beneficiary-birth-year" class="data-textbox">
        {{ date('Y', strtotime($aics_beneficiary['birth_date'])) }}</div>
    <div id="aics-beneficiary-age" class="data-textbox">{{ $aics_beneficiary['age'] }}</div>

    <div id="aics-beneficiary-gender" class="data-textbox">{{ strtoupper($aics_beneficiary['gender']) }}</div>
    <div id="aics-beneficiary-occupation" class="data-textbox">{{ strtoupper($aics_beneficiary['occupation']) }}</div>
    <div id="aics-beneficiary-monthly-salary" class="data-textbox">{{ $aics_beneficiary['monthly_salary'] }}</div>

    @if (isset($aics_beneficiary['category']))
        <div class="data-textbox" style=" top:420pt; left:20pt; text-align:left; height:80pt; ">
            {{ $aics_beneficiary['category']['category'] }}
        </div>
    @endif

    @if (isset($aics_beneficiary['subcategory']))
        <div class="data-textbox" style=" top:420pt; left:110pt;  text-align:left; height:80pt; ">
            {{ $aics_beneficiary['subcategory']['subcategory'] }}
            @if ($aics_beneficiary['subcategory_others'])
                <br> {{ $aics_beneficiary['subcategory_others'] }}
            @endif
        </div>
    @endif


    <div class="data-textbox" style=" top:415pt; left:219pt; width: 300pt; text-align:left; height:80pt; ">
        {{ $aics_beneficiary['assessment'] }}
    </div>
    <div id="payroll-amount" class="data-textbox" style=" right:150pt; bottom:100pt">
        {{ number_format($aics_beneficiary['payroll_client']['payroll']['amount'], 2) }}
    </div>


    <div id="payroll-amount" class="data-textbox"
        style=" right:13pt; bottom:100pt; width: 69px; font-size:5pt; text-align:center;">
        {{ $aics_beneficiary['payroll_client']['payroll']['source_of_fund'] }}
    </div>

    <div id="bene-full-name" class="data-textbox"
        style="width: 180pt;text-align:center; bottom:20pt; left:16pt; font-size:6pt; ">
        {{ strtoupper($aics_beneficiary['first_name']) }}
        {{ strtoupper($aics_beneficiary['middle_name']) }}
        {{ strtoupper($aics_beneficiary['last_name']) }}
        {{ strtoupper($aics_beneficiary['ext_name']) }}
    </div>

    <div id="bene-full-name" class="data-textbox"
        style="width: 125pt;text-align:center; bottom:30pt; right:143pt; font-size:6pt; ">
        {{ strtoupper($aics_beneficiary['interviewed_by']) }}

    </div>


    <!--
if($aics_client['rel_beneficiary'] != 'Myself')
<div id="aics-client-last-name" class="data-textbox">{ strtoupper($aics_client['last_name']) }}</div>
<div id="aics-client-first-name" class="data-textbox">{ strtoupper($aics_client['first_name']) }}</div>
<div id="aics-client-middle-name" class="data-textbox">{ strtoupper($aics_client['middle_name']) }}</div>
<div id="aics-client-ext-name" class="data-textbox">{ strtoupper($aics_client['ext_name']) }}</div>

<div id="aics-client-street-number" class="data-textbox">{ strtoupper($aics_client['street_number']) }}</div>
<div id="aics-client-psgc-brgy" class="data-textbox">{ strtoupper($aics_client['psgc']['brgy_name']) }}</div>
<div id="aics-client-psgc-city" class="data-textbox">{ strtoupper($aics_client['psgc']['city_name']) }}</div>
<div id="aics-client-psgc-province" class="data-textbox">{ strtoupper($aics_client['psgc']['province_name']) }}</div>
<div id="aics-client-psgc-region" class="data-textbox">{ strtoupper($aics_client['psgc']['region_name_short']) }}</div>

<div id="aics-client-mobile-number" class="data-textbox">{ strtoupper($aics_client['mobile_number']) }}</div>
<div id="aics-client-birth-month" class="data-textbox">{ date("d", strtotime($aics_client['birth_date'])) }}</div>
<div id="aics-client-birth-day" class="data-textbox">{ date("m", strtotime($aics_client['birth_date'])) }}</div>
<div id="aics-client-birth-year" class="data-textbox">{ date("Y", strtotime($aics_client['birth_date'])) }}</div>
<div id="aics-client-rel-client" class="data-textbox">{ strtoupper($aics_client['rel_beneficiary']) }}</div>
endif;-->
    <div>

    </div>
</body>

</html>
