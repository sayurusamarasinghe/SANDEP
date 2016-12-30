<?php
	if(isset($_POST['node']) && isset($_POST['building']) && isset($_POST['country']) && isset($_POST['city']) && isset($_POST['location'])){
		include('../db/database.php');
		$conn = new connection();
		$sql = "SELECT DISTINCT t1.*, t2.NodeID, t3.Sensor_Name, t2.Sensor_Code, t3.Sensor_Code FROM nodes t1, node_sensors t2, sensor_list t3 WHERE t1.NodeID=t2.NodeID AND t2.Sensor_Code=t3.Sensor_Code AND 
		".($_POST['node']=='+'?"1":"t1.Node_Number='".$_POST['node']."'")." AND ".($_POST['building']=='+'?"1":"t1.Building='".$_POST['building']."'")." AND 
		".($_POST['country']=='+'?"1":"t1.Country='".$_POST['country']."'")." AND ".($_POST['city']=='+'?"1":"t1.City='".$_POST['city']."'")." AND 
		".($_POST['location']=='+'?"1":"t1.Location='".$_POST['location']."'").";";
		$query = $conn->query($sql);
		echo "<option disabled selected>Select a sensor/actuator</option>";
		echo "<option value='+'>Any</option>";
		while($record = $conn->fetch_assoc($query)){
			echo "<option value='".$record['Sensor_Code']."'>".$record['Sensor_Name']."</option>";
		}
	}
	else{
		echo "ERROR";
	}
?>