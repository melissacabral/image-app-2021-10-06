<?php 
//logout logic if they clicked the logout link
if( isset( $_GET['action'] )  AND $_GET['action'] == 'logout' ){
   	//get the logged in user_id
   	if( isset( $_COOKIE['user_id'] ) ){
   		$user_id = $_COOKIE['user_id'];
   	}elseif( isset( $_SESSION['user_id'] ) ){
   		$user_id = $_SESSION['user_id'];
   	}else{
   		$user_id = 0;
   	}
   	//Nullify the access token from this user's DB row
   	$result = $DB->prepare( 'UPDATE users 
							SET
							access_token = :token
							WHERE user_id = :id
							LIMIT 1' );
	$result->execute( array(
						'token' => NULL,
						'id' => $user_id,
					) );

    //invalidate all cookies and session vars
    setcookie( 'access_token', 0, time() - 9999 );
    setcookie( 'user_id', 0, time() - 9999 );

    $_SESSION = array();

    // This will delete the cookie PHPSESSID
    // from https://www.php.net/manual/en/function.session-destroy.php
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    //destroy the session id
    session_destroy();
}