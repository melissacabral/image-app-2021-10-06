<?php 

//display any ugly timestamp as a nice looking date
function nice_date( $date ){
	$nice_date = new DateTime( $date );
	echo $nice_date->format( 'l, F jS, Y' );
}

// Convert timestamp to Time Ago (1 day ago..)
// https://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
function time_ago($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


//Count the number of approved comments on any post
function count_comments( $id = 0 ){
    //tell the function to use the DB connection from the global scope
    global $DB;
    //write the query
    $result = $DB->prepare('SELECT COUNT(*) AS total
                            FROM comments
                            WHERE post_id = ?');
    //run it - bind the data to the placeholders
    $result->execute( array( $id ) );
    //check it
    if( $result->rowCount() >= 1 ){
         //loop it
         while( $row = $result->fetch() ){
             //return the count
             echo $row['total'];
         }       
    }   
} //end function

//display the user's profile pic with a default fallback
function show_profile_pic( $profile_pic, $size = 50 ){
    // if blank, get the default
    if( $profile_pic == '' ){
        $profile_pic = 'images/default-user.png';
    }
    echo "<img src='$profile_pic' width='$size' height='$size'>";
}

//display any form's feedback
function show_feedback( &$message = '', &$class = 'error', &$bullets = array() ){
    if( isset( $message ) ){
    ?>
    <div class="feedback <?php echo $class; ?>">
        <h2><?php echo $message; ?></h2>
        <?php if( !empty( $bullets ) ){ ?>
        <ul>
            <?php 
            foreach( $bullets AS $bullet ){
                echo "<li>$bullet</li>";
            } ?>
        </ul>
        <?php } ?>
    </div>
    <?php 
    } //end if message is set
}

//no close php