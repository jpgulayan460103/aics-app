<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    <title>COE</title>
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

        table, table td {border: solid 1px; text-align: center;}
         table td {max-height:60px;}
        
    </style>
</head>

<body>
    

    

<table cellpadding=0 cellspacing=0 >
   
        @foreach ($aics_beneficiaries as  $aics_beneficiary)

        @php
        $sulod =  "";
        $sulod =   $aics_beneficiary["id"] ."/";
        $sulod .=        $aics_beneficiary['payroll_client']['sequence'] ."/" ;
        $sulod .=        $aics_beneficiary['full_name'] ."/";

        $sulod .=       $aics_beneficiary['birth_date'] ."/";
        $sulod .=        $aics_beneficiary['payroll_client']["payroll"]["amount"] ."/";
    @endphp

        <tr>
            <td>
                {!! QrCode::size(60)->generate($sulod) !!}

            </td>
            <td>
                <img src='{{ asset('images/new_logo.png') }}' />    
 
            </td>
            <td>
             
                           
               <h2 style="padding-bottom:0px; margin-bottom:0px;">QN:{{ $aics_beneficiary['payroll_client']['sequence'] }} {{ $aics_beneficiary['full_name'] }} <BR/>
                
                 <small>   VALIDATED ON :  {{date('m-d-Y', strtotime($aics_beneficiary['payroll_client']['created_at'])) }}</small>
                </H2>
                <span>Present this QR code for verification. Please secure this QR code for the day of payout.<br> It is
                    only valid for one person. Please bring your valid ID.</span>
                </div>





            </td>
        </tr>
        @endforeach
</table>

</body>



</html>
