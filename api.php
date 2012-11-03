<?php
require("connect_db.php");
//header("Content-type: text/xml");

$type = $_GET['type'];
$lat = $_GET['lat'];
$lng = $_GET['lng'];

if($type=="xml"){
  header("Content-type: text/xml");
}

$radius = 0.2;
$now = time();
$query = "SELECT ID,Location,Lat,Lng,StartTime,EndTime, ( 3959 * acos( cos( radians($lat) ) * cos( radians( Lat ) ) * cos( radians( Lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( Lat ) ) ) ) AS distance FROM data HAVING distance < $radius AND EndTime < $now ORDER BY distance";
//echo $query;
$result = mysql_query($query) or die(mysql_error().$query);
//$rows = mysql_fetch_assoc($result);
//echo $result;
//var_dump($rows);
$out = array();
$r=0;
$b=255;
$g=0;

// function defination to convert array to xml
function array_to_xml($student_info, &$xml_student_info) {
    foreach($student_info as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml_student_info->addChild("$key");
                array_to_xml($value, $subnode);
            }
            else{
                array_to_xml($value, $xml_student_info);
            }
        }
        else {
            $xml_student_info->addChild("$key","$value");
        }
    }
}

while($row=mysql_fetch_assoc($result)){
  //echo "ad";
  //print_r($row);
  $diff = $row['StartTime'] - $now;
  $diff = abs($diff);

  $row['color'] = "#".dechex($r).dechex($g).dechex($b);
    $r++;
  $g++;
  $out[]=$row;
  //echo "<br/>";
  
}

  if($type=="json")
    echo json_encode($out);
  else if($type=="xml"){
    $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><data></data>");
    //$out = array_flip($out);
    //array_walk_recursive($out, array ($xml, 'addChild'));
    array_to_xml($out,$xml);
    print $xml->asXML();
  }
    //print_r($row);


?>



