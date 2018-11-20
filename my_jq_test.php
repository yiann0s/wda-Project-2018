<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My JQ example</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
     $(document).ready(function() {

            $("#submit").on('click',function(){
			console.log("onclick called");
            $.ajax({
            url: "post.php",
			async: true,
            type: "POST",
            data: {
                city: $("#city").val(),
                guest_count: $("#guest-count").val(),
                name: $("#name").val(),
            },
            dataType: "JSON",
            success: function (jsonStr) {
                $("#result").text(JSON.stringify(jsonStr));
            }
        });

    });

    });
    </script>
    </head>
    <body>
    <h1>jQuery Ajax Jason example</h1>
	<form name="contact" id="contact" >
		 City : <input type="text" name="cityName" id="city"/><br/>
		 Guest Count : <input type="text" name="guestCount" id="guest-count"/><br/>
		 Name : <input type="text" name="roomName" id="name"/><br/>
		<input type="button" value="Submit" name="submit" id="submit"/>
	</form>
	<div id="result"></div>
    </body>
</html>