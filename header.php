<?php
	include 'connect2.php';
?>

<!-- Be careful with calling scripts with include, if not care they can mess with the html of the current page they are being added to.  -->
	<!-- Try and avoid putting the html and head tags when using script on multiple pages or it might get it wrong. -->
<link rel="stylesheet" type="text/css" href="header.css">

<body>
	<header>
		<nav>
			<ul class="nav_links">
				<li><a href="HomePage.php">Home</a></li>
				<li><a href="AvailablePlayers.php">Available Players</a></li>
				<li><a href="createFantasyTeam.php">Create Fantasy Team</a></li>
				<?php if(isset($_SESSION['firstName'])): ?>
					<?php if($_SESSION['admin'] == 1): ?>
						<li><a href="ModerateUserAccounts.php">User Accounts</a></li>
						<li><a href="ModerateComments.php">Manage Comments</a></li>
					<?php endif ?>

					<li><a href="ViewTeams.php">View Fantasy Teams</a></li>
					<li><a href="TeamRoster.php?userId=<?= $_SESSION['userID']?>&firstName=<?= $_SESSION['firstName']?>">Team Roster</a></li>
					<li><a href="Logout.php">Logout</a></li>
				<?php else: ?>
					<li><a href="CreateUser.php">Sign Up</a></li>
					<li><a href="Login.php">Login</a></li>
				<?php endif ?>
			</ul>
		</nav>
	</header>
</body>