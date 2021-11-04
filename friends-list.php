<?php
require('CONFIG.php');
require_once('includes/functions.php');
require('includes/header.php');

if( ! $logged_in_user ){
    die( 'You must be logged in to see this page' );
}

?>

<main class="content">
  
        <div id="friends-container">
        <?php show_friends($logged_in_user['user_id']); ?>             
        </div>    
  
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<?php if( $logged_in_user ){ ?>
<script type="text/javascript">
	//when the heart button is clicked, trigger the ajax handler
	$('#friends-container').on( 'click', '.add-friend', function(){
		//which user clicked qhich post?
		var friendee = $(this).data('friendee');
		var friender = <?php echo $logged_in_user['user_id']; ?> ;

		console.log( friender, friendee );

		var container = $(this).parents('#friends-container');
		$.ajax({
			method 	: 'POST',
			url 	: 'ajax-handlers/friend-request.php',
			data 	: {
						'friender' : friender,
						'friendee' : friendee,
						},
			success : function( response ){
						//update the likes interface
						container.html(response);
						},
			error 	: function(){
				console.log('Ajax Error');
			}
		});
	} );
</script>
<?php } //end if logged in ?>
<?php
require('includes/footer.php');
?>