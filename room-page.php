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
	<div class="room-page-navbar">
		<a  href="#">Hotels</a>
		<a href="#" class="right"><i class="fa fa-fw fa-user"></i>Profile</a>
		<a href="#" class="right"><i class="fa fa-fw fa-home"></i>Home</a>
	</div>
	<div class="hotel-info-top-bar">
		<div>Megali Vretania Hotel</div>
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
