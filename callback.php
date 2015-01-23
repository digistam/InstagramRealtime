<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	include('./mysql/insert.inc.php');
	$challenge = $_GET['hub_challenge'];

	// It appears that Instagram is not auto-unsubscribing from high volume tags UNLESS your server is not responding quickly enough.
	// Although it was not obvious to me at the time, it seems that there must have been times where my server was taking 2 seconds to respond, possibly due to concurrent calls on some blocking resource.
	// After posting this question, I ripped out everything from my HTTP responder except for one method call to copy the data that Instagram sent; everything else happens asynchronously, so if there is any blocking it does not prevent the HTTP response from going back to Instagram. I am able to stay subscribed to multiple high-volume tags (including the #1 tag on Instagram) without getting auto-unsubscribed.
	// It also does seem to be true (and undocumented) that if you fall behind/respond slowly, you get unsubscribed from the problematic tag.
		
    if ($challenge) {
        echo $challenge;
    }
    else
    {
        sleep(2);
		$verify_token = '12345';
		$hub_mode = $_GET['hub.mode'];
        $myString = file_get_contents('php://input');
        $jsonArray = json_decode($myString);

        foreach($jsonArray as $value){
            $subscription_id = $value->subscription_id;
            $tag = $value->object_id;
            $object = $value ->object;
            $keyword = $value->object_id;
            if ($object == 'geography') {
            	$object = 'geographies';
            }
            else {
            	$object = 'tags';
            }
            $time = $value ->time;
		}
     				
		$json = file_get_contents("https://api.instagram.com/v1/". $object ."/". $tag ."/media/recent?client_id=*****");
		$data = json_decode($json);
				
		foreach(json_decode($json)->data as $item){
    	    $src = $item->images->standard_resolution->url;
			$thumb = $item->images->thumbnail->url;
			$url = $item->link;
			$created_time = $item->created_time;
			$created_time = gmdate("Y-m-d\TH:i:s\Z", $created_time);
    		$longitude = $item->location->longitude;
    		$latitude = $item->location->latitude;
    		$location = $item->location->name;
    		$location_id = $item->location->id;
    		$username = $item->caption->from->username;
    		$tags = $item->tags;
    		$tags = implode(",", $tags);
    		if ($object == 'geographies') {
        	    $keyword = 'Geo';
    		}
			$sql = "INSERT INTO media (keyword, tags, picture, published, longitude, latitude, location, location_id, link, username) VALUES ('$keyword', '$tags', '$src', '$created_time', '$longitude', '$latitude', '$location', '$location_id', '$url', '$username');";
			$retval = mysql_query( $sql, $db );
			if(! $retval )
			{
  		        die('Could not enter data: ' . mysql_error());
			}
			$sqldups = "DELETE a FROM MEDIA a, MEDIA b WHERE a.picture = b.picture AND a.id > b.id;";
			$retval = mysql_query( $sqldups, $db );
			if(! $retval )
			{
  			    die('Could not enter data: ' . mysql_error());
			}
			mysql_close($db);
			}
        }
    mysql_close($db);
?>
