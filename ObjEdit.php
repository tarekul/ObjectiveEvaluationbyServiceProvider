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
	$server="localhost";
	$username="root";
	$password="root";
	$databaseName="S1533608";
	$connection=new mysqli($server,$username,$password,$databaseName);

	
	$SIDholder=0;
	$OIDholder=0;
	$rowSel1=0;
	$rowSel2=0;
	$rowSel3=0;
	$rowSel4=0;
	$go=0;
	for($empVar2=1;$empVar2<31;$empVar2++){
		for($empVar=1;$empVar<101;$empVar++){	
			for($counter=1;$counter<5;$counter++){
				//if(isset('pick'.$empVar2.'&'.$empVar.'&'.$counter)){
				if($_POST['pick'.$empVar2.'&'.$empVar.'&'.$counter]=="asis"){
					$go=1;
					$SIDholder=$empVar2;
					$OIDholder=$empVar;
					if($counter==1){
						$rowSel1=1;
						//echo $rowSel1;
					}
					else if($counter==2)
						$rowSel2=2;
					else if($counter==3)
						$rowSel3=3;
					else if($counter==4)
						$rowSel4=4;

				}
				//}
				if($_POST['pick'.$empVar2.'&'.$empVar.'&'.$counter]=="updatemode"){
					$go==1;
					$SIDholder=$empVar2;
					$OIDholder=$empVar;
					if($counter==1){
						$rowSel1=10;

					}
					else if($counter==2)
						$rowSel2=20;
					else if($counter==3)
						$rowSel3=30;
					else if($counter==4)
						$rowSel4=40;

				}

				if($_POST['pick'.$empVar2.'&'.$empVar.'&'.$counter]=="del"){
					$go==1;
					$SIDholder=$empVar2;
					$OIDholder=$empVar;
					if($counter==1){
						$rowSel1=100;

					}
					else if($counter==2)
						$rowSel2=200;
					else if($counter==3)
						$rowSel3=300;
					else if($counter==4)
						$rowSel4=400;
				}	

			}
		}
	}
	if($go==1){
	$searchFor="SELECT * FROM list_of_services WHERE SID=$SIDholder";
	$search=$connection->query($searchFor);
	$fetch=mysqli_fetch_array($search);
	$serviceName=$fetch['Service_Name'];
	echo "<h1>Objective ".$OIDholder." of [".$SIDholder.":".$serviceName."]<h1>";	
	
	echo "<form action=lastedit.php method=post>";
	echo "<table>";
		echo "<tr>
				<td>Measuring Instrument</td>
				<td>Type</td>
				<td>PDF DOCUMENTS</td>
				<td>Below Expectations</td>
				<td>Exceed Expectations</td>
				<td>Meet Expectations</td>
				<td><input type=submit name=editOID value=edit".$SIDholder."&".$OIDholder."></td>

				
			</tr>";	
		echo "<tr>";
			if($rowSel1==1){
				$searchFor2="SELECT * FROM Grading WHERE OID=$OIDholder and RowNum=$rowSel1";
				$search2=$connection->query($searchFor2);
				$sql = "SELECT name FROM file WHERE OID=$OIDholder and RowNum=$rowSel1";
				$result = $connection->query($sql);
				$sql2="SELECT * FROM EvaluationCondition WHERE OID=$OIDholder and RowNum=$rowSel1";
				$result2=$connection->query($sql2);
				$fetch2=mysqli_fetch_array($search2);  
				$row=mysqli_fetch_array($result);
				$row2=mysqli_fetch_array($result2);
				$MInstr=$fetch2['MeasuringInstrument'];
				$type=$fetch2['Type'];
				$pdf=$row['name'];
				$Below=$row2['BelowCondition'];
				$Exceed=$row2['ExceedCondition'];


				echo "<td>Name: ".$MInstr."</td>"; 
				echo "<td>type: ".$type."</td>";
				echo "<td>".$pdf."</td>";
				echo "<td>".$Below."</td>";
				echo "<td>".$Exceed."</td>";
				$Below++;
				$Exceed--;
				echo "<td>".$Below."% ~ ".$Exceed."%</td>";

			
			}
			if($rowSel1==10){
				$counter=$rowSel1=1;
			    $empVar=$OIDholder;
				$measureVar=$_POST['write'.$empVar.'&'.$counter];
				//echo $measureVar;
				$update="UPDATE Grading SET MeasuringInstrument='".$measureVar."' WHERE OID=$OIDholder and RowNum=$rowSel1";
				$connection->query($update);
				echo "<td>Name: ".$measureVar."</td>"; 
				$typeChange=$_POST['check'.$empVar.'&'.$counter];
				//echo $typeChange;
				$update2="UPDATE Grading SET Type='".$typeChange."' WHERE OID=$OIDholder and RowNum=$rowSel1";
				$connection->query($update2);
				echo "<td>type: ".$typeChange."</td>";
				
				if(isset($_FILES['uploaded_file'.$empVar.'&'.$counter])){
					$name = $connection->real_escape_string($_FILES['uploaded_file'.$empVar.'&'.$counter]['name']);
        			$mime = $connection->real_escape_string($_FILES['uploaded_file'.$empVar.'&'.$counter]['type']);
        			$data = $connection->real_escape_string(file_get_contents($_FILES  ['uploaded_file'.$empVar.'&'.$counter]['tmp_name']));
        			$size = intval($_FILES['uploaded_file'.$empVar.'&'.$counter]['size']);

        			$query="UPDATE file SET name='{$name}', mime='{$mime}', data='{$data}', size='{$size}' WHERE OID=$empVar AND RowNum=$rowSel1";
        			//echo $query;
        			$result = $connection->query($query);
 
        			// Check if it was successfull
        			if($result) {
            			echo 'Success! Your file was successfully added!';
        			}
        			else {
            			echo 'Error! Failed to insert the file';
					}
				}
				$sql = "SELECT name FROM file WHERE OID=$OIDholder AND RowNum=$rowSel1";
				$result = $connection->query($sql);
				$row=mysqli_fetch_array($result);
				$pdfName=$row['name'];
				echo "<td>".$pdfName."</td>";

				$Below=$_POST['myList'.$empVar.$counter];
				$update3="UPDATE EvaluationCondition SET BelowCondition=$Below WHERE OID=$OIDholder and RowNum=$rowSel1";
				$connection->query($update3);
				echo "<td>~".$Below."</td>";

				$Exceed=$_POST['myList2'.$empVar.$counter];
				$update4="UPDATE EvaluationCondition SET ExceedCondition=$Exceed WHERE OID=$OIDholder and RowNum=$rowSel1";
				$connection->query($update4);
				echo "<td>~".$Exceed."</td>";
				$Below++;
				$Exceed--;
				echo "<td>".$Below."~ ".$Exceed."</td>";

			}

			if($rowSel1==100){
				$rowSel1=1;
				$delete="DELETE FROM Grading WHERE OID=$OIDholder AND RowNum=$rowSel1";
				//echo $delete;
				$deleterow=$connection->query($delete);
				$delete2="DELETE FROM EvaluationCondition WHERE OID=$OIDholder AND RowNum=$rowSel1";
				$connection->query($delete2);
				$delete3="DELETE FROM file WHERE OID=$OIDholder AND RowNum=$rowSel1";
				$connection->query($delete3);
			}


		echo "</tr>";	

		echo "<tr>";
			if($rowSel2==2){
				$searchFor2="SELECT * FROM Grading WHERE OID=$OIDholder and RowNum=$rowSel2";
				$search2=$connection->query($searchFor2);
				$sql = "SELECT name FROM file WHERE OID=$OIDholder and RowNum=$rowSel2";
				$result = $connection->query($sql);
				$sql2="SELECT * FROM EvaluationCondition WHERE OID=$OIDholder and RowNum=$rowSel2";
				$result2=$connection->query($sql2);
				$fetch2=mysqli_fetch_array($search2);  
				$row=mysqli_fetch_array($result);
				$row2=mysqli_fetch_array($result2);
				$MInstr=$fetch2['MeasuringInstrument'];
				$type=$fetch2['Type'];
				$pdf=$row['name'];
				$Below=$row2['BelowCondition'];
				$Exceed=$row2['ExceedCondition'];


				echo "<td>Name: ".$MInstr."</td>"; 
				echo "<td>type: ".$type."</td>";
				echo "<td>".$pdf."</td>";
				echo "<td>".$Below."</td>";
				echo "<td>".$Exceed."</td>";
				$Below++;
				$Exceed--;
				echo "<td>".$Below."% ~ ".$Exceed."%</td>";

			
			}
			if($rowSel2==20){
				$counter=$rowSel2=2;
			    $empVar=$OIDholder;
				$measureVar=$_POST['write'.$empVar.'&'.$counter];
				//echo $measureVar;
				$update="UPDATE Grading SET MeasuringInstrument='".$measureVar."' WHERE OID=$OIDholder and RowNum=$rowSel2";
				$connection->query($update);
				echo "<td>Name: ".$measureVar."</td>"; 
				$typeChange=$_POST['check'.$empVar.'&'.$counter];
				//echo $typeChange;
				$update2="UPDATE Grading SET Type='".$typeChange."' WHERE OID=$OIDholder and RowNum=$rowSel2";
				$connection->query($update2);
				echo "<td>type: ".$typeChange."</td>";
				
				if(isset($_FILES['uploaded_file'.$empVar.'&'.$counter])){
					$name = $connection->real_escape_string($_FILES['uploaded_file'.$empVar.'&'.$counter]['name']);
        			$mime = $connection->real_escape_string($_FILES['uploaded_file'.$empVar.'&'.$counter]['type']);
        			$data = $connection->real_escape_string(file_get_contents($_FILES  ['uploaded_file'.$empVar.'&'.$counter]['tmp_name']));
        			$size = intval($_FILES['uploaded_file'.$empVar.'&'.$counter]['size']);

        			$query="UPDATE file SET name='{$name}', mime='{$mime}', data='{$data}', size='{$size}' WHERE OID=$empVar AND RowNum=$rowSel2";
        			//echo $query;
        			$result = $connection->query($query);
 
        			// Check if it was successfull
        			if($result) {
            			echo 'Success! Your file was successfully added!';
        			}
        			else {
            			echo 'Error! Failed to insert the file';
					}
				}
				$sql = "SELECT name FROM file WHERE OID=$OIDholder AND RowNum=$rowSel2";
				$result = $connection->query($sql);
				$row=mysqli_fetch_array($result);
				$pdfName=$row['name'];
				echo "<td>".$pdfName."</td>";

				$Below=$_POST['myList'.$empVar.$counter];
				$update3="UPDATE EvaluationCondition SET BelowCondition=$Below WHERE OID=$OIDholder and RowNum=$rowSel2";
				$connection->query($update3);
				echo "<td>~".$Below."</td>";

				$Exceed=$_POST['myList2'.$empVar.$counter];
				$update4="UPDATE EvaluationCondition SET ExceedCondition=$Exceed WHERE OID=$OIDholder and RowNum=$rowSel2";
				$connection->query($update4);
				echo "<td>~".$Exceed."</td>";
				$Below++;
				$Exceed--;
				echo "<td>".$Below."~ ".$Exceed."</td>";

			}

			if($rowSel2==200){
				$rowSel2=2;
				$delete="DELETE FROM Grading WHERE OID=$OIDholder AND RowNum=$rowSel2";
				//echo $delete;
				$deleterow=$connection->query($delete);
				$delete2="DELETE FROM EvaluationCondition WHERE OID=$OIDholder AND RowNum=$rowSel2";
				$connection->query($delete2);
				$delete3="DELETE FROM file WHERE OID=$OIDholder AND RowNum=$rowSel2";
				$connection->query($delete3);
			}

				

		echo "</tr>";

		echo "<tr>";
			if($rowSel3==3){
				$searchFor2="SELECT * FROM Grading WHERE OID=$OIDholder and RowNum=$rowSel3";
				$search2=$connection->query($searchFor2);
				$sql = "SELECT name FROM file WHERE OID=$OIDholder and RowNum=$rowSel3";
				$result = $connection->query($sql);
				$sql2="SELECT * FROM EvaluationCondition WHERE OID=$OIDholder and RowNum=$rowSel3";
				$result2=$connection->query($sql2);
				$fetch2=mysqli_fetch_array($search2);  
				$row=mysqli_fetch_array($result);
				$row2=mysqli_fetch_array($result2);
				$MInstr=$fetch2['MeasuringInstrument'];
				$type=$fetch2['Type'];
				$pdf=$row['name'];
				$Below=$row2['BelowCondition'];
				$Exceed=$row2['ExceedCondition'];


				echo "<td>Name: ".$MInstr."</td>"; 
				echo "<td>type: ".$type."</td>";
				echo "<td>".$pdf."</td>";
				echo "<td>".$Below."</td>";
				echo "<td>".$Exceed."</td>";
				$Below++;
				$Exceed--;
				echo "<td>".$Below."% ~ ".$Exceed."%</td>";

			
			}
			if($rowSel3==30){
				$counter=$rowSel3=3;
			    $empVar=$OIDholder;
				$measureVar=$_POST['write'.$empVar.'&'.$counter];
				//echo $measureVar;
				$update="UPDATE Grading SET MeasuringInstrument='".$measureVar."' WHERE OID=$OIDholder and RowNum=$rowSel3";
				$connection->query($update);
				echo "<td>Name: ".$measureVar."</td>"; 
				$typeChange=$_POST['check'.$empVar.'&'.$counter];
				//echo $typeChange;
				$update2="UPDATE Grading SET Type='".$typeChange."' WHERE OID=$OIDholder and RowNum=$rowSel3";
				$connection->query($update2);
				echo "<td>type: ".$typeChange."</td>";
				
				if(isset($_FILES['uploaded_file'.$empVar.'&'.$counter])){
					$name = $connection->real_escape_string($_FILES['uploaded_file'.$empVar.'&'.$counter]['name']);
        			$mime = $connection->real_escape_string($_FILES['uploaded_file'.$empVar.'&'.$counter]['type']);
        			$data = $connection->real_escape_string(file_get_contents($_FILES  ['uploaded_file'.$empVar.'&'.$counter]['tmp_name']));
        			$size = intval($_FILES['uploaded_file'.$empVar.'&'.$counter]['size']);

        			$query="UPDATE file SET name='{$name}', mime='{$mime}', data='{$data}', size='{$size}' WHERE OID=$empVar AND RowNum=$rowSel3";
        			//echo $query;
        			$result = $connection->query($query);
 
        			// Check if it was successfull
        			if($result) {
            			echo 'Success! Your file was successfully added!';
        			}
        			else {
            			echo 'Error! Failed to insert the file';
					}
				}
				$sql = "SELECT name FROM file WHERE OID=$OIDholder AND RowNum=$rowSel3";
				$result = $connection->query($sql);
				$row=mysqli_fetch_array($result);
				$pdfName=$row['name'];
				echo "<td>".$pdfName."</td>";

				$Below=$_POST['myList'.$empVar.$counter];
				$update3="UPDATE EvaluationCondition SET BelowCondition=$Below WHERE OID=$OIDholder and RowNum=$rowSel3";
				$connection->query($update3);
				echo "<td>~".$Below."</td>";

				$Exceed=$_POST['myList2'.$empVar.$counter];
				$update4="UPDATE EvaluationCondition SET ExceedCondition=$Exceed WHERE OID=$OIDholder and RowNum=$rowSel3";
				$connection->query($update4);
				echo "<td>~".$Exceed."</td>";
				$Below++;
				$Exceed--;
				echo "<td>".$Below."~ ".$Exceed."</td>";

			}

			if($rowSel3==300){
				$rowSel3=3;
				$delete="DELETE FROM Grading WHERE OID=$OIDholder AND RowNum=$rowSel3";
				//echo $delete;
				$deleterow=$connection->query($delete);
				$delete2="DELETE FROM EvaluationCondition WHERE OID=$OIDholder AND RowNum=$rowSel3";
				$connection->query($delete2);
				$delete3="DELETE FROM file WHERE OID=$OIDholder AND RowNum=$rowSel3";
				$connection->query($delete3);
			}

				

		echo "</tr>";

		echo "<tr>";
			if($rowSel4==4){
				$searchFor2="SELECT * FROM Grading WHERE OID=$OIDholder and RowNum=$rowSel4";
				$search2=$connection->query($searchFor2);
				$sql = "SELECT name FROM file WHERE OID=$OIDholder and RowNum=$rowSel4";
				$result = $connection->query($sql);
				$sql2="SELECT * FROM EvaluationCondition WHERE OID=$OIDholder and RowNum=$rowSel4";
				$result2=$connection->query($sql2);
				$fetch2=mysqli_fetch_array($search2);  
				$row=mysqli_fetch_array($result);
				$row2=mysqli_fetch_array($result2);
				$MInstr=$fetch2['MeasuringInstrument'];
				$type=$fetch2['Type'];
				$pdf=$row['name'];
				$Below=$row2['BelowCondition'];
				$Exceed=$row2['ExceedCondition'];


				echo "<td>Name: ".$MInstr."</td>"; 
				echo "<td>type: ".$type."</td>";
				echo "<td>".$pdf."</td>";
				echo "<td>".$Below."</td>";
				echo "<td>".$Exceed."</td>";
				$Below++;
				$Exceed--;
				echo "<td>".$Below."% ~ ".$Exceed."%</td>";

			
			}
			if($rowSel4==40){
				$counter=$rowSel4=4;
			    $empVar=$OIDholder;
				$measureVar=$_POST['write'.$empVar.'&'.$counter];
				//echo $measureVar;
				$update="UPDATE Grading SET MeasuringInstrument='".$measureVar."' WHERE OID=$OIDholder and RowNum=$rowSel4";
				$connection->query($update);
				echo "<td>Name: ".$measureVar."</td>"; 
				$typeChange=$_POST['check'.$empVar.'&'.$counter];
				//echo $typeChange;
				$update2="UPDATE Grading SET Type='".$typeChange."' WHERE OID=$OIDholder and RowNum=$rowSel4";
				$connection->query($update2);
				echo "<td>type: ".$typeChange."</td>";
				
				if(isset($_FILES['uploaded_file'.$empVar.'&'.$counter])){
					$name = $connection->real_escape_string($_FILES['uploaded_file'.$empVar.'&'.$counter]['name']);
        			$mime = $connection->real_escape_string($_FILES['uploaded_file'.$empVar.'&'.$counter]['type']);
        			$data = $connection->real_escape_string(file_get_contents($_FILES  ['uploaded_file'.$empVar.'&'.$counter]['tmp_name']));
        			$size = intval($_FILES['uploaded_file'.$empVar.'&'.$counter]['size']);

        			$query="UPDATE file SET name='{$name}', mime='{$mime}', data='{$data}', size='{$size}' WHERE OID=$empVar AND RowNum=$rowSel4";
        			//echo $query;
        			$result = $connection->query($query);
 
        			// Check if it was successfull
        			if($result) {
            			echo 'Success! Your file was successfully added!';
        			}
        			else {
            			echo 'Error! Failed to insert the file';
					}
				}
				$sql = "SELECT name FROM file WHERE OID=$OIDholder AND RowNum=$rowSel4";
				$result = $connection->query($sql);
				$row=mysqli_fetch_array($result);
				$pdfName=$row['name'];
				echo "<td>".$pdfName."</td>";

				$Below=$_POST['myList'.$empVar.$counter];
				$update3="UPDATE EvaluationCondition SET BelowCondition=$Below WHERE OID=$OIDholder and RowNum=$rowSel4";
				$connection->query($update3);
				echo "<td>~".$Below."</td>";

				$Exceed=$_POST['myList2'.$empVar.$counter];
				$update4="UPDATE EvaluationCondition SET ExceedCondition=$Exceed WHERE OID=$OIDholder and RowNum=$rowSel4";
				$connection->query($update4);
				echo "<td>~".$Exceed."</td>";
				$Below++;
				$Exceed--;
				echo "<td>".$Below."~ ".$Exceed."</td>";

			}

			if($rowSel4==400){
				$rowSel4=4;
				$delete="DELETE FROM Grading WHERE OID=$OIDholder AND RowNum=$rowSel4";
				//echo $delete;
				$deleterow=$connection->query($delete);
				$delete2="DELETE FROM EvaluationCondition WHERE OID=$OIDholder AND RowNum=$rowSel4";
				$connection->query($delete2);
				$delete3="DELETE FROM file WHERE OID=$OIDholder AND RowNum=$rowSel4";
				$connection->query($delete3);
			}

				

		echo "</tr>";

	echo "</table>";
	echo "</form>";	
	}
	
	
	

	
	//this code starting from here will execute only when the link is 
	//selected for the first time in index.php
	if($go==0){
	$SIDholder=$_GET['SerID']; //this is the SID of the selected link
	$OIDholder=$_GET['ObjID']; //this is the link that was selected.
	

	/*Each ObjId should have a table that has measuring, type, 
	pdf document, evaluation condition.

	Need heading for each ObjId link. Heading looks like this:
	Objective <OID> of [<SID:SERVICENAME>]

	Need to fetch the Service name from database using $SIDholder */

	$searchFor="SELECT * FROM list_of_services WHERE SID=$SIDholder";
	$search=$connection->query($searchFor);
	$fetch=mysqli_fetch_array($search);
	$serviceName=$fetch['Service_Name'];

	echo "<h1>Objective ".$OIDholder." of [".$SIDholder.":".$serviceName."]<h1>";

	//Finished the heading for the page CHECK
	//Now to make the table
	echo "<form action=lastedit.php method=post>";
	echo "<table>";
		echo "<tr>
				<td>Measuring Instrument</td>
				<td>Type</td>
				<td>PDF DOCUMENTS</td>
				<td>Below Expectations</td>
				<td>Exceed Expectations</td>
				<td>Meet Expectations</td>
				<td><input type=submit name=editOID value=edit".$SIDholder."&".$OIDholder."></td>

				
			</tr>";

	//made the table and labeled the column CHECK
	//Need to fetch the contents of table
	$searchFor2="SELECT * FROM Grading WHERE OID=$OIDholder";
	$search2=$connection->query($searchFor2);
	$sql = "SELECT * FROM file WHERE OID=$OIDholder";
	$result = $connection->query($sql);
	$sql2="SELECT * FROM EvaluationCondition WHERE OID=$OIDholder";
	$result2=$connection->query($sql2);
	while($fetch2=mysqli_fetch_array($search2) AND $row=mysqli_fetch_array($result) AND $row2=mysqli_fetch_array($result2)){
		$MInstr=$fetch2['MeasuringInstrument'];
		$type=$fetch2['Type'];
		$pdfName=$row['name'];
		$ID=$row['id'];
		$Below=$row2['BelowCondition'];
		$Exceed=$row2['ExceedCondition'];
		echo "<tr>";
				echo "<td>Name: ".$MInstr."</td>"; 
				echo "<td>type: ".$type."</td>";
				echo "<td><a href=get_file.php?id=".$ID.">".$pdfName."</a></td>";
				//echo "<td>".$pdfName."</td>";
				echo "<td>".$Below."</td>";
				echo "<td>".$Exceed."</td>";
				$Below++;
				$Exceed--;
				echo "<td>".$Below."~ ".$Exceed."</td>";
				
				
		echo "</tr>";
		
	}
	
	
		
		
	 
	
	echo "</table>";	
	echo "</form>";	
	}
	
	?>
</body>
</html>
