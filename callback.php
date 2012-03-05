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

$con = mysql_connect("localhost","root","-Removed-");
if (!$con)
  {
  die('Database is unhappy with its working conditions, So its on strike for a while. Its chanting : ' . mysql_error());
  }

mysql_select_db("notorac", $con);
$esc_id = mysql_real_escape_string($_POST["id"]);
$blobbed = mysql_real_escape_string($_POST["file"]);

mysql_query("UPDATE `notorac`.`code` SET `output` = '$blobbed'
WHERE `code`.`id` = $esc_id;") or mysql_query("UPDATE `notorac`.`code` SET `error` = 1 WHERE `code`.`id` = $esc_id;");

$blobbey = mysql_real_escape_string($_POST["cc"]);
mysql_query("UPDATE `notorac`.`code` SET `compiler` = '$blobbey'
WHERE `code`.`id` = $esc_id;");

$timew = mysql_real_escape_string($_POST["time"]);
mysql_query("UPDATE `notorac`.`code` SET `time` = '$timew'
WHERE `code`.`id` = $esc_id;");

$haslua = mysql_num_rows(mysql_query("SELECT * FROM `luaScripts` WHERE `codeid` = $esc_id"));
if ($haslua == 1){
	$ohboy = mysql_query("SELECT * FROM `luaScripts` WHERE `codeid` = $esc_id LIMIT 1;");
	$luadata = mysql_fetch_array($ohboy);
	if (strtr($luadata['sdout'], "Ú", "") == strtr($_POST['code'], "Ú", "")){
		
		mysql_query("UPDATE `notorac`.`submissions` SET `correct` = 1 WHERE `codeid` = $esc_id;");
	}
}
mysql_close($con);
?>
Why are you here?