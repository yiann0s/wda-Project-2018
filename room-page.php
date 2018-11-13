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
$room_extended_info_result = $room_extended_info_query->get_result();
$room_extended_info_table=[];
if($room_extended_info_result->num_rows === 0){
	$room_extended_info_message = "no results";
} else{
	$room_extended_info_count = 0;
	while($room_extended_info_row = $room_extended_info_result->fetch_assoc()) {
		$room_extended_info_table[] = $room_extended_info_row;
		$room_extended_info_count = $room_extended_info_count +1;
	}
	$room_extended_info_message = "there are ".$room_extended_info_count." results";
}

$user_review_query = $connection->prepare("SELECT rv.date_created,rv.rate,rv.text,u.username
FROM `room` AS r, `reviews` AS rv,`user` AS u
WHERE rv.user_id = u.user_id AND rv.room_id = r.room_id AND r.room_id = ?");
$user_review_query->bind_param("s",$room_id);
$user_review_query->execute();
$user_review_table = [];
$user_review_result = $user_review_query->get_result();
if($user_review_result->num_rows === 0){
	$message1 = "no results";
} else{
	$user_review_count = 0;
	while($user_review_row = $user_review_result->fetch_assoc()) {
		$user_review_table[] = $user_review_row;
		$user_review_count = $user_review_count +1;
	}
	$user_review_message = "there are ".$user_review_count." results";
}

$avg_reviews_query = $connection->prepare("SELECT AVG(rv.rate) AS avg_rate_value
FROM `reviews` AS rv, `room` AS rm 
WHERE rm.room_id = rv.room_id AND rm.room_id = ?");

$avg_reviews_query->bind_param("s",$room_id);
$avg_reviews_query->execute();
$avg_reviews_table = [];
$avg_reviews_result = $avg_reviews_query->get_result();
if($avg_reviews_result->num_rows === 0){
	$avg_reviews_msg = "no results";
} else{
	$avgReviewsCount = 0;
	while($avg_reviews_row = $avg_reviews_result->fetch_assoc()) {
		$avg_reviews_table = $avg_reviews_row;
		$avgReviewsCount = $avgReviewsCount +1;
	}
	$avg_reviews_msg = "there are ".$avgReviewsCount." results";
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
	<?php 	echo "extended room info msg:".$room_extended_info_message;
			echo ", Selected room id = ".$room_id;
			echo ", user review msg:".$user_review_message;
			echo ", avg reviews msg:".$avg_reviews_msg;
			?>
	<div class="room-page-navbar">
		<a  href="#">Hotels</a>
		<a href="#" class="right"><i class="fa fa-fw fa-user"></i>Profile</a>
		<a href="#" class="right"><i class="fa fa-fw fa-home"></i>Home</a>
	</div>
	<div>	
		<?php	if (count($room_extended_info_table) > 0) {?>
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
				<?php	foreach ($room_extended_info_table as $room_extended_info_row) { ?>
				<tr>
					<td><?php echo $room_extended_info_row['photo']; ?></td>
					<td><?php echo $room_extended_info_row['name']; ?></td>
					<td><?php echo $room_extended_info_row['city']; ?></td>
					<td><?php echo $room_extended_info_row['photo']; ?></td>
					<td><?php echo $room_extended_info_row['area']; ?></td>
					<td><?php echo $room_extended_info_row['room_type']; ?></td>
					<td><?php echo $room_extended_info_row['count_of_guests']; ?></td>
					<td><?php echo $room_extended_info_row['price']; ?></td>
					<td><?php echo $room_extended_info_row['long_description']; ?></td>
				</tr>
				<?php	} ?>
			</table>
		<?php	}	?>
		<?php	if (count($avg_reviews_table) > 0) {?>
			<table>
				<tr>
					<th>Avg rating</th>
				</tr>
				<?php	foreach ($avg_reviews_table as $avg_reviews_row) { ?>
				<tr>
				<td><?php echo var_dump($avg_reviews_row); ?></td>
				<td><?php echo $avg_reviews_row[0]; ?></td>
				<td><?php echo $avg_reviews_row[1]; ?></td>
				<td><?php echo $avg_reviews_row[2]; ?></td>
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
	<div>	
		<?php	if (count($user_review_table) > 0) {?>
			<table>
				<tr>
					<th>date created</th>
					<th>rate</th>
					<th>text</th>
					<th>username</th>
				</tr>
				<?php	foreach ($user_review_table as $user_review_row) { ?>
				<tr>
					<td><?php echo $user_review_row['date_created']; ?></td>
					<td><?php echo $user_review_row['rate']; ?></td>
					<td><?php echo $user_review_row['text']; ?></td>
					<td><?php echo $user_review_row['username']; ?></td>
				</tr>
				<?php	} ?>
			</table>
		<?php	}	?>
	</div>
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
