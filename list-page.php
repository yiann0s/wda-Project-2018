<?php
$city_selection =  $_POST["City"];
$room_type_selection = $_POST["Room-Type"];
$check_in_date_selection = $_POST["check-in-date"];
$checkInDateTime = DateTime::createFromFormat('j/n/Y', $check_in_date_selection);
$checkInDateTime = $checkInDateTime->format('d-m-Y'); 
$check_out_date_selection = $_POST["check-out-date"];
$checkOutDateTime = DateTime::createFromFormat('j/n/Y', $check_out_date_selection);
$checkOutDateTime = $checkOutDateTime->format('d-m-Y'); 

// $query = "SELECT * FROM `room` where ";


$hostname = "localhost";
$username = "wda2018";
$password = "123456";
$databaseName = "wda2018";

///ena sxolioo 2
// ena sxolio 3 
// connect to mysql database

$connect = mysqli_connect($hostname, $username, $password, $databaseName);

//mysql select complex query 
$complex_query = "SELECT r.photo,r.name,r.city,r.area,rt.room_type,r.count_of_guests,r.price,r.short_description
FROM `room` AS r,`room_type` AS rt,`bookings` AS b WHERE r.room_type = rt.id AND r.room_id=b.room_id 
AND (('$check_in_date_selection' < b.check_in_date AND '$check_out_date_selection' <= b.check_in_date) OR
('$check_in_date_selection' >= b.check_out_date AND '$check_out_date_selection' > b.check_out_date))
AND r.city = '$city_selection'
AND rt.room_type = '$room_type_selection'";

$result = mysqli_query($connect, $complex_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Page Title</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="styles/list-page-style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="styles/jquery-ui.css" rel="stylesheet">
</head>
<body>
	<div ><?php echo $city_selection; ?></div>
	<div ><?php echo $room_type_selection; ?></div>
	<div ><?php echo $check_in_date_selection; ?></div>
	<div ><?php echo $check_out_date_selection; ?></div>
	<div><?php while($row = mysqli_fetch_array($result)):;?>
						<?php echo "id:".$row[0].",a:".$row[1];?><br>
						<?php endwhile;?>
	</div>
	<div><?php 
		if ($checkInDateTime < $checkOutDateTime) {
			echo "check in date before check out date";
		} else {
			echo "check in date after check out date";
		}
		if ($result->num_rows > 0) {
			echo " there are rows ";
		} else {
			echo " there are NO rows ";
		}
		?>
	</div>
	<div class="list-page-navbar">
		<a class="active" href="#">Hotels</a>
		<a href="#" class="right"><i class="fa fa-fw fa-user"></i>Profile</a>
		<a href="#" class="right"><i class="fa fa-fw fa-home"></i>Home</a>
	</div>
	<div class="row">
		<div class="side">
			<h3>FIND THE PERFECT HOTEL</h3>
				<div>
					<select name="Count-of-Guests">
						<option value="" disabled selected>Count of Guests</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
				</div>
				<div>
					<select name="City">
						<option value="" disabled selected>City</option>
						<option value="Athens">Athens</option>
						<option value="Thessaloniki">Thessaloniki</option>
						<option value="Heraklion">Heraklion</option>
						<option value="Larissa">Larissa</option>
					</select>
				</div>
					<div>
					<select name="Room-Type">
						<option value="" disabled selected>Room type</option>
						<option value="1-room">single</option>
						<option value="2-room">double</option>
						<option value="3-room">three</option>
						<option value="4-room">four</option>
					</select>  
			</div>
			<div>
				<input id="min-range" contenteditable="true">
				</input>
				<input id="max-range" contenteditable="true">
				</input>
			</div>
			<div id="slider"></div>
			<div>
				<input type="text" id="datepicker1" placeholder="Check-in Date">
			</div>
			<div>
				<input type="text" id="datepicker2" placeholder="Check-out Date">
			</div>
			 <input type="submit" value="FIND HOTEL">
		</div>
		<div class="main">
			
				<h2>Search Results</h2>
				<div class="search-result-row">
				<div class="search-result-side">
					<div class="fakeimg" style="height:200px;">Image</div>
					<div class="per-night" >aa</div>
				</div>
				<div class="search-result-main">
					<div class="fakeimg2" style="height:200px;">Image</div>
					<div class="extra-info">
						<div>guest count</div><div>type of room</div>
					</div>
				</div>
				</div>
		</div>
  </div>
</div>
	<div class="footer">
		<h6>Ioannis Kadianakis 2018 WDA</h6>
	</div> 
	<script src="scripts/jquery.js"></script>
	<script src="scripts/jquery-ui.js"></script>
	<script>
	$( "#datepicker1" ).datepicker({
		inline: true
	});

	$( "#datepicker2" ).datepicker({
		inline: true
	});

	$( "#slider" ).slider({
		range: true,
		values: [ 0, 500 ]
	});



	// Hover states on the static widgets
	$( "#dialog-link, #icons li" ).hover(
		function() {
			$( this ).addClass( "ui-state-hover" );
		},
		function() {
			$( this ).removeClass( "ui-state-hover" );
		}
	);
	</script>
</body>
</html>
