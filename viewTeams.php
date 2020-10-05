<?php
	include 'header.php';

	$query = "SELECT userfantasyteam.fantasyTeamName, users.firstName, users.lastName, userfantasyteam.userId FROM userfantasyteam JOIN users ON userfantasyteam.userId = users.userID";

	$statement = $db->prepare($query);

	$statement->execute();

	$fantasyTeams = $statement->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Team Viewer</title>
	<link rel="stylesheet" type="text/css" href="AvailablePlayersStyle.css"/>
</head>
<body>
	<?php if(!(isset($_SESSION['firstName']))): ?>
		<p>You must be signed in to view other user's teams.</p>
	<?php else: ?>
		<table>
			<tr>
				<th>User Name</th>
				<th>Team Name</th>
				<th>View Team</th>
			</tr>
		<?php foreach($fantasyTeams as $fantasyTeam): ?>
			<tr>
				<td><?= $fantasyTeam['firstName'] . ' ' . $fantasyTeam['lastName']?></td>
				<td><?= $fantasyTeam['fantasyTeamName'] ?></td>
				<td><h4><a href="TeamRoster.php?userId=<?= $fantasyTeam['userId'] ?>&firstName=<?=  $fantasyTeam['firstName'] ?>">VIEW</a></h4></td>
			</tr>
		<?php endforeach ?>
		</table>
	<?php endif ?>

</body>
</html>