<?php
	if(isset($_POST['signup_nickname']) && isset($_POST['signup_fname']) && isset($_POST['signup_lname']) && isset($_POST['signup_email']) && isset($_POST['signup_dob']) && isset($_POST['signup_pwd'])){
		include('../db/database.php');
		$conn = new connection();
			$res = $conn->insert("users","'".$_POST['signup_nickname']."', '".$_POST['signup_fname']."', '".$_POST['signup_lname']."', '".$_POST['signup_email']."', '".$_POST['signup_dob']."', '".md5($_POST['signup_pwd'])."'");
			echo "<h3 class='highlight'>Congratulations</h3>";
			echo "<p>Your account has been successfully created. Please using the Login button in the menu bar below to sign into your account and start connecting.</p>";
			echo "<button onclick=\"document.getElementById('id01').style.display='none'\" type='button' class='w3-btn-block w3-blue'>Close and Login</button>";
	}
	else{
		echo "ERROR";
	}
?>