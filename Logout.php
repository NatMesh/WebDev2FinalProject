<?php 
	include 'connect2.php';
	
	session_destroy();

	header('Location: HomePage.php');
?>	