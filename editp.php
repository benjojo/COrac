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

if (isset($_POST["password1"])){
	if ($_POST["password1"] == $_POST["password2"]){
		$wat =  $_POST["password1"];
		$newhash = hash('haval128,5', $wat);
		$idnumber = $_SESSION['id'];
		mysql_query("UPDATE  `notorac`.`auth` SET  `password` =  '$newhash' WHERE  `auth`.`userID` =" .$idnumber . ";");
	}else{
	die("Passwords did not match.");
	}
}
$challenge = mysql_query("SELECT * FROM `problems` LIMIT 0,50;");
$idnumber = $_SESSION['id'];
$username = mysql_query("SELECT * FROM `auth` WHERE `userID` = '$idnumber' LIMIT 1;");
$userinfo = mysql_fetch_array($username);

mysql_close($con);


include('header.php');
?>

		
		<h2>Editing the profile of <?php echo $userinfo['username'];?></p></h2>

<form accept-charset="UTF-8" action="editp.php" method="post"><div style="margin:0;padding:0;display:inline">
</div>
  <fieldset>
    <label for="user_password">Password</label>
    <input id="user_password" name="password1" size="30" type="password" />
    <label for="user_password_confirmation">Password confirmation</label>
    <input id="user_password_confirmation" name="password2" size="30" type="password" />
    <label for="user_email">Email</label>
    <input id="user_email" name="email" size="30" type="text" disabled="yes" value="<?php echo $userinfo['email'];?>" />
    <input name="commit" type="submit" value="Hit it." />
  </fieldset>
</form>
	</div>
</body>

</html>
