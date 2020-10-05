<?php
	include 'header.php';

	$isTeamMaxPlayers = false;

	$isTeamNotCreated = false;

	$userCanAddPlayers = false;

	$orderValue = filter_input(INPUT_GET, 'orderValue', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$isOrderValuePassed = true;

	if (is_null($orderValue)) {
		$isOrderValuePassed = false;
	}

	//We can concatenate the wild cards % that will let us search for a name that has the search value in any position. 
		//You tried to pass it as one string into the query but nothing was returned because it was searching for the % symbols as well.
	$userSearch = '%' . filter_input(INPUT_POST, 'searchValue', FILTER_SANITIZE_FULL_SPECIAL_CHARS) . '%';

	//Search value based on player catagory
	$playerPosition = filter_input(INPUT_POST, 'positions', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
	}
	else if($teamPlayersCount >= 11){
		$isTeamMaxPlayers = true;
	}
	else if(isset($_POST['Search'])){
		//Creates a players table based on the users search
		$query4 = "SELECT * FROM nbaplayers WHERE NAME LIKE :userSearch AND POS =  :position";

		//INCLUDE INTERNAL IF STATEMENTS TO CONCAT FOR MORE SPECIFIC SEARCH.

		$statement4 = $db->prepare($query4);

		$statement4 -> bindValue(':userSearch', $userSearch);

		$statement4 -> bindValue(':position', $playerPosition);
		$statement4 -> execute();

		$players = $statement4->fetchAll();

		$userCanAddPlayers = true;
	}
	else if ($isOrderValuePassed){
		$query = "SELECT * FROM nbaplayers WHERE userID = 0 AND isAvailable = 0 ORDER BY";

		if($orderValue == 'PTS')
		{
			$query .= ' PTS DESC';
		}


		if($orderValue == 'REB')
		{
			$query .= ' REB DESC';
		}

		if($orderValue == 'AST')
		{
			$query .= ' AST DESC';
		}


		

		$statement = $db->prepare($query);

		$statement -> bindValue(':orderValue', $orderValue);

		$statement->execute();

		$players = $statement->fetchAll();


		$userCanAddPlayers = true;
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
			<!-- ADD THE RADIO BUTTONS FOR POSITIONAL CATAGORIES -->
		<form action="AvailablePlayers.php" method="POST">
			<fieldset>
				<p>Choose a position catagory:</p>
				<select name="positions" id="positions">
					<!-- We can leave the value as blank and this will simply return all values of that column applying no condition to the search. -->
					<option value="">All Positions</option>
					<option value="G">Guard</option>
					<option value="F">Forward</option>
					<option value="C">Center</option>
					<option value="G-F">Guard and Forward</option>
					<option value="F-G">Forward and Guard</option>
					<option value="F-C">Forward and Center</option>
					<option value="C-F">Center and Forward</option>
				</select>
			</fieldset>
			

			<label>search by player name:</label>
			<input type="text" name="searchValue" id="searchValue">
			<input type="submit" name="Search" value="Search">
		</form>

		<!-- This table will display all nbaplayers that are available to be added to a team. -->
		<table>
			<tr>
				<th>FULL NAME</th>
				<th>POS</th>
				<th>MIN</th>
				<th>FT%</th>
				<th>eFG%</th>
				<th><a href="AvailablePlayers.php?orderValue=PTS">PTS</a></th>
				<th><a href="AvailablePlayers.php?orderValue=REB">REB</a></th>
				<th><a href="AvailablePlayers.php?orderValue=AST">AST</a></th>
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