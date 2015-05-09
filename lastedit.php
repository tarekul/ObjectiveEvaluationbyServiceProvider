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
	$connection = new mysqli("localhost","root","root","S1533608");
	//Now the tables need to be created
	//table headers first	

	echo "<form action=ObjEdit.php method=post enctype=multipart/form-data>";
	echo "<table>";
		//Need to store the OID from the ObjEdit page.
	$empVar; //this will hold the OID.
	$empVar2;//this will hold SID
		for($i=1;$i<31;$i++){
			for($p=1;$p<101;$p++){
				if($_POST['editOID']=="edit".$i."&".$p){
				 	$empVar2=$i;
				 	$empVar=$p; 
				 }

			}
		}
		echo "<tr>
				<td>Measuring Instrument</td>
				<td>Type</td>
				<td>PDF DOCUMENTS</td>
				<td>Below Expectations</td>
				<td>Exceed Expectations</td>
				
				<td><input type=submit name=submit value=submit></td>
				<td>Row#</td>
				
			</tr>";	

	//column names are there.
	//Now I need to loop through the Grading table from database
	//and print the contents on the table.		
	$counter=1;		
	
	$searchFor2="SELECT * FROM Grading WHERE OID=$empVar";
	$search2=$connection->query($searchFor2);
	while($fetch2=mysqli_fetch_array($search2)){
		
		
		$MInstr=$fetch2['MeasuringInstrument'];
		$type=$fetch2['Type'];
		
		$searchFor3="SELECT * FROM EvaluationCondition WHERE OID=$empVar";
		$search3=$connection->query($searchFor3);
		$fetch3=mysqli_fetch_array($search3);
		$Bexp=$fetch3['BelowCondition'];
		$Eexp=$fetch3['ExceedCondition'];
		$BexpMeet=$Bexp+1;
		$EexpMeet=$Eexp+1;

		$search4="SELECT * FROM file WHERE OID=$empVar AND RowNum=$counter";
		$searchfor4=$connection->query($search4);
		$fetch4=mysqli_fetch_array($searchfor4);
		$pdf=$fetch4['name']; 

		echo "<tr>";
			//echo "<td>".$empVar."</td>";
				//textbox in each row with the name of task from
				//database preset on textbox.
				//user can edit the name.
				echo "<td>Name:<input type=text name=write".$empVar."&".$counter." value=".$MInstr."></td>"; 
				/*need radio button to choose between 'assignment'
				or 'exam'. Also need to check database and have atleast
				one radio buttoned checked.*/

					

				echo "<td>";
				if($type=='assignment'){	
					echo "<input type=radio name=check".$empVar."&".$counter." value=assignment checked>assignment";
					echo "<input type=radio name=check".$empVar."&".$counter." value=exam>exam";
				}
				else{
					echo "<input type=radio name=check".$empVar."&".$counter." value=assignment>assignment";
					echo "<input type=radio name=check".$empVar."&".$counter." value=exam checked>exam";
				}


				echo "</td>";
				
				echo "<td><input type=file name=uploaded_file".$empVar."&".$counter."></td>"; 
				
 
    
        
 

				
				echo "<td>";
					echo"<select name = myList".$empVar.$counter.">";
               		echo"<option value = 10>10%</option>";
               		$counter2++;
               		echo"<option value = 20 >20%</option>";
               		$counter2++;
               		echo"<option value = 30 >30%</option>";
               		$counter2++;
               		echo"<option value = 40 >40%</option>";
             		echo "</select>";

				echo "</td>";
				echo "<td>";
					echo"<select name = myList2".$empVar.$counter.">";
               		echo"<option value = 70 >70%</option>";
               		$counter3++;
               		echo"<option value = 80 >80%</option>";
               		$counter3++;
               		echo"<option value = 90 >90%</option>";
               		$counter3++;
               		echo"<option value = 95 >95%</option>";

      				echo "</select>";

				echo "</td>";
				echo "<td>";
					echo "<input type=radio name=pick".$empVar2."&".$empVar."&".$counter." value=asis checked>as-is";
					
					echo "<input type=radio name=pick".$empVar2."&".$empVar."&".$counter." value=updatemode>update";
					
					echo "<input type=radio name=pick".$empVar2."&".$empVar."&".$counter." value=del>delete";
				

				echo "</td>";

				echo"<td>".$counter."</td>";
		
		//Table made for user to edit. Now need to go back to ObjEdit page so changes appear.
		echo "</tr>";
		$counter++;
	}
	
	echo "</table>";
	echo "</form>";

	?>
</body>
</html>