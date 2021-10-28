<?php 
$logged_in_user = check_login(); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Image Sharing App</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css" integrity="sha512-xiunq9hpKsIcz42zt0o2vCo34xV0j6Ny8hgEylN3XBglZDtTZ2nwnqF/Z/TTCc18sGdvCjbFInNd++6q3J0N6g==" crossorigin="anonymous" />

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="<?php echo_if_exists( $body_class ); ?>">
<div class="site">
	<header class="header">
		<h1>
			<a href="<?php echo SITEROOT; ?>">
				Image Sharing App
			</a>
		</h1>

		<nav class="main-navigation">
			<form class="searchform" action="search.php" method="get">
				<input type="search" name="phrase">
				<input type="submit" value="search">
				<input type="hidden" name="page" value="1">
			</form>

			<ul class="menu">
			<?php if( ! $logged_in_user ){ ?>
				<!-- logged out menu -->
				<li><a href="register.php">Sign up</a></li>
				<li><a href="login.php">Log In</a></li>
			<?php }else{ ?>
				<!-- logged in menu -->
				<li><a href="new-post.php">&plus; Post</a></li>
				<li class="user"><a href="profile.php?user_id=<?php echo $logged_in_user['user_id']; ?>">
					<?php show_profile_pic( $logged_in_user['profile_pic'], 35 ); ?>
					</a>
				</li>
				<li><a href="login.php?action=logout">Log Out</a></li>
			<?php } ?>
			</ul>
		</nav>
	</header>