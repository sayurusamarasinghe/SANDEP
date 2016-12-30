<?php
	if(isset($_POST['country'])){
		session_start();
		include('../db/database.php');
		$conn = new connection();
		$sql = "SELECT DISTINCT City, City_Code, City_Name FROM nodes, city_list WHERE City=City_Code AND ".($_POST['country']=='+'?"1":"Country='".$_POST['country']."'")." AND
		City_Code IN (SELECT City FROM subscriptions WHERE Email='".$_SESSION['email']."' AND (Country='+' OR Country='".$_POST['country']."'));";
		$query = $conn->query($sql);
		echo "<option disabled selected>Select a city</option>";
		//echo "<option value='+'>Any</option>";
		while($record = $conn->fetch_assoc($query)){
			echo "<option value='".$record['City_Code']."'>".$record['City_Name']."</option>";
		}
	}
	else{
		echo "ERROR";
	}
?>