<?php
    if(isset($_POST["message"])){
		$message      = $_POST["message"];
		$firstName   = $_POST["firstName"];
		$lastName    = $_POST["lastName"];
		$email       = $_POST["email"];
        $data = array(
            "User message"     => $message,
            "User firstName"  => $firstName,
            "User lastName"   => $lastName,
            "User email"      => $email
        );
        echo json_encode($data);
    } else {
		echo "post message is not set";
	}
?>
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

            $("#submit").click(function(){
			console.log("onclick called");
            $.ajax({
            //url: "post.php",
			url: "<?php echo $_SERVER['PHP_SELF']; ?>",
			async: true,
            type: "POST",
            data: {
                message: $("#message").val(),
                firstName: $("#firstName").val(),
                lastName: $("#lastName").val(),
                email: $("#email").val()
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
	<form name="contact" id="contact" method="post">
	 Message : <textarea name="message" id="message"></textarea><br/>
	 firstName : <input type="text" name="firstName" id="firstName"/><br/>
	 lastName : <input type="text" name="lastName" id="lastName"/><br/>
	 email : <input type="text" name="email" id="email"/><br/>
	<input type="button" value="Submit" name="submit" id="submit"/>
	</form>
	<div id="result"></div>
    </body>
</html>