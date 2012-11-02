<?php
require("connect_db.php");
//header("Content-type: text/xml");

$type = $_GET['type'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];


$query = "SELECT ID, ( 3959 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance FROM data HAVING distance < 10 ORDER BY distance";
echo $query;
$result = mysql_query($query) or die(mysql_error().$query);
$rows = mysql_fetch_assoc($result);
echo $result;
var_dump($rows);
foreach($rows as $row){
  print_r($row);
  
}


?>



