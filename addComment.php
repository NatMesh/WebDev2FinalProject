<?php 
	include 'header.php';

	$commentGreaterThen240Characters = false;

	$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$teamPageId = filter_input(INPUT_POST, 'teamPageId', FILTER_SANITIZE_NUMBER_INT);

	$validTeamPageId = filter_input(INPUT_POST, 'teamPageId', FILTER_VALIDATE_INT);

	$teamOwner = filter_input(INPUT_GET, 'teamOwner', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$commentLength = strlen($comment);

	if($commentLength <= 240 && $validTeamPageId){
		$query = "INSERT INTO comments (comment, teamPageId, firstName) values (:comment, :teamPageId, :firstName)";
		$statement = $db->prepare($query);
		$statement -> bindValue(':comment', $comment);
		$statement -> bindValue(':teamPageId', $teamPageId);
		$statement -> bindValue(':firstName', $_SESSION['firstName']);
		$statement -> execute();

		print_r($teamPageId);

		print_r($teamOwner);

		header("Location:TeamRoster.php?userId=$teamPageId&firstName=$teamOwner");


	} else{
		$commentGreaterThen240Characters = true;
	}

	

	
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php if($commentGreaterThen240Characters): ?>
		<p>Your comment can not exceed 240 characters.</p>
	<?php endif ?>

</body>
</html>