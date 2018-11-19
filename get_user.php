<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
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

$string = "<table><tr><th>Room ID</th><th>name</th><th>city</th></tr>";
while($row = mysqli_fetch_array($result)) {
    $string  = $string."<tr><td>".$row['room_id']."</td><td>".$row['name']."</td><td>".$row['city']."</td></tr>";
}
$string = $string."</table>";
echo $string;
mysqli_close($con);
?>
</body>
</html> 