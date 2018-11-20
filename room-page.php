<?php
include 'session.php';
include 'db_credentials.php';
include 'custom_functions.php';

$room_id =  $_POST["roomId"];
$current_user_id = $_SESSION["user_id"];

// Create connection
$connection = new mysqli($hostname, $username, $password, $databaseName);
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} 

$room_extended_info_query = $connection->prepare("SELECT r.photo,r.name,r.city,r.area,r.lat_location,r.lng_location,r.parking,r.wifi,r.pet_friendly,r.count_of_guests,r.price,r.long_description,rt.room_type
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

$favorite_query = $connection->prepare("SELECT fav.status 
FROM `favorites` AS fav,`room` AS rm,`user` AS u 
WHERE rm.room_id = fav.room_id AND fav.user_id = u.user_id AND u.user_id = ? AND rm.room_id = ?");
$favorite_query->bind_param("ss",$current_user_id,$room_id);
$favorite_query->execute();
$favorite_table = [];
$favorite_result = $favorite_query->get_result();
if($favorite_result->num_rows === 0){
	$favorite_msg = "no results";
} else{
	$favoriteCount = 0;
	while($favorite_row = $favorite_result->fetch_assoc()) {
		$favorite_table = $favorite_row;
		$favoriteCount = $favoriteCount +1;
	}
	$favorite_msg = "there are ".$favoriteCount." results";
}
// $message = "";
// if(isset($_POST['reviewSubmit'])){ //check if form was submitted
  // $input = $_POST['reviewText']; //get input text
  // $message = "Success! You entered: ".$input;
// } 
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
	<?php 	//echo "extended room info msg:".$room_extended_info_message; echo ", Selected room id = ".$room_id; echo ", user review msg:".$user_review_message; echo ", avg reviews msg:".$avg_reviews_msg;?>
	<div class="room-page-navbar">
		<a  href="#">Hotels</a>
		<a href="#" class="right"><i class="fa fa-fw fa-user"></i>Profile</a>
		<a href="index.php" class="right"><i class="fa fa-fw fa-home"></i>Home</a>
	</div>
	<div style="display: none;"><?php	if (count($room_extended_info_table) > 0) {?>
				<?php	foreach ($room_extended_info_table as $room_extended_info_row) { ?>
					<?php echo $room_extended_info_row['photo']; ?>
					<?php echo $room_extended_info_row['name']; ?>
					<?php echo $room_extended_info_row['city']; ?>
					<?php echo $room_extended_info_row['photo']; ?>
					<?php echo $room_extended_info_row['area']; ?>
					<?php echo $room_extended_info_row['room_type']; ?>
					<?php echo $room_extended_info_row['count_of_guests']; ?>
					<?php echo $room_extended_info_row['price']; ?></td>
					<?php echo $room_extended_info_row['long_description']; ?>
					<?php echo $room_extended_info_row['lat_location']; ?>
					<?php echo $room_extended_info_row['lng_location']; ?>
					<?php echo $room_extended_info_row['parking']; ?>
					<?php echo $room_extended_info_row['wifi']; ?>
					<?php echo $room_extended_info_row['pet_friendly']; ?>
				<?php	} ?>
		<?php	}	?>
		<?php	if (count($avg_reviews_table) > 0) {
					foreach ($avg_reviews_table as $avg_reviews_row) { 
						$avg = $avg_reviews_row[0].$avg_reviews_row[1].$avg_reviews_row[2]; 
					}
					//round(x,y,PHP_ROUND_HALF_UP) round up to 1 decimal e.g 3.14 converts to 3.1 and 3.14 to 3.2
					$rounded_avg = round(floatval($avg),1,PHP_ROUND_HALF_UP);	
				}	
		?>
		<?php	if (count($favorite_table) > 0) {
					if ( array_values($favorite_table)[0] == 1 ){
						$isFavorite = "true";
					} else {
						$isFavorite = "false";
					}	
			}	
		?>
	</div>
	<div class="hotel-info-top-bar">
		<div><?php echo $room_extended_info_row['name']; ?></div>
		<div><?php echo $room_extended_info_row['city'].", ".$room_extended_info_row['area']; ?></div>
		<div><?php echo "Ratings:".$rounded_avg."/5"?></div>
		<div><?php echo "Is this your favorite? ".$isFavorite?></div>
		<div id="per-night"><?php echo "Per Night: ".$room_extended_info_row['price']; ?></div>
	</div>
	<div>
		<!-- <div class="fakeimg" style="height:200px;" src="">Image</div> -->
		<?php echo '<img style="height:200px;" src="/wdaProject2018/images/rooms/'.$room_extended_info_row['photo'].'"/>'; ?>
	</div>
	<div class="hotel-info-mid-bar">
		<a >COUNT OF GUESTS: <?php echo $room_extended_info_row['count_of_guests']; ?></a> 
		<a >TYPE OF ROOM: <?php echo $room_extended_info_row['room_type']; ?></a> 
		<a >PARKING: <?php echo $hasParking = ($room_extended_info_row['parking'] === 1) ? "Yes" : "No" ;  ?></a> 
		<a >WIFI: <?php echo $hasParking = ($room_extended_info_row['wifi'] === 1) ? "Yes" : "No" ;  ?></a>
		<a >PET FRIENDLY: <?php echo $hasParking = ($room_extended_info_row['pet_friendly'] === 1) ? "Yes" : "No" ;  ?></a>
	</div>	
	<div class="hotel-room-description">
		<h5>Room Description</h5>
		<?php echo $room_extended_info_row['long_description']; ?>
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
					<th>Date created</th>
					<th>Rating</th>
					<th>Comments</th>
					<th>Username</th>
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
		<form action="" method="post" id="review-form">
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
			<textarea rows="2" cols="60" form="review-form" name="reviewText">Enter text here...</textarea>
			<div>
				<input type="submit" value="Submit" name="reviewSubmit">
			</div>
		</form>
	</div>

	<div class="footer">
		<h6>Ioannis Kadianakis 2018 WDA</h6>
	</div> 
	<script>
	function myMap() {
	var myLat = <?php echo floatval($room_extended_info_row['lat_location']);?>;
	var myLng = <?php echo floatval($room_extended_info_row['lng_location']);?>;
	var room_location = {lat:myLat , lng: myLng};

	var mapProp= {
		center:room_location,
		zoom:15,
	};
	var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

	 var marker = new google.maps.Marker({position: room_location, map: map});

	}
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1LjCZ-zoS3jSLGi7-ttm9KyxuSTXzrds&callback=myMap"></script>
</body>
</html>
