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
    ?>

    <div style="font-family:Calibri;">
        <img src="{{ asset('images/lbp.png') }}" style="position: absolute; top: -10; left: 40; width: 80px; height: 80px;">
        <center style="font-size: 14px; font-weight: bold;  margin-bottom: 3px;">DEPARTMENT OF SCIENCE AND TECHNOLOGY</center>
        <center style="font-size: 12px; color: green; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">PAYROLL REGISTER</center>
        <center style="font-size: 11px; margin-top: 2px; color: gray; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">LBP BRANCH : LBP KCC MALL DE ZAMBOANGA &nbsp;&nbsp;&nbsp; CODE : [ 999 ]</center>
        <center style="font-size: 11px; margin-top: 2px; color: gray; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">BATCH 00001</center>
    </div>

    <table style="font-size: 10px; font-family:Arial, Helvetica, sans-serif; width: 100%; margin-top: 25px;  margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 20%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">ACCOUNT NO.</td>
            <td style="width: 60%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">ACCOUNT NAME</td>
            <td style="width: 20%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">AMOUNT</td>
        </tr>
        @foreach($benefits['lists'] as $benefit)
        <tr style="text-align: center; font-size: 11px; text-transform: uppercase; font-weight: bold;">
            <td>{{$benefit['account_no']}}</td>
            <td>{{$benefit['name']}}</td>
            <td>{{ number_format($benefit['total'],2)}}</td>
        </tr>
        @endforeach
    </table>
    <center style="font-size: 11px; margin-top: 10px; color: gray; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">********** END OF REGISTER **********</center>
    
    <h5 style="font-size: 11px; margin-top: 30px; color: black; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">TOTAL NO. OF RECORDS: <span style="color: green;">{{ count($benefits['lists'])}}</span></h5>
    <h5 style="font-size: 11px; margin-top: -15px; color: black; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">TOTAL AMOUNT: <span style="color: green;">{{ number_format($benefits['total'],2) }}</span></h5>
    
    <div style="margin-top: 40px; font-family:Arial, Helvetica, sans-serif;">
        <div style="float: right; width: 240px; margin-right: 10px; text-align: center;">
            <span class="nor" style="font-size: 12px;">MARTIN A. WEE</span>
            <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
            <p style="margin-top: -1px; margin-bottom: -5px; font-size: 9px; font-weight: bold;">Noted By:</p>
        </div>

        <div style="float: left; width: 240px; margin-left: 10px; text-align: center;">
        <span class="nor" style="font-size: 12px;">{{ $user['profile']['firstname']}} {{ $user['profile']['middlename'][0]}}. {{ $user['profile']['lastname']}}</span>
        <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
        <p style="margin-top: -1px; margin-bottom: -5px; font-size: 9px; font-weight: bold;">Prepared By:</p>
    </div>

    <table style="font-size: 9px; font-family:Arial, Helvetica, sans-serif; width: 100%; border:none;  left: 0; bottom: 0; position:absolute; margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 15%; text-align: center; font-style: bold; border-left: none; border-right: none; padding: 5px;">Rec: {{ count($benefits['lists'])}}</td>
            <td style="width: 25%; text-align: center; font-style: bold; border-left: none; border-right: none; padding: 5px;">Total Amt: {{ number_format($benefits['total'],2) }}</td>
            <td style="width: 30%; text-align: center; font-style: bold; border-left: none; border-right: none; padding: 5px;">Acct Hsh: {{ number_format('45636482000',2) }}</td>
            <td style="width: 30%; text-align: center; font-style: bold; border-left: none; border-right: none; padding: 5px;">Hash Total: {{ number_format('45636482000',2) }}</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- <div style="font-family:Calibri;">
        <center style="font-size: 12px; color: green; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">DOST-SEI SCHOLARSHIP PAYMENTS FOR CREDIT TO THE </center>
        <center style="font-size: 11px; margin-top: 2px; color:green; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">SA-LBP ACCOUNTS OF SCHOLARS RA 7678</center>
        <center style="font-size: 11px; margin-top: 2px; color: gray; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">{{ date('F d, Y') }}</center>
    </div>

    <table style="font-size: 9px; font-family:Arial, Helvetica, sans-serif; width: 100%; margin-top: 25px;  margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 20%; text-align: center; font-style: bold; background-color: #e3e3e3; padding: 5px;">ACCOUNT NO.</td>
            <td style="width: 60%; text-align: center; font-style: bold; background-color: #e3e3e3; padding: 5px;">ACCOUNT NAME</td>
            <td style="width: 20%; text-align: center; font-style: bold; background-color: #e3e3e3; padding: 5px;">Total</td>
        </tr>
        @foreach($benefits['lists'] as $benefit)
        <tr style="text-align: center; font-size: 11px; text-transform: uppercase; font-weight: bold;">
            <td>{{$benefit['account_no']}}</td>
            <td>{{$benefit['name']}}</td>
            <td>{{ number_format($benefit['total'],2)}}</td>
        </tr>
        @endforeach
    </table> -->
    <div style="font-family:Calibri;">
        <img src="{{ asset('images/dost.png') }}" style="position: absolute; top: -10; left: 40; width: 70px; height: 70px;">
        <img src="{{ asset('images/sei.png') }}" style="position: absolute; top: -10; right: 40; width: 70px; height: 70px;">
        <center style="font-size: 12px; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">REPUBLIC OF THE PHILIPPINES</center>
        <center style="font-size: 13px; font-weight: bold;">DEPARTMENT OF SCIENCE AND TECHNOLOGY</center>
        <center style="font-size: 12px; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">REGIONAL OFFICE IX</center>


        <center style="font-size: 20px; letter-spacing: .5rem; margin-top: 60px; font-weight: bold;">CERTIFICATION</center>

        <p style="font-family:Arial, Helvetica, sans-serif; margin-top:50px; font-size: 12px; text-indent: 50px;">This is to authorized <b>Land bank of the Philippines</b> (LBP) to debit the amount of <b>Php {{number_format($benefits['total'],2)}}</b> from the <b>DOST-SEI S&T Scholarship Fund</b> with <b>Account No. 1952-1000-64</b> to the attached Payroll Register Batch 00001.</p>

        <div style="margin-top: 100px; font-family:Arial, Helvetica, sans-serif;">
            <div style="float: right; width: 240px; margin-right: 10px; text-align: center;">
                <span class="nor" style="font-size: 12px;">MARTIN A. WEE</span>
                <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
                <p style="margin-top: 0px; margin-bottom: -5px; font-size: 12px; font-weight: bold;">Regional Director</p>
            </div>

            <div style="float: left; width: 240px; margin-left: 10px; text-align: center;">
            <span class="nor" style="font-size: 12px;">{{ $user['profile']['firstname']}} {{ $user['profile']['middlename'][0]}}. {{ $user['profile']['lastname']}}</span>
            <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px; margin-top: 0px;" />
            <p style="margin-top: 0px; margin-bottom: -5px; font-size: 12px; font-weight: bold;">Cashier</p>
        </div>
    </div>
</body>

</html>
