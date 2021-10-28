<aside class="sidebar">	
	
	<?php 
	//get up to 5 users, newest first
	$result = $DB->prepare('SELECT profile_pic, username, user_id
							FROM users
							ORDER BY user_id DESC
							LIMIT 5');
	//run it
	$result->execute();
	//check it
	if( $result->rowCount() >= 1 ){	 
		?>	
		<section class="users">
			<h2>Newest Users</h2>
			<ul>
				<?php while( $row = $result->fetch() ){ ?>
					<li class="user">
						<a href="profile.php?user_id=<?php echo $row['user_id']; ?>">
							<?php show_profile_pic( $row['profile_pic'], 40 ); ?>
							<?php echo $row['username']; ?>
						</a>
					</li>
				<?php } ?>
			</ul>
		</section>
	<?php } //end if users ?>


	<?php 
	//get up to 20 categories in alpabetical order by name 
	$result = $DB->prepare('SELECT categories.name, COUNT(*) AS total
							FROM posts, categories
							WHERE categories.category_id = posts.category_id
							GROUP BY posts.category_id
							LIMIT 20');
	//run it
	$result->execute();
	//check it
	if( $result->rowCount() >= 1 ){
		?>
		<section class="categories">
			<h2>Categories</h2>
			<ul>
				<?php while( $row = $result->fetch() ){ ?>

					<li><?php echo $row['name']; ?> - <?php echo $row['total']; ?> Posts</li>

				<?php } ?>
			</ul>
		</section>
	<?php } //end if categories ?>

	<?php 
	//get up to 20 tags in alpabetical order by name 
	$result = $DB->prepare('SELECT name
							FROM tags
							ORDER BY name ASC
							LIMIT 20');
	//run it
	$result->execute();
	//check it
	if( $result->rowCount() >= 1 ){
		?>
		<section class="tags">
			<h2>Tags</h2>
			<ul>
				<?php while( $row = $result->fetch() ){ ?>

					<li><?php echo $row['name']; ?> - X Posts</li>

				<?php } ?>
			</ul>
		</section>
	<?php } //end if tags ?>

</aside>