<?php
	if(isset($_POST['building']) && isset($_POST['country']) && isset($_POST['city']) && isset($_POST['location'])){
		session_start();
		include('../db/database.php');
		$conn = new connection();
		$sql = "SELECT DISTINCT Node_Number FROM nodes WHERE 
		".($_POST['building']=='+'?"1":"Building='".$_POST['building']."'")." AND ".($_POST['country']=='+'?"1":"Country='".$_POST['country']."'")." AND 
		".($_POST['city']=='+'?"1":"City='".$_POST['city']."'")." AND ".($_POST['location']=='+'?"1":"Location='".$_POST['location']."'")." AND
		Node_Number IN (SELECT Node_Number FROM subscriptions WHERE Email='".$_SESSION['email']."' AND (Country='+' OR Country='".$_POST['country']."') AND
		(City='+' OR City='".$_POST['city']."') AND (Location='+' OR Location='".$_POST['location']."') AND (Building='+' OR Building='".$_POST['building']."'));";
		$query = $conn->query($sql);
		echo "<option disabled selected>Select a node</option>";
		//echo "<option value='+'>Any</option>";
		while($record = $conn->fetch_assoc($query)){
			echo "<option value='".$record['Node_Number']."'>Node #".$record['Node_Number']."</option>";
		}
	}
	else{
		echo "ERROR";
	}
?>