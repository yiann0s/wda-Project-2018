<?php
include 'db_credentials.php';

$city_selection = $_POST["city"];
$guest_count   = $_POST["guest_count"];
$room_type   = $_POST["room_type"];
$check_in_date = $_POST["check_in_date"];
$check_out_date = $_POST["check_out_date"];
$start_price= $_POST["start_price"];
$end_price= $_POST["end_price"];
$myArray = array();
if(isset($city_selection)){
	$connection = mysqli_connect($hostname, $username, $password, $databaseName);
	// Check connection
	if (!$connection) {
		die("Connection failed: " . $connection->connect_error);
	} 

	$sql="SELECT r.room_id,r.photo,r.name,r.city,r.area,rt.room_type,r.count_of_guests,r.price,r.short_description
	FROM `room` AS r,`room_type` AS rt 
	WHERE r.room_type = rt.id 
	AND rt.room_type = '".$room_type."'
	AND r.city = '".$city_selection."' 
	AND r.count_of_guests = '".$guest_count."'
	AND price BETWEEN '".$start_price."' AND '".$end_price."' 
	AND r.room_id NOT IN (
	SELECT room_id FROM `bookings` 
	WHERE (check_in_date BETWEEN '".$check_in_date."' AND '".$check_out_date."') 
		OR (check_out_date BETWEEN '".$check_in_date."' AND '".$check_out_date."') 
		OR ( check_in_date < '".$check_in_date."' AND check_out_date > '".$check_out_date."')	
	)";
	
	$result = mysqli_query($connection,$sql);
	
	while($row = mysqli_fetch_array($result)) {
		$myArray[] = $row;
	}
	
	echo json_encode($myArray);
}
?>