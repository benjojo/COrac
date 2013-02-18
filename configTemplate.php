<?php
/*
Things that are stored in the session var.
UserID
UserName
ClassID
*/

session_start();

$con = mysql_connect("localhost","root","-Removed-");
if (!$con)
{
	die(mysql_error());
}
mysql_select_db("notorac", $con);

function CheckSession()
{
    if(!isset($_SESSION['id']))
    {
        header("location: ./");
        die("Aborting. Not Logged In.");
    }
}

?>