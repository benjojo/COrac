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
if ($_SESSION['authlevel'] < 2){
	$challenge = mysql_query("INSERT INTO `notorac`.`alerts` (`userid`, `issue`) VALUES ('$idnumber', 'Attemped to load teacher only page.');");
	die('You are not allowed to view this page. This offence has been logged.');
}
if(isset($_POST['title'])){
// OH NO! We need to add somthing.
// Joy.
$tit = mysql_real_escape_string($_POST["title"]);
$content = mysql_real_escape_string($_POST["dis"]);
$sin = mysql_real_escape_string($_POST["simp"]);
$sou = mysql_real_escape_string($_POST["sout"]);
mysql_query("INSERT INTO `notorac`.`problems` (`id`, `subject`, `text`, `injection`, `endinjection`, `solvedcount`, `simp`, `sout`) VALUES (NULL, '$tit', '$content', '', '', '0', '$sin', '$sout');");
}
$challenge = mysql_query("SELECT * FROM `submissions` WHERE `problemid` = $esc_id ORDER BY  `correct` DESC;");
$idnumber = $_SESSION['id'];
//$prob = mysql_fetch_array($challenge);

include('header.php');
?>

<h2>Adding a new challange:</h2>
<form accept-charset="UTF-8" action="teacher_add.php" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" />
    </div> <fieldset>
    <label for="Title">Title</label>
    <input id="Title" name="title" size="64" type="text" />

    <label for="dis">Discription</label>
    <textarea wrap="off" name="dis" ></textarea>

    <label for="user_password">Sample Input</label>
    <textarea wrap="off" name="simp" ></textarea>

    <label for="user_password">Sample Output</label>
    <textarea wrap="off" name="sout" ></textarea>

    <input name="commit" type="submit" value="Add" />
  </fieldset>
</form>

<?php

mysql_close($con); // I hate when I have to do this...

?>
</body>
</html>
