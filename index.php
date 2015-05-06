
<html>
<head>
    <style>
        table,th,td{
            border: 1px solid black;
        }
    </style>
 </head> 
 <body>  
<?php

//Make connection to to database
//                        $server,$username,$password,$databaseName);
$connection = new mysqli("localhost","root","root","S1533608");


//make and print the service table
$sql="SELECT * FROM list_of_services";
$info=$connection->query($sql);

echo "<H1>Services Table</H1>";
echo"<form action=GoalEdit.php method=post>";
echo "<table>";

echo "<tr>
        <th>SID</th>
        <th>Service Statement</th>
        <th>Objectives</th>
        <td></td>
      </tr>";

      

//Filling in the goal table
while($row_fetch=mysqli_fetch_array($info)) {
    $sid=$row_fetch['SID'];
    $serviceName=$row_fetch['Service_Name'];
     
    
    echo "<tr>";
            echo "<td>s".$sid."</td>
            <td>".$serviceName."</td>";

            echo "<td>";
            echo "<table>";
                echo "<tr>
                    
                    <th>OID</th>
                    <th>Objective Statement</th>
                    <th>g1</th>
                    <th>g2</th>
                    <th>g3</th>
                    <th>g4</th>
                    <th>g5</th>
                    <th>g6</th>
                    <th>g7</th>
                    <th>g8</th>
                    <th>g9</th>
                    <th>g10</th>
                    
                </tr>";    

                $find="SELECT * FROM SID_OID WHERE SID=$sid";
                $look=$connection->query($find);
                while($row_get=mysqli_fetch_array($look)){
                    
                    $oid=$row_get['OID'];
                    $find2="SELECT Objective_Statement FROM list_of_objectives WHERE $oid=OID";
                    $look2=$connection->query($find2);
                    echo "<tr>";   
                     
                     
                    $row_get2=mysqli_fetch_array($look2);
                    $obj=$row_get2['Objective_Statement'];
                            
                    if(isset($_POST['selected'.$oid])){
                        
                        if($_POST['selected'.$oid]=='updatemode'){
                            //echo "hello";
                            echo $box=$_POST['text'.$oid];
                            echo $new = "UPDATE list_of_objectives SET Objective_Statement='".$box."' WHERE OID=".$oid;
                            $connection->query($new);
                            for($i=1;$i<10;$i++){
                                if($_POST['g'.$i]=='on'){
                                    //$vari=$_POST['g'.$i];
                                    echo $new2="INSERT INTO OID_GID (OID,GID) VALUES (".$oid.",".$i.")";
                                    $connection->query($new2);
                                }
                                
                                    
                                

                            }
            
                            $obj=$box;
                            echo "<td>o".$oid."</td>";
                            echo "<td>".$obj."</td>";
                        }
                        else if($_POST['selected'.$oid]=='asis'){
            
                            //echo "<tr>";
                            echo "<td>o".$oid."</td>";
                            echo"<td>".$obj."</td>";
                            //echo "</tr>";
                        }
                        else if($_POST['selected'.$oid]=='del'){
                            echo $sq3= "DELETE FROM SID_OID WHERE OID=".$oid." AND SID=$sid";
                            $connection->query($sq3);
                            

                        }


                    }
                    
                    
                    else{
                        //echo "nooooo ";
                        echo "<td><a href=ObjEdit.php?ObjID=$oid&SerID=$sid>o".$oid."</td>";
                        echo "<td>".$obj."</td>";
                    }

                    $find3="SELECT * FROM OID_GID WHERE $oid=OID";
                    $look3=$connection->query($find3);
            
                    $my_array=array();
                    while($row_get3=mysqli_fetch_array($look3)){
                        $found3=$row_get3['GID'];
                        if($found3==1){
                            array_push($my_array,$found3);
                        }
                        else if($found3==2){
                            array_push($my_array,$found3);
                        }
                        else if($found3==3){
                            array_push($my_array,$found3);
                    
                        }
                        else if($found3==4){
                            array_push($my_array,$found3);
                        }
                        else if($found3==5){
                            array_push($my_array,$found3);

                        }
                        else if($found3==6){
                            array_push($my_array,$found3);
                        }
                        else if($found3==7){
                            array_push($my_array,$found3);
                        }
                        else if($found3==8){
                            array_push($my_array,$found3);
                        }
                        else if($found3==9){
                            array_push($my_array,$found3);
                        }
                        else if($found3==10){
                            array_push($my_array,$found3);
                        }

                        
                        
                    }
                    
                    for($i=1;$i<10;$i++){
                        if(in_array($i, $my_array)){
                            echo "<td>";
                                echo "<p>&#10004;</p>";
                                echo "</td>";

                        }
                        else{
                            echo "<td></td>";
                        }
                    }

                    echo "</tr>";

                    
                    

                }
                echo "</tr>";

            echo "</table>";

                


                
             
            echo "</td>";
            echo "<td><input type=submit name=editIT value=edit".$sid."></td>";
          echo "</tr>";
}

//finished table

echo "</table>";
echo "</form>";




?>
</body>
</html>