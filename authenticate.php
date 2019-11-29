<!-- Brings up a prompt to have the user sign in to gain authenticated priviledges. -->
<?php
	include 'header.php';

	$userSignIn = filter_input(INPUT_POST, 'emailAddress', FILTER_SANITIZE_EMAIL);

	$passSignIn = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$isLoginInfoBlank = false;

	$isLoginIncorrect = false;

	$isLoginCorrent = false;

	if(isset($_POST['SignIn'])){
		if(strlen($userSignIn) == 0 || strlen($passSignIn) == 0){
			$isLoginInfoBlank = true;
		}
		else{
			$query = "SELECT * FROM users WHERE emailAddress = '$userSignIn' AND password = '$passSignIn'";

			$statement = $db->prepare($query);

			$statement->execute();

			$user = $statement->fetch();

			$count = $statement->rowCount();

			if($count == 1){
				$_SESSION['firstName'] = $user['firstName'];
				$_SESSION['userID'] = $user['userID'];
				$_SESSION['admin'] = $user['admin'];
				$isLoginCorrent = true;
			}
			else{
				$isLoginIncorrect = true;
			}

			header('Location: HomePage.php');
		}
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php if($isLoginInfoBlank): ?>
		<h1>An error occured while processing your post.</h1>
		<p>
			Information was missing.  
		</p>
	<?php endif ?>

	<?php if($isLoginCorrent): ?>
		<h1>YOU IN!</h1>
		<p>
			Welcome <?= $user['firstName']  ?>
		</p>
	<?php endif ?>

	<?php if($isLoginIncorrect): ?>
		<h1>An error occured while processing your post.</h1>
		<p>
			 Invalid Email Address or Password!
		</p>
	<?php endif ?>
</body>
</html>

