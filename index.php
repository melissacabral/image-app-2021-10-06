<?php require('CONFIG.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Image Sharing App</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css" integrity="sha512-xiunq9hpKsIcz42zt0o2vCo34xV0j6Ny8hgEylN3XBglZDtTZ2nwnqF/Z/TTCc18sGdvCjbFInNd++6q3J0N6g==" crossorigin="anonymous" />

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="site">
	<header class="header">
		<h1>Image Sharing App</h1>
	</header>
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
			<span class="date"><?php echo $row['date']; ?></span>
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
	<aside class="sidebar"></aside>
	<footer class="footer"></footer>
</div>
</body>
</html>