<?php
	if(isset($_POST['country']) && isset($_POST['city']) && isset($_POST['location'])){
		session_start();
		include('../db/database.php');
		$conn = new connection();
		$sql = "SELECT DISTINCT Building, Building_Code, Building_Name FROM nodes, building_list WHERE 
		Building=Building_Code AND ".($_POST['country']=='+'?"1":"Country='".$_POST['country']."'")." AND 
		".($_POST['city']=='+'?"1":"City='".$_POST['city']."'")." AND ".($_POST['location']=='+'?"1":"Location='".$_POST['location']."'")." AND
		Building_Code IN (SELECT Building FROM subscriptions WHERE Email='".$_SESSION['email']."' AND (Country='+' OR Country='".$_POST['country']."') AND
		(City='+' OR City='".$_POST['city']."') AND (Location='+' OR Location='".$_POST['location']."'));";
		$query = $conn->query($sql);
		echo "<option disabled selected>Select a building</option>";
		//echo "<option value='+'>Any</option>";
		while($record = $conn->fetch_assoc($query)){
			echo "<option value='".$record['Building_Code']."'>".$record['Building_Name']."</option>";
		}
	}
	else{
		echo "ERROR";
	}
?>