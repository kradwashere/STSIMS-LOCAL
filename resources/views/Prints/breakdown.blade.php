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
        
        $privileges = json_encode($privileges); 
        $privileges = json_decode($privileges, true);  
    ?>

    <div style="font-family:Calibri;">
        <center style="font-size: 14px; font-weight: bold;  margin-bottom: 3px;">DEPARTMENT OF SCIENCE AND TECHNOLOGY</center>
        <center style="font-size: 12px; color: green; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">REGIONAL OFFICE NO. IX</center>
        <center style="font-size: 11px; margin-top: 2px; color: gray; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">PETTIT BARRACKS, ZAMBOANGA CITY</center>
        <br/>
        
        <center style="font-size: 14px; font-weight: bold;  margin-bottom: 3px;">BREAKDOWN OF FINANCIAL ASSISTANCE</center>
    </div>

    <table style="font-size: 10px; font-family:Arial, Helvetica, sans-serif; width: 100%; margin-top: 25px;  margin-left: auto; margin-right: auto;">
        <tr>
            <td style="text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">Academic Year</td>
            @foreach($privileges as $privilege)
            <td style="font-size: 10px; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">{{$privilege}}</td>
            @endforeach
            <td style="text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">Total</td>
        </tr>
        @foreach($lists as $benefit)
        <tr style="text-align: center; font-size: 11px; text-transform: uppercase; font-weight: bold;">
            <td>{{$benefit['academic_year']}} - {{$benefit['semester']['name']}}</td>
            @php $total = 0; @endphp
            @foreach($benefit['benefits'] as $privilege)
                @if($privilege['benefit']['name'] == 'Stipend')
                @php 
                    $total = $total + $privilege['amount'];
                @endphp
                <td>{{$total}}</td>
                @else
                <td>{{$privilege['amount']}}</td>
                @endif
            @endforeach
            <td>{{ number_format($benefit['benefits_sum_amount'],2)}}</td>
        </tr>
        @endforeach
    </table>

  
</body>

</html>
