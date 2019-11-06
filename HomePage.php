<?php 
	include 'connect2.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>SportsNet Fantasy Page</title>
	<!-- add icon to link -->
		<!-- Of icon rel, href is file path, type is image/icon -->
	<link rel="icon" href="SNLogo.png" type="image/icon">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<a href="createFantasyTeam.php">Create Fantasy Team</a>
	<?php if(isset($_SESSION['firstName'])): ?>
		<a href="Logout.php">Logout</a>
	<?php else: ?>
		<a href="CreateUser.php">Sign Up</a>
		<a href="Login.php">Login</a>
	<?php endif ?>


</body>
</html>