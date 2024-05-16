<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <title>GIS</title>
    <style>
        body {
            color: #000000;

        }

        @page {
            size: 8in 11in;
            /* size: 8.5in 13in; */
            font-size: 8pt;
            margin: 0;
            opacity: 0.75;
            padding: 0 !important;

            /* background: url("{{ public_path('images/watermark.png') }}") no-repeat 0 0; */
        }

        .data-textbox {
            position: absolute;
            font-weight: 900;
            line-height: 0.8;
            color: black;
            text-transform: uppercase;
            /* border: solid red 1px;*/
        }


        table {
            table-layout: fixed;
        }

        td {
            word-wrap: break-word;
            /*  border: solid red 1px;*/
        }

        ul {
            line-height: 0px;
            margin: 0px;
            padding: 0px;
        }

        ul li {
            list-style-type: none;
            margin: 0px;
            padding: 0px;
        }

        ul li input {
            margin: 0px;
            padding: 0px;
        }

        .chk {

            display: inline-flex;
            vertical-align: middle;
        }

        input[type="checkbox"] {
            margin-bottom: -5;
            padding: 0;
            font-weight: normal;
        }

        .custom-checkbox {
            transform: scale(0.75);
        }
    </style>
</head>



@foreach ($aics_beneficiaries as $aics_beneficiary)

    <body>


        <div
            style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; text-align: center;z-index: -1000; ">
            <img src="{{ public_path('images/gis-akap-2024-b.jpg') }}" style="width: 95%;">
        </div>

        <!--<div class="data-textbox" style=" font-weight:bold; text-align:center;top:92pt;right:200pt; ">
          OFFSITE<input type="radio" checked name="" id="">
        </div>-->

        <!--<div class="data-textbox" style=" font-weight:bold; text-align:center;top:92pt;right:280pt; ">
            Referral <input type="checkbox" checked name="" id="">
         </div>-->

        <div class="data-textbox" style="text-align:center;top:82pt;left:70pt; ">
            {{ $aics_beneficiary['payroll_client']['sequence'] }}
        </div>
        <div class="data-textbox" style="top:80pt;right:75pt;">
            {{ \Carbon\Carbon::parse($aics_beneficiary['payroll_client']['created_at'])->timeZone('Asia/Manila')->format('m-d-Y') }}
        </div>

        <table class="data-textbox " style="top:175px; left:30px ; width:90%; text-align:center">
            <tr>
                <td style="width:30%"> {{ $aics_beneficiary['last_name'] }} </td>
                <td style="width:30%"> {{ $aics_beneficiary['first_name'] }} </td>
                <td style="width:20%"> {{ $aics_beneficiary['middle_name'] }} </td>
                <td style="width:10%"> {{ $aics_beneficiary['ext_name'] }} </td>
            </tr>
        </table>

        <table class="data-textbox " style="top:200px; left:30px ; width:88%; text-align:center">
            <tr>
                <td style="width:20%; font-size: 6pt;"> {{ $aics_beneficiary['street_number'] }} </td>
                <td style="width:20%"> {{ $aics_beneficiary['psgc']['brgy_name'] }} </td>
                <td style="width:20%"> {{ $aics_beneficiary['psgc']['city_name'] }} </td>
                <td style="width:20%"> {{ $aics_beneficiary['psgc']['province_name'] }} </td>
                <td style="width:10%"> {{ $aics_beneficiary['psgc']['region_name_short'] }} </td>
            </tr>
        </table>

        <table class="data-textbox " style="top:235px; left:30px ; width:88%; text-align:center">
            <tr>
                <td style="width:16%"> {{ $aics_beneficiary['mobile_number'] }} </td>
                <td style="width:16%"> {{ date('m-d-Y', strtotime($aics_beneficiary['birth_date'])) }} </td>
                <td style="width:5%">{{ $aics_beneficiary['age'] }}</td>
                <td style="width:14%"> {{ $aics_beneficiary['gender'] }} </td>
                <td style="width:14%">{{ $aics_beneficiary['civil_status'] }} </td>
                <td style="width:14%"> {{ $aics_beneficiary['occupation'] }} </td>
                <td style="width:14%"> {{ $aics_beneficiary['monthly_salary'] }} </td>
            </tr>

        </table>

        <table class="data-textbox " style="top:270px; left:30px ; width:88%; text-align:left">

            <tr>
                <td>Self </td>
            </tr>
        </table>

        <div class="data-textbox"
            style="width:130px; top:375pt; left:20pt;  text-align:left; height:80pt; font-size:7pt; font-weight:normal; text-transform:none;  ">
            @foreach ($categories as $category)
                <div style="display:inline-block; margin-top:-2pt; width:60px;">
                    <input type="checkbox" name="" id="" class="custom-checkbox"
                        @if (isset($aics_beneficiary['category'])) @if ($category == $aics_beneficiary['category']['category']) checked @endif @endif>
                    {{ $category }}
                </div>
            @endforeach
        </div>


        <div class="data-textbox"
            style=" width:300pt; top:380pt; left:120pt;  text-align:left; height:80pt;  font-size:7pt; font-weight:normal; text-transform:none;">

            <div style="display:inline-block;  width:75pt; ">
                @foreach ($subcategories['shortSubcategories'] as $subcategory)
                    <div style="display:inline-block; margin-top:-3pt; width:100%;">
                        <input type="checkbox" name="" id="" class="custom-checkbox"
                            @if (isset($aics_beneficiary['subcategory'])) @if ($subcategory == $aics_beneficiary['subcategory']['subcategory'])
                                checked @endif
                            @endif/>
                        {{ $subcategory }}
                    </div>
                @endforeach

            </div>
            <div style="display:inline-block; width:65.5%; ">

                @foreach ($subcategories['longSubcategories'] as $subcategory)
                    <div style="display:inline-block;margin-top:-3pt;  width:100%;">
                        <input type="checkbox" name="" id="" class="custom-checkbox"
                            @if (isset($aics_beneficiary['subcategory'])) @if ($subcategory == $aics_beneficiary['subcategory']['subcategory'])
                                checked @endif
                            @endif
                        />

                        {{ $subcategory }}
                        @if ($subcategory == 'Others')
                            @if ($aics_beneficiary['subcategory_others'])
                                : {{ $aics_beneficiary['subcategory_others'] }}
                            @endif
                        @endif


                    </div>
                @endforeach



            </div>
            <!--foreach ($subcategories as $index_sub => $subcategory)
                <div style="display:inline-block; margin-top:-3pt; width:75pt; ">
                    <input type="checkbox" name="" id="" class="custom-checkbox"
                        if (isset($aics_beneficiary['subcategory'])) if ($subcategory == $aics_beneficiary['subcategory']['subcategory'])
                     checked endif
                        endif>
                     $subcategory }}
                    if ($subcategory == 'Others')
                        if ($aics_beneficiary['subcategory_others'])
                            :  $aics_beneficiary['subcategory_others'] }}
                        endif
                    endif
                </div>
            endforeach-->
        </div>


        <div class="data-textbox"
            style="line-height:1em; top:440pt; left:30pt; width: 520pt; text-align:left; height:40pt; ">
            {{ $aics_beneficiary['assessment'] }}
        </div>

        <!-- <div class="data-textbox" style=" top:513pt; left:30; width: 280pt; text-align:left; height:80pt; ">
            <input type="checkbox" name="" id="" checked class="custom-checkbox">
            FINANCIAL ASSISTANCE CHECKBOX
        </div>-->


        <div class="data-textbox"
            style=" top:489pt; left:324pt; width: 280pt; text-align:left; height:80pt;  font-size:7pt; font-weight:normal; text-transform:none;">
            <input type="checkbox" name="" id="" checked class="custom-checkbox">
            <!-- PSYCHOSOCIAL SUPPORT CHECKBOX-->
        </div>

        <div class="data-textbox"
            style="  top:532pt; left:330pt; text-align:left;  font-size:7pt; font-weight:normal; text-transform:none;  ">
            <input type="checkbox" name="" id="" checked class="custom-checkbox">
            <!-- SOCIAL WORK COUNSELING CHECKBOX-->
        </div>


        @php
            $pos = strpos($assistance_type, 'Medical');
        @endphp
        @if ($pos === false)
        @else
            <div class="data-textbox" style="  top:505pt; left:25pt; text-align:left; font-size:7pt; ">
                <input type="checkbox" name="" id="" checked>
            </div>
        @endif



        @php
            $pos = strpos($assistance_type, 'Funeral');
        @endphp
        @if ($pos === false)
        @else
            <div class="data-textbox" style="  top:515pt; left:25pt; text-align:left; font-size:7pt; ">
                <input type="checkbox" name="" id="" checked>
            </div>
        @endif



        @php
            $pos = strpos($assistance_type, 'Transportation');
        @endphp
        @if ($pos === false)
        @else
            <div class="data-textbox" style="  top:525pt; left:25pt; text-align:left; font-size:7pt; ">
                <input type="checkbox" name="" id="" checked>
            </div>
        @endif


        @php
            $pos = strpos($assistance_type, 'Educational');
        @endphp
        @if ($pos === false)
        @else
            <div class="data-textbox"
                style="  top:534pt; left:25pt; text-align:left; font-size:6pt; font-weight:normal; text-transform:none; ">
                <input type="checkbox" name="" id="" checked>
            </div>
        @endif

        @php
            $pos = strpos($assistance_type, 'Food');
        @endphp
        @if ($pos === false)
        @else
            <div class="data-textbox" style="  top:500pt; left:95pt; text-align:left; font-size:6pt; ">
                <input type="checkbox" name="" id="" checked>
            </div>
        @endif


        <table class="data-textbox " style="top:755px; left:30px ; width:90%; text-align:center">
            <tr>
                <td style="width: 60%">
                    FOR
                    @php
                        $pos = strpos($assistance_type, 'Other');
                    @endphp
                    @if ($pos === false)
                    {{ $assistance_type_subcategory }}
                    @else
                    {{ $assistance_type }} for {{ $assistance_type_subcategory }}
                    @endif
                </td>
                <td style="width: 25%">
                    {{ number_format($aics_beneficiary['payroll_client']['payroll']['amount'], 2) }}</td>
                <td style="width: 15%"> {{ $aics_beneficiary['payroll_client']['payroll']['source_of_fund'] }}</td>
            </tr>
        </table>

        <table class="data-textbox " style="top:868px; left:30px ; width:92%; text-align:center">
            <tr>
                <td style="width:35%">
                    {{ strtoupper($aics_beneficiary['first_name']) }}
                    {{ strtoupper($aics_beneficiary['middle_name']) }}
                    {{ strtoupper($aics_beneficiary['last_name']) }}
                    {{ strtoupper($aics_beneficiary['ext_name']) }}
                </td>
                <td style="width: 12%"></td>
                <td style="width: 20%"></td>
                <td style="width: 20%"> {{ $approved_by }} </td>
            </tr>
        </table>




        <div>

        </div>


        <!-- <div style="page-break-after: always;"></div> -->
    </body>
@endforeach

</html>
