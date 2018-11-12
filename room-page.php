<?php
include 'custom_functions.php';

$room_id =  $_POST["roomId"];

$hostname = "localhost";
$username = "wda2018";
$password = "123456";
$databaseName = "wda2018";

// Create connection
$connection = new mysqli($hostname, $username, $password, $databaseName);
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} 

$room_extended_info_query = $connection->prepare("SELECT r.photo,r.name,r.city,r.area,r.count_of_guests,r.price,r.long_description,rt.room_type
FROM `room` AS r,`room_type` AS rt
WHERE r.room_id =  ? AND r.room_type = rt.id ");

$room_extended_info_query->bind_param("s",$room_id);
$room_extended_info_query->execute();
$result = $room_extended_info_query->get_result();
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

$user_review_query = $connection->prepare("SELECT rv.date_created,rv.rate,rv.text,u.username
FROM `room` AS r, `reviews` AS rv,`user` AS u
WHERE rv.user_id = u.user_id AND rv.room_id = r.room_id AND r.room_id = ?");
$user_review_query->bind_param("s",$room_id);
$user_review_query->execute();
$table_data1 = [];
$result1 = $user_review_query->get_result();
if($result1->num_rows === 0){
	$message1 = "no results";
} else{
	$count1 = 0;
	while($row1 = $result1->fetch_assoc()) {
		$table_data1[] = $row1;
		$count1 = $count1 +1;
	}
	$message1 = "there are ".$count1." results";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Page Title</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="styles/room-page-style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link href="styles/jquery-ui.css" rel="stylesheet">
	 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
</head>
<body>
	<?php echo $message; echo " Selected room id = ".$room_id;  echo '  '.$message1;?>
	<div class="room-page-navbar">
		<a  href="#">Hotels</a>
		<a href="#" class="right"><i class="fa fa-fw fa-user"></i>Profile</a>
		<a href="#" class="right"><i class="fa fa-fw fa-home"></i>Home</a>
	</div>
	<div>	
		<?php	if (count($table_data) > 0) {?>
			<table>
				<tr>
					<th>Photo</th>
					<th>Name</th>
					<th>City</th>
					<th>Area</th>
					<th>Room type</th>
					<th>Count of guests</th>
					<th>price</th>
					<th>long description</th>
					
				</tr>
				<?php	foreach ($table_data as $row) { ?>
				<tr>
					<td><?php echo $row['photo']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['city']; ?></td>
					<td><?php echo $row['photo']; ?></td>
					<td><?php echo $row['area']; ?></td>
					<td><?php echo $row['room_type']; ?></td>
					<td><?php echo $row['count_of_guests']; ?></td>
					<td><?php echo $row['price']; ?></td>
					<td><?php echo $row['long_description']; ?></td>
				</tr>
				<?php	} ?>
			</table>
		<?php	}	?>
	</div>
	<div>	
		<?php	if (count($table_data1) > 0) {?>
			<table>
				<tr>
					<th>date_created</th>
					<th>rate</th>
					<th>text</th>
					<th>username</th>
				</tr>
				<?php	foreach ($table_data1 as $row1) { ?>
				<tr>
					<td><?php echo $row1['date_created']; ?></td>
					<td><?php echo $row1['rate']; ?></td>
					<td><?php echo $row1['text']; ?></td>
					<td><?php echo $row1['username']; ?></td>
				</tr>
				<?php	} ?>
			</table>
		<?php	}	?>
	</div>
	<div class="hotel-info-top-bar">
		<div>Athens, Syntagma</div>
		<div>Reviews:</div>
		<div>stars</div>
		<div>heart</div>
		<div id="per-night">Per Night: 500E</div>
	</div>
	<div>
		<div class="fakeimg" style="height:200px;">Image</div>
	</div>
	<div class="hotel-info-mid-bar">
		<a >COUNT OF GUESTS</a> 
		<a >TYPE OF ROOM</a> 
		<a >PARKING</a> 
		<a >WIFI</a>
		<a >PET FRIENDLY</a>
	</div>	
	<div class="hotel-room-description">
	<h5>Room Description</h5>
	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse gravida massa id enim egestas, nec tristique quam pellentesque. Integer consectetur eleifend vehicula. Ut a scelerisque leo
	</div>
	<div class="isBooked">
	isBooked?
	</div>
	<div>
		<div id="googleMap" style="width:100%;height:100px;"></div>
	</div>
	<div id="reviews">
	<h5>Reviews</h5>
	</div>
	<div id="add-review">
		<h5>Add Review</h5>
		<div>Stars</div>
		<div class="rating">
			<label>
			<input type="radio" name="rating" value="1" title="1 star"> 1
			</label>
			<label>
			<input type="radio" name="rating" value="2" title="2 stars"> 2
			</label>
			<label>
			<input type="radio" name="rating" value="3" title="3 stars"> 3
			</label>
			<label>
			<input type="radio" name="rating" value="4" title="4 stars"> 4
			</label>
			<label>
			<input type="radio" name="rating" value="5" title="5 stars"> 5
			</label>
		</div>
			<textarea rows="2" cols="60">
			At w3schools.com you will learn how to make a website. We offer free tutorials in all web development technologies.
			</textarea>
		<div>
		<input type="submit" value="Submit">
		</div>
	</div>

	<div class="footer">
		<h6>Ioannis Kadianakis 2018 WDA</h6>
	</div> 
	<script>
	function myMap() {

	var athens = {lat: 37.983810, lng: 23.727539};

	var mapProp= {
		center:athens,
		zoom:15,
	};
	var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

	 var marker = new google.maps.Marker({position: athens, map: map});

	}
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1LjCZ-zoS3jSLGi7-ttm9KyxuSTXzrds&callback=myMap"></script>
</body>
</html>
