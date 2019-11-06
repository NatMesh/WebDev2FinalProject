<?php
	include 'connect2.php';

	$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$emailAddress = filter_input(INPUT_POST, 'emailAddress', FILTER_SANITIZE_EMAIL);

	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$accountSignUpNotValid = false;

	if(isset($_POST['Create'])){
		if(strlen($firstName) == 0 || strlen($lastName) == 0 || strlen($emailAddress) == 0 || strlen($password) == 0){
			$accountSignUpNotValid = true;
		}
		else{
			$query = "INSERT INTO users (firstName, lastName, emailAddress, password) values (:firstName, :lastName, :emailAddress, :password)";
			$statement = $db->prepare($query);
			$statement -> bindValue(':firstName', $firstName);
			$statement -> bindValue(':lastName', $lastName);
			$statement -> bindValue(':emailAddress', $emailAddress);
			$statement -> bindValue(':password', $password);

			$statement -> execute();

			header('Location: HomePage.php');

			exit();
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php if($accountSignUpNotValid): ?>
			<h1>An error occured while processing your post.</h1>
			<p>
				info was missing.  
			</p>
			<a href="HomePage.php">Return Home</a>
	<?php endif ?>
</body>
</html>
