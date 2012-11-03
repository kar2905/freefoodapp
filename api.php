<?php
require("connect_db.php");
//header("Content-type: text/xml");

$type = $_GET['type'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$radius = 0.2;

$query = "SELECT ID,Location,StartTime,EndTime, ( 3959 * acos( cos( radians($lat) ) * cos( radians( Lat ) ) * cos( radians( Lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( Lat ) ) ) ) AS distance FROM data HAVING distance < $radius ORDER BY distance";
//echo $query;
$result = mysql_query($query) or die(mysql_error().$query);
//$rows = mysql_fetch_assoc($result);
//echo $result;
//var_dump($rows);
while($row=mysql_fetch_assoc($result)){
  //echo "ad";
  print_r($row);
  echo "<br/>";
  
}


?>



