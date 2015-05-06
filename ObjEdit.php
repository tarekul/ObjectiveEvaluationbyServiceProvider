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
				<td><input type=submit name=editOID value=edit".$OIDholder."></td>

				
			</tr>";

	//made the table and labeled the column CHECK
	//Need to fetch the contents of table
	$searchFor2="SELECT * FROM Grading WHERE OID=$OIDholder";
	$search2=$connection->query($searchFor2);
	while($fetch2=mysqli_fetch_array($search2)){
		$MInstr=$fetch2['MeasuringInstrument'];
		$type=$fetch2['Type'];
		$pdf=$fetch2['PDFdocument'];
		$searchFor3="SELECT * FROM EvaluationCondition WHERE OID=$OIDholder";
		$search3=$connection->query($searchFor3);
		$fetch3=mysqli_fetch_array($search3);
		$Bexp=$fetch3['BelowCondition'];
		$Eexp=$fetch3['ExceedCondition'];
		$BexpMeet=$Bexp+1;
		$EexpMeet=$Eexp+1;
		echo "<tr>";
				echo "<td>Name: ".$MInstr."</td>"; 
				echo "<td>type: ".$type."</td>";
				echo "<td>".$pdf."</td>"; 
				echo "<td>~".$Bexp."%</td>";
				echo "<td>~".$Eexp."%</td>";
				echo "<td>".$BexpMeet."% ~ ".$EexpMeet."%</td>";

				
		
		
	}
	
	echo "</tr>";
	 
	
	echo "</table>";	
	echo "</form>";	
	?>
</body>
</html>
