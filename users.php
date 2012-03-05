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
$listofusers = mysql_query("SELECT submissions.userid, COUNT( submissions.userid ) AS sub, auth.username
FROM  `submissions` 
JOIN  `auth` ON submissions.userid = auth.userID
GROUP BY submissions.userid
ORDER BY  `sub` DESC;");

mysql_close($con);
include('header.php');
?>
		<h2>Leaderboard</h2>

<table class="problems">
  <tr class="heading">
    <td>User</td>
    <td>Submissions</td>
  </tr>
  <?php
  	while($row = mysql_fetch_array($listofusers))
  	{
		echo("<tr class=\"\">");
		echo("<td class=\"name\"><a href=\"profile.php?id=" . $row['userid'] . "\">" . $row['username'] . "</a> </td>");
		echo("<td class=\"score\">" . $row['sub'] . "</td>");
		echo("</td>");
  	}
	?>

</table>
	</div>

</body>
</html>
