<?php 
session_start();
?>

<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>

	<div id="register">
			<h1>Expenses Tracker</h1>
			<?php 
				if(isset($_SESSION['errors']))
				{
					foreach ($_SESSION['errors'] as $value)
					{
						echo "<p id='errors'>" . $value . "</p>";
					}
					unset($_SESSION['errors']);
				}
			?>

		<form action='process.php' method='post'>
			<input type='hidden' name='action' value='register_user'>
			<label>Your Name: </label><input type='text' name='name' placeholder='Enter Name'><br>
			<label>Your Starting Budget($): </label><input type='text' name='budget' placeholder='Enter Budget'><br><br>
			<input class='btn' id='submit' type='submit' name='register' value='Submit'>
		</form>
	</div>	

</body>
</html>