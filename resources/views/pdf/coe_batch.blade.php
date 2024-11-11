<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <title>COE</title>
    <style>
        @page {
            size: 8.5in 13in;
            margin: 0;
            margin-top: 5pt;
            opacity: 0.75;
            padding: 0 !important;
            font-size: 9pt;
            font-family: Arial, sans-serif
        }


        .data-textbox {
            position: absolute;
            font-weight: 900;
            line-height: 0.8;
            color: black;
            text-transform: uppercase;
           /* border: solid red 1px;*/
            text-align: center;
        }

        .data-textbox td {
            /*   border: solid red 1px;*/
        }

        input[type="checkbox"] {
            margin-bottom: -5;
            padding: 0;
            font-weight: normal;
        }

        #ce-0-qn {
            top: 83pt;
            left: 25pt;
            width: 95%;
        }

        #ce-0-belowQN
        {
            top: 96pt;
            left: 25pt;
            width: 80px;
        }

        #ce-0-bene {
            top: 112pt;
            left: 25pt;
            width: 93%;
        }

        #ce-0-address {
            top: 140pt;
            left: 25pt;
            width: 93%;
            font-size: 8pt;
        }

        #ce-0-self {
            top: 175pt;
            left: 25pt;
            width: 93%;
            font-size: 8pt;
        }

        #ce-0-records {
            position: absolute;
            font-weight: normal;
            text-align: left;
            top: 220pt;
            left: 20pt;
            width: 99%
        }

        #ce-0-asst {
            top: 310pt;
            left: 20pt;
            width: 95%
        }


        #ce-0-amount {
            top: 325pt;
            left: 20px;
            width: 95%
        }

        #ce-1-qn {
            top: 463pt;
            left: 25pt;
            width: 95%;
        }

        #ce-1-belowQN
        {
            top: 475pt;
            left: 25pt;
            width: 80px;
        }

        #ce-1-bene {
            top: 498pt;
            left: 25pt;
            width: 93%;
        }

        #ce-1-address {
            top: 521pt;
            left: 25pt;
            width: 93%;
            font-size: 8pt;
        }

        #ce-1-self {
            top: 556pt;
            left: 25pt;
            width: 93%;
            font-size: 8pt;
        }

        #ce-1-records {
            position: absolute;
            font-weight: normal;
            text-align: left;
            top: 601pt;
            left: 20pt;
            width: 99%
        }

        #ce-1-asst {
            top: 695pt;
            left: 20pt;
            width: 95%
        }

        #ce-1-amount {
            top: 716pt;
            left: 20px;
            width: 95%
        }

        #ce-0-sig {
            top: 355pt;
            left: 20pt;
            width: 95%;
            font-size: 8pt;
        }

        #ce-1-sig {
            top: 747pt;
            left: 20pt;
            width: 95%;
            font-size: 8pt;
        }
    </style>
</head>

@foreach ($aics_beneficiaries as $aics_beneficiary)
    @php
        $my_records = [];
        $my_records = json_decode($aics_beneficiary['records']);
        $pos_aics = strpos($aics_beneficiary['payroll_client']['payroll']['source_of_fund'], 'AICS');
  

    @endphp

    <body>

        @for ($i = 0; $i < 2; $i++)
            <div
                style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; text-align: center;z-index: -1000; ">
                <img src="{{ public_path('images/ce-akap-2024-b.jpg') }}" style="width: 95%;">
            </div>


            <table id="ce-{{ $i }}-qn" class="data-textbox">
                <tr>
                    <td style="width:15%"> {{ $aics_beneficiary['payroll_client']['sequence'] }}</td>
                    <td></td>
                    <td style="width:25%">
                        <!-- {{ date('m-d-Y', strtotime($aics_beneficiary['payroll_client']['created_at'])) }}</td> -->
                    </td>
                </tr>
            </table>

            <table  id="ce-{{ $i }}-belowQN"  class="data-textbox">
                <tr>
                    <td> @if ($pos_aics === false)
                         <!--AKAP-->
                        <input type="checkbox" name="" checked id="" style="margin-left:39px ">
                     
                        @else
                        <!--AICS-->
                        <input type="checkbox" name="" checked id=""  style="margin-left:-50px " >
                        @endif
                    </td>
                   <!-- <td> 
                       
                       if ($pos_aics === false)
                        <input type="checkbox" name="" checked id="" style="margin-left:30px ">
                        endif
                    </td>-->
                </tr>
            </table>

            <table id="ce-{{ $i }}-bene" class="data-textbox">
                <tr>
                    <td style="width:15%"> </td>
                    <td style="width:60%">
                        {{ $aics_beneficiary['first_name'] . ' ' . $aics_beneficiary['middle_name'] . ' ' . $aics_beneficiary['last_name'] . ' ' . $aics_beneficiary['ext_name'] }}

                    </td>
                    <td style="width:10%; text-align:left;">
                        <input type="checkbox" @if ($aics_beneficiary['gender'] == 'Lalake') checked="true" @endif>
                    </td>
                    <td style="width:10%; text-align:left;">
                        <input type="checkbox" @if ($aics_beneficiary['gender'] == 'Babae') checked="true" @endif>
                    </td>
                    <td style="width:10%">{{ $aics_beneficiary['age'] }}</td>
                </tr>
            </table>


            <table id="ce-{{ $i }}-address" class="data-textbox" style="">
                <tr>

                    <td style="width:15%"> </td>
                    <td style="width:85%">
                        @if ($aics_beneficiary['street_number'])
                            {{ $aics_beneficiary['street_number'] . ', ' }}
                        @endif
                        {{ 'BRGY ' . $aics_beneficiary['psgc']['brgy_name'] . ', ' . $aics_beneficiary['psgc']['city_name'] . ', ' . $aics_beneficiary['psgc']['province_name'] }}
                    </td>


                </tr>
            </table>



            <table id="ce-{{ $i }}-self" class="data-textbox">
                <tr>
                    <td style="width:50%">Self </td>
                    <td style="width:50%">
                    </td>

                </tr>
            </table>


            <table id="ce-{{ $i }}-records">
                <tr>
                    <td>
                        @foreach ($record_options as $index => $record_option)
                            <div style="width:24% ; display:inline-block;">
                                @if ($index != 12)
                                    @if ($record_option != '')
                                        <input type="checkbox" name="" id=""
                                            @if ($my_records && in_array($record_option, $my_records)) checked @endif>
                                    @endif
                                    {{ $record_option }}
                                @elseif(isset($aics_beneficiary['valid_id_presented']))
                                    <span
                                        style="text-decoration:underline;">{{ $aics_beneficiary['valid_id_presented'] }}</span>
                                @endif
                            </div>
                        @endforeach
                        <div style="width:20% ; display:inline-block; border-bottom:solid 1px;">
                            {{ $aics_beneficiary['records_others'] }}</div>
                    </td>
                </tr>
            </table>

            <table id="ce-{{ $i }}-asst" class="data-textbox" style="">
                <tr>
                    <td style="width:25%"></td>
                    <td style="width:20%; font-size:8pt;">
                        @if (isset($assistance_type))
                            {{ $assistance_type }}
                        @endif
                    </td>
                    <td style="width:5%; font-size:8pt;"></td>
                    <td style="width:50%; font-size:8pt;">
                        @if (isset($assistance_type_subcategory))
                            {{ $assistance_type_subcategory }}
                        @endif
                    </td>
                </tr>
            </table>


            <table id="ce-{{ $i }}-amount" class="data-textbox" style="">
                <tr>
                    <td style="width:10%"></td>
                    <td style="width:30%; font-size:8pt;">
                        {{ $amount_in_words }}
                    </td>
                    <td style="width:5%; font-size:8pt;"></td>
                    <td style="width:15%; font-size:8pt;"> {{ number_format($amount, 2) }}</td>
                    <td style="width:10%; font-size:8pt;"></td>
                    <td>
                        {{ $aics_beneficiary['payroll_client']['payroll']['source_of_fund'] }}

                    </td>
                </tr>
            </table>




            <table id="ce-{{ $i }}-sig" class="data-textbox" style="">
                <tr>
                    <td style="width:33%">
                        {{ $aics_beneficiary['first_name'] . ' ' . $aics_beneficiary['middle_name'] . ' ' . $aics_beneficiary['last_name'] . ' ' . $aics_beneficiary['ext_name'] }}

                    </td>
                    <td style="width:33%"></td>
                    <td style="width:33%">
                        {{ $approved_by }}
                    </td>
                </tr>
            </table>
        @endfor

        <table id="ce-rcpt-qn" class="data-textbox" style="top:788pt; left: 20pt; width:95%">
            <tr>
                <td style="width:15%; text-align:left;">QN: {{ $aics_beneficiary['payroll_client']['sequence'] }}</td>
                <td></td>
                <td style="width:25%">
                    <!-- {{ date('m-d-Y', strtotime($aics_beneficiary['payroll_client']['created_at'])) }}</td> -->
                </td>
            </tr>
        </table>


        <table id="ce-rcpt" class="data-textbox" style="top:800pt; left: 20pt; width:95%">
            <tr>
                <td style="width:10%"></td>
                <td style="width:50%; font-size:8pt;">
                    {{ $amount_in_words }} PESOS ONLY
                </td>
                <td style="width:5%; font-size:8pt;"></td>
                <td style="width:20%; font-size:8pt;">
                    {{ number_format($amount, 2) }}
                </td>
            </tr>
        </table>

        <table id="ce-sig2" class="data-textbox" style="top:860pt; left: 20pt; width:95%">
            <tr>
                <td style="width:33%">
                    {{ $aics_beneficiary['first_name'] . ' ' . $aics_beneficiary['middle_name'] . ' ' . $aics_beneficiary['last_name'] . ' ' . $aics_beneficiary['ext_name'] }}

                </td>
                <td style="width:33%">{{ $SDO }}</td>
                <td style="width:33%">
                    {{ $approved_by }}
                </td>
            </tr>
        </table>




    </body>
@endforeach

</html>
