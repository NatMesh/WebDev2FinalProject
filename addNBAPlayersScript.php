<?php
	include 'header.php';

	$isNotAvailable = 1;

	$playerID = filter_input(INPUT_GET, 'playerID', FILTER_SANITIZE_NUMBER_INT);

	$validatePlayerID = filter_input(INPUT_GET, 'playerID', FILTER_VALIDATE_INT);

	

	if($validatePlayerID){
		$query = "UPDATE nbaplayers SET userID = :userID, isAvailable = :availability WHERE playerID = :playerID";

		$statement = $db->prepare($query);

		$statement->bindValue(':userID', $_SESSION['userID']);
		$statement->bindValue(':availability', $isNotAvailable);
		$statement->bindValue(':playerID', $playerID);

		$statement->execute();

		header('Location: TeamRoster.php');
	} else{
		header('Location: HomePage.php');
	}

	

?>

<!DOCTYPE html>
<html>
<head>
	<title>Available Players</title>
</head>
<body>

</body>
</html>