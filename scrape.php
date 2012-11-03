<?php
require("simple_html_dom.php");
require("connect_db.php");

// Create DOM from URL or file
//$url = "http://food-bot.com/calendar-date/field_university/Carnegie%20Mellon";

function insert(){
}


$url = "http://food-bot.com/home";


$html = file_get_html($url);
$uni = $html->find("select[name=select] option");
foreach ($uni as $u){
    $url = $u->value;
    if(strlen($url) > 0){
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
        }
      }
      //break;
  }
}


?>
