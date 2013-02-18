<?php
session_start();
$USE_AUTH_API = 0; // Change if you want to use in a diffrent system.

$con = mysql_connect("localhost","root","-Removed-");
if (!$con)
{
	die('Database is unhappy with its working conditions, So its on strike for a while. Its chanting : ' . mysql_error());
}
mysql_select_db("notorac", $con);
?>