<?php 
	include 'header.php';

	$invalidCommentId = false;

	$commentId = filter_input(INPUT_GET, 'commentId', FILTER_SANITIZE_NUMBER_INT);

	$validCommentId = filter_input(INPUT_GET, 'commentId', FILTER_VALIDATE_INT);

	if($validCommentId){
		$query = "DELETE FROM comments WHERE commentId = :commentId";
		$statement = $db->prepare($query);
		$statement->bindValue(':commentId', $commentId);
		$statement->execute();

		header('Location: ModerateComments.php');
	}else{
		$invalidCommentId = true;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php if($invalidCommentId): ?>
		<p>Comment deletion was unsuccessful.</p>
	<?php endif ?>
</body>
</html>