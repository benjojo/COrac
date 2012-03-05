<?php
/* #############################################################################################
WARNING. By using this code you have ensured that you have confirmed that the
owner (Ben Cartwright - Cox, Ben@benjojo.co.uk) is aware of its use and that
you agree to the following.
1) Not responisble for any data loss in the use of this package
2) You are not to use it along the data of 1st of May 2013.
3) There are date checkers in this code. You may not alter them with out the owners permission
If use of this code is found in use with out the owners permission, Action will be taken to
remove it if permission is not granted.
*/ ############################################################################################

require 'session.php';

if ($_SESSION['id'] == null){
	die('You are not logged in, Your session proabbly timed out. Please login again.');
}

$con = mysql_connect("localhost","root","-Removed-");
if (!$con)
  {
  die('Database is unhappy with its working conditions, So its on strike for a while. Its chanting : ' . mysql_error());
  }

mysql_select_db("notorac", $con);
$esc_id = mysql_real_escape_string($_GET["id"]);
$challenge = mysql_query("SELECT * FROM `problems` WHERE `id` = '$esc_id' LIMIT 1;");
$idnumber = $_SESSION['id'];
$username = mysql_query("SELECT * FROM `auth` WHERE `userID` = '$idnumber' LIMIT 1;");
$prob = mysql_fetch_array($challenge);
mysql_close($con);
include('header.php');
?>


</body>
</html>
