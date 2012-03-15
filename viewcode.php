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

$esc_id = mysql_real_escape_string($_GET["id"]);
$submission = mysql_query("SELECT * FROM `submissions` WHERE `codeid` = '$esc_id' LIMIT 1;");
$submissiondata = mysql_fetch_array($submission);
$codeid = $esc_id;
$userid = $submissiondata['userid'];
$problemid = $submissiondata['problemid'];

$userlookup = mysql_query("SELECT * FROM `auth` WHERE `userID` = '$userid' LIMIT 1;");
$userdata = mysql_fetch_array($userlookup);

$username = mysql_query("SELECT * FROM `code` WHERE `id` = '$codeid' LIMIT 1;");
$code = mysql_fetch_array($username);


mysql_close($con);
include('header.php');
if ($code['output'] == ""){
echo("			<div class=\"warning\">
				<ul>
						<p>No Output was Given. Check the compiler output for errors?</p>
				</ul>
			</div>
			");
			}
if (md5($code['output']) == "2069e0021d088d04710ccff7681d1abe"){
echo("			<div class=\"warning\">
				<ul>
						<p>Exectuion Failed. Check The Compiler.</p>
				</ul>
			</div>
			");
			}
if (((int)($code['time'])) >= 1){
echo("			<div class=\"warning\">
				<ul>
						<p>Code Ran for too long. Infinate loop?</p>
				</ul>
			</div>
			");
}
?>
<script type="text/javascript" src="js/XRegExp.js"></script>
<script type="text/javascript" src="js/shCore.js"></script>
<script type="text/javascript" src="js/shBrushVb.js"></script>


<link href="shCore.css" rel="stylesheet" type="text/css" />
<link href="shThemeDefault.css" rel="stylesheet" type="text/css" />
 

<h2>Code Submission number #<?php echo $codeid;?> (By <?php echo $userdata['username'];?>) <?php if($submissiondata['correct'] == 1){echo "(Correct)";}?></h2>

  <fieldset class="submission">
  	<img src="/notorac/i/document.png" alt="Document" width="32" height="32" />
	<p><strong>Source code</strong></p>
	
	<pre class="brush: vb">
	<?php echo strtr($code['code'], "Ú", "\n");// HACK?>
	</pre>

  	<img src="/notorac/i/arrowd.png" alt="Document" width="32" height="32" />
	<p><strong>Output</strong></p>
	<textarea wrap="off"><?php echo $code['output'];?></textarea>
  	<img src="/notorac/i/read.png" alt="Document" width="32" height="32" />
	<p><strong>Compiler Said...</strong></p>
	<textarea wrap="off"><?php
	$swag = strtr($code['compiler'], "Ú", "\n");
	echo str_replace("/var/www/notapi", "~", $swag);
	?></textarea>
	<img src="/notorac/i/arrowd.png" alt="Document" width="32" height="32" />
	<?php
	if(isset($code['sdin'])){
		$ding = $code['sdin'];
		echo("<p><strong>What was inputted into the program:</strong></p><p> $ding </p>");
	}
	?>
	<img src="/notorac/i/clock.png" alt="Document" width="32" height="32" />
	<p><strong>Execution Time:</strong></p>
	<p>
	<?php echo $code['time'] . " Secs";?>
	</p>
  </fieldset>
  





	</div>
	<script type="text/javascript">
     SyntaxHighlighter.all()
</script>
</body>
</html>

