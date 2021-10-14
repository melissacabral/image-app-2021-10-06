<?php 
require('CONFIG.php'); 
require_once('includes/functions.php');
require('includes/header.php');
?>
	<main class="content">
		<?php 
		//1. Write it. get all published posts, newest first
		$result = $DB->prepare('SELECT image, title, body, date
								FROM posts
								WHERE is_published = 1
								ORDER BY date DESC'); 
		//2. run it
		$result->execute();
		//3. check it - did we find any posts?	
		if( $result->rowCount() >= 1 ){			
			//4. loop it - once per row
			while( $row = $result->fetch() ){
		?>
		<div class="one-post">
			<img src="<?php echo $row['image']; ?>">
			<h2><?php echo $row['title']; ?></h2>
			<p><?php echo $row['body']; ?></p>
			<span class="date"><?php echo time_ago( $row['date'] ); ?></span>
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