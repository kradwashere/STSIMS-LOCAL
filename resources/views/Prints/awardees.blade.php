


<!doctype html>
<html lang="en">
    <head>  
        <style>
            html * {
            font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;
        }
            table, td, th {
                border: .5px solid black;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }    
            th {
                padding: 8px;
            }
            td {
                padding: 5px;
                text-align: center;
            }
            .b {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        
        <?php 
            $scholars = json_encode($scholars); 
            $scholars = json_decode($scholars, true);    

            $agency = json_encode($agency); 
            $agency = json_decode($agency, true); 
            
            $awards = json_encode($awards); 
            $awards = json_decode($awards, true); 
            
            // $group = json_encode($group); 
            // $group = json_decode($group, true); 
        ?>
      
      <!-- Arial, Helvetica, sans-serif -->
        <div style="font-family:Calibri">
            <img src="{{ asset('images/sei.png') }}" alt="tag" style="position: absolute; top: 3; left: 240; width: 35px; height: 35px;">
            <img src="{{ asset('images/dost.png') }}" alt="tag" style="position: absolute; top: 3; left: 510; width: 35px; height: 35px;">
            
            <center style="font-size: 14px;">SCIENCE EDUCATION INSTITUTE</center>
            <center style="font-size: 12px; font-weight: bold;">DEPARTMENT OF SCIENCE AND TECHNOLOGY</center>
            <center style="font-size: 11px;">DOST - {{ strtoupper($agency['region']['region'])}}</center>
            <br>
            <center style="font-size: 14px; font-weight: bold;">LIST OF DOST-SEI GRADUATES W/ HONORS</center>
          
        </div>

        <table style="width:100%; font-size: 12px; padding: 10px; margin-top: 10px; font-family:Arial, Helvetica, sans-serif">
            <thead>
            <!-- style="background-color: #a7dceb;" -->
                <tr>
                    <th rowspan="2" style="width: 13%;">Program</th>
                    <th rowspan="2" style="width: 13%;">No. of Graduates</th>
                    <th colspan="6" class="text-center" style="width: 74%;">Academic Award</th>
                </tr>
                <tr>
                    @foreach($awards as $award)
                        <th class="text-center">{{ $award['name']}}</th>
                    @endforeach
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($scholars as $scholar)
                <tr class="text-center">
                    <td class="b">{{ strtoupper($scholar['name']) }}</td>
                    <td>{{$scholar['count']}}</td>
                    @foreach($scholar['list'] as $count)
                        <td>{{ $count }}</td>
                    @endforeach
                    <td>{{$scholar['total']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div style="margin-top: 70px;">
            <div style="float: right; width: 270px; margin-right: 10px; text-align: center;">
                <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px;" />
                <p style="margin-top: -1px; margin-bottom: -5px;">Technical Coordinator</p>
                <span style="font-size: 11px; color: #434343;">( Noted By )</span> 
            </div>

            <div style="float: left; width: 270px; margin-left: 10px; text-align: center;">
            <hr style="height:1px;border:none;color:#333;background-color:#333; margin-bottom: 1px;" />
            <p style="margin-top: -1px; margin-bottom: -5px;">Scholarship Coordinator</p>
                <span style="font-size: 11px; color: #434343;">( Prepared By )</span> 
            </div>
        </div>
       
    </body>
</html>