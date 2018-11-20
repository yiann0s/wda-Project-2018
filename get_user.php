<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
$q = intval($_POST['selected_value']);

$city_selection = "Athens";

$con = mysqli_connect('localhost','wda2018','123456','wda2018');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

$sql="SELECT * FROM room WHERE room_id = '".$q."' AND city = '".$city_selection."'";
$result = mysqli_query($con,$sql);

$string = "<table>";
while($row = mysqli_fetch_array($result)) {
    $string  = $string."<tr><td>".$row['room_id']."</td><td>".$row['name']."</td><td>".$row['city']."</td></tr>";
}
$string = $string."</table>";
echo $string;
mysqli_close($con);
?>
</body>
</html> 