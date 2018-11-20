<?php

include 'session.php';
include 'db_credentials.php';

//HTML and PHP tags stripped from given vars
$city_selection =  strip_tags($_POST["City"]);
$room_type_selection = strip_tags($_POST["Room-Type"]);
$check_in_date_selection = strip_tags($_POST["check-in-date"]);
$check_out_date_selection = strip_tags($_POST["check-out-date"]);

// Create connection
$connection = new mysqli($hostname, $username, $password, $databaseName);
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} 


//ta id twn dwmatiwn pou einai sthn X polh kai einai Y room type  kai den einai kleismena hmeromhnies pou epikalyptoun thn epilogh tou xrhsth
$stmt = $connection->prepare("SELECT r.room_id,r.photo,r.name,r.city,r.area,rt.room_type,r.count_of_guests,r.price,r.short_description
FROM `room` AS r,`room_type` AS rt 
WHERE r.room_type = rt.id 
AND r.city = ?
AND rt.room_type = ?
AND r.room_id NOT IN (
	SELECT room_id FROM `bookings` 
	WHERE (check_in_date BETWEEN ? AND ?) 
		OR (check_out_date BETWEEN ? AND ?) 
		OR ( check_in_date < ? AND check_out_date > ?)	
)");

$stmt->bind_param("ssssssss", $city_selection, $room_type_selection, 
$check_in_date_selection,$check_out_date_selection, 
$check_in_date_selection,$check_out_date_selection,
 $check_in_date_selection,$check_out_date_selection);

$stmt->execute();
$message = "";
$table_data = array();
$result = $stmt->get_result();
if($result->num_rows === 0){
	$message = "no results";
} else{
	$count = 0;
	while($row = $result->fetch_assoc()) {
		$table_data[] = $row;
		$count = $count +1;
	}
	$message = "there are ".$count." results";
}

$count_of_guests_query = "SELECT DISTINCT count_of_guests FROM `room`  
ORDER BY `room`.`count_of_guests` ASC;";
$guests_result = mysqli_query($connection,$count_of_guests_query);

$room_type_query = "SELECT room_type FROM `room_type`";
$room_type_result = mysqli_query($connection, $room_type_query);

$city_query = "SELECT DISTINCT city FROM `room` ORDER BY city ASC";
$city_result = mysqli_query($connection,$city_query);

$room_type_query = "SELECT room_type FROM `room_type` ORDER BY `room_type`.`id` ASC";
$room_type_result = mysqli_query($connection,$room_type_query);

//echo "In current session user id " . $_SESSION['user_id'];
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
	<div class="list-page-navbar">
		<a class="active" href="#">Hotels</a>
		<a href="#" class="right"><i class="fa fa-fw fa-user"></i>Profile</a>
		<a href="index.php" class="right"><i class="fa fa-fw fa-home"></i>Home</a>
	</div>
	<div class="row">
			<div class="side">
				<h3>FIND THE PERFECT HOTEL</h3>
				<div>
					<select name="Count-of-Guests" id="count_of_guests">
						<option value="" disabled selected>Count of Guests</option>
						<?php while($row1 = mysqli_fetch_array($guests_result)):;?>
							<option <?php if ($room_type_selection == $row1[0]) echo "selected"; ?>><?php echo $row1[0];?></option>
						<?php endwhile;?>
					</select>
				</div>
				<div>
					<select name="Room-Type" id="room_type">
						<option value="" disabled selected>Room Type</option>
						<?php while($room_type_row = mysqli_fetch_array($room_type_result)):;?>
							<option <?php if ($room_type_selection == $room_type_row[0]) echo "selected"; ?>><?php echo $room_type_row[0];?></option>
						<?php endwhile;?>
					</select>
				</div>
				<div>
					<select name="City" id="city">
						<option value="" disabled selected>City</option>
						<?php while($row2 = mysqli_fetch_array($city_result)):;?>
							<option <?php if ($city_selection == $row2[0]) echo "selected"; ?>><?php echo $row2[0];?></option>
						<?php endwhile;?>
					</select>
				</div>
				<div>
					<input type="number" id="start_price" placeholder="from:" min="0" />
					<input type="number" id="end_price" placeholder="to:" min="0"/>
				</div>
				<div>
					<input type="text" id="check_in_datepicker" placeholder="Check-in Date" value="<?php echo $check_in_date_selection; ?>">
				</div>
				<div>
					<input type="text" id="check_out_datepicker" placeholder="Check-out Date" value="<?php echo $check_out_date_selection; ?>">
				</div>
				 <!-- <input type="button" id="ajax-btn" value="FIND HOTEL"> -->
				 <input type="button" id="filter-btn" value="FIND HOTEL">
			</div>
		<div class="main" id="first-results">
				<h2>Search Results</h2>
				<?php	foreach ($table_data as $row) { ?>
				<div class="search-result-row">
					<div class="search-result-side">
						<?php echo '<img style="height:100px;width:100px;" src="/wdaProject2018/images/rooms/'.$row['photo'].'"/>'; ?>
						<div class="per-night" ><?php echo "Per night: ".$row['price']; ?></div>
					</div>
					<div class="search-result-main">
						<div class="main-right-side" >
							<h3><?php echo $row['name']; ?></h3>
							<h4><?php echo $row['city'].", ".$row['area']; ?></h4>
							<div><?php echo $row['short_description']; ?></div>
							<?php $ID = $row['room_id'];?>
								<form action="\wdaProject2018\room-page.php" method="post">
								<input type="hidden" name="roomId" value="<?php echo $row['room_id']; ?>">
								<input type="submit" name="submit" value="Go to Hotel Page">
							</form>
						</div>
						<div class="extra-info">
							<div><?php echo "Guest count: ".$row['count_of_guests']." | Type of room: ".$row['room_type']; ?></div>
						</div>
					</div>
				</div>
				<?php	} ?>
		</div>
  </div>
</div>
	<div class="footer">
		<h6>Ioannis Kadianakis 2018 WDA</h6>
	</div> 
	<script src="scripts/jquery.js"></script>
	<script src="scripts/jquery-ui.js"></script>
	<script>
	$(document).ready(function() {
		$("#filter-btn").on('click',function(){
			console.log("onclick called, room type " + $("#room_type").val());
			$.ajax({
				url: "post.php",
				async: true,
				type: "POST",
				data: {
					city: 			$('#city').val(),
					guest_count: 		$('#count_of_guests').val(),
					room_type: 		$("#room_type").val(),
					check_in_date: 	$("#check_in_datepicker").val(),
					check_out_date: 	$("#check_out_datepicker").val(),
					start_price: 			$("#start_price").val(),
					end_price: 				$("#end_price").val(),
				},
				dataType: "JSON",
				success: function (jsonStr) {
					console.log("it's sucessful");
					$("#first-results").html("<h2>Search Results</h2>");
					for (var i = 0; i < jsonStr.length; i++) {
						console.log("city: "+jsonStr[i].city
						+",guests:" +jsonStr[i].count_of_guests+
						",room id:" + jsonStr[i].room_id + ",photo:"+jsonStr[i].photo+",name:"+jsonStr[i].name+
						",room type:"+jsonStr[i].room_type + ",price:"+jsonStr[i].price+",short description:"+jsonStr[i].short_description);
						
					}
					alert("ajax query has returned "+jsonStr.length+ " results");
				},
				error: function( req, status, err ) {
					console.log( 'something went wrong', status, err );
				}
			});
		});
	
    });		
	</script>
	<script>

	$( "#slider" ).slider({
		range: true,
		values: [ 0, 500 ]
	});
	
	$( "#check_in_datepicker" ).datepicker({
			inline: true,
			dateFormat: "yy-mm-dd",
			minDate: new Date(),
			onSelect: function(date){

				var selectedDate = new Date(date);
				var msecsInADay = 86400000;
				var endDate = new Date(selectedDate.getTime() + msecsInADay);

			   //Set Minimum Date of check out date picker after check in date is selected
				$("#check_out_datepicker").datepicker( "option", "minDate", endDate );

			}
		});

		$( "#check_out_datepicker" ).datepicker({
			inline: true,
			dateFormat: "yy-mm-dd",
			minDate: new Date()
		});

	</script>
</body>
</html>
