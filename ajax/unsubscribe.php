<?php
	if(isset($_POST['sub_id'])){
		include('../db/database.php');
		$conn = new connection();
		
	}
	else{
		echo "ERROR";
	}
?>