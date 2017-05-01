<?php
	
function timeAgo( $time ) {
    $right_now = time();
    if ( ! $time )
        return;
    $diff = abs( $right_now - $time );
    $second = 1;
    $minute = $second * 60;
    $hour = $minute * 60;
    $day = $hour * 24;
    $week = $day * 7;
    if ( $diff < $second * 2 )
        return "right now";
    if ( $diff < $minute )
        return floor( $diff / $second ) . " seconds ago";
    if ( $diff < $minute * 2 )
        return "about 1 minute ago";
    if ( $diff < $hour )
        return floor( $diff / $minute ) . " mins ago";
    if ( $diff < $hour * 2 )
    	return "1 hr ago";
    if ( $diff < $day )
    	return floor( $diff / $hour ) . " hrs ago";
    if ( $diff > $day && $diff < $day * 2 )
        return "yesterday";
    if ( $diff < $day * 365 )
        return floor( $diff / $day) . " days ago";
    else
        return "over a year ago";
}
        
       	
function voom_instagram(){
	
	$instagram_id = '####';
	$access_token = '####';
	$photo_count= 1;
	$username = 'name';

	//Grab API
    $url = 'https://api.instagram.com/v1/users/' . $instagram_id . '/media/recent/?access_token=' . $access_token . '&count=' . $photo_count;
	
	//Cache API Result
    $cache = './' . sha1($url) . '.json';
    
    //Run API Cache every 10 Minutes 10 x 60 seconds
    if(file_exists($cache) && filemtime($cache) > time() - 10*60){
        $jsonData = json_decode(file_get_contents($cache));
    } else {
        $jsonData = json_decode((file_get_contents($url)));
        file_put_contents($cache,json_encode($jsonData));
    }
	
    foreach ($jsonData->data as $key=>$value) {
	  	//Use this to pull the time 
		$instaTime = $value->caption->created_time;
		
		$insta_post .= '<i class="fa fa-instagram"></i>';
		$insta_post .= '<h4><a href="https://www.instagram.com/' . $username . '" target="_blank">';
		$insta_post .=  '' . value->user->username . '';
		$insta_post .= '</a></h4>';
		
		$insta_post .= '<a href="' . $value->link . '" target="_blank">';
		$insta_post .= '<img src="' . $value->images->standard_resolution->url . '" alt="' . $value->caption->text . '">';
		$insta_post .= '</a>';
		$insta_post .= '<h5>';
		$insta_post .= '' . timeAgo($instaTime) . '';
		$insta_post .= '</h5>';	  
    }
    
    return $insta_post;

}


?>
