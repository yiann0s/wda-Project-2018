<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My AJAX examples</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
	$(document).ready(function(){
		$("#my-btn").on("click", function(){
			// console.log("value selected: "+$('#selection-value').val());
			//$('#message').html("<div style='color:green'>The value was "+$('#selection-value').val()+"</div>");
			if ($('#selection-value').val() == "") {
				$('#message').html("<div style='color:red'>The value was empty</div>");
				return;
			} else {
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				var data = new FormData();
				data.append('selected_value',$('#selection-value').val());
				
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("txtHint").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("POST","get_user.php",true);
				xmlhttp.send(data);
			}
		});
	});
  </script>
</head>
<body>
<form>
	<select id="selection-value"">
		<option value="" disabled selected>Select a number:</option>
		<option value="1">One</option>
		<option value="2">Two</option>
		<option value="3">Three</option>
		<option value="4">Four</option>
	</select>
	<input type="button" id="my-btn" value="Show">
</form>
<br>
<div id="txtHint"></div>

</body>
</html>