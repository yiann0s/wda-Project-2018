
<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
<script>
	function isValidEMail(id){
		var emailField = document.getElementById(id);
		console.log("value of mail is "+emailField.value);
		if (emailField.value.search('@') !== -1){
			return true;
		} else {
			alert("please check your email field");
			emailField.style = " border: 3px solid red";
			document.getElementById('errors').innerHTML = "Your email must have a @ ";
			return false;
		}
	}
	function isValidEMailJQ(id){
		var $emailField = $('#'+id);
		console.log("value of mail is "+$emailField.value);
		if (emailField.value.search('@') !== -1){
			return true;
		} else {
			alert("please check your email field");
			emailField.style = " border: 3px solid red";
			$('#errors').innerHTML = "Your email must have a @ ";
			return false;
		}
	}
	
	function resetErrors(id){
		document.getElementById('errors').innerHTML = '';
		document.getElementById(id).style = "border: 1px solid ThreeDLightShadow";
	}
</script>
</head>
<body>  
<div><?php 

?>

<h2>PHP Form Validation Example</h2>
<div id="errors"> </div>
<!-- <form onsubmit="alert('TEST')" method="post" action="<?php echo ($_SERVER["PHP_SELF"]);?>"> -->
<form onsubmit="return isValidEMail('e-mail-field')" method="post" action="<?php echo ($_SERVER["PHP_SELF"]);?>">  
  E-mail: <input onfocus="resetErrors(this.id)" id="e-mail-field" type="text" name="email" >
 
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
echo "<h2>Your Input:</h2>";
echo "<br>";
?>

</body>
</html>
