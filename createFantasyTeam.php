<!-- Displays a create team page where users who are authenticated can create a team with a given name and then add players from the players table to their team that are available. -->
<?php 
	include 'connect2.php';

	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Create Team</title>
</head>
<body>
	<h1>hello</h1>

	<form action="crudFantasyTeamScript.php" method="POST">
		<label>Team Name</label>
		<input type="text" name="FantasyTeamName" id="FantasyTeamName">
	</form>
</body>
</html>