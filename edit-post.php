<?php 
require('CONFIG.php'); 
require_once('includes/functions.php');
require('includes/header.php');
//kill the page if not logged in
if( ! $logged_in_user ){
	exit('This page is for logged in users only');
}
//which post are we editing?
$post_id = filter_var( $_GET['post_id'], FILTER_SANITIZE_NUMBER_INT );
?>
	<main class="content">
		<?php require( 'includes/edit-post-parse.php' ); ?>

		<h2>Edit Your Post</h2>

		<?php show_feedback( $feedback, $feedback_class, $errors ); ?>

		<img src="uploads/<?php echo $image; ?>_medium.jpg">

		<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<label>Title</label>
			<input type="text" name="title" value="<?php echo $title; ?>">

			<label>Caption</label>
			<textarea name="body"><?php echo $body; ?></textarea>

			<?php //get all the categories in alphabetical order
			$result = $DB->prepare('SELECT * FROM categories 
									ORDER BY name ASC');
			$result->execute();
			if( $result->rowCount() >= 1 ){ ?>
			<label>Category</label>
			<select name="category_id">
				<?php while( $row = $result->fetch() ){ ?>
				<option value="<?php echo $row['category_id']; ?>">
					<?php echo $row['name']; ?>
				</option>
				<?php } ?>
			</select>
			<?php } ?>

			<label>
				<input type="checkbox" name="allow_comments" value="1" <?php 
					checked( $allow_comments, 1 ); ?>>
				Allow Comments on this post
			</label>

			<label>
				<input type="checkbox" name="is_published" value="1" <?php 
					checked( $is_published, 1 ); ?>>
				Make this post public
			</label>

			<input type="submit" value="Save Post">
			<input type="hidden" name="did_edit" value="1">
			
		</form>
	</main>
<?php 
require('includes/sidebar.php'); 
require('includes/footer.php');
?>	