<?php 
//This is an example file to show basic rating functionality on a page that show multiple posts. pay attention to lines 24 and 44-75
require('CONFIG.php'); 
require_once('includes/functions.php');
require('includes/header.php');
?>
<main class="content">
	<h1>Rating Example</h1>
	<div class="grid">
		<?php 
		//get all the posts so we have something to rate
		$result = $DB->prepare('SELECT *
			FROM posts
			WHERE is_published = 1
			ORDER BY posts.date DESC
			LIMIT 20'); 
		$result->execute();
		if( $result->rowCount() >= 1 ){			
			while( $row = $result->fetch() ){
				?>
				<div class="item">			
					<?php show_post_image( $row['image'] ) ?>

					<!-- this container has to be here -->
					<div class="rating-container">
					<?php rating_interface($row['post_id'], $logged_in_user['user_id']); ?>	
					</div>	
				</div>		

				<?php 
			} //end while loop
		}else{ ?>

			<div class="feedback">
				<h2>Sorry</h2>
				<p>No posts found. Try a search instead.</p>
			</div>

		<?php }//end if posts found ?>

	</div>
</main>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<?php if($logged_in_user){ ?>
<script type="text/javascript">
        $(":radio").click(function() { 
            //get the value of the rating they clicked
            var rating = this.value;      
            var postId = $(this).data("id");  
            var userId = <?php echo $logged_in_user['user_id']; ?>;   
            var $outputContainer =  $(this).parents('.rating-container');
            console.log($outputContainer);
            //create an ajax request to display.php
            $.ajax({   
                type: "GET",
                url: "ajax-handlers/rate-parse.php",  
                data: { 
                    'rating': rating, 
                    'postId': postId,
                    'userId': userId
                    },   
               
              success: function(response){
                $outputContainer.html(response);
                }
            });
        });
         //do stuff during and after ajax is loading (like visual feedback)
        $(document).on({
            ajaxStart: function() { $outputContainer.addClass("loading");    },
            ajaxStop: function() { $outputContainer.removeClass("loading"); } 
        });
    </script>
<?php } //end if logged in ?>

<footer>just a placeholder footer here</footer>
</body>
</html>	