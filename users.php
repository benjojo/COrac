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
