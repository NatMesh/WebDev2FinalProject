<!-- Connects us to the database using a PDO object and gives us the ability to send queries to our database. -->
<?php
	//beigns a session so we can access our sessions variables that will be set at login.
	session_start();

	//Database_DataSourceName
	define('DB_DSN', 'mysql:host=localhost;dbname=sportsnetfantasypage;charset=utf8');
	//Database User
	define('DB_USER', 'serveruser2');
	//Database Password
	define('DB_PASS', 'gorgonzola7!');

	//Connection error handling
	//we use a try catch to handle any errors generated when creating our PDO object
	try{
		//A PDO aka PHP Data Object allows us to access the functionality provided by a SQL server in an object-oriented manner.
		$db = new PDO(DB_DSN, DB_USER, DB_PASS);
	} catch (PDOException $e){
		print "Error: " . $e->getMessage();
		die();
	}
?>