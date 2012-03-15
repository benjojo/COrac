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
require 'config.php';
if (isset($_POST["login"])){
	if ($USE_AUTH_API == 0){
		$esc_usr = mysql_real_escape_string($_POST["login"]);
		$esc_pas = hash('haval128,5', $_POST["password"]);
		$result = mysql_query("SELECT * FROM `auth` WHERE `username` = '$esc_usr' AND `password` = '$esc_pas';");

		$count=mysql_num_rows($result);
		
		if($count==1){
			$row = mysql_fetch_array($result);
					$_SESSION['id'] = $row['userID'];
					$_SESSION['authlevel'] = $row['authlevel'];
			header("location:home.php");
		}
		else
		{
			die('Failed to login, User / Password combo not found in database. Also: ' . $esc_pas);
		}
	}else{
		if(GetAuthAPIStatus($_POST["login"],$_POST["password"])){
			$esc_usr = mysql_real_escape_string($_POST["login"]);
			$StatusQuery = mysql_query("SELECT * FROM `auth` WHERE `username` = '$esc_usr';"); // Query to see if he is a new user...
			$count=mysql_num_rows($StatusQuery);
			if($count == 1){
				// We know this guy.
				$row = mysql_fetch_array($result);
				$_SESSION['id'] = $row['userID'];
				$_SESSION['authlevel'] = $row['authlevel'];
				header("location:home.php");
			}else{
				// We don't know this guy, Lets add him to the DB.
				// Make up a email
				$fake_email = $esc_user . "@cabot.ac.uk";
				mysql_query("INSERT INTO `notorac`.`auth` (`username`, `password`, `userID`, `authlevel`, `email`) VALUES ('$esc_user', '2ae66f90b7788ab8950e8f81b829c947', NULL, '1', '$fake_email');");
				header("location:home.php"); // We are done here. (I think.)
			}
		}else{
			die('Failed to login, User / Password combo not found in database.';
		}
	}
}
mysql_close($con);
?>