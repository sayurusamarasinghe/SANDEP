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
<title>SANDEP Analysis Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/w3.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="http://cdn.jsdelivr.net/sockjs/1.0.3/sockjs.min.js"></script>
<script src="js/stomp.js"></script>

<!-- Navbar (sticky bottom) -->
<div class="w3-bottom w3-hide-small">
    <ul class="w3-navbar w3-blue w3-center w3-padding-8 w3-opacity-min w3-hover-opacity-off">
        <li style="width:10%"><a href="#home" class="w3-margin-left w3-round w3-hover-indigo w3-blue" data-toggle="modal" data-target="#profile"><span style="font-size:15px;"><b><?php if (isset($_SESSION['email'])) { ?>Hello <span class="highlight">Sparky</span><?php } else { ?> <span class="highlight">Login</span> <?php } ?></b><span></a></li>
        <li style="width:15%"><a href="index.php" class="w3-round w3-hover-indigo w3-blue">Home</a></li>
        <li style="width:15%"><a href="client.php" class="w3-round w3-hover-indigo w3-blue">Virtual Client</a></li><!-- Virtual Client :- manage subscriptions/publish/realtime console -->
        <li style="width:15%"><a href="analysis.php" class="w3-round w3-hover-indigo w3-blue w3-grayscale-min disabled">Analysis Dashboard</a></li><!-- Analyzing sensor readings -->
        <li style="width:15%"><a href="configure_node.php" class="w3-round w3-hover-indigo w3-blue">Configuration Terminal</a></li><!-- Create .ino configuration files for nodes -->
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
                if (isset($_SESSION['email'])) {
                    $record = $conn->select_record("users", "*", "Email='" . $_SESSION['email'] . "'");
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
                                        <dd><?php echo $record['First_Name'] . " " . $record['Last_Name']; ?><hr/></dd>
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
                    } else {
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
            <h1 class="w3-center w3-text-white"><b>SANDEP IoT Testbed - <span class="highlight">Analysis Dashboard</span></b></h1>
            <br/>
            <table width="100%" class="w3-text-black">
                <tr>
                    <td style="padding: 10px;" valign="top" width="35%">

                        <div class="panel panel-primary" style="background-color: rgba(245, 245, 245, 0.3);">
                            <div class="panel-heading">Sensor Selection</div>
                            <div class="panel-body">

                                <form class="form-horizontal" action="analysis.php" method="POST" id="main-form">

                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="country">Country :</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="country" name="country">
                                                <option disabled selected>Select a country</option>
                                                <?php
                                                $query = $conn->select("country_list", "*", "Country_Code IN (SELECT Country FROM subscriptions WHERE Email='" . $_SESSION['email'] . "')");
                                                while ($record = $conn->fetch_assoc($query)) {
                                                    echo "<option value='" . $record['Country_Code'] . "'>" . $record['Country_Name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="city">City :</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="city" name="city">
                                                <option disabled selected>Select a city</option>
                                            </select>
                                        </div>  
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="location">Location :</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="location" name="location">
                                                <option disabled selected>Select a location</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="building">Building :</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="building" name="building">
                                                <option disabled selected>Select a building</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="node">Node :</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="node" name="node">
                                                <option disabled selected>Select a node</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="sensor">Sensor/Actuator :</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="sensor" name="sensor">
                                                <option disabled selected>Select a sensor/actuator</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group"> 
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="submit" class="btn btn-primary" id="analyze">Analyze</button>
                                        </div>
                                    </div> 
                                </form>

                            </div>
                        </div>
                    </td>
                    <td style="padding: 10px;" valign="top" width="50%">
                        <div class="panel panel-primary" style="background-color: rgba(245, 245, 245, 0.3);">
                            <div class="panel-heading">Node Details</div>
                            <div class="panel-body">
                                <table>
                                    <?php
                                    if (isset($_POST['country']) && isset($_POST['city']) && isset($_POST['location']) && isset($_POST['building']) && isset($_POST['node']) && isset($_POST['sensor'])) {
                                        $record = $conn->select_record("country_list", "Country_Name", "Country_Code='" . $_POST['country'] . "'");
                                        echo "<tr><th>Country</th><td> : </td><td>" . $record['Country_Name'] . "</td></tr>";
                                        $record = $conn->select_record("city_list", "City_Name", "City_Code='" . $_POST['city'] . "'");
                                        echo "<tr><th>City</th><td> : </td><td>" . $record['City_Name'] . "</td></tr>";
                                        $record = $conn->select_record("location_list", "Location_Name", "Location_Code='" . $_POST['location'] . "'");
                                        echo "<tr><th>Location</th><td> : </td><td>" . $record['Location_Name'] . "</td></tr>";
                                        $record = $conn->select_record("building_list", "Building_Name", "Building_Code='" . $_POST['building'] . "'");
                                        echo "<tr><th>Building</th><td> : </td><td>" . $record['Building_Name'] . "</td></tr>";
                                        echo "<tr><th>Node Number</th><td> : </td><td>" . $_POST['node'] . "</td></tr>";
                                        $record = $conn->select_record("message_log", "MAX(Date)", "Country='" . $_POST['country'] . "' AND City='" . $_POST['city'] . "' AND Location='" . $_POST['location'] . "' AND 
									Building='" . $_POST['building'] . "' AND Node='" . $_POST['node'] . "' AND Sensor='" . $_POST['sensor'] . "'");
                                        echo "<tr><th>Last Updated</th><td> : </td><td>" . $record['MAX(Date)'] . "</td></tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                            <div class="panel-footer">Selected Sensor - 
                                <?php
                                if (isset($_POST['country']) && isset($_POST['city']) && isset($_POST['location']) && isset($_POST['building']) && isset($_POST['node']) && isset($_POST['sensor'])) {
                                    $record = $conn->select_record("sensor_list", "Sensor_Name", "Sensor_Code='" . $_POST['sensor'] . "'");
                                    echo $record['Sensor_Name'];
                                } else {
                                    echo "Sensor not yet selected";
                                }
                                ?>	
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>	
                    <td style="padding: 10px;" valign="top" colspan="2">

                        <div class="panel panel-primary" style="background-color: rgba(245, 245, 245, 0.3);">
                            <div class="panel-heading">Variation over Time</div>
                            <div class="panel-body" id="chart_container">

                            </div>
                            <div class="panel-footer">The above column graph shows the variation of readings from the selected sensor for a limited time period.</div>
                        </div>
                    </td>
                </tr>
                <tr>	
                    <td style="padding: 10px;" valign="top" colspan="2">

                        <div class="panel panel-primary" style="background-color: rgba(245, 245, 245, 0.3);">
                            <div class="panel-heading">Sensor Perfomance</div>
                            <div class="panel-body" id="guage_container" align="center">

                            </div>
                            <div class="panel-footer">The above guages show the perfomance of the sensor and the variation of the reading.</div>
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
        $.post("ajax/analysis_city_list.php", {country: $("#country").val()}, function(data){
			$("#city").html(data); 
		});
		$("#analyze").prop('disabled', true);
		$("#publish").prop('disabled', true);
    });
	
	$("#city").change(function(){
        $.post("ajax/analysis_location_list.php", {country: $("#country").val(), city: $("#city").val()}, function(data){
			$("#location").html(data); 
		});
		$("#analyze").prop('disabled', true);
		$("#publish").prop('disabled', true);
    });
	
	$("#location").change(function(){
        $.post("ajax/analysis_building_list.php", {country: $("#country").val(), city: $("#city").val(), location: $("#location").val()}, function(data){
			$("#building").html(data); 
		});
		$("#analyze").prop('disabled', true);
		$("#publish").prop('disabled', true);
    });
	
	$("#building").change(function(){
        $.post("ajax/analysis_node_list.php", {country: $("#country").val(), city: $("#city").val(), location: $("#location").val(), building: $("#building").val()}, function(data){
			$("#node").html(data); 
		});
		$("#analyze").prop('disabled', true);
		$("#publish").prop('disabled', true);
    });
	
	$("#node").change(function(){
        $.post("ajax/analysis_sensor_list.php", {country: $("#country").val(), city: $("#city").val(), location: $("#location").val(), building: $("#building").val(), node: $("#node").val()}, function(data){
			$("#sensor").html(data);
			//console.log(data);
		});
		$("#analyze").prop('disabled', true);
		$("#publish").prop('disabled', true);
    });
	
	$('.disabled').click(function(e){
		e.preventDefault();
	});
	
	$("#sensor").change(function(){
		$("#analyze").prop('disabled', false);
		$("#publish").prop('disabled', false);
	});
	
});
	
</script>

<?php 
    if(isset($_POST['country']) && isset($_POST['city']) && isset($_POST['location']) && isset($_POST['building']) && isset($_POST['node']) && isset($_POST['sensor'])){
        $query = $conn->select("message_log","Message, Date","Country='".$_POST['country']."' AND City='".$_POST['city']."' AND Location='".$_POST['location']."' AND 
        Building='".$_POST['building']."' AND Node='".$_POST['node']."' AND Sensor='".$_POST['sensor']."' AND Date>'".date("Y-m-d H:i:s", strtotime('-14 days', strtotime(date("Y-m-d H:i:s",time()))))."'");

?>

<script type="text/javascript">
		
    google.charts.load('current', {'packages':['corechart','gauge']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart(){
        var data = new google.visualization.DataTable();
        data.addColumn('datetime', 'Time');
        data.addColumn('number', 'Sensor Reading');
        data.addRows([
    
    <?php
        while ($record = $conn->fetch_assoc($query)) {
            echo "[new Date('" . $record['Date'] . "')," . $record['Message'] . "],";
        }
    ?>
                
        ]);
        // Set chart options
        var date1 = new Date();
        date1.setDate(date1.getDate()-1);
        var date2 = new Date();
        var options = {
                'title'	:'Variation of Sensor Reading over Time',
                'width'	: $('#chart_container').width(),
                'height'	:400,
                'is3D'	:true,
                'legend'	:{'position':'none'},
                'chartArea'	:{'width': '90%', 'height': '80%'},
                'hAxis'	:{'minValue': date1, 'maxValue': date2},
                'colors'	:['#6495ED']
        };

        // Instantiate and draw our chart, passing in some options.
        var chart_column = new google.visualization.ColumnChart(document.getElementById('chart_container'));
        chart_column.draw(data, options);

        // Guage
        var mpm = 0; // Messages per minute
        var mph = 0; // Messages per hour
        var reading = 0; // Last reading
        var latency = 0; // Latency
        var date = null;

        var data1 = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['Rate per min', mpm],
            ['Rate per hr', mph],
            ['Reading', reading],
            ['Latency', latency]
        ]);

        var options1 = {
            width: 800, height: 250,
            redFrom: 90, redTo: 100,
            yellowFrom:75, yellowTo: 90,
            minorTicks: 5
        };

        var chart_guage = new google.visualization.Gauge(document.getElementById('guage_container'));

        chart_guage.draw(data1, options1);   

        setInterval(function() {
            $.ajax({
                url: 'ajax/guage_data.php',
                dataType: 'json',
                data: {country: '<?php echo $_POST['country']; ?>', city: '<?php echo $_POST['city']; ?>', location: '<?php echo $_POST['location']; ?>', building: '<?php echo $_POST['building']; ?>', node: '<?php echo $_POST['node']; ?>', sensor: '<?php echo $_POST['sensor']; ?>'},
                success: function(data_post){
                    mpm = data_post[0]; // Messages per minute
                    mph = data_post[1]; // Messages per hour
                    reading = data_post[2]; // Last reading
                    latency = data_post[3]; // Latency
                    date = data_post[4];
                }
            });
            //console.log("MPM "+mpm); console.log("MPM "+mph); console.log("MPM "+reading); console.log("MPM "+latency);
            data1.setValue(0, 1, mpm);
            data1.setValue(1, 1, mph);
            data1.setValue(2, 1, reading);
            data1.setValue(3, 1, latency);
            if(date != null){
                var d = new Date(date); //console.log(d);
                data.addRows([[d, parseFloat(reading)]]); 
                chart_column.draw(data, options);
            }
            chart_guage.draw(data1, options1);
        }, 5000);
    }
	
</script>
<?php } ?>
</html>

