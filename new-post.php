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
		<?php require( 'includes/new-post-parse.php' ); ?>

		<h2>Add New Post</h2>

		<?php show_feedback( $feedback, $feedback_class, $errors ); ?>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" 
			enctype="multipart/form-data">
			<label>Upload a .jpg, .gif or .png</label>

			<input type="file" name="uploadedfile" accept="image/*" required>

			<input type="submit" value="Next: Add Post Details &rarr;">

			<input type="hidden" name="did_upload" value="1">
			
		</form>
	</main>
<?php 
require('includes/sidebar.php'); 
require('includes/footer.php');
?>	