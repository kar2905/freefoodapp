<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */
/* Load required lib files. */
session_start();
include('connect_db.php');
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
    header('Location: ./clearsessions.php');
}
/* Get user access tokens out of the session. */
$access_token = $_SESSION['access_token'];

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

/* If method is set change API call made. Test is called by default. */
//$content = $connection->get('account/verify_credentials');

/* Some example calls */
//$content = $connection->get('users/show', array('screen_name' => 'yutongp'));
//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
//$connection->post('statuses/destroy', array('id' => 5437877770));
//$connection->post('friendships/create', array('id' => 9436992));
//$connection->post('friendships/destroy', array('id' => 9436992));

    $myFile = "testFile.txt";
    $fh = fopen($myFile, "r") or die("can't open file");
    $previousid=fread($fh, filesize($myFile));
    fclose($fh);
        
$content = $connection->get('search/tweets', array('q' => 'freefood', 'count'=>100));
$limit = $connection->get('application/rate_limit_status', array('resources' => 'search'));
$remain = $limit->{"resources"}->{"search"}->{"/search/tweets"}->{"remaining"};
if($remain >  0){
    $i = 0;
    foreach( $content->statuses as $tweet){
        if(!empty($tweet->coordinates)){
            $mText = (string) $tweet->text;
            $mLag = floatval($tweet->coordinates->coordinates[0]);
 		    $mLat = floatval($tweet->coordinates->coordinates[1]);
		    $i++;
            $ret = mysql_query("SELECT * FROM data WHERE Lat =$mLat AND Lng = $mLag AND Name = '$mText'");
            $row = mysql_fetch_assoc($ret);
            if(empty($row)){
            $sql = "INSERT INTO data(Lat, Lng, Name) VALUES ($mLat,$mLag,'$mText')";
            mysql_query($sql);
            }
        }
    }
    $myFile = "testFile.txt";
    $fh = fopen($myFile, "w") or die("can't open file");
    fwrite($fh, $content->statuses[0]->id);
    fclose($fh);
	$remain = $remain--;
    $nextid = $content->statuses[count($content->statuses)-1]->id - 1;
    echo $nextid."  &&  ".$previousid."<br>";

    while($i < 70 && $remain > 30 && $nextid > $previousid){
        $content = $connection->get('search/tweets', array('max_id'=>$nextid, 'q' => 'freefood', 'count'=>100));
        foreach( $content->statuses as $tweet){
            if(!empty($tweet->coordinates)){
                $mText = (string) $tweet->text;
                $mLag = floatval($tweet->coordinates->coordinates[0]);
                $mLat = floatval($tweet->coordinates->coordinates[1]);
                $i++;
                $ret = mysql_query("SELECT * FROM data WHERE Lat =$mLat AND Lng = $mLag AND Name = '$mText'");
                $row = mysql_fetch_assoc($ret);
                if(empty($row)){
                    $sql = "INSERT INTO data(Lat, Lng, Name) VALUES ($mLat,$mLag,'$mText')";
                    mysql_query($sql);
                }
        }
        }
        $nextid = $content->statuses[count($content->statuses)-1]->id - 1;
		$remain --;
   }

	
}
echo $remain;


/* Include HTML to display on the page */
//include('html.inc');
?>