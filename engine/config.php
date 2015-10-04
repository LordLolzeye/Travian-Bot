<?php
date_default_timezone_set('Europe/Berlin');
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
$dbuser = 'root';
$dbhost = 'localhost';
$dbpass = '';
$db = 'travian';
$con = mysql_connect($dbhost,$dbuser,$dbpass);
if(!$con)
{
  die('Could not connect: ' . mysql_error());
}
mysql_select_db($db, $con);
if(isset($_SESSION['uname']))
{
  $uname = $_SESSION['uname'];
}  
?>