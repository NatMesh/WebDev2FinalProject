<?php
	require 'connect2.php';

	$fantasyTeamName = filter_input(INPUT_POST, 'fantasyTeamName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$fantasyTeamNameValid = false;



	if(isset($_POST['CreateTeam'])){
		if(strlen($fantasyTeamName) == 0){
			$fantasyTeamNameValid = true;
		}
		else{
		$query = "INSERT INTO userfantasyteam (fantasyTeamName, userId) values (:fantasyTeamName, :userId)";

		$statement = $db->prepare($query);
		$statement -> bindValue(':fantasyTeamName', $fantasyTeamName);
		$statement -> bindvalue(':userId', $_SESSION['userID']);

		$statement -> execute();

		$fantasyTeamID = $db -> lastInsertId();

		$query2 = "UPDATE users SET fantasyTeamID = :fantasyTeamID WHERE userId = :userID";

		
		$statement2 = $db->prepare($query2);

		$statement2->bindValue(':fantasyTeamID', $fantasyTeamID);
		$statement2->bindValue(':userID', $_SESSION['userID']);

		$statement2->execute();

		//FOR NOW WE SEND THEM TO HOMEPAGE BUT LATER ON WE WILL SEND THE USER TO OUR PLAYERS PAGE WHERE THEY CAN ADD PLAYERS THAT HAVE NOT BEEN SELECTED TO THEIR TEAM.

		header('Location: HomePage.php');

		exit();
		}
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Create Team Page</title>
</head>
<body>
	<?php if($fantasyTeamNameValid): ?>
			<h1>An error occured while creating your team.</h1>
			<p>
				Team name was missing.  
			</p>
	<?php endif ?>
</body>
</html>