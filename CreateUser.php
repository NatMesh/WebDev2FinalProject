<!-- Displays a create user page where someone can sign up and create an account on this website. -->
<?php 

?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
</head>
<body>
	<form action="crudUserScript.php" method="POST">
		<fieldset>
			<legend>Create Account</legend>
			<p>
				<label>First Name</label>
				<input type="text" name="firstName" id="firstName">
			</p>

			<p>
				<label>Last Name</label>
				<input type="text" name="lastName" id="lastName">
			</p>

			<p>
				<label>Email Address</label>
				<input type="email" name="emailAddress" id="emailAddress">
			</p>

			<p>
				<label>Password</label>
				<input type="password" name="password" id="password">
			</p>

			<p>
				<input type="submit" name="Create" value="Sign Up">
			</p>
		</fieldset>
	</form>
</body>
</html>