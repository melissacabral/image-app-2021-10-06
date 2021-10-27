<?php 
//parse the form
if( isset($_POST['did_edit']) ){
	//sanitize everything
	$title 			= filter_var( $_POST['title'], FILTER_SANITIZE_STRING );
	$body 			= filter_var( $_POST['body'], FILTER_SANITIZE_STRING );
	$category_id 	= filter_var( $_POST['category_id'], FILTER_SANITIZE_NUMBER_INT );
	//sanitize booleans
	if( ! isset( $_POST['allow_comments'] ) OR $_POST['allow_comments'] != 1 ){
		$allow_comments = 0;
	}else{
		$allow_comments = 1;
	}

	if( ! isset( $_POST['is_published'] ) OR $_POST['is_published'] != 1){
		$is_published = 0;
	}else{
		$is_published = 1;
	}
	//validate everything
	$valid = true;

	//title too long or blank
	if( $title == '' OR strlen( $title ) > 50 ){
		$valid = false;
		$errors[] = 'Please provide a title that is shorter than 50 characters.';
	}
	//body too long
	if( strlen($body) > 2000 ){
		$valid = false;
		$errors[] = 'Post body must be shorter than 2,000 characters';
	}
	//invalid category
	if( $category_id < 1 ){
		$valid = false;
		$errors[] = 'Please choose a category for this post';
	}
	//if valid, update the post in the database
	if( $valid ){
		$result = $DB->prepare('UPDATE posts
			SET
			title = :title,
			body = :body,
			category_id = :cat,
			allow_comments = :allow_comments, 
			is_published = :is_published

			WHERE post_id = :post_id
			AND user_id = :user_id
			LIMIT 1	');
		$data = array(
			'title' 			=> $title,
			'body' 				=> $body,
			'cat'				=> $category_id,
			'allow_comments' 	=> $allow_comments,
			'is_published' 		=> $is_published,
			'post_id' 			=> $post_id,
			'user_id' 			=> $logged_in_user['user_id'],
		);

		$result->execute($data);
		//tricky query! lets debug it
		//debug_statement($result);

		if( $result->rowCount() >= 1 ){
			//success
			$feedback = 'Changes successfully saved';
			$feedback_class = 'success';
		}else{
			//no changes made
			$feedback = 'No changes made to your post';
			$feedback_class = 'info';
		}
	}else{
		//error
		$feedback = 'Error. Fix the following:';
		$feedback_class = 'error';
	}

}//end form parser


//pre-fill the form and make sure it belongs to the logged in user
$result = $DB->prepare('SELECT * FROM posts
	WHERE post_id = :post_id
	AND user_id = :user_id
	LIMIT 1');
$data = array(
	'post_id' => $post_id,
	'user_id' => $logged_in_user['user_id'],
);
$result->execute($data);
//if one row found, create simle variables to display in the form
if( $result->rowCount() >= 1 ){
	$row = $result->fetch();
	//make variables $title, $body, etc
	extract($row);
}