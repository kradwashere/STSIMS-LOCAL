


<!doctype html>
<html lang="en">
    <head>
        <style>
            table, td, th {
                border: .5px solid black;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }    
            th {
                padding: 5px;
            }
            td {
                padding: 2px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        
        <?php 
            $scholars = json_encode($scholars); 
            $scholars = json_decode($scholars, true);    

            $agency = json_encode($agency); 
            $agency = json_decode($agency, true);   

            // $group = json_encode($group); 
            // $group = json_decode($group, true);  
        ?>
      

        <div style="font-family:Calibri">
            <img src="{{ asset('images/sei.png') }}" alt="tag" style="position: absolute; top: 1; left: 200; width: 40px; height: 40px;">
            <img src="{{ asset('images/dost.png') }}" alt="tag" style="position: absolute; top: 1; left: 550; width: 40px; height: 40px;">
            
            <center style="font-size: 12px; font-weight: bold; color: #3066ad; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">SCIENCE EDUCATION INSTITUTE</center>
            <center style="font-size: 14px; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">DEPARTMENT OF SCIENCE AND TECHNOLOGY</center>
            <center style="color: gray; font-weight: bold; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace; font-size: 12px;">DOST - {{ strtoupper($agency['region']['region'])}}</center>
            <br>
            <center style="font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace; font-size: 15px; font-weight: bold;">LIST OF DOST-SEI SCHOLAR-GRADUATES</center>
            

        <table style="width:100%; font-size: 10px; padding: 20px; font-family:Arial, Helvetica, sans-serif">
            <!-- <thead>
                <tr style="background-color: #a7dceb;">
                    <th width="5%">No.</th>
                    <th width="7%">Awarded</th>
                    <th width="10%">Program</th>
                    <th width="30%">Name</th>
                    <th width="12%">School</th>
                    <th width="12%">Course</th>
                    <th width="12%">Academic Award</th>
                </tr>
            </thead>
            <tbody> -->
            <tr>
                <td style="width: 5%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">NO.</td>
                <td style="width: 5%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">AWARDED</td>
                <td style="width: 8%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">PROGRAM</td>
                <td style="width: 25%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">NAME</td>
                <td style="width: 30%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">SCHOOL</td>
                <td style="width: 25%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">COURSE</td>
                <td style="width: 10%; text-align: center; font-style: bold; background-color: black; color: white; padding: 5px;">AWARD</td>
            </tr>
            @foreach($scholars as $index=>$scholar)
                @php $name = strtoupper($scholar['profile']['firstname'].' '.$scholar['profile']['lastname']) @endphp
                <tr class="text-center">
                    <td>{{$index+1}}</td>
                    <td>{{$scholar['awarded_year']}}</td>
                    <td>{{ strtoupper($scholar['program']['name']) }}</td>
                    <td>{{ $name }}</td>
                    <td>{{strtoupper($scholar['education']['school']['name'])}}</td>
                    <td>{{$scholar['education']['course']['name']}}</td>
                    <td>{{($scholar['education']['award'] == 'n/a') ? $scholar['education']['award'] : $scholar['education']['award']['name']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

       
    </body>
</html>