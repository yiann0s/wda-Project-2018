<?php
$city_selection =  $_POST["City"];
$room_type_selection = $_POST["Room-Type"];
$check_in_date_selection = $_POST["check-in-date"];
// $checkInDateTime = DateTime::createFromFormat('j/n/Y', $check_in_date_selection);
// $CID = $checkInDateTime;//->format('Y-m-d'); 
$check_out_date_selection = $_POST["check-out-date"];
// $checkOutDateTime = DateTime::createFromFormat('j/n/Y', $check_out_date_selection);
// $COD = $checkOutDateTime->format('Y-m-d'); 

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


if (isset($_POST['count-of-guests'])) {
	$count_of_guests = $_POST['count-of-guests'];
    if (isset($_POST['ajax'])) {
        echo json_encode(array(
           'count-of-guests' => ($count_of_guests),
        ));
        exit;
    }
}

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
	<?php print_r($_POST); ?>
	<div ><?php echo $city_selection; ?></div>
	<div ><?php echo $room_type_selection; ?></div>
	<div ><?php echo "check in date unformatted ".$check_in_date_selection; ?></div>
	<div ><?php echo "check out date unformatted ".$check_out_date_selection; ?></div>
	<div id="messages"></div>
	<div>	<?php	if (count($table_data) > 0) {?>
			<table>
				<tr>
					<th>Room ID</th>
					<th>Name</th>
					<th>City</th>
					<th>Photo</th>
					<th>Area</th>
					<th>Room type</th>
					<th>COunt of guests</th>
					<th>price</th>
					<th>short_description</th>
					
				</tr>
				<?php	foreach ($table_data as $row) { ?>
				<tr>
					<td><?php echo $row['room_id']; ?></td>
					<td><?php echo $row['name']; ?></td>
					<td><?php echo $row['city']; ?></td>
					<td><?php echo $row['photo']; ?></td>
					<td><?php echo $row['area']; ?></td>
					<td><?php echo $row['room_type']; ?></td>
					<td><?php echo $row['count_of_guests']; ?></td>
					<td><?php echo $row['price']; ?></td>
					<td><?php echo $row['short_description']; ?></td>
				</tr>
				<?php	} ?>
			</table>
		<?php	}	?>
	</div>
	<div>
		<?php echo "results of statmtnt ".$message;?>
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
					<select name="Count-of-Guests" id="count-of-guests">
						<option value="" disabled selected>Count of Guests</option>
						<?php while($row1 = mysqli_fetch_array($guests_result)):;?>
							<option <?php if ($room_type_selection == $row1[0]) echo "selected"; ?>><?php echo $row1[0];?></option>
						<?php endwhile;?>
					</select>
				</div>
				<div>
					<select name="Room-Type">
						<option value="" disabled selected>Room Type</option>
						<?php while($room_type_row = mysqli_fetch_array($room_type_result)):;?>
							<option <?php if ($room_type_selection == $room_type_row[0]) echo "selected"; ?>><?php echo $room_type_row[0];?></option>
						<?php endwhile;?>
					</select>
				</div>
				<div>
					<select name="City">
						<option value="" disabled selected>City</option>
						<?php while($row2 = mysqli_fetch_array($city_result)):;?>
							<option <?php if ($city_selection == $row2[0]) echo "selected"; ?>><?php echo $row2[0];?></option>
						<?php endwhile;?>
					</select>
				</div>
				<div>
					<input type="number" id="start-price" placeholder="from:" min="0" />
					<input type="number" id="end-price" placeholder="to:" min="0"/>
				</div>
				<div>
					<input type="text" id="check-in-datepicker" placeholder="Check-in Date" value="<?php echo $check_in_date_selection; ?>">
				</div>
				<div>
					<input type="text" id="check-out-datepicker" placeholder="Check-out Date" value="<?php echo $check_out_date_selection; ?>">
				</div>
				 <input type="button" id="ajax-btn" value="FIND HOTEL">
			</div>
		<div class="main">

				<h2>Search Results</h2>
				<?php	foreach ($table_data as $row) { ?>
				<div class="search-result-row">
					<div class="search-result-side">
						<!--<div class="fakeimg" style="height:200px;"><?php //echo $row['photo']; ?></div> -->
						<?php echo '<img src="/wdaProject2018/images/rooms/'.$row['photo'].'"/>'; ?>
						<div class="per-night" ><?php echo "Per night: ".$row['price']; ?></div>
					</div>
					<div class="search-result-main">
						<div class="main-right-side" >
							<h3><?php echo $row['name']; ?></h4>
							<h4><?php echo $row['city'].", ".$row['area']; ?></h5>
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
	$(document).ready(function(){
		$('#ajax-btn').on('click', function(event) {
			$.ajax({
					url: "list-page.php",
					success: function(){
							$('#messages').html("<div class='error' style='color:green;'>AJAX request succesful</div>");
					},
					error: function(){
							$('#messages').html("<div class='error' style='color:red;'>AJAX request failed.</div>");
					}
			});
		});

		/*$('#ajax-btn').on('click', function(event) {
			 event.preventDefault();
			 dataString = $('#count-of-guests').val();
			 $.ajax({
				type: "post",
				url: "list-page.php",
				dataType:"json",
				data: dataString,
				success: function (response) {
						$('#messages').html("<div class='error' style='color:green;'>AJAX request succesful</div>");

				},
				error: function (xhr,status,error) {
					$('#messages').html("<div class='error' style='color:red;'>AJAX request failed.</div>");
				}
			})
			return false;
		});*/
		
		/*$('#ajax-btn').on('click', function() {
			console.log($('#count-of-guests').val());
			$.ajax({
				type: "POST",
				async: true,
				url: "<?php echo $_SERVER['PHP_SELF']; ?>",
				data: {
					'count-of-guests': $('#count-of-guests').val(),
					'ajax': 1
				},
				dataType: 'json',
				success: function (result, status, xhr) {
					// parseJQueryAjaxResponse(result);
					$('#messages').html("<div class='error' style='color:green;'>AJAX request succesful</div>");
				},
				error: function (xhr,status,error) {
					$('#messages').html("<div class='error' style='color:red;'>AJAX request failed.</div>");
				}
			});
		});*/
		function parseJQueryAjaxResponse(responseData) {
			if ('isValidEmail' in responseData) {
				if (responseData['isValidEmail']) {
					$('#messages').html("<div class='success'>Your email is valid!</div>");
				} else {
					$('#messages').html("<div class='error'>Your email is invalid</div>");
				}
			} else {
				$('#messages').html("<div class='error'>Invalid AJAX response.</div>");
			}
		}
	
	});
</script>
	<script>

	$( "#slider" ).slider({
		range: true,
		values: [ 0, 500 ]
	});
	
	$( "#check-in-datepicker" ).datepicker({
			inline: true,
			dateFormat: "yy-mm-dd",
			minDate: new Date(),
			onSelect: function(date){

				var selectedDate = new Date(date);
				var msecsInADay = 86400000;
				var endDate = new Date(selectedDate.getTime() + msecsInADay);

			   //Set Minimum Date of check out date picker after check in date is selected
				$("#check-out-datepicker").datepicker( "option", "minDate", endDate );

			}
		});

		$( "#check-out-datepicker" ).datepicker({
			inline: true,
			dateFormat: "yy-mm-dd",
			minDate: new Date()
		});

	</script>
</body>
</html>
