<?php

//DATABASE CONNECT.

$connect = mysql_connect('localhost','root','root') or die(mysql_error());
mysql_select_db('freefoodapp',$connect);
?>