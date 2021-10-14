<aside class="sidebar">	
	
	<?php 
	//get up to 5 users, newest first
	$result = $DB->prepare('SELECT profile_pic, username
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
						<img src="<?php echo $row['profile_pic']; ?>" width="50" height="50">
						<?php echo $row['username']; ?>
					</li>
				<?php } ?>
			</ul>
		</section>
	<?php } //end if users ?>


	<?php 
	//get up to 20 categories in alpabetical order by name 
	$result = $DB->prepare('SELECT name
							FROM categories
							ORDER BY name ASC
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

					<li><?php echo $row['name']; ?> - X Posts</li>

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