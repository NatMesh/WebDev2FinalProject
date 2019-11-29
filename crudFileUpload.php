<?php 

	include 'ImageResize.php';

	use \Gumlet\ImageResize;

	if(isset($_POST['uploadProfilePicture']))
	{
		$imageFileName = $_FILES['image']['name'];
		//echo $imageFileName;

		$uploadFileExtension = pathinfo($imageFileName, PATHINFO_EXTENSION);

		$validUploadTypes = ['jpg', 'png', 'gif', 'pdf'];

		$isValidUploadType = in_array($uploadFileExtension, $validUploadTypes);

		//echo $isValidUploadType;

		if($isValidUploadType)
		{
			if(isset($_FILES['image']) && ($_FILES['image']['error'] == 0))
			{

				$current_folder = dirname(__FILE__);

				$subFolderName = 'uploads';

				//echo $imageFileExtension;

				$imageFileName = basename($_FILES['image']['name']);

				
				 //var_dump($imageFileName);
				//$baseImageFileName = 

				 $newFilePathArray = [$current_folder, $subFolderName, $imageFileName];

				 
				 $newFilePath = implode(DIRECTORY_SEPARATOR, $newFilePathArray);

				 //echo $newFilePath;


				 $temporaryFilePath = $_FILES['image']['tmp_name'];

				 move_uploaded_file($temporaryFilePath, $newFilePath);

				 $fileLocation = $subFolderName . DIRECTORY_SEPARATOR . $imageFileName;

				 var_dump($fileLocation);

				 $image = new \Gumlet\ImageResize($subFolderName . DIRECTORY_SEPARATOR. $imageFileName);
				 $image->resizeToBestFit(150,150);
				 $image->save($fileLocation);

				 var_dump($_SESSION['userID']);

				 //Create the update statement to add the file path of the users profile picture to their row so it can be referenced.
				 $query = "UPDATE users SET profilePicturePath = :fileLocation WHERE userID = :userID";
				 $statement = $db->prepare($query);
				 $statement->bindValue(':fileLocation', $fileLocation);
				 $statement->bindValue(':userID',$_SESSION['userID']);
				 $statement->execute();

			}
		}
	}

	//If statement will start here for opertaions to remove an uploaded image and update the database
	if(isset($_POST['removeProfilePicture']))
	{
		//Grabs the file path for the users info so we can delete from the file directory.
		$query2 = "SELECT * FROM users WHERE userID = :userID";
		$statement2 = $db->prepare($query2);
		$statement2->bindValue(':userID', $_SESSION['userID']);
		$statement2->execute();
		$userInfo = $statement2->fetch();

		if($userInfo['profilePicturePath'] != NULL)
		{
			//Deletes the user's photo from the directory
			unlink($userInfo['profilePicturePath']);
		}

		//Create the update statement to set the user's profilePicturePath to NULL 
		 $query = "UPDATE users SET profilePicturePath = :x WHERE userID = :userID";
		 $statement = $db->prepare($query);
		 $statement->bindValue(':x', "");
		 $statement->bindValue(':userID',$_SESSION['userID']);
		 $statement->execute();


	}
?>