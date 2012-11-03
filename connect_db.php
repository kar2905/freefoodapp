<?php

//DATABASE CONNECT.

$connect = mysql_connect('localhost','root','root') or die(mysql_error());
mysql_select_db('freefoodapp',$connect);
$connect = mysql_connect('localhost','sachinprabhu_ffp','f5daa32b') or die(mysql_error());
mysql_select_db('sachinprabhu_ffp',$connect);
?>
