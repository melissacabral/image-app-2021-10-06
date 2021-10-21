<?php
//parse the form if it was submitted
if( isset($_POST['did_comment']) ){
	//sanitize everything
	$body = filter_var($_POST['body'], FILTER_SANITIZE_STRING);
	//validate (body not blank)
	$valid = true;
	if( '' == $body ){
		$valid = false;
		$errors['body'] = 'Please fill in the comment.';
	}
	//if valid, add this comment to the database
	if( $valid ){
		$result = $DB->prepare('INSERT INTO comments
								(user_id, body, date, post_id, is_approved)
								VALUES 
								(:user_id, :body, now(), :post_id, 1 )');
		$result->execute( array( 
			'body' => $body, 
			'post_id' => $post_id,
			'user_id' => $logged_in_user['user_id'],
		) );
		if($result->rowCount() >= 1){
			//success
			$feedback = 'Thanks for your comment';
			$feedback_class = 'success';
		}else{
			//db error
			$feedback = 'Your comment could not be saved. Try again.';
			$feedback_class = 'error';
		}
	}else{
		$feedback = 'Your comment could not be saved. Fix the following:';
		$feedback_class = 'error';
	}
} //end parser
//no close php