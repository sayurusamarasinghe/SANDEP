<?php
	if(isset($_POST['country']) && isset($_POST['city'])){
		include('../db/database.php');
		$conn = new connection();
		$sql = "SELECT DISTINCT Location, Location_Code, Location_Name FROM nodes, location_list WHERE 
		Location=Location_Code AND ".($_POST['city']=='+'?"1":"City='".$_POST['city']."'")." AND ".($_POST['country']=='+'?"1":"Country='".$_POST['country']."'").";";
		$query = $conn->query($sql);
		echo "<option disabled selected>Select a location</option>";
		echo "<option value='+'>Any</option>";
		while($record = $conn->fetch_assoc($query)){
			echo "<option value='".$record['Location_Code']."'>".$record['Location_Name']."</option>";
		}
	}
	else{
		echo "ERROR";
	}
?>