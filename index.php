 <?php

// php select option value from database

$hostname = "localhost";
$username = "wda2018";
$password = "123456";
$databaseName = "wda2018";

///ena sxolioo 2
// ena sxolio 3 
// connect to mysql database

$connect = mysqli_connect($hostname, $username, $password, $databaseName);

// mysql select query
$city_query = "SELECT DISTINCT city FROM `room`";

$room_type_query = "SELECT room_type FROM `room_type`";

$result = mysqli_query($connect, $city_query);

$result1 = mysqli_query($connect, $room_type_query);

?>

<!DOCTYPE html>
<html>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="styles/style.css" rel="stylesheet" type="text/css">
	<link href="styles/jquery-ui.css" rel="stylesheet">
	<body>
		<div class="welcome-navbar">
			<a href="#">Hotels</a> 
			<a class="active" href="#home"><i class="fa fa-fw fa-home"></i>Home</a> 
		</div>
		<div class="welcome-bg-img">
		  <form action="\wdaProject2018\list-page.php" class="welcome-container" method="post">
				<div>
					<select name="City">
						<option value="" disabled selected>City</option>
						<?php while($row1 = mysqli_fetch_array($result)):;?>
						<option><?php echo $row1[0];?></option>
						<?php endwhile;?>
					</select>
					<select name="Room-Type">
						<option value="" disabled selected>Room type</option>
						<?php while($row1 = mysqli_fetch_array($result1)):;?>
						<option><?php echo $row1[0];?></option>
						<?php endwhile;?>
					</select>  
				</div>
				<div>
					<input type="text" name="check-in-date" id="datepicker1" placeholder="Check-in Date">
					<input type="text" name="check-out-date" id="datepicker2" placeholder="Check-out Date">
				</div>
				<div>
				</div>
				<button type="submit" class="welcome-btn">Search</button>
			</form>
		</div>	
		<div class="welcome-footer">
		  <h6>Ioannis Kadianakis 2018 WDA</h6>
		</div> 
		<script src="scripts/jquery.js"></script>
	<script src="scripts/jquery-ui.js"></script>
	<script>
	$( "#datepicker1" ).datepicker({
		inline: true,
		dateFormat: "dd/mm/yy"
	});

	$( "#datepicker2" ).datepicker({
		inline: true,
		dateFormat: "dd/mm/yy"
	});
	</script>
	</body>
</html> 