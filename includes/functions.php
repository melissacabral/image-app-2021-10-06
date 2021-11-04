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

/**
* displays sql query information including the computed parameters.
* Silent unless DEBUG MODE is set to 1 in config.php
* @param [statement handler] $sth -  any PDO statement handler that needs troubleshooting
*/
function debug_statement($sth){
    if( DEBUG_MODE ){
        echo '<pre>';
        $info = debug_backtrace();
        echo '<b>Debugger ran from ' . $info[0]['file'] . ' on line ' . $info[0]['line'] . '</b><br><br>';
        $sth->debugDumpParams();
        echo '</pre>';
    }
}
/*
display a variable if it exists (prevents warnings)
 */
function echo_if_exists( &$var ){
    if( isset( $var ) ){
        echo $var;
    }
}

/* make checkboxes "stick" */
function checked( &$thing1, $thing2 ){
    if( $thing1 == $thing2 ){
        echo 'checked';
    }
}

/* make select dropdowns "stick" */
function selected( &$thing1, $thing2 ){
    if( $thing1 == $thing2 ){
        echo 'selected';
    }
}

/**
 * check to see if the viewer is logged in
 * @return array|bool false if not logged in, array of all user data if they are logged in
 */

function check_login(){
    global $DB;
    //if the cookie is valid, turn it into session data
    if(isset($_COOKIE['access_token']) AND isset($_COOKIE['user_id'])){
        $_SESSION['access_token'] = $_COOKIE['access_token'];
        $_SESSION['user_id'] = $_COOKIE['user_id'];
    }

   //if the session is valid, check their credentials
    if( isset($_SESSION['access_token']) AND isset($_SESSION['user_id']) ){
        //check to see if these keys match the DB     

     $data = array(
        'id' => $_SESSION['user_id'],
        'access_token' =>$_SESSION['access_token'],
    );

     $result = $DB->prepare(
        "SELECT * FROM users
        WHERE user_id = :id
        AND access_token = :access_token
        LIMIT 1");
     $result->execute( $data );

     if($result){
            //success! return all the info about the logged in user
        return $result->fetch();
    }else{
        return false;
    }
}else{
        //not logged in
    return false;
}
}
/*Make a default avatar from the user's first initial*/
function make_letter_avatar($string, $size){
//random pastel color
    $H =   mt_rand(0, 360);
    $S =   mt_rand(25, 50);
    $B =   mt_rand(90, 96);

    $RGB = get_RGB($H, $S, $B);

    $imageFilePath = 'avatars/' . $string . '_' .  $H . '_' . $S . '_' . $B . '.png';

    //base avatar image that we use to center our text string on top of it.
    $avatar = imagecreatetruecolor($size, $size);  
    //make and fill the BG color
    $bg_color = imagecolorallocate($avatar, $RGB['red'], $RGB['green'], $RGB['blue']);
    imagefill( $avatar, 0, 0, $bg_color );
    //white text
    $avatar_text_color = imagecolorallocate($avatar, 255, 255, 255);
// Load the gd font and write 
    $font = imageloadfont('gd-files/gd-font.gdf');
    imagestring($avatar, $font, 10, 10, $string, $avatar_text_color);

    imagepng($avatar, $imageFilePath);

    imagedestroy($avatar);

    return $imageFilePath;
}


/*
*  Converts HSV to RGB values
*  Input:     Hue        (H) Integer 0-360
*             Saturation (S) Integer 0-100
*             Lightness  (V) Integer 0-100
*  Output:    Array red, green, blue
*/
function get_RGB($iH, $iS, $iV) {
    if($iH < 0)   $iH = 0;   // Hue:
    if($iH > 360) $iH = 360; //   0-360
    if($iS < 0)   $iS = 0;   // Saturation:
    if($iS > 100) $iS = 100; //   0-100
    if($iV < 0)   $iV = 0;   // Lightness:
    if($iV > 100) $iV = 100; //   0-100

    $dS = $iS/100.0; // Saturation: 0.0-1.0
    $dV = $iV/100.0; // Lightness:  0.0-1.0
    $dC = $dV*$dS;   // Chroma:     0.0-1.0
    $dH = $iH/60.0;  // H-Prime:    0.0-6.0
    $dT = $dH;       // Temp variable

    while($dT >= 2.0) $dT -= 2.0; // php modulus does not work with float
    $dX = $dC*(1-abs($dT-1));     // as used in the Wikipedia link

    switch(floor($dH)) {
        case 0:
        $dR = $dC; $dG = $dX; $dB = 0.0; break;
        case 1:
        $dR = $dX; $dG = $dC; $dB = 0.0; break;
        case 2:
        $dR = 0.0; $dG = $dC; $dB = $dX; break;
        case 3:
        $dR = 0.0; $dG = $dX; $dB = $dC; break;
        case 4:
        $dR = $dX; $dG = 0.0; $dB = $dC; break;
        case 5:
        $dR = $dC; $dG = 0.0; $dB = $dX; break;
        default:
        $dR = 0.0; $dG = 0.0; $dB = 0.0; break;
    }

    $dM  = $dV - $dC;
    $dR += $dM; $dG += $dM; $dB += $dM;
    $dR *= 255; $dG *= 255; $dB *= 255;

    return  array(
        'red' =>  round($dR),
        'green'=> round($dG),
        'blue' => round($dB)
    );
}

// Show any post image at any size
function show_post_image( $image, $size = 'large' ){
    echo '<img src="uploads/' . $image . '_' . $size . '.jpg">';
}


//Count the number of unique likes on any post
function count_likes( $post_id = 0 ){
    global $DB;
    $result = $DB->prepare('SELECT COUNT(DISTINCT user_id) AS total
        FROM  likes
        WHERE post_id = ?');
    $result->execute(array( $post_id ));
    $row = $result->fetch();
    return $row['total'];
}
//
function like_interface( $post_id = 0, &$user_id = 0 ){
    //does the logged in user like this post?
    global $DB;
    $result = $DB->prepare('SELECT * FROM LIKES 
        WHERE user_id = :user_id
        AND post_id = :post_id
        LIMIT 1');
    $result->execute( array(
        'user_id' => $user_id,
        'post_id' => $post_id,
    ) );
    if($result->rowCount() >= 1){
        $class='you-like';
    }else{
        $class='not-liked';
    }
    if($user_id < 1){
        $class='not-logged-in';
    }
    ?>
    <span class="like-interface">
        <span class="<?php echo $class; ?>">
            <span class="heart-button" data-postid="<?php echo $post_id; ?>">❤</span>
            <?php echo count_likes( $post_id ); ?>
        </span>   
    </span>
    <?php
}


/**
 * Count the number of followers a user has
 */
function count_followers( $user_id ){
    global $DB;
    $result = $DB->prepare("SELECT COUNT(*) AS total
        FROM follows
        WHERE followee_id = ?");
    $result->execute(array($user_id));
    $row = $result->fetch();

    echo $row['total'] == 1 ? '1 Follower' : $row['total'] . ' Followers';
}
/**
 * Count the number of accounts a user follows
 */
function count_following( $user_id ){
    global $DB;
    $result = $DB->prepare("SELECT COUNT(*) AS total
        FROM follows
        WHERE follower_id = ?");
    $result->execute(array($user_id));
    $row = $result->fetch();

    echo $row['total'] . ' Following';
}
/**
 * Display all info about a user's followers
 * @param  int $user_id the profile we're viewing
 * @return mixed HTML
 */
function follows_interface( $followee, $follower ){
    global $DB;
    //if viewer is logged in
    if($follower){
        //are they already following this account?
        $result = $DB->prepare("SELECT * FROM follows 
            WHERE followee_id = ?
            AND follower_id = ?
            LIMIT 1");
        $result->execute(array( $followee, $follower ));
        if($result->rowCount() >= 1){
            //the viewer follows them
            $class = 'button-outline';
            $label = 'Unfollow';
        }else{
            //the viewer doesn't follow them yet
            $class = 'button';
            $label = 'Follow';
        }
    }

    ?>
    <div class="item"><?php count_followers( $followee ); ?></div>
    <div class="item"><?php count_following( $followee ); ?></div>
    <?php if( $follower AND $followee != $follower ){ ?>
        <div class="item">
            <button class="follow-button <?php echo $class; ?>" data-followee="<?php echo $followee; ?>">
                <?php echo $label; ?>
            </button>
        </div>
    <?php } 
}
/**
 * Rating Additions
 */

/**
 * Show the stars
 * Display both the current average rating of a post and the interface to add a new rating
 * @param  int $post_id 
 * @return HTML star inputs and outputs
 */
function rating_interface($post_id = 0, &$user_id = 0){
    rating_output($post_id); 
    rating_inputs($post_id, $user_id); 
}
/**
 * Get the current average rating of any post
 * @param  int $post_id 
 * @return float - average rating as a decimal like 3.058
 */
function get_rating( $post_id = 0 ){
    global $DB;
    //calculate the average rating
    $result= $DB->prepare("SELECT AVG(rating) AS average FROM ratings WHERE post_id = ?");
    $result->execute(array($post_id));
    $row = $result->fetch();
    return $row['average'];
}
/**
 * Display radio button inputs if logged in and user hasn't rated yet
 * @param  integer $post_id  
 * @param  integer &$user_id the user who may or may not have rated it yet
 * @return HTML  a form with radio button inputs
 */
function rating_inputs($post_id = 0, &$user_id = 0){
    global $DB;
    // only if logged in 
    if( isset($user_id) AND $user_id!= 0 ){
    //check if this user has already rated
        $result = $DB->prepare('SELECT * from ratings 
            WHERE user_id = ? 
            AND post_id = ?');
        $result->execute(array($user_id, $post_id));

        if($result->rowCount() < 1){
            ?>
            <form action="#" method="post">
                <label>Rate this:</label>
                <div class="star-rating">
                    <!--    data-id is the primary key for the post (post_id = 1)    -->
                    <input type="radio" name="rating" value="1" data-id="<?php echo $post_id; ?>"><i></i>
                    <input type="radio" name="rating" value="2" data-id="<?php echo $post_id; ?>"><i></i>
                    <input type="radio" name="rating" value="3" data-id="<?php echo $post_id; ?>"><i></i>
                    <input type="radio" name="rating" value="4" data-id="<?php echo $post_id; ?>"><i></i>
                    <input type="radio" name="rating" value="5" data-id="<?php echo $post_id; ?>"><i></i>
                </div>
            </form>
            <?php
        }//end if user haven't rated yet
        else{
            $row = $result->fetch();
            $rating = $row['rating'];
            echo '<br>you already rated this '. $rating;
        }
    }//end if logged in
    else{
        echo 'not logged in';
    }
}
/**
 * Display the current average rating as stars
 * @param  int $post_id 
 * @return HTML output stars
 */
function rating_output( $post_id ){
    $avg = get_rating($post_id);
    ?>
    <div class="star-rating star-rating-output rating-<?php echo round($avg); ?>">
        <i></i>
        <i></i>
        <i></i>
        <i></i>
        <i></i>
    </div>
    <?php
}
/**
 * Display the HTML output of your friends list and your pending friend requests
 * @param  integer $user_id 
 * @return HTML interface for the friends-list page and similar pages
 */
function show_friends( $user_id = 0 ){
     global $DB;
    $friends = array();
    $pendings = array();
   
    $result = $DB->prepare("SELECT  u.user_id, u.username, u.profile_pic,        
        case when b.friender_id is null then 
        'pending'
        else
            'friends'
        end as status
        FROM friends f 
        INNER JOIN users u  
        ON u.user_id = f.friender_id
        LEFT JOIN friends b  
        ON b.friender_id = f.friendee_id 
        AND  b.friendee_id = u.user_id
        WHERE  f.friendee_id = ?
        ");

        //run it
    $result->execute( array( $user_id ) );
        //check it
    if( $result->rowCount() >= 1 ){
      while( $row = $result->fetch() ){
                //add the found user to the correct array
        if($row['status'] == 'friends'){
            $friends[] = $row;
        }else{
            $pendings[] = $row;
        }
    } 

        //FRIENDS LIST DISPLAY 
    if(! empty($friends)){
        ?>
        <section class="added-friends">
            <h1>Your Friends!</h1>
            <h2>See what they're up to</h2>

            <?php foreach($friends as $friend){
                ?>
                <div class="friend flex">
                    <?php show_profile_pic($friend['profile_pic']) ?>
                    <?php echo $friend['username']; ?> <button class="add-friend" data-friendee="<?php echo $friend['user_id'] ?>">Remove</button>
                </div>
                <?php
            } ?>

        </section><!-- friends -->
        <?php 
         } //end of friends list

         //PENDING DISPLAY     
         if(! empty($pendings)){
            ?>

            <section class="pending-friends">
                <h2>Pending Friend Requests</h2>

                <?php foreach($pendings as $pending){
                    ?>
                    <div class="pending-friend flex">
                        <?php show_profile_pic($pending['profile_pic']) ?>
                        <?php echo $pending['username']; ?>
                       
                        <button class="add-friend" data-friendee="<?php echo $pending['user_id'] ?>">Accept</button>
                       
                        <!-- TODO: make this work -->
                        <button class="deny-friend button-outline">&times; Deny</button>
                    </div>
                    <?php
                } ?>

            </section>
            <?php 
         } //end of friends list
     }else{
        echo '<h2>You Have No Friends :(</h2>';
    }

}
//no close php