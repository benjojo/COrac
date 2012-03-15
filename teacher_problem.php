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


require 'config.php';
$esc_id = mysql_real_escape_string($_GET["id"]);
$challenge = mysql_query("SELECT * FROM `submissions` WHERE `problemid` = $esc_id ORDER BY  `correct` DESC;");
$idnumber = $_SESSION['id'];
if ($_SESSION['authlevel'] < 2){
	$challenge = mysql_query("INSERT INTO `notorac`.`alerts` (`userid`, `issue`) VALUES ('$idnumber', 'Attemped to load teacher only page.');");
	die('You are not allowed to view this page. This action has been logged.');
}
include('header.php');
?>
<h2>The Following Submissions have been given for Problem #<?php echo($esc_id);?></h2>

<table class="problems">
  <tr class="heading">
    <td>User</td>
    <td>Link To submssion</td>
    <td>Correct?</td>
  </tr>
  <?php
  	while($row = mysql_fetch_array($challenge))
  	{
		echo("<tr class=\"\">");
		$uid = $row['userid'];
		$username = mysql_query("SELECT * FROM `auth` WHERE `userID` = '$uid' LIMIT 1;");
		$ud = mysql_fetch_array($username);
		echo("<td class=\"User\"><a href=\"profile.php?id=" . $ud['userID'] . "\">" . $ud['username'] . "</a> </td>");
		$cid = $row['codeid'];
		echo("<td class=\"Link To submssion\"><a href=\"viewcode.php?id=" . $row['codeid'] . "\">" . "Submission Number #$cid</a></td>");
		if($row['correct'] == 1){
		echo("<td class=\"Correct\">  	<img src=\"/notorac/i/correct.png\" alt=\"Correct\" width=\"32\" height=\"32\" /></td>");
		}else{
		echo("<td class=\"Correct\">  	<img src=\"/notorac/i/x2.png\" alt=\"Correct\" width=\"32\" height=\"32\" /></td>");
		}
		echo("</td>");
  	}
	?>

</table>
	</div>

<?php

mysql_close($con); // I hate when I have to do this...

?>
</body>
</html>
