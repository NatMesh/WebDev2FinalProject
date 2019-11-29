<?php
	include 'header.php';

	$isTeamMaxPlayers = false;

	$isTeamNotCreated = false;

	$userCanAddPlayers = false;

	//Query to check if a user has created a fantasy team before trying to add players.
	$query3 = "SELECT * FROM userfantasyteam WHERE userId = :userID";
	$statement3 = $db->prepare($query3);
	$statement3->bindValue('userID', $_SESSION['userID']);
	$statement3->execute();
	$userFantasyTeam = $statement3->fetchAll();
	$userFantasyTeamCount = $statement3->rowCount();

	//Query to see if a user has less then 11 players so they can add more to their team
	//A USER CAN ONLY HAVE A MAX OF 11 PLAYERS ON THEIR TEAM.
	$query2 = "SELECT * FROM nbaplayers WHERE userID = :userID";
	$statement2 = $db->prepare($query2);
	$statement2->bindValue(':userID', $_SESSION['userID']);
	$statement2->execute();
	$teamPlayers = $statement2->fetchAll();
	$teamPlayersCount = $statement2->rowCount();


	// A fantasyTeamID of 0 means the player is not belonging to any team
		//If the value is anything other then 0 they belong to a team.
	// A isAvailable value of 0 means the player is available to be added to a user's team
		//If the value is 1 they belong to a team

	if(!(isset($_SESSION['firstName']))){
		header('Location: login.php');
	}
	else if($userFantasyTeamCount != 1){
		$isTeamNotCreated = true;
		var_dump($isTeamNotCreated);
	}
	else if($teamPlayersCount >= 11){
		$isTeamMaxPlayers = true;
	}
	else{
		//This query will grab all players from our nbaplayers table that are not owned by any team.
		$query = "SELECT * FROM nbaplayers WHERE userID = 0 AND isAvailable = 0";

		$statement = $db->prepare($query);

		$statement->execute();

		$players = $statement->fetchAll();

		$userCanAddPlayers = true;
	}
	

?>

<!DOCTYPE html>
<html>
<head>
	<title>Players table</title>
	<link rel="stylesheet" type="text/css" href="AvailablePlayersStyle.css"/>
</head>
<body>
	<?php if($isTeamNotCreated): ?>
		<p>You need to create a team before you can add players.</p>
	<?php endif ?>

	<?php if($isTeamMaxPlayers): ?>
		<p>You can only have 11 players on your team. You can remove players from your team roster to add new one.</p>
	<?php endif ?>

	<?php if($userCanAddPlayers): ?>
		<h1>Available Players</h1>

		<!-- This table will display all nbaplayers that are available to be added to a team. -->
		<table>
			<tr>
				<th>FULL NAME</th>
				<th>POS</th>
				<th>MIN</th>
				<th>FT%</th>
				<th>eFG%</th>
				<th>PTS</th>
				<th>REB</th>
				<th>AST</th>
				<th>STL</th>
				<th>BLK</th>
				<th>ADD PLAYER</th>
			</tr>
			<?php foreach ($players as $player): ?>
				<tr>
					<td><?= $player['NAME'] ?></td>
					<td><?= $player['POS'] ?></td>
					<td><?= $player['MIN'] ?></td>
					<td><?= $player['FT%'] ?></td>
					<td><?= $player['eFG%'] ?></td>
					<td><?= $player['PTS'] ?></td>
					<td><?= $player['REB'] ?></td>
					<td><?= $player['AST'] ?></td>
					<td><?= $player['STL'] ?></td>
					<td><?= $player['BLK'] ?></td>
					<!-- When you do not have a form and want to pass data to another page just use a GET Parameter and pass it through the super global. -->
						<!-- You can always still use a cookie or session variable. -->
					<td><h4><a href="addNBAPlayersScript.php?playerID=<?= $player['playerID'] ?>">ADD</a></h4></td>
				</tr>
			<?php endforeach ?>
		</table>
	<?php endif ?>
</body>
</html>