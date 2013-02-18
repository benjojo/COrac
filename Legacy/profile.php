<?php
/* #############################################################################################
WARNING. By using this code you have ensured that you have confirmed that the following things apply
1) Not responisble for any data loss in the use of this package
2) This is for non commercial systems.
If you have more questions please email (Ben (t) benjojo.co.uk)
*/ ############################################################################################


require 'session.php';

if ($_SESSION['id'] == null){
	die('You are not logged in, Your session proabbly timed out. Please login again.');
}
require 'config.php';
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