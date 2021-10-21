<?php 
require('CONFIG.php'); 
require_once('includes/functions.php');
require('includes/logout-parse.php');
require('includes/login-parse.php');
//doctype 
require('includes/header-no-nav.php'); 
?>
	<main class="content">
		<div class="container important-form">
			<h1>Log In</h1>

			<?php show_feedback( $feedback, $feedback_class, $errors ); ?>

			<form method="post" action="login.php">
				<label>Username</label>
				<input type="text" name="username">

				<label>Password</label>
				<input type="password" name="password">

				<input type="submit" value="Log In" >

				<input type="hidden" name="did_login" value="true">
			</form>
		</div>
	</main>
<?php include('includes/footer.php'); ?>