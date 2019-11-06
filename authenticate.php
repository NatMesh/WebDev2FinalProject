<!-- Brings up a prompt to have the user sign in to gain authenticated priviledges. -->
<?php
	include 'connect2.php';

	$userSignIn = filter_input(INPUT_POST, 'emailAddress', FILTER_SANITIZE_EMAIL);

	$passSignIn = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$isLoginInfoBlank = false;

	$isLoginIncorrect = false;

	if(isset($_POST['SignIn'])){
		if(strlen($userSignIn) == 0 || strlen($passSignIn) == 0){
			$isLoginInfoBlank = true;
		}
		else{
			$query = "SELECT * FROM users WHERE emailAddress = '$userSignIn' AND password = '$passSignIn'";

			$statement = $db->prepare($query);

			$statement->execute();

			$count = $statement->rowCount();

			if($count == 1){
				$_SESSION['firstName'] = $query['firstName'];
				$_SESSION['userID'] = $query['userID'];

				header('Location: HomePage.php');
				exit();
			}
			else{
				$isLoginIncorrect = true;
			}

			
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
		<a href="HomePage.php">Return Home</a>
	<?php endif ?>

	<?php if($isLoginIncorrect): ?>
		<h1>An error occured while processing your post.</h1>
		<p>
			 Invalid Email Address or Password!
		</p>
		<a href="HomePage.php">Return Home</a>
	<?php endif ?>
</body>
</html>

