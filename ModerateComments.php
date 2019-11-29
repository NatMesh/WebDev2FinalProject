<?php 
	include 'header.php';

	$query = "SELECT * FROM comments";
	$statement = $db->prepare($query);
	$statement->execute();
	$userComments = $statement->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Comments</title>
	<link rel="stylesheet" type="text/css" href="AvailablePlayersStyle.css">
</head>
<body>
	<table>
		<tr>
			<th>Commenter Name</th>
			<th>Comment</th>
			<th>Date of Comment</th>
			<th>Edit Comment</th>
			<th>Delete Comment</th>
		</tr>

		<?php foreach($userComments as $userComment): ?>
			<tr>
				<td><?= $userComment['firstName'] ?></td>
				<td><?= $userComment['comment'] ?></td>
				<td><?= $userComment['Date'] ?></td>
				<td><h4><a href="">EDIT</a></h4></td>
				<td><h4><a href="DeleteComments.php?commentId=<?= $userComment['commentId'] ?>">DELETE</a></h4></td>
			</tr>
		<?php endforeach ?>
	</table>
</body>
</html>