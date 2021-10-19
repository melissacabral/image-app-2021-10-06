<?php 
require('CONFIG.php'); 
require_once('includes/functions.php');

//CONFIG. How many posts per page?
$per_page = 4;

//what did they search for?
$phrase = filter_var( $_GET['phrase'], FILTER_SANITIZE_STRING );

require('includes/header.php');
?>
	<main class="content">

		<?php 
		if( $phrase != '' ){
			//get all the published posts about this phrase
			$result = $DB->prepare('SELECT * FROM posts
									WHERE is_published = 1
									AND (
										title LIKE :phrase
										OR body LIKE :phrase
									)');
			$result->execute( array( 'phrase' => "%$phrase%") );
			//how many total results found?
			$total = $result->rowCount();

			//how many pages will it take to hold them? (round up because there's no "half" page)
			$max_pages = ceil($total/$per_page);

			//what page are we on? URL will be like search.php?phrase=bla&page=2
			$current_page = filter_var( $_GET['page'], FILTER_SANITIZE_NUMBER_INT );

			//make sure the current page is valid
			if( $current_page < 1 OR $current_page > $max_pages ){
				$current_page = 1;
			}

			//create the offset for the SQL LIMIT
			$offset = ( $current_page - 1 ) * $per_page;

			//write the query again, this time with the LIMIT
			$result = $DB->prepare('SELECT * FROM posts
									WHERE is_published = 1
									AND (
										title LIKE :phrase
										OR body LIKE :phrase
									)
									LIMIT :offset, :per_page');
			//must use trict datatypes with bindParam because LIMIT requires integers
			$wildcard_phrase =  "%$phrase%";
			$result->bindParam( 'phrase', $wildcard_phrase, 	PDO::PARAM_STR );
			$result->bindParam( 'offset', $offset, 				PDO::PARAM_INT );
			$result->bindParam( 'per_page', $per_page, 			PDO::PARAM_INT );	
			
			$result->execute();	

		 ?>
		<section class="title">
			<h2>Search Results for <?php echo $phrase; ?></h2>
			<h3><?php echo $total; ?> posts found</h3>
			<h3>Showing page <?php echo $current_page; ?> of <?php echo $max_pages; ?></h3>
		</section>

		<?php if( $total >= 1 ){ ?>
		<section class="grid">
			
			<?php while( $row = $result->fetch() ){ ?>
			<div class="item">
				<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
					<img src="<?php echo $row['image']; ?>" width="150" height="150">

					<h3><?php echo $row['title']; ?></h3>
					<span class="date"><?php nice_date($row['date']); ?></span>
				</a>
			</div>
			<?php } //end while  ?>

		</section> <!-- end .grid -->

		<section class="pagination">
			<?php //variables for the neighboring pages
			$prev = $current_page - 1;
			$next = $current_page + 1; 

			if( $current_page != 1 ){
			?>
			<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $prev; ?>" class="button">
				&larr; Previous
			</a>
			<?php } 

			if( $current_page != $max_pages ){
			?>
			<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next; ?>" class="button">
				Next &rarr;
			</a>
			<?php } ?>

		</section>
		<?php } //end if total?>

		<?php 
		}else{
			echo 'Invalid Search';
		} 
		?>
	</main>
<?php 
require('includes/sidebar.php'); 
require('includes/footer.php');
?>	