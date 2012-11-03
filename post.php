<?php
require("connect_db.php");

$lat = $_GET['lat'];
$lng = $_GET['lng'];
$st = $_GET['st'];
$et = $_GET['et'];
$location = $_GET['location'];

if($lat && $lng ){
  if(!$st){
    $st = time();
  }
  if(!$et){
    $et = $st + 60*60;
  }
  if(!$location){
    $location = "";
  }
  $query = "INSERT INTO data(Lat,Lng,Location,StartTime,EndTime) VALUES(".$lat.",".$lng.",'".$location."',".$st.",".$et.")";
  $result = mysql_query($query) or die(mysql_error().$query);
  echo True;
}
  
?>
