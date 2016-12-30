<?php
	session_start();
	include('db/database.php');
	$conn = new connection();
	if(!isset($_SESSION['email'])){
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html>
<title>SANDEP Virtual Client</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/w3.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://cdn.jsdelivr.net/sockjs/1.0.3/sockjs.min.js"></script>
<script src="js/stomp.js"></script>

<!-- Navbar (sticky bottom) -->
<div class="w3-bottom w3-hide-small">
  <ul class="w3-navbar w3-blue w3-center w3-padding-8 w3-opacity-min w3-hover-opacity-off">
	<li style="width:10%"><a href="#home" class="w3-margin-left w3-round w3-hover-indigo w3-blue" data-toggle="modal" data-target="#profile"><span style="font-size:15px;"><b><?php if(isset($_SESSION['email'])){?>Hello <span class="highlight">Sparky</span><?php } else { ?> <span class="highlight">Login</span> <?php } ?></b><span></a></li>
    <li style="width:15%"><a href="index.php" class="w3-round w3-hover-indigo w3-blue">Home</a></li>
    <li style="width:15%"><a href="client.php" class="w3-round w3-hover-indigo w3-blue w3-grayscale-min disabled">Virtual Client</a></li><!-- Virtual Client :- manage subscriptions/publish/realtime console -->
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

<div class="w3-container w3-padding-64 w3-indigo bg-image2" id="us" style="min-height:86%">
  <div class="w3-content-full-width">
    <h1 class="w3-center w3-text-white"><b>SANDEP IoT Testbed - <span class="highlight">Virtual Client</span></b></h1>
	<br/>
    <table width="100%" class="w3-text-black">
		<tr>
			<td style="padding: 10px;" valign="top" width="35%">
			
				<div class="panel panel-primary" style="background-color: rgba(245, 245, 245, 0.3);">
					<div class="panel-heading">Subscribe/Publish</div>
					<div class="panel-body">
						
						<form class="form-horizontal" action="#" method="POST" id="main-form">
						
							<div class="form-group">
								<label class="control-label col-sm-3" for="country">Country :</label>
								<div class="col-sm-9">
									<select class="form-control" id="country">
										<option disabled selected>Select a country</option>
									<?php 
										$query = $conn->select("country_list","*","1");
										while($record = $conn->fetch_assoc($query)){
											echo "<option value='".$record['Country_Code']."'>".$record['Country_Name']."</option>";
										}
									?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="city">City :</label>
								<div class="col-sm-9">
									<select class="form-control" id="city">
										<option disabled selected>Select a city</option>
									</select>
								</div>  
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="location">Location :</label>
								<div class="col-sm-9">
									<select class="form-control" id="location">
										<option disabled selected>Select a location</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="building">Building :</label>
								<div class="col-sm-9">
									<select class="form-control" id="building">
										<option disabled selected>Select a building</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="node">Node :</label>
								<div class="col-sm-9">
									<select class="form-control" id="node">
										<option disabled selected>Select a node</option>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="sensor">Sensor/Actuator :</label>
								<div class="col-sm-9">
									<select class="form-control" id="sensor">
										<option disabled selected>Select a sensor/actuator</option>
									</select>
								</div>
							</div>
							
						  <div class="form-group"> 
							<div class="col-sm-offset-3 col-sm-9">
							  <button type="button" class="btn btn-primary" id="subscribe" disabled>Subscribe</button>
							</div>
						  </div>
						  
						  <hr/>
						  
						  <div class="form-group">
							<label class="control-label col-sm-3" for="publish_value">Value:</label>
							<div class="col-sm-9"> 
							  <input type="number" step="0.01" class="form-control" id="publish_value" placeholder="Enter value">
							</div>
						  </div>
						  
						  <div class="form-group"> 
							<div class="col-sm-offset-3 col-sm-9">
							  <button type="button" class="btn btn-primary" id="publish" disabled>Publish</button>
							</div>
						  </div>
						  
						</form>
						
					</div>
				</div>
				
				<div class="panel panel-primary" style="background-color: rgba(245, 245, 245, 0.3);">
					<div class="panel-heading">Console</div>
					<div class="panel-body">
						<div id="console"></div>
					</div>
				</div>
			
			</td>
			<td style="padding: 10px;" valign="top" width="50%">
			
				<div class="panel panel-primary" style="background-color: rgba(245, 245, 245, 0.3);">
					<div class="panel-heading">Subscriptions</div>
					<div class="panel-body" id="subscriptions">
						
						<?php
							
							$query = $conn->query("SELECT * FROM subscriptions t1, sensor_list t3, country_list t4, city_list t5, location_list t6, building_list t7
							WHERE t1.Email='".$_SESSION['email']."' AND t1.Country = t4.Country_Code AND t1.City = t5.City_Code AND 
							t1.Location = t6.Location_Code AND t1.Building = t7.Building_Code AND t1.Sensor_Code = t3.Sensor_Code;");
							
							$subscriptions[] = null;
							$subscriptions_1[] = null;
							$i = 0;
							while($record = $conn->fetch_assoc($query)){
								$subscriptions[$i] = str_replace('+','*',$record['Country'].".".$record['City'].".".$record['Location'].".".$record['Building'].".".$record['Node_Number'].".".$record['Sensor_Code']);
								$subscriptions_1[$i] = str_replace('+','A',$record['Country']."-".$record['City']."-".$record['Location']."-".$record['Building']."-".$record['Node_Number']."-".$record['Sensor_Code']);
								$i++;
						?>
						<table>
							<tr>
								<td style="padding: 10px;" valign="top" width="50%">
								
									<div class="panel panel-info">
									  <div class="panel-heading">
										<h4 class="panel-title">
										  <a data-toggle="collapse" href="#<?php echo $subscriptions_1[$i-1]; ?>"><?php echo $record['Country_Name']."/".$record['City_Name']."/".$record['Location_Name']."/".$record['Building_Name']."/".($record['Node_Number']=='+'?"Any Node":"Node ".$record['Node_Number'])."/".$record['Sensor_Name'] ?></a>
										</h4>
									  </div>
									  <div id="<?php echo $subscriptions_1[$i-1]; ?>" class="panel-collapse collapse">
										<div class="panel-body">Reading : 29.35</div>
										<div class="panel-footer"><div class="last_update">Last Updated : 26-11-2016 04:46 pm </div><button class="btn btn-default" >Unsubscribe</button></div>
									  </div>
									</div>
									
								</td>
								<td style="padding: 10px;" valign="top">
									<?php
										if($record = $conn->fetch_assoc($query)){
											$subscriptions[$i] = str_replace('+','*',$record['Country'].".".$record['City'].".".$record['Location'].".".$record['Building'].".".$record['Node_Number'].".".$record['Sensor_Code']);
											$subscriptions_1[$i] = str_replace('+','A',$record['Country']."-".$record['City']."-".$record['Location']."-".$record['Building']."-".$record['Node_Number']."-".$record['Sensor_Code']);
											$i++;
									?>
									<div class="panel panel-info">
									  <div class="panel-heading">
										<h4 class="panel-title">
										  <a data-toggle="collapse" href="#<?php echo $subscriptions_1[$i-1]; ?>"><?php echo $record['Country_Name']."/".$record['City_Name']."/".$record['Location_Name']."/".$record['Building_Name']."/".($record['Node_Number']=='+'?"Any Node":"Node ".$record['Node_Number'])."/".$record['Sensor_Name'] ?></a>
										</h4>
									  </div>
									  <div id="<?php echo $subscriptions_1[$i-1]; ?>" class="panel-collapse collapse">
										<div class="panel-body">Reading : 29.35</div>
										<div class="panel-footer"><div class="last_update">Last Updated : 26-11-2016 04:46 pm </div><button class="btn btn-default" >Unsubscribe</button></div>
									  </div>
									</div>
									<?php
										}
									?>
								</td>
							</tr>
						</table>
						
						<?php
							}
						?> 
						
					</div>
				</div>
			</td>
		</tr>
	</table>
    <p><i>lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint
      occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
      laboris nisi ut aliquip ex ea commodo consequat.</i>
    </p><br>
    <p class="w3-center"><a href="#wedding" class="w3-btn w3-round w3-padding-large w3-large w3-blue">More Details</a></p>
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
});

$(document).ready(function(){
    $("#country").change(function(){
        $.post("ajax/city_list.php", {country: $("#country").val()}, function(data){
			$("#city").html(data); 
		});
		$("#subscribe").prop('disabled', true);
		$("#publish").prop('disabled', true);
    });
	
	$("#city").change(function(){
        $.post("ajax/location_list.php", {country: $("#country").val(), city: $("#city").val()}, function(data){
			$("#location").html(data); 
		});
		$("#subscribe").prop('disabled', true);
		$("#publish").prop('disabled', true);
    });
	
	$("#location").change(function(){
        $.post("ajax/building_list.php", {country: $("#country").val(), city: $("#city").val(), location: $("#location").val()}, function(data){
			$("#building").html(data); 
		});
		$("#subscribe").prop('disabled', true);
		$("#publish").prop('disabled', true);
    });
	
	$("#building").change(function(){
        $.post("ajax/node_list.php", {country: $("#country").val(), city: $("#city").val(), location: $("#location").val(), building: $("#building").val()}, function(data){
			$("#node").html(data); 
		});
		$("#subscribe").prop('disabled', true);
		$("#publish").prop('disabled', true);
    });
	
	$("#node").change(function(){
        $.post("ajax/sensor_list.php", {country: $("#country").val(), city: $("#city").val(), location: $("#location").val(), building: $("#building").val(), node: $("#node").val()}, function(data){
			$("#sensor").html(data);
		});
		$("#subscribe").prop('disabled', true);
		$("#publish").prop('disabled', true);
    });
	
	$('.disabled').click(function(e){
		e.preventDefault();
	});
	
	$("#sensor").change(function(){
		$("#subscribe").prop('disabled', false);
		$("#publish").prop('disabled', false);
	});
	
	$("#subscribe").click(function(){
		$.post("ajax/subscribe.php", {country: $("#country").val(), city: $("#city").val(), location: $("#location").val(), building: $("#building").val(), node: $("#node").val(), sensor: $("#sensor").val()}, function(data){
			$("#subscriptions").html(data);
		});
		$("#console").html($("#console").html()+"New subscription added : "+(new Date($.now()))+"\n");
	});
	
	// WebSocket and STOMP
	var has_had_focus = false;
    var pipe = function(el_name, send) {
        var div  = $('#console');
        var inp  = $('#publish_value');
        var pub = $('#publish');

        var print = function(m, p) {
            p = (p === undefined) ? '' : JSON.stringify(p);
            div.append($("<code>").text(m + ' ' + p));
            div.scrollTop(div.scrollTop() + 10000);
        };

        if (send) {
            pub.click(function() {
                send(inp.val());
                inp.val('');
                return false;
            });
        }
        return print;
    };

    var client = Stomp.client('ws://35.160.37.101:15674/ws');
    
    client.debug = pipe('#console');

    var print_first = pipe('#first', function(data) {
		var str_temp = $('#country').val()+"."+$('#city').val()+"."+$('#location').val()+"."+$('#building').val()+"."+$('#node').val()+"."+$('#sensor').val();
		var str = str_temp.replace(/\+/g, "*");
        client.send('/topic/'+str, {"content-type":"text/plain"}, data);
    });
    var on_connect = function(x) {
		<?php
			for($i=$i-1;$i>=0;$i--){
		?>
		id = client.subscribe("/topic/<?php echo $subscriptions[$i]; ?>", function(d) {
               //print_first(d.body);
			   //alert(d.headers['destination']);
			   $('#<?php echo $subscriptions_1[$i]; ?>').find('.panel-body').html('Reading : '+d.body);
			   $('#<?php echo $subscriptions_1[$i]; ?>').find('.panel-footer').find('.last_update').html('Last Updated : '+Date()+'<hr/>');
        });	
		<?php
			}
		?>
    };
	
	// What happens when a new subscription is added?
	$('#subscribe').click(function(x) {
		var str_temp = $('#country').val()+"."+$('#city').val()+"."+$('#location').val()+"."+$('#building').val()+"."+$('#node').val()+"."+$('#sensor').val();
		var str = str_temp.replace(/\+/g, "*");
        id = client.subscribe("/topic/"+str, function(d) {
               //print_first(d.body);
			   //alert(d.body);
        });
    });
	
    var on_error =  function() {
        console.log('error');
    };
    client.connect('guest', 'guest', on_connect, on_error, '/');

    $('#first input').focus(function() {
        if (!has_had_focus) {
            has_had_focus = true;
            $(this).val("");
        }
    });
	
});
	
	
</script>
</html>

