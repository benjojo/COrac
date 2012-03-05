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
$idnumber = $_SESSION['id'];
$username = mysql_query("SELECT * FROM `auth` WHERE `userID` = '$esc_id' LIMIT 1;");
$userdata = mysql_fetch_array($username);

$AttemptedS = mysql_query("SELECT * FROM `submissions` WHERE `userid` = '$esc_id' AND correct = 0;");



$SolvedS = mysql_query("SELECT * FROM `submissions` WHERE `userID` = '$esc_id' AND `correct` = 1;");



mysql_close($con);
include('header.php');
?>
<div class="show_user">
  <h2><span><?php echo $userdata['username']; ?></span></h2>
  
  <p>
    <strong><?php echo $userdata['username']; ?></strong> has solved some problems...
  </p>
  
  
  <table class="problems">
    <tr class="heading">
      <td>Problem</td>
      <td>Time Solved</td>
    </tr>
  <?php
  	while($row = mysql_fetch_array($SolvedS))
  	{
		echo("<tr class=\"\">");
		$prob = $row['problemid'];
		$ti = $row['time'];
		echo("<td class=\"Problem\"><a href=\"problems.php?id=2\">Problem #$prob</a> </td>");
		echo("<td class=\"Time Solved\">$ti</td>");
		echo("</tr>");
  	}
	?>
  </table>
    <p>
    <strong><?php echo $userdata['username']; ?></strong> has also tried done these attempts...
  </p>

    <table class="problems">
    <tr class="heading">
      <td>Problem</td>
      <td>Time Attemped</td>
    </tr>
  <?php
  	while($row = mysql_fetch_array($AttemptedS))
  	{
		echo("<tr class=\"\">");
		$prob = $row['problemid'];
		$ti = $row['time'];
		echo("<td class=\"Problem\"><a href=\"problems.php?id=2\">Problem #$prob</a> </td>");
		echo("<td class=\"Time Attemped\">$ti</td>");
		echo("</tr>");
  	}
	?>
  </table>

</div>
	</div>
</body>
<script src="/assets/application-6728c025b1babaf8d0ee37d4e69971dd.js" type="text/javascript"></script>

</html>