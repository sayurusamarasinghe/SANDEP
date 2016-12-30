<?php
	if(isset($_POST['node']) && isset($_POST['building']) && isset($_POST['country']) && isset($_POST['city']) && isset($_POST['location']) && isset($_POST['sensor'])){
		include('../db/database.php');
		session_start();
		$conn = new connection();
		//$temp = $conn->select_record("subscriptions","MAX(SubID)","1");
		$conn->insert("subscriptions","'".$_SESSION['email']."','".$_POST['country']."','".$_POST['city']."','".$_POST['location']."','".$_POST['building']."'
		,'".$_POST['node']."','".$_POST['sensor']."', CURRENT_TIMESTAMP");
?>

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

<?php		
	}
	else{
		echo "ERROR";
	}
?>