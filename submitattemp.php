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
/*
INSERT INTO `notorac`.`code` (`id`, `code`, `output`) VALUES (NULL, 0x89, 0x89);

INSERT INTO `notorac`.`code` (`id`, `code`) VALUES (NULL, 0x89);

UPDATE `notorac`.`code` SET `output` = 0xDEADBEEFFEED WHERE `code`.`id` = 3;
*/

function strhex($str)
{
	$hex = '';
	for ($i=0; $i < strlen($str); $i++)
	{
		$hex .= dechex(ord($str[$i]));
	}
	return $hex;
}

if ($_SESSION['id'] == null){
	die('You are not logged in, Your session proabbly timed out. Please login again.');
}

require 'config.php';
$esc_id = mysql_real_escape_string($_POST["id"]);
$challenge = mysql_query("SELECT * FROM `problems` WHERE `id` = '$esc_id' LIMIT 1;");
$idnumber = $_SESSION['id'];
$username = mysql_query("SELECT * FROM `auth` WHERE `userID` = '$idnumber' LIMIT 1;");
$prob = mysql_fetch_array($challenge);

// Now we submit the code into the database...
// First we encode the data into a BLOB.
$bloddata = mysql_real_escape_string($_POST["code"]);
// Now upload it to the database...
mysql_query("INSERT INTO `notorac`.`code` (`id`, `code`) VALUES (NULL, '$bloddata');");
// Now we get the latest entry in the database...
$latestcode = mysql_query("SELECT * FROM `code` ORDER BY `code`.`id`  DESC LIMIT 1;");
$lcode = mysql_fetch_array($latestcode);
$codeid = $lcode["id"];
// Now add a link to the user, Problem, And code.
mysql_query("INSERT INTO `notorac`.`submissions` (`userid`, `codeid`, `problemid`, `correct`) VALUES ('$idnumber', '$codeid', '$esc_id', '0');");
// Done. Now we need to send it off to the compile server...
// And hold the connection for 5 secs then goto the (hopefully) populated output...

$haslua = mysql_num_rows(mysql_query("SELECT * FROM `luaScripts` WHERE `codeid` = $esc_id"));
if ($haslua == 1){
	$ohboy = mysql_query("SELECT * FROM `luaScripts` WHERE `codeid` = $esc_id LIMIT 1;");
	$luadata = mysql_fetch_array($ohboy);
	shell_exec("bash clear.sh");
	// /var/www/notorac
	$myFile = "file.lua";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = $luadata['code'];
	fwrite($fh, $stringData);
	fclose($fh);
	$testoutput = shell_exec("lua file.lua");
	//shell_exec("bash clear.sh");
	
	$prepArr = explode("#",$testoutput);
	$counter = 0;
	foreach ($prepArr as $pop){
		if ($counter == 1){
				$escape = mysql_real_escape_string($pop);
				mysql_query("UPDATE `notorac`.`code` SET `sdout` = '$escape' WHERE `id` = $codeid;");
		}else{
				$escape = mysql_real_escape_string($pop);
				$stin = $pop;
				mysql_query("UPDATE `notorac`.`code` SET `sdin` = '$escape' WHERE `id` = $codeid;");
				$counter = 1;
		}
	}
}


$request_url = "noi.benjojo.co.uk/notapi/";
$post_params['code'] = $_POST["code"];
$post_params['id'] = $codeid;
if ($haslua == 1){
$post_params['sdin'] = $stin;
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
$result = curl_exec($ch);
curl_close($ch);
/*
$mrBlobby = "0x" . strhex($result);
mysql_query("UPDATE `notorac`.`code` SET `compiler` = $mrBlobby WHERE `code`.`id` = $codeid;");
*/
mysql_close($con);

include('header.php');
?>
<script type="text/javascript">
<!--
function delayer(){
    window.location = "viewcode.php?id=<?php echo $codeid;?>"
}
//-->
</script>
<body onLoad="setTimeout('delayer()', 2000)">



<h2>Processing...</h2>

  <fieldset class="submission">
  	<img src="/notorac/i/cog.gif" alt="GTFO" width="32" height="32" />
	<p><strong>Running your code for</strong> 1.0 second</p>
  </fieldset>





	</div>
</body>
</html>
