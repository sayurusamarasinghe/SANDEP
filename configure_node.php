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
<title>SANDEP Configuration Terminal</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/w3.css">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="http://cdn.jsdelivr.net/sockjs/1.0.3/sockjs.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="js/stomp.js"></script>

<!-- Navbar (sticky bottom) -->
<div class="w3-bottom w3-hide-small">
    <ul class="w3-navbar w3-blue w3-center w3-padding-8 w3-opacity-min w3-hover-opacity-off">
        <li style="width:10%"><a href="#home" class="w3-margin-left w3-round w3-hover-indigo w3-blue" data-toggle="modal" data-target="#profile"><span style="font-size:15px;"><b><?php if (isset($_SESSION['email'])) { ?>Hello <span class="highlight">Sparky</span><?php } else { ?> <span class="highlight">Login</span> <?php } ?></b><span></a></li>
        <li style="width:15%"><a href="index.php" class="w3-round w3-hover-indigo w3-blue">Home</a></li>
        <li style="width:15%"><a href="client.php" class="w3-round w3-hover-indigo w3-blue">Virtual Client</a></li><!-- Virtual Client :- manage subscriptions/publish/realtime console -->
        <li style="width:15%"><a href="analysis.php" class="w3-round w3-hover-indigo w3-blue">Analysis Dashboard</a></li><!-- Analyzing sensor readings -->
        <li style="width:15%"><a href="configure_node.php" class="w3-round w3-hover-indigo w3-blue w3-grayscale-min disabled">Configuration Terminal</a></li><!-- Create .ino configuration files for nodes -->
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
            <h1 class="w3-center w3-text-white"><b>SANDEP IoT Testbed - <span class="highlight">Configuration Terminal</span></b></h1>
            <br/>
            <table width="100%" class="w3-text-black">
                <tr>
                    <td style="padding: 10px;" valign="top" width="35%">

                        <div class="panel panel-primary" style="background-color: rgba(245, 245, 245, 0.3);">
                            <div class="panel-heading">Node Selection</div>
                            <div class="panel-body">
                                
                                <form class="form-horizontal" id="main-form">

                                    <div class="form-group" align="center">
                                        <div class="checkbox" >
                                            <label class="checkbox-inline">
                                                <input type="checkbox" data-toggle="toggle" data-on="New" data-off="Existing" id="checkbox_type_1">
                                            </label>
                                            <label class="checkbox-inline">
                                                <input type="checkbox" data-toggle="toggle" data-on="Perceptor" data-off="Gateway" id="checkbox_type_2">
                                                <b>Node - Configuration</b>
                                            </label>
                                        </div>
                                    </div>
                                    <hr/>
                                    
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
                                </form>
                                
                            </div>
                        </div>
                    </td>
                    <td style="padding: 10px;" valign="top" width="40%">
                        <div class="panel panel-primary" style="background-color: rgba(245, 245, 245, 0.3);">
                            <div class="panel-heading">Node Configuration</div>
                            <div class="panel-body">
                                <form class="form-horizontal" action="analysis.php" method="POST" id="main-form">

                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="node_tranceiver_main">Main Transceiver :</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="node_tranceiver_main" name="node_tranceiver_main">
                                                <option disabled selected>Select a transceiver</option>
                                                <option>Bluetooth Low Energy (BLE)</option>
                                                <option>Wifi Direct</option>
                                                <option>LoRa</option>
                                                <option>XBee</option>
                                            </select>
                                        </div>  
                                    </div>

                                    <div id="form_content">
                                        <div class='form-group'>
                                            <label class='control-label col-sm-3' for='node_tranceiver_1'>Transceiver 1 :</label>
                                            <div class='col-sm-9'>
                                                <select class='form-control' id='node_tranceiver_1' name='node_main_tranceiver_1'>
                                                    <option disabled selected>Select a transceiver</option>
                                                    <option value='ble'>Bluetooth Low Energy (BLE)</option>
                                                    <option value='wifi'>Wifi Direct</option>
                                                    <option value='lora'>LoRa</option>
                                                    <option value='xbee'>XBee</option>
                                                    <option value='none'>None</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label class='control-label col-sm-3' for='node_tranceiver_2'>Transceiver 2 :</label>
                                            <div class='col-sm-9'>
                                                <select class='form-control' id='node_tranceiver_2' name='node_main_tranceiver_2'>
                                                    <option disabled selected>Select a transceiver</option>
                                                    <option value='ble'>Bluetooth Low Energy (BLE)</option>
                                                    <option value='wifi'>Wifi Direct</option>
                                                    <option value='lora'>LoRa</option>
                                                    <option value='xbee'>XBee</option>
                                                    <option value='none'>None</option>
                                                </select>
                                            </div>  
                                        </div>
                                        <div class='form-group'>
                                            <label class='control-label col-sm-3' for='node_tranceiver_3'>Transceiver 3 :</label>
                                            <div class='col-sm-9'>
                                                <select class='form-control' id='node_tranceiver_3' name='node_main_tranceiver_3'>
                                                    <option disabled selected>Select a transceiver</option>
                                                    <option value='ble'>Bluetooth Low Energy (BLE)</option>
                                                    <option value='wifi'>Wifi Direct</option>
                                                    <option value='lora'>LoRa</option>
                                                    <option value='xbee'>XBee</option>
                                                    <option value='none'>None</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label class='control-label col-sm-3' for='node_tranceiver_4'>Transceiver 4 :</label>
                                            <div class='col-sm-9'>"+
                                                <select class='form-control' id='node_tranceiver_4' name='node_main_tranceiver_4'>
                                                    <option disabled selected>Select a transceiver</option>
                                                    <option value='ble'>Bluetooth Low Energy (BLE)</option>
                                                    <option value='wifi'>Wifi Direct</option>
                                                    <option value='lora'>LoRa</option>
                                                    <option value='xbee'>XBee</option>
                                                    <option value='none'>None</option>
                                                </select>
                                            </div>  
                                        </div>
                                    </div>
                                </form>
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
                    <td style="padding: 10px;" valign="top" width="25%">
                        <div class="panel panel-primary" style="background-color: rgba(245, 245, 245, 0.3);">
                            <div class="panel-heading">Node Configuration</div>
                            <div class="panel-body">
                                
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
    $('#checkbox_type_2').change(function(){
        if(!$('#checkbox_type_2').is(':checked')){
            $('#form_content').html(
                "<div class='form-group'>"+
                    "<label class='control-label col-sm-3' for='node_tranceiver_1'>Transceiver 1 :</label>"+
                    "<div class='col-sm-9'>"+
                        "<select class='form-control' id='node_tranceiver_1' name='node_main_tranceiver_1'>"+
                            "<option disabled selected>Select a transceiver</option>"+
                            "<option value='ble'>Bluetooth Low Energy (BLE)</option>"+
                            "<option value='wifi'>Wifi Direct</option>"+
                            "<option value='lora'>LoRa</option>"+
                            "<option value='xbee'>XBee</option>"+
                            "<option value='none'>None</option>"+
                        "</select>"+
                    "</div>"+  
                "</div>"+
                "<div class='form-group'>"+
                    "<label class='control-label col-sm-3' for='node_tranceiver_2'>Transceiver 2 :</label>"+
                    "<div class='col-sm-9'>"+
                        "<select class='form-control' id='node_tranceiver_2' name='node_main_tranceiver_2'>"+
                            "<option disabled selected>Select a transceiver</option>"+
                            "<option value='ble'>Bluetooth Low Energy (BLE)</option>"+
                            "<option value='wifi'>Wifi Direct</option>"+
                            "<option value='lora'>LoRa</option>"+
                            "<option value='xbee'>XBee</option>"+
                            "<option value='none'>None</option>"+
                        "</select>"+
                    "</div>"+  
                "</div>"+
                "<div class='form-group'>"+
                    "<label class='control-label col-sm-3' for='node_tranceiver_3'>Transceiver 3 :</label>"+
                    "<div class='col-sm-9'>"+
                        "<select class='form-control' id='node_tranceiver_3' name='node_main_tranceiver_3'>"+
                            "<option disabled selected>Select a transceiver</option>"+
                            "<option value='ble'>Bluetooth Low Energy (BLE)</option>"+
                            "<option value='wifi'>Wifi Direct</option>"+
                            "<option value='lora'>LoRa</option>"+
                            "<option value='xbee'>XBee</option>"+
                            "<option value='none'>None</option>"+
                        "</select>"+
                    "</div>"+  
                "</div>"+
                "<div class='form-group'>"+
                    "<label class='control-label col-sm-3' for='node_tranceiver_4'>Transceiver 4 :</label>"+
                    "<div class='col-sm-9'>"+
                        "<select class='form-control' id='node_tranceiver_4' name='node_main_tranceiver_4'>"+
                            "<option disabled selected>Select a transceiver</option>"+
                            "<option value='ble'>Bluetooth Low Energy (BLE)</option>"+
                            "<option value='wifi'>Wifi Direct</option>"+
                            "<option value='lora'>LoRa</option>"+
                            "<option value='xbee'>XBee</option>"+
                            "<option value='none'>None</option>"+
                        "</select>"+
                    "</div>"+  
                "</div>"
            );
        }
        else{
            $('#form_content').html(
                "<div class='form-group'>"+
                    "<label class='control-label col-sm-3' for='node_perceptor_1_type'>Perceptor 1 :</label>"+
                    "<div class='col-sm-4'>"+
                        "<select class='form-control' id='node_perceptor_1_type' name='node_perceptor_1_type'>"+
                            "<option value='sensor'>Sensor</option>"+
                            "<option value='actuator'>Actuator</option>"+
                            "<option value='none' selected>None</option>"+
                        "</select>"+
                    "</div>"+
                    "<div class='col-sm-5'>"+
                        "<select class='form-control' id='node_perceptor_1' name='node_perceptor_1'>"+
                            "<option disabled selected>N/A</option>"+
                        "</select>"+
                    "</div>"+
                "</div>"+
                
                "<div class='form-group'>"+
                    "<label class='control-label col-sm-3' for='node_perceptor_2_type'>Perceptor 2 :</label>"+
                    "<div class='col-sm-4'>"+
                        "<select class='form-control' id='node_perceptor_2_type' name='node_perceptor_2_type'>"+
                            "<option value='sensor'>Sensor</option>"+
                            "<option value='actuator'>Actuator</option>"+
                            "<option value='none' selected>None</option>"+
                        "</select>"+
                    "</div>"+
                    "<div class='col-sm-5'>"+
                        "<select class='form-control' id='node_perceptor_2' name='node_perceptor_2'>"+
                            "<option disabled selected>N/A</option>"+
                        "</select>"+
                    "</div>"+
                "</div>"+
                
                "<div class='form-group'>"+
                    "<label class='control-label col-sm-3' for='node_perceptor_3_type'>Perceptor 3 :</label>"+
                    "<div class='col-sm-4'>"+
                        "<select class='form-control' id='node_perceptor_3_type' name='node_perceptor_3_type'>"+
                            "<option value='sensor'>Sensor</option>"+
                            "<option value='actuator'>Actuator</option>"+
                            "<option value='none' selected>None</option>"+
                        "</select>"+
                    "</div>"+
                    "<div class='col-sm-5'>"+
                        "<select class='form-control' id='node_perceptor_3' name='node_perceptor_3'>"+
                            "<option disabled selected>N/A</option>"+
                        "</select>"+
                    "</div>"+
                "</div>"+
                
                "<div class='form-group'>"+
                    "<label class='control-label col-sm-3' for='node_perceptor_4_type'>Perceptor 4 :</label>"+
                    "<div class='col-sm-4'>"+
                        "<select class='form-control' id='node_perceptor_4_type' name='node_perceptor_4_type'>"+
                            "<option value='sensor'>Sensor</option>"+
                            "<option value='actuator'>Actuator</option>"+
                            "<option value='none' selected>None</option>"+
                        "</select>"+
                    "</div>"+
                    "<div class='col-sm-5'>"+
                        "<select class='form-control' id='node_perceptor_4' name='node_perceptor_4'>"+
                            "<option disabled selected>N/A</option>"+
                        "</select>"+
                    "</div>"+
                "</div>" 
            );
        }
    });
    
    $('body').on('click', '#node_perceptor_1_type', function(){
        load_perceptor_data(1);
    });
    $('body').on('click', '#node_perceptor_2_type', function(){
        load_perceptor_data(2);
    });
    $('body').on('click', '#node_perceptor_3_type', function(){
        load_perceptor_data(3);
    });
    $('body').on('click', '#node_perceptor_4_type', function(){
        load_perceptor_data(4);
    });
    
    function load_perceptor_data(num){
        if($('#node_perceptor_'+num+'_type').val()=='sensor'){
            $('#node_perceptor_'+num).html(
                "<option value='TEM'>Temperature</option>"+
                "<option value='ATM'>Atmospheric Pressure</option>"+
                "<option value='HUM'>Humidity</option>"
            );
        }
        else if($('#node_perceptor_'+num+'_type').val()=='actuator'){
            $('#node_perceptor_'+num).html(
                "<option value='LED'>LED</option>"+
                "<option value='BUZ'>Buzzer</option>"+
                "<option value='REL'>Relay Circuit</option>"
            );
        }
        else{
            $('#node_perceptor_'+num).html(
                "<option disabled selected>N/A</option>"
            );
        }
    }
</script>
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
</html>

