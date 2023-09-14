<!doctype html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        html * {
            font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;
        }
        table,
        td,
        th {
            border: .5px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 5px;
            vertical-align: top;
        }

        td {
            padding: 5px;
            vertical-align: top;
            /* text-align: center; */
        }
        input[type=checkbox] {
            transform: scale(.7);
        }
         .a {
            width: 55px; 
            height: 55px;
         }
         label {
        display: block;
        padding-left: 15px;
        text-indent: -15px;
        }
        input {
        width: 13px;
        height: 13px;
        padding: 0;
        margin:0;
        vertical-align: bottom;
        position: relative;
        top: -5px;
        left: 7px;
        *overflow: hidden;
        
        }
        .spec_table td {
margin-left: -20px;
font-size: .9em;
line-height: 1.1em;
border-top: none !important;
}
.val {
    font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;
    text-align: center;
    text-transform: uppercase;
    /* font-weight: bold; */
}
.nor {
    font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;
    text-transform: uppercase;
    /* font-weight: bold; */
}
.tex {
    font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;
    text-transform: uppercase;
    font-size: 11px;
    margin-left: 20px;
    /* font-weight: bold; */
}
.page-break {
  page-break-after: always;
}

    </style>
</head>

<body>
    <?php 
        $benefits = json_encode($benefits); 
        $benefits = json_decode($benefits, true); 

        $user = json_encode($user); 
        $user = json_decode($user, true); 

        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $number = $digit->format($benefits['total']);
        
        $lists = json_encode($lists); 
        $lists = json_decode($lists, true); 
       
    ?>

    <!-- <div style="font-family:Calibri;">
        <center style="font-size: 12px; font-family:Arial, Helvetica, sans-serif; font-weight: bold;">DOST-SEI SCHOLARSHIP PAYMENTS FOR CREDIT TO THE</center>
        <center style="font-size: 12px; font-family:Arial, Helvetica, sans-serif; font-weight: bold;">SA-LBP ACCOUNTS OF SCHOLARS RA 7687</center>
    </div>

    <table style="font-size: 9px; font-family:Arial, Helvetica, sans-serif; width: 100%; margin-top: 25px;  margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 10%; text-align: center; font-family:Arial, Helvetica, sans-serif; font-style: bold; padding: 5px;">ACCOUNT NO.</td>
            <td style="width: 1%; text-align: center; font-family:Arial, Helvetica, sans-serif; font-style: bold; padding: 5px;">NO.</td>
            <td style="width: 15%; text-align: center; font-family:Arial, Helvetica, sans-serif; font-style: bold; padding: 5px;">NAME</td>
            @foreach($lists as $list)
            <td style="text-align: center; font-family:Arial, Helvetica, sans-serif; font-style: bold; padding: 5px;">{{$list}}</td>
            @endforeach
            <td style="width: 12%; text-align: center; font-family:Arial, Helvetica, sans-serif; font-style: bold; padding: 5px;">TOTAL</td>
        </tr>
        @foreach($benefits['lists'] as $index=>$benefit)
        <tr style="font-size: 9px;">
            <td style="font-family:Arial, Helvetica, sans-serif; text-align: center;">{{$benefit['account_no']}}</td>
            <td style="font-family:Arial, Helvetica, sans-serif; text-align: center;">{{($index++)+1}}</td>
            <td style="font-family:Arial, Helvetica, sans-serif; text-align: center;">{{ucwords(strtolower($benefit['name']))}}</td>
            @foreach($lists as $list)
            <td style="text-align: center; font-family:Arial, Helvetica, sans-serif;">{{$list}}</td>
            @endforeach
            <td style="font-family:Arial, Helvetica, sans-serif; text-align: center;">{{ number_format($benefit['total'],2)}}</td>
        </tr>
        @endforeach
    </table>

    <div style="margin-top: 60px; font-family:Arial, Helvetica, sans-serif;">
        <div style="float: right; width: 240px;">
            <p style="font-family:Arial, Helvetica, sans-serif; margin-top: -25px; margin-left: 0px; font-size: 10px; font-weight: bold;">Prepared By:</p>
            <span class="nor" style="font-size: 12px;"></span>
            <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
        </div>

        <div style="float: left; width: 240px;">
            <p style="font-family:Arial, Helvetica, sans-serif; margin-top: -25px; margin-left: 0px; font-size: 10px; font-weight: bold;">Certified Correct:</p>
            <span class="nor" style="font-size: 12px;"></span>
            <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
        </div>

        <div style="float: left; width: 240px; margin-left: -240px; margin-top: 100px;">
            <p style="font-family:Arial, Helvetica, sans-serif; margin-top: -25px; margin-left: 0px; font-size: 10px; font-weight: bold;">Approved By:</p>
            <span class="nor" style="font-size: 12px;"></span>
            <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
        </div>
    </div> -->

    <!-- <div class="page-break"></div>

    <div style="font-family:Calibri;">
        <span style="position: absolute; top: -10; left: 40; font-size: 11px;">{{date('d M Y',strtotime(now() . ' +1 day'))}}</span>
        <span style="position: absolute; top: -10; right: 40; font-size: 11px;">Page no. 1</span>
        <img src="{{ asset('images/lbp.png') }}" style="position: absolute; top: 0; left: 40; width: 60px; height: 60px;">
        <center style="font-size: 15px; font-weight: bold;  margin-bottom: 3px;">DEPARTMENT OF SCIENCE AND TECHNOLOGY</center>
        <center style="font-size: 14px; color: green; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">PAYROLL REGISTER</center>
        <center style="font-size: 12px; margin-top: 2px; color: gray; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">LBP BRANCH : LBP KCC MALL DE ZBGA &nbsp;&nbsp;&nbsp; CODE : [ 999 ]</center>
        <center style="font-size: 12px; margin-top: 2px; color: gray; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">BATCH 00035</center>
    </div>

    <table style="font-size: 11px; font-family:Arial, Helvetica, sans-serif; width: 100%; margin-top: 25px;  margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 20%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">ACCOUNT NO.</td>
            <td style="width: 60%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">ACCOUNT NAME</td>
            <td style="width: 20%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">AMOUNT</td>
        </tr>
        @foreach($benefits['lists'] as $benefit)
        <tr style="font-size: 11px; text-transform: uppercase; font-weight: bold; ">
            <td style="text-align: center;">{{$benefit['account_no']}}</td>
            <td>{{$benefit['name']}}</td>
            <td style="text-align: center;">{{ number_format($benefit['total'],2)}}</td>
        </tr>
        @endforeach
    </table>
    <center style="font-size: 11px; margin-top: 10px; color: gray; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">********** END OF REGISTER **********</center>
    
    <h5 style="font-size: 13px; margin-top: 30px; color: black; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">TOTAL NO. OF RECORDS: <span style="color: green;">{{ count($benefits['lists'])}}</span></h5>
    <h5 style="font-size: 13px; margin-top: -15px; color: black; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">TOTAL AMOUNT: <span style="color: green;">{{ number_format($benefits['total'],2) }}</span></h5>
    
    <div style="margin-top: 60px; font-family:Arial, Helvetica, sans-serif;">
        <div style="float: right; width: 240px;">
            <p style="margin-top: -25px; margin-left: 0px; font-size: 10px; font-weight: bold;">Checked By:</p>
            <span class="nor" style="font-size: 12px;"></span>
            <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
            <p style="margin-top: 5px; margin-bottom: -5px; font-size: 9px;">Approver Name</p>
            <p style="margin-top: 10px; margin-bottom: -5px; font-size: 9px;">Approver Position</p> 
        </div>

        <div style="float: left; width: 240px;">
            <p style="margin-top: -25px; margin-left: 0px; font-size: 10px; font-weight: bold;">Prepared By:</p>
            <span class="nor" style="font-size: 12px;"></span>
            <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
            <p style="margin-top: 5px; margin-bottom: -5px; font-size: 9px;">Verifier Name</p>
            <p style="margin-top: 10px; margin-bottom: -5px; font-size: 9px;">Verifier Position</p>
        </div>

        <div style="float: left; width: 240px; margin-left: -240px; margin-top: 100px;">
            <p style="margin-top: -25px; margin-left: 0px; font-size: 10px; font-weight: bold;">Noted By:</p>
            <span class="nor" style="font-size: 12px;"></span>
            <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
            <p style="margin-top: 5px; margin-bottom: -5px; font-size: 9px;">Certifier Name</p>
            <p style="margin-top: 10px; margin-bottom: -5px; font-size: 9px;">Certifier Position</p>
        </div>

        <table style="font-size: 10px; font-family:Arial, Helvetica, sans-serif; width: 100%; border:none;  left: 0; bottom: 0; position:absolute; margin-left: auto; margin-right: auto;">
            <tr>
                <td style="width: 15%; text-align: center; font-style: bold; border-left: none; border-right: none; padding: 5px;">Rec: {{ count($benefits['lists'])}}</td>
                <td style="width: 25%; text-align: center; font-style: bold; border-left: none; border-right: none; padding: 5px;">Total Amt: {{ number_format($benefits['total'],2) }}</td>
                <td style="width: 30%; text-align: center; font-style: bold; border-left: none; border-right: none; padding: 5px;">Acct Hsh: {{ number_format('159364820000',2) }}</td>
                <td style="width: 30%; text-align: center; font-style: bold; border-left: none; border-right: none; padding: 5px;">Hash Total: {{ number_format('10236482000',2) }}</td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div> -->

    
    <div style="font-family:Calibri;">
        <img src="{{ asset('images/dost.png') }}" style="position: absolute; top: -10; left: 40; width: 80px; height: 80px;">
        <!-- <img src="{{ asset('images/sei.png') }}" style="position: absolute; top: -10; right: 40; width: 70px; height: 70px;"> -->
        <div style="margin-left: 160px;">
            <span style="font-size: 14px; font-family:Arial, Helvetica, sans-serif;">Republic of the Philippines</span><br />
            <span style="font-size: 16px; font-family:Arial, Helvetica, sans-serif; font-weight: bold;">DEPARTMENT OF SCIENCE AND TECHNOLOGY</span><br />
            <span style="font-size: 14px; font-family:Arial, Helvetica, sans-serif;">Regional Office IX</span>
        </div>
        <span style="font-family:Arial, Helvetica, sans-serif; position: absolute; top: 100; right: 140; font-size: 16px;">{{str_replace('Sep', 'Sept', date('d M Y',strtotime(now().' +1 day')))}}</span>

        <center style="font-size: 24px; letter-spacing: .5rem; margin-top: 140px; font-family:Arial, Helvetica, sans-serif; font-weight: bold;">CERTIFICATION</center>
        <p style="font-family:Arial, Helvetica, sans-serif; margin-top:50px; margin-left: 80px; margin-right: 80px; font-size: 15px; text-indent: 50px; text-align: justify; text-justify: inter-word;">This is to authorized <span style="font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Land Bank of the Philippines</span> (LBP) to debit the amount of <span style="font-family:Arial, Helvetica, sans-serif; font-weight:bold;">{{strtoupper($number)}} PESOS (Php {{number_format($benefits['total'],2)}})</span> from the <span style="font-family:Arial, Helvetica, sans-serif; font-weight:bold;">DOST-SEI S&T Scholarship Fund</span> with <span style="font-family:Arial, Helvetica, sans-serif; font-weight:bold;">Account No. 1952-1000-64</span> to the attached Payroll Register Batch 00057.</p>

        <div style="margin-top: 100px; font-family:Arial, Helvetica, sans-serif;">
            <div style="float: right; width: 240px; margin-right: 80px;">
                <span class="nor" style="font-size: 16px; font-family:Arial, Helvetica, sans-serif; font-weight: bold;">JALI J. BADIOLA</span>
                <p style="margin-top: 0px; font-family:Arial, Helvetica, sans-serif; margin-bottom: -5px; font-size: 14px;">CASHIER III</p>
            </div>

            <div style="margin-top: 130px; float: right; width: 240px; margin-right: -240px;">
                <span class="nor" style="font-size: 16px; font-family:Arial, Helvetica, sans-serif; font-weight: bold;">MARTIN A. WEE</span>
                <p style="margin-top: 0px; font-family:Arial, Helvetica, sans-serif; margin-bottom: -5px; font-size: 14px;">REGIONAL DIRECTOR</p>
            </div>

            <!-- <span style="font-family:Arial, Helvetica, sans-serif; position: absolute; top: 100; right: 140; font-size: 16px;">{{date('d M Y')}}</span>
            <div style="float: left; width: 240px; margin-left: 10px; text-align: center;">
            <span class="nor" style="font-size: 13px; font-weight: bold;">JALI J. BADIOLA</span>
            <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
            <p style="margin-top: 0px; font-family:Arial, Helvetica, sans-serif; margin-bottom: -5px; font-size: 10px;">CASHIER III</p> -->
        </div>
    </div>
</body>

</html>
