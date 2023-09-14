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
        $lists = json_encode($lists); 
        $lists = json_decode($lists, true); 
        
    ?>

    <div style="font-family:Calibri;">
        <center style="font-size: 13px; font-weight: bold;  margin-bottom: 3px;">DETAILS OF FINANCIAL REPORT</center>
        <center style="font-size: 12px; font-weight: bold;  margin-bottom: 3px;">PERIOD FROM : {{ strtoupper($info) }}</center>
    </div>

    <table style="font-size: 9px; font-family:Arial, Helvetica, sans-serif; width: 100%; margin-top: 25px;  margin-left: auto; margin-right: auto;">
        <tr>
            <td style="width: 32%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">DETAILS</td>
            <td style="width: 17%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">UNEXPENDED BALANCE</td>
            <td style="width: 17%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">CURRENT RELEASE</td>
            <td style="width: 17%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">DISBURSEMENT</td>
            <td style="width: 17%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">BALANCE</td>
        </tr>
        @foreach($lists as $list)
        <tr style="font-size: 11px; text-transform: uppercase; font-weight: bold; ">
            <td style="text-align: center;">{{$list['name']}}</td>
        </tr>
        @endforeach
    </table>

    <!-- <div style="font-family:Calibri;">
        <center><span style="font-size: 11px; font-family:Arial, Helvetica, sans-serif; font-weight: bold;">DETAILS OF FINANCIAL REPORT</span></center>
        <center><span style="font-size: 11px; font-family:Arial, Helvetica, sans-serif; font-weight: bold;">PERIOD FROM : {{$info}}</span></center>
    </div> -->
   

</body>

</html>
