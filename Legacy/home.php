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
