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
$challenge = mysql_query("SELECT * FROM `problems` LIMIT 0,50;");
$idnumber = $_SESSION['id'];
$username = mysql_query("SELECT * FROM `auth` WHERE `userID` = '$idnumber' LIMIT 1;");


mysql_close($con);


include('header.php');
?>
<div class="pageContent">
		<h2>Oh hello there <?php
		$name = mysql_fetch_array($username);
		echo $name['username'];?></h2>
		<?php if ($_SESSION['authlevel'] == 2){
echo("<p>
  Add a problem <a href=\"teacher_add.php\">here</a>
</p>
");

} ?>

<table class="problems">
  <tr class="heading">
    <td>Problem</td>
    <td>Score</td>
    <td>Solved by</td>
  </tr>
	<?php
	while($row = mysql_fetch_array($challenge))
  	{
		echo("<tr class=\"\">");
		echo("<td class=\"name\"><a href=\"problems.php?id=" . $row['id'] . "\">" . $row['subject'] . "</a> </td>");
		echo("<td class=\"score\"></td>");
		echo("<td class=\"solved_by\">");
		echo ($row['solvedcount'] . " Users");
		echo("</td>");
  	}
	?>
</table>
</div> <!-- .pageContent -->
</div> <!-- .container (I think) -->
</body>

</html>
