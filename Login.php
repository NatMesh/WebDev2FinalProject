<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
</head>
<body>
	<form action="authenticate.php" method="POST">
		<fieldset>
			<p>
				<label>Email Address</label>
				<input type="email" name="emailAddress" id="emailAddress">
			</p>

			<p>
				<label>Password</label>
				<input type="password" name="password" id="password">
			</p>

			<p>
				<input type="submit" name="SignIn" value="Sign In">
			</p>
		</fieldset>
	</form>
</body>
</html>