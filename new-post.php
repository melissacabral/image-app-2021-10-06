<?php 
require('CONFIG.php'); 
require_once('includes/functions.php');
require('includes/header.php');
//kill the page if not logged in
if( ! $logged_in_user ){
	exit('This page is for logged in users only');
}
?>
	<main class="content">
		<h2>Add New Post</h2>
		<p>If you can see this page, you must be logged in</p>
	</main>
<?php 
require('includes/sidebar.php'); 
require('includes/footer.php');
?>	