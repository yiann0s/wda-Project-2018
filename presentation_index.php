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
if (!$connect){
	die("Error:".mysql_error($connect));
}
// mysql select query
$city_query = "SELECT DISTINCT city FROM `room`";


$result = mysqli_query($connect, $city_query);
$cities = array();
if (mysql_num_rows($result)>0){
	while ( $row = mysql_fetch_assoc($result)){
		$cities[] = $row;
	}
}

$result1 = mysqli_query($connect, $room_type_query);

//var_dump($cities)
var_dump($_POST)

if (isset($_POST('request'))){
		// mysql select query
	$city_query = "SELECT *
					FROM `room`
					WHERE `city` = '".$_POST[city]."'
					ORDER BY city ASC";


	$result = mysqli_query($connect, $city_query);
	$cities = array();
	if (mysql_num_rows($result)>0){
		while ( $row = mysql_fetch_assoc($result)){
			$cities[] = $row;
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>my test page </title>
  <style>
	html,
	body {
		margin: 0;
		padding: 0;
		width: 40%;
		height: 100%;
		background: #FFFFFF;
		
	}
	
	.text-align {
		text-align: center;
	}
	.center-space {
		max-width: 400px;
		margin: 30% auto;
		padding: 2rem 4em;
		background: #fff;
		
	}
	
	.form-container select {
		display: inline-block;
		min-width: 120px;
	}
	
	.button {
		padding: 0.5 rem 1em;
		border: 1px solid #coc;
		background: #fff;
	}
	
	.button::hover {
		cursor: pointer;
		background: FFFFFF;
	}
	
  </style>
</head>
<body>
 <div class="screen-center" form="container-align">
  <select>
  <?php echo $row['city']>
  </select>
 </div>
</body>
</html>