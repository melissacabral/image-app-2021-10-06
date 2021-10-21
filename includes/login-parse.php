<?php 
if( isset( $_POST['did_login'] ) ){
	//sanitize all fields
	$username = filter_var( $_POST['username'], FILTER_SANITIZE_STRING );
	$password = filter_var( $_POST['password'], FILTER_SANITIZE_STRING );
	//validate
	$valid = true;
	//username wrong length
	if( strlen( $username ) < USERNAME_MIN OR strlen( $username ) > USERNAME_MAX ){
		$valid = false;
		//TODO:  get rid of this after testing
		$errors['username'] = 'username wrong length';
	}
	//password wrong length
	if( strlen( $password ) < PASSWORD_MIN ){
		$valid = false;
		//TODO: delete me
		$errors['password'] = 'password too short';
	}
	//if valid, check to see if good credentials
	if( $valid ){
		//look up the user's username first
		$result = $DB->prepare('SELECT user_id, password 
								FROM users
								WHERE username = ?
								LIMIT 1');
		$result->execute( array( $username ) );
		//if username found, verify the password against the hash
		if( $result->rowCount() >= 1 ){
			$row = $result->fetch();
			//verify the password
			if( password_verify( $password, $row['password']) ){
				//if we get a match, log them in for a week
				//generate a random token
				$access_token = bin2hex( random_bytes( 30 ) );
				//store it in the DB and in cookies & sessions
				$result = $DB->prepare( 'UPDATE users 
										SET
										access_token = :token
										WHERE user_id = :id
										LIMIT 1' );
				$result->execute( array(
									'token' => $access_token,
									'id' => $row['user_id'],
								) );
				//if it worked, store it as a cookie and session
				if( $result->rowCount() >= 1 ){
					setcookie( 'access_token', $access_token, time() + 60 * 60 * 24 * 7 );
					$_SESSION['access_token'] = $access_token;

					setcookie( 'user_id', $row['user_id'], time() + 60 * 60 * 24 * 7 );
					$_SESSION['user_id'] = $row['user_id'];

					//TODO: redirect to a secret page
					$feedback = 'You are now logged in';
					$feedback_class = 'success';
				}else{
					$feedback = 'Sorry, the authentication system encountered a problem. Try again.';
					$feedback_class = 'error';
				} 
			}else{
				$feedback = 'Incorrect Login. Try again.';
				$feedback_class = 'error';
			}				
		}else{
			$feedback = 'Incorrect Login. Try again.';
			$feedback_class = 'error';
		}		
	}else{
		$feedback = 'Incorrect Login. Try again.';
		$feedback_class = 'error';
	}
	
}//end login parse
//no close