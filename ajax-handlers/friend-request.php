<?php 
require('../CONFIG.php');
require('../includes/functions.php');
$friender = filter_var( $_POST['friender'], FILTER_SANITIZE_NUMBER_INT );
$friendee = filter_var( $_POST['friendee'], FILTER_SANITIZE_NUMBER_INT );
$data = array( 
    'friender'=>$friender, 
    'friendee'=>$friendee,
 );
//check to see if person has already sent request or is already friends
$result = $DB->prepare('SELECT friends.*
                        FROM friends
                        WHERE friender_id = :friender
                        AND friendee_id = :friendee
                        LIMIT 1');
$result->execute( $data );

if( $result->rowCount() >= 1 ){
    $query = '  DELETE FROM friends                         
                WHERE friender_id = :friender
                AND friendee_id = :friendee';
}else{
    $query = '  INSERT into friends 
                (friender_id, friendee_id, date)
                VALUES 
                (:friender, :friendee, now())';
}

// for adding a friend
$result = $DB->prepare($query);

    $result->execute( $data );

    if( $result->rowCount() >= 1){
        show_friends($friender); 
    }else{
        echo 'error';
    }
 
 ?>