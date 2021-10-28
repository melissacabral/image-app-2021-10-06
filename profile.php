<?php 
require('CONFIG.php'); 
require_once('includes/functions.php');
require('includes/header.php');

//which user are we showing? URL will be profile.php?user_id=X
if( isset($_GET['user_id']) ){
	$user_id = filter_var( $_GET['user_id'], FILTER_SANITIZE_NUMBER_INT );
	//make sure it isn't blank
	if( '' == $user_id  ){
		$user_id = 0;
	}
}else{
	$user_id = 0;
}
?>
	<main class="content grid">
		<?php 
		//Get this user's info as well as any published posts they've written
		$result = $DB->prepare('SELECT posts.*, users.username, users.bio, 
									users.profile_pic
								FROM users
								LEFT JOIN posts
									ON (posts.user_id = users.user_id 
										AND posts.is_published = 1)
								WHERE users.user_id = ?
								ORDER BY posts.date DESC
								LIMIT 20'); 
		//2. run it
		$result->execute( array($user_id) );
		//3. check it - did we find any posts?	
		if( $result->rowCount() >= 1 ){
			$count = 1;			
			//4. loop it - once per row
			while( $row = $result->fetch() ){
				if( $count == 1 ){
					//big bio and post
		?>
		<div class="important">
			<div class="author author-profile">
				<img src="<?php echo $row['profile_pic']; ?>">
				<h2><?php echo $row['username']; ?></h2>
				<p><?php echo $row['bio']; ?></p>
			</div>

			<div class="follows grid">
				<div class="item">XXX <br> Followers</div>
				<div class="item">XX <br> Following</div>
				<?php 
				//if this profile belongs to the logged in user, show a "edit profile button", otherwise show the follow button
				if( $logged_in_user AND $user_id == $logged_in_user['user_id'] ){ ?>
					<div class="item"><a class="button" href="#">Edit Profile</a></div>
				<?php }else{?>
					<div class="item"><button>Follow</button></div>
				<?php } ?>
			</div>

			<?php //if this user has a post, show it, otherwise this is a blank profile
			if( $row['image'] != '' ){ ?>
			<div class="big-post one-post">
				<?php show_post_image($row['image'], 'xlarge'); ?>
			</div><!-- end .post -->
			<?php }else{
				echo '<div>This user hasn\'t made any posts yet.</div>';
			} ?>
		</div><!-- end .important -->

		<?php
				}else{
					//little post
		?>
		<div class="one-post little-post item">
			<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
				<?php show_post_image( $row['image'], 'small' ) ?>
			</a>
		</div>		

		<?php 
				}//end if 

			//make the count increase by 1
			$count++;

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