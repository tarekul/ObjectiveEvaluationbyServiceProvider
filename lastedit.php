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
	//Need to store the OID from the ObjEdit page.
	$empVar; //this will hold the OID.
		for($i=1;$i<101;$i++){
			if($_POST['editOID']=="edit".$i){
				 $empVar=$i; 

			}
		}	
	//Now the tables need to be created
	//table headers first	

	echo "<form action=ObjEdit.php method=post>";
	echo "<table>";
		echo "<tr>
				<td>Measuring Instrument</td>
				<td>Type</td>
				<td>PDF DOCUMENTS</td>
				<td>Below Expectations</td>
				<td>Exceed Expectations</td>
				
				<td><input type=submit name=submit value=submit></td>

				
			</tr>";	

	//column names are there.
	//Now I need to loop through the Grading table from database
	//and print the contents on the table.		
	$counter=1;		

	$searchFor2="SELECT * FROM Grading WHERE OID=$empVar";
	$search2=$connection->query($searchFor2);
	while($fetch2=mysqli_fetch_array($search2)){
		$counter2=1;
		$counter3=1;
		$MInstr=$fetch2['MeasuringInstrument'];
		$type=$fetch2['Type'];
		$pdf=$fetch2['PDFdocument'];
		$searchFor3="SELECT * FROM EvaluationCondition WHERE OID=$empVar";
		$search3=$connection->query($searchFor3);
		$fetch3=mysqli_fetch_array($search3);
		$Bexp=$fetch3['BelowCondition'];
		$Eexp=$fetch3['ExceedCondition'];
		$BexpMeet=$Bexp+1;
		$EexpMeet=$Eexp+1;
		echo "<tr>";
			//echo "<td>".$empVar."</td>";
				//textbox in each row with the name of task from
				//database preset on textbox.
				//user can edit the name.
				echo "<td>Name:<input type=text>".$MInstr."</td>"; 
				/*need radio button to choose between 'assignment'
				or 'exam'. Also need to check database and have atleast
				one radio buttoned checked.*/

					

				echo "<td>";
				if($type=='assignment'){	
					echo "<input type=radio name=check".$empVar.$counter." value=assignment checked>assignment";
					echo "<input type=radio name=check".$empVar.$counter." value=exam>exam";
				}
				else{
					echo "<input type=radio name=check".$empVar.$counter." value=assignment>assignment";
					echo "<input type=radio name=check".$empVar.$counter." value=exam checked>exam";
				}


				echo "</td>";
				$counter++;
				echo "<td><input type=file name=uploaded>".$pdf."</td>"; 
				echo "<td>";
					echo"<select id = myList".$empVar.$counter.">";
               		echo"<option value = 1 name=dropdwn".$empVar.$counter.$counter2.">10%</option>";
               		$counter2++;
               		echo"<option value = 2 name=dropdwn".$empVar.$counter.$counter2.">20%</option>";
               		$counter2++;
               		echo"<option value = 3 name=dropdwn".$empVar.$counter.$counter2.">30%</option>";
               		$counter2++;
               		echo"<option value = 4 name=dropdwn".$empVar.$counter.$counter2.">40%</option>";
             		echo "</select>";

				echo "</td>";
				echo "<td>";
					echo"<select id = myList2".$empVar.$counter.">";
               		echo"<option value = 1 name=dropdwn".$empVar.$counter.$counter3.">70%</option>";
               		$counter3++;
               		echo"<option value = 2 name=dropdwn".$empVar.$counter.$counter3.">80%</option>";
               		$counter3++;
               		echo"<option value = 3 name=dropdwn".$empVar.$counter.$counter3.">90%</option>";
               		$counter3++;
               		echo"<option value = 4 name=dropdwn".$empVar.$counter.$counter3.">95%</option>";

      				echo "</select>";

				echo "</td>";
				

				
		
		echo "</tr>";
	}
	
		

		
				

					
	












	echo "</table>";
	echo "</form>";





	?>
</body>