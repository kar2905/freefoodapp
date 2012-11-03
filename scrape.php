<?php
require("simple_html_dom.php");
require("connect_db.php");

// Create DOM from URL or file
//$url = "http://food-bot.com/calendar-date/field_university/Carnegie%20Mellon";

function insert($date,$location){
  //var_dump($location);
  $location = trim($location);
  $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(" ","+",$location)."&sensor=true";
  $output = file_get_contents($url);
  $output = json_decode($output);
  $lat = $output->results[0]->geometry->location->lat;
  $lng = $output->results[0]->geometry->location->lng;
  $st = time(date_parse($date));
  $et = $st + 60*60;
  //echo $lat.",".$lng;
  $query = "INSERT INTO data(Lat,Lng,Location,StartTime,EndTime) VALUES(".$lat.",".$lng.",'".$location."',".$st.",".$et.")";
  $result = mysql_query($query) or die(mysql_error().$query);
}

//insert(12,"7500 Wean Hall");
$url = "http://food-bot.com/home";


$html = file_get_html($url);
$uni = $html->find("select[name=select] option");

foreach ($uni as $u){
    $url = $u->value;
    $uni_name = $u->value;


    if(strlen($url) > 0){
      $arr = explode("/",$uni_name);
      $uni_name = $arr[5];
      $url = str_replace(" ","%20",$url);
      var_dump($url);
      
      $html = file_get_html($url);
      $ret = $html->find('div[id=node-title]');
      //$ret = $html->find('span[class=date-display-single]');
      echo count($ret);

      foreach($ret as $r){
        $u = "http://food-bot.com/".$r->first_child()->href;
        $h = file_get_html($u);
        $out = $h->find("span[class=date-display-single]");
        if(count($out) > 0 ){
          $date =  $out[0];
          $o = $h->find("div[class=field-field-location]");
          $location = $o[0]->children(2);
          echo $date.$location."<br/>";
          insert($date->plaintext,trim($location->plaintext)." ".$uni_name);
        }
      }
      //break;
  }
}


?>
