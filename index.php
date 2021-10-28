<?php 
require('CONFIG.php'); 
require_once('includes/functions.php');
require('includes/header.php');
?>
	<main class="content">
		<?php 
		//1. Write it. get all published posts, newest first
		$result = $DB->prepare('SELECT posts.post_id, posts.image, posts.title, posts.body, posts.date, users.username, users.profile_pic, users.user_id, categories.name
								FROM posts, users, categories
								WHERE posts.is_published = 1
								AND users.user_id = posts.user_id
								AND categories.category_id = posts.category_id
								ORDER BY posts.date DESC
								LIMIT 20'); 
		//2. run it
		$result->execute();
		//3. check it - did we find any posts?	
		if( $result->rowCount() >= 1 ){			
			//4. loop it - once per row
			while( $row = $result->fetch() ){
		?>
		<div class="one-post">
			<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
				<?php show_post_image( $row['image'] ) ?>
			</a>

			<?php 
			//show this button if the logged in viewer is the author
			if( $logged_in_user AND $logged_in_user['user_id'] == $row['user_id'] ){ ?>
			<br>
			<a href="edit-post.php?post_id=<?php echo $row['post_id']; ?>" 
				class="button button-outline">Edit</a>
			<?php } ?>


			<span class="author">
				<?php show_profile_pic( $row['profile_pic'] ); ?>
				<?php echo $row['username']; ?>
			</span>

			<h2><?php echo $row['title']; ?></h2>
			<p><?php echo $row['body']; ?></p>

			<span class="category"><?php echo $row['name']; ?></span>

			<span class="date"><?php echo time_ago( $row['date'] ); ?></span>

			<span class="comment-count"><?php count_comments( $row['post_id'] ); ?></span>
		</div>		

		<?php 
			} //end while loop
		}else{ ?>
		
		<div class="feedback">
			<h2>Sorry</h2>
			<p>No posts found. Try a search instead.</p>
		</div>

		<?php }//end if posts found ?>

	</main>
<?php 
require('includes/sidebar.php'); 
require('includes/footer.php');
?>	