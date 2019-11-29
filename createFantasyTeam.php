<!-- Displays a create team page where users who are authenticated can create a team with a given name and then add players from the players table to their team that are available. -->
<?php 
	include 'header.php';
	$teamExists = false;

	if(!(isset($_SESSION['firstName']))){
		header('Location: login.php');
	}
	else{
		$query = "SELECT * FROM userfantasyteam WHERE userId = :userId";


		$statement = $db->prepare($query);

		$statement -> bindvalue(':userId', $_SESSION['userID']);

		$statement->execute();

		$team = $statement->fetch();

		$count = $statement->rowCount();

		if($count == 1){
			$teamExists = true;
		}
	}	

		
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Create Team</title>
</head>
<body>
	<?php if($teamExists): ?>
		<p>You can not have more then one team.</p>
	<?php else: ?>
		<form action="crudFantasyTeamScript.php" method="POST">
			<fieldset>
				<legend>Create Fantasy Team</legend>
				<p>
					<label>Fantasy Team Name</label>
					<input type="text" name="fantasyTeamName" id="fantasyTeamName">
				</p>

				<p>
					<input type="submit" name="CreateTeam" value="Create Team">
				</p>
			</fieldset>
		</form>
	<?php endif ?>
</body>
</html>