<?php
/* #############################################################################################
WARNING. By using this code you have ensured that you have confirmed that the following things apply
1) Not responisble for any data loss in the use of this package
2) This is for non commercial systems.
If you have more questions please email (Ben (t) benjojo.co.uk)
*/ ############################################################################################


require 'config.php';
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