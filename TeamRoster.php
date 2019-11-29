<?php 
	include 'header.php';

	include 'crudFileUpload.php';

	$userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);
	$validateUserId = filter_input(INPUT_GET, 'userId', FILTER_VALIDATE_INT);

	$firstName = filter_input(INPUT_GET, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$userIdNotValid = false;

	if($validateUserId){
		//This query will grab all the players belonging to a user's team.
		$query = "SELECT * FROM nbaplayers WHERE userID = :userID";
		$statement = $db->prepare($query);
		$statement->bindValue(':userID', $userId);
		$statement->execute();
		$userFantasyTeam = $statement->fetchAll();
	}else{
		$userIdNotValid = true;
	}

	//Grabs all the comments unique to this user's page made by other users including who made the comment, and the timestamp for when it was made.
	$query2 = "SELECT comment, Date, firstName FROM comments WHERE teamPageId = :userId";
	$statement2 = $db->prepare($query2);
	$statement2->bindValue(':userId', $userId);
	$statement2->execute();
	$teamPageComments = $statement2->fetchAll();

	//Query to check if a user has a set display photo 
	$query3 = "SELECT * FROM users WHERE userID = :userID";
	$statement3 = $db->prepare($query3);
	$statement3->bindValue(':userID', $userId);
	$statement3->execute();
	$userInfo = $statement3->fetch();

?> 

<!DOCTYPE html>
<html>
<head>
	<title>Team Roster</title>
	<link rel="stylesheet" type="text/css" href="TeamRoster.css"/>
</head>
<body>

	<?php if($userIdNotValid): ?>
		<p>The user's team page could not be found.</p>
	<?php else: ?>


		<main>
			<div class="userInfo">
				<figure>
					<!-- Checks to see if a user has set a profile picture and if they have not it will give them a default photo and the option to submit a photo to be used -->
					<?php if($userInfo['profilePicturePath'] == NULL): ?>
						<!-- default photo that will be set -->
						<img src="uploads/thumbnail_default.png">

						<!-- This form to edit account info will only be available if the team roster page belongs to the signed in user -->
						<?php if($userId == $_SESSION['userID']): ?>
							<!-- form that will allow the user to upload a new photo -->
							<form method="post" enctype="multipart/form-data">
								<label for="image">Update Profile Picture:</label>
								<!-- input tag with type "file" will allow us to submit a file to a directory. -->
								<input type="file" name="image" id="image">
								<input type="submit" name="uploadProfilePicture" id="Upload Image">
							</form>
						<?php endif ?>
					<?php endif ?>

					<!-- If a user has uploaded a display photo it will show the photo they have uploaded and give them the option -->
					<?php if($userInfo['profilePicturePath'] != NULL): ?>
						<!-- Sets the user's display photo to the photo they uploaded -->
						<img src="<?= $userInfo['profilePicturePath'] ?>">

						<!-- This form to edit account info will only be available if the team roster page belongs to the signed in user -->
						<?php if($userId == $_SESSION['userID']): ?>
							<!-- form that will allow the user to upload a new photo -->
							<form method="post" enctype="multipart/form-data">
								<label for="image">Remove Profile Picture:</label>
								<!-- input tag with type "file" will allow us to submit a file to a directory. -->
								<button type="submit" name="removeProfilePicture" id="Remove Image">Remove</button>
							</form>
						<?php endif ?>
					<?php endif ?>
				</figure>
				<summary>
					<h1><?= $firstName ?>'s Team</h1>
				</summary>
			</div>

			<section>
				<table>
					<tr>
						<th>NAME</th>
						<th>POS</th>
						<th>MIN</th>
						<th>FT%</th>
						<th>eFG%</th>
						<th>PTS</th>
						<th>REB</th>
						<th>AST</th>
						<th>STL</th>
						<th>BLK</th>
						<th>REMOVE PLAYER</th>
					</tr>
					<?php foreach($userFantasyTeam as $player): ?>
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
							<td><h4><a href="">REMOVE</a></h4></td>
						</tr>
					<?php endforeach ?>
				</table>

				<form action="addComment.php?teamOwner=<?= $firstName ?>" method="POST">

					<label>Comment:</label>

						<textarea name="comment" placeholder="Make a comment.."></textarea>

						<input type="hidden" name="teamPageId" value="<?= $userId ?>">
					<input type="submit" name="post" value="Post">
				</form>

				<h3>All Comments:</h3>
				<?php foreach($teamPageComments as $teamPageComment): ?>
					<p><b><?= $teamPageComment['firstName']?>            </b><span><?= $teamPageComment['Date']?></span></p> 
					<p class="seperate_comments"><?= $teamPageComment['comment'] ?></p>
				<?php endforeach ?>
			</section>
		</main>
	<?php endif ?>

</body>
</html>