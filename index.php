<?php
	session_start();
	include('db/database.php');
	$conn = new connection();
	if(isset($_POST['email']) && isset($_POST['password'])){
		$query = $conn->select("users","*","email='".$_POST['email']."' AND password='".md5($_POST['password'])."'");
		if($conn->num_rows($query)!=0){
			$record = $conn->fetch_assoc($query);
			$_SESSION['email'] = $record['Email'];
		}
	}
	else if(isset($_GET['logged_in']) && $_GET['logged_in']=='false'){
		unset($_SESSION['email']);
	}
?>

<!DOCTYPE html>
<html>
<title>SANDEP IoT Testbed</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/w3.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Header / Home-->
<header class="w3-display-container w3-wide bgimg" id="home">
  <div class="w3-display-middle w3-text-white w3-center">
    <h1 class="w3-jumbo">Welcome to <span class="highlight">SANDEP</class></h1>
    <h2>IoT Testbed</h2>
	<h1><span class="sensor_count highlight" data-count="1572">0</span><span> Sensors Online</span></h1>
  </div>
</header>

<video class="fullscreen" autoplay loop muted>
	<source src="videos/1.mp4" type="video/mp4">
</video>

<!-- Navbar (sticky bottom) -->
<div class="w3-bottom w3-hide-small">
  <ul class="w3-navbar w3-blue w3-center w3-padding-8 w3-opacity-min w3-hover-opacity-off">
	<li style="width:10%"><a href="#home" class="w3-margin-left w3-round w3-hover-indigo w3-blue" data-toggle="modal" data-target="#profile"><span style="font-size:15px;"><b><?php if(isset($_SESSION['email'])){?>Hello <span class="highlight">Sparky</span><?php } else { ?> <span class="highlight">Login</span> <?php } ?></b><span></a></li>
    <li style="width:15%"><a href="index.php" class="w3-round w3-hover-indigo w3-blue w3-grayscale-min disabled">Home</a></li>
    <li style="width:15%"><a href="client.php" class="w3-round w3-hover-indigo w3-blue">Virtual Client</a></li><!-- Virtual Client :- manage subscriptions/publish/realtime console -->
    <li style="width:15%"><a href="analysis.php" class="w3-round w3-hover-indigo w3-blue">Analysis Dashboard</a></li><!-- Analyzing sensor readings -->
	<li style="width:15%"><a href="#wedding" class="w3-round w3-hover-indigo w3-blue">View Node Statistics</a></li><!-- View and analyze the state of the nodes - both personal and global -->
	<li style="width:15%"><a href="#wedding" class="w3-round w3-hover-indigo w3-blue">Manage Subscriptions</a></li><!-- Defining the subscriptions for nodes - selecting publisher and subscriber (either a node or DB/API) -->
    <li style="width:15%"><a href="#rsvp" class="w3-margin-right w3-round w3-hover-indigo w3-blue">View Data Statistics</a></li><!-- View and analyze the data received from subscriptions -->
  </ul>
</div>

<body> 

<!-- Profile Modal -->
<div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<?php 
		if(isset($_SESSION['email'])){
			$record = $conn->select_record("users","*","Email='".$_SESSION['email']."'");
	?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><span class="highlight"><?php echo $record['Nickname']; ?></span>'s Profile</h4>
      </div>
      <div class="modal-body">
			<table>
				<tr>
					<td style="padding: 10px"><img src="images/profile_pic_<?php echo $record['Nickname']; ?>.jpg" width="300px;"></td>
					<td>
						<dl>
							<dt><b>Name</b></dt>
							<dd><?php echo $record['First_Name']." ".$record['Last_Name']; ?><hr/></dd>
							<dt><b>Email</b></dt>
							<dd><?php echo $record['Email']; ?><hr/></dd>
							<dt><b>Date of Birth</b></dt>
							<dd><?php echo $record['DOB']; ?><hr/></dd>
							<dt><b>Number of Nodes Online</b></dt>
							<dd>7 out of 9<hr/></dd>
						</dl>
					</td>
				</tr>
			</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-secondary">Edit Profile</button>
        <button type="button" class="btn btn-primary" onclick="window.location='index.php?logged_in=false';">Log Out</button>
      </div>
	<?php
		}
		else{
	?>
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel"><span class="highlight">Login</span> to your account</h4>
		  </div>
		  <div class="modal-body">
				<form class="form-horizontal" method="POST" action="index.php">
				  <div class="form-group">
					<label class="control-label col-sm-3" for="email">Email : </label>
					<div class="col-sm-9">
					  <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
					</div>
				  </div>
				  <div class="form-group">
					<label class="control-label col-sm-3" for="pwd">Password : </label>
					<div class="col-sm-9"> 
					  <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
					</div>
				  </div>
				  <div class="form-group modal-footer"> 
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" onclick="document.getElementById('id01').style.display='block'" class="btn btn-primary" data-dismiss="modal">Join</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Login</button>
					</div>
				  </div>
				</form>
		  </div>
	<?php
		}
	?>  
    </div>
  </div>
</div>

<!-- About / Jane And John -->
<div class="w3-container bg-image w3-padding-64 w3-indigo " id="us">
  <div class="w3-content">
    <h1 class="w3-center w3-text-white"><b>SANDEP IoT Testbed</b></h1>
    <img class="w3-round" src="images/3.jpg" style="width:100%;margin:32px 0">
    <p><i>lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint
      occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
      laboris nisi ut aliquip ex ea commodo consequat.</i>
    </p><br>
    <p class="w3-center"><a href="#wedding" class="w3-btn w3-round w3-padding-large w3-large w3-blue">More Details</a></p>
  </div>
</div>

<div class="w3-display-container bgimg2">
  <div class="w3-display-middle w3-text-white w3-center">
    <h1 class="w3-jumbo">Helps you stay connected</h1><br>
    <h2>where ever you go</h2>
  </div>
</div>

<div class="w3-container bg-image w3-padding-64 w3-purple w3-center" id="wedding">
  <div class="w3-content">
    <h1 class="w3-text-white"><b>Features</b></h1>
    <img class="w3-round-large w3-grayscale-min" src="images/4.jpg" style="width:100%;margin:64px 0">
    <div class="w3-row">
      <div class="w3-half">
        <h2>Node Network</h2>
        <p>Gateways</p>
        <p>Perceptor Nodes</p>
      </div>
      <div class="w3-half">
        <h2>API</h2>
        <p>Control Actuators</p>
        <p>Energize your programs</p>
      </div>
    </div>
  </div>
</div>

<div class="w3-container w3-padding-64 w3-purple w3-center w3-wide" id="rsvp">
  <h1>Connectivity made simpler</h1>
  <p class="w3-large">Start connecting right away</p>
  <p class="w3-xlarge">
    <button onclick="document.getElementById('id01').style.display='block'" class="w3-btn w3-round w3-blue w3-opacity w3-hover-opacity-off" style="padding:8px 60px" <?php if(isset($_SESSION['email'])){ echo "disabled";} ?>>Join & Start</button>
  </p>
</div>

<div id="id01" class="w3-modal">
  <div class="w3-modal-content w3-card-8 w3-animate-fade w3-padding-jumbo" style="max-width:600px">
    <div class="w3-container w3-white w3-center"  id="signup">
	  <div id="message"></div>
      <span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn w3-hover-text-grey w3-margin">x</span>
      <h1 class="w3-wide">Sign up and start connecting</h1>
      <p>We really hope we can address your requirement</p>
      <form>
        <label for="signup_nickname" style="float:left;">Nickname</label><input class="w3-input w3-border" type="text" placeholder="Enter Nickname" id="signup_nickname" name="signup_nickname">
		<label for="signup_fname" style="float:left;">First Name</label><input class="w3-input w3-border" type="text" placeholder="Enter First Name" id="signup_fname" name="signup_nickname">
		<label for="signup_lname" style="float:left;">Last Name</label><input class="w3-input w3-border" type="text" placeholder="Enter Last Name" id="signup_lname" name="signup_nickname">
		<label for="signup_email" style="float:left;">Email</label><input class="w3-input w3-border" type="email" placeholder="Enter Email Address" id="signup_email" name="signup_nickname">
		<label for="signup_dob" style="float:left;">Date of Birth</label><input class="w3-input w3-border" type="date" placeholder="Enter Date of Birth" id="signup_dob" name="signup_nickname">
		<label for="signup_pwd" style="float:left;">Password</label><input class="w3-input w3-border" type="password" placeholder="Enter New Password" id="signup_pwd" name="signup_nickname">
		<label for="signup_cpwd" style="float:left;">Confirm Password</label><input class="w3-input w3-border" type="password" placeholder="Enter Password Again" id="signup_cpwd" name="signup_nickname">
      </form>
      <p><i>Sincerely, SANDEP Development Team</i></p>
      <div class="w3-row">
        <div class="w3-half">
          <button id="join" type="button" class="w3-btn-block w3-green">Join Now</button>
        </div>
        <div class="w3-half">
          <button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-btn-block w3-red">Join Later</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="w3-center w3-black w3-padding-16">
  <p>Powered by <a href="http://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a></p>
</footer>
<div class="w3-hide-small" style="margin-bottom:32px"> </div>

</body>

<script>
$('.sensor_count').each(function() {
  var $this = $(this),
      countTo = $this.attr('data-count');
  
  $({ countNum: $this.text()}).animate({
    countNum: countTo
  },
  {
    duration: 15000,
    easing:'linear',
    step: function() {
      $this.text(Math.floor(this.countNum));
    },
    complete: function() {
      $this.text(this.countNum);
      //alert('finished');
    }

  });  
});

$(function() {
    function reposition() {
        var modal = $(this),
            dialog = modal.find('.modal-dialog');
        modal.css('display', 'block');
        
        // Dividing by two centers the modal exactly, but dividing by three 
        // or four works better for larger screens.
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height() - $('.w3-navbar').height()*2)));
		dialog.css("margin-left", 10);
    }
    // Reposition when a modal is shown
    $('.modal').on('show.bs.modal', reposition);
    // Reposition when the window is resized
    $(window).on('resize', function() {
        $('.modal:visible').each(reposition);
    });
	
	$('.disabled').click(function(e){
     e.preventDefault();
  })
});

$(document).ready(function(){
    $("#join").click(function(){
		if($("#signup_pwd").val() == $("#signup_cpwd").val() && $("#signup_pwd").val() != "" && $("#signup_email").val() != ""){
			$.post("ajax/add_user.php", {
				signup_nickname	: $("#signup_nickname").val(),
				signup_fname	: $("#signup_fname").val(),
				signup_lname	: $("#signup_lname").val(),
				signup_email	: $("#signup_email").val(),
				signup_dob		: $("#signup_dob").val(),
				signup_pwd	: $("#signup_pwd").val()
			}, function(data){
				$("#signup").html(data); 
			});
		}
        else{
			$("#message").html("<h3><span class='error-message'>Sorry, we encountered an error</span></h3><p>Make sure that you have filled everything correctly.</p>").fade();
		}
    });
});
</script>

</html>

