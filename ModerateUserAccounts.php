<?php 
	include 'header.php';

	$query = "SELECT * FROM users WHERE admin = 0";
	$statement = $db->prepare($query);
	$statement->execute();
	$userAccounts = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
	<title>User Accounts</title>
	<link rel="stylesheet" type="text/css" href="AvailablePlayersStyle.css">
</head>
<body>
	<table>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email Address</th>
			<th>Edit Account</th>
			<th>Delete Account</th>
		</tr>
		<?php foreach($userAccounts as $userAccount): ?>
			<tr>
				<td><?= $userAccount['firstName'] ?></td>
				<td><?= $userAccount['lastName'] ?></td>
				<td><?= $userAccount['emailAddress'] ?></td>
				<td><h4><a href="">EDIT</a></h4></td>
				<td><h4><a href="">DELETE</a></h4></td>
			</tr>
		<?php endforeach ?>
	</table>
</body>
</html>