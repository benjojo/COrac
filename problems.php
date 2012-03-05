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

$con = mysql_connect("localhost","root","-Removed-");
if (!$con)
  {
  die('Database is unhappy with its working conditions, So its on strike for a while. Its chanting : ' . mysql_error());
  }

mysql_select_db("notorac", $con);
$esc_id = mysql_real_escape_string($_GET["id"]);
$challenge = mysql_query("SELECT * FROM `problems` WHERE `id` = '$esc_id' LIMIT 1;");
$idnumber = $_SESSION['id'];
$username = mysql_query("SELECT * FROM `auth` WHERE `userID` = '$idnumber' LIMIT 1;");
$luaQ = mysql_query("SELECT * FROM `luaScripts` WHERE `codeid` = $esc_id LIMIT 1;");
$luaD = mysql_fetch_array($luaQ);

$prob = mysql_fetch_array($challenge);
mysql_close($con);
include('header.php');
?>


<h2><?php echo $prob['subject'];?></h2>


<p>
  View the <a href="hol.php?id=<?php echo $prob['id'];?>">hall of fame</a> for this problem
</p>
<?php if ($_SESSION['authlevel'] == 2){
$wat = $prob['id'];
echo("<p>
  See how the students are doing <a href=\"teacher_problem.php?id=$wat\">here</a>
</p>
");

} ?>
<form accept-charset="UTF-8" action="submitattemp.php" enctype="multipart/form-data"  method="post">
<div style="margin:0;padding:0;display:inline">
<input name="utf8" type="hidden" value="&#x2713;" />
<input name="id" type="hidden" value="<?php echo $prob['id']; ?>" />
</div>
  <fieldset class="submission">
  	<img src="/notorac/i/cloud_upload.png" alt="GTFO" width="32" height="32" />
    <label for="">Source Code To Submit</label>
    <label for="attempt_language">Language</label>
    <select id="attempt_language" name="attempt[language]"><option value="c">VB.Net</option>
    <label for="attempt[source]">Source Code</label>
    <textarea cols="40" id="code" name="code" rows="20" style="position:relative">Module Module1

    Sub Main()
		
    End Sub

End Module</textarea>

    <input name="commit" type="submit" value="Submit" />
  </fieldset>
  


</form>



  <p><strong>Time Limit:</strong> 1.0 second</p>

<p><?php echo $prob['text'];?></p>


  <table class="sample_data">
    <tr>
      <th>Sample Input</th>
      <th>Sample Output</th>
    </tr>
      <tr>
        <td>
          <pre><?php echo $prob['simp'];?>
</pre>
        </td>
        <td>
          <pre><?php echo $prob['sout'];?>
</pre>
        </td>
      </tr>
  </table>
<?php
if ($_SESSION['authlevel'] == 2){
	echo("	<pre class=\"brush: lua\">");
	echo strtr($luaQ['code'], "Ú", "\n");// HACK
	echo("</pre>");
}
?>


	</div>
</body>
    <script type="text/javascript" src="/notorac/js/jq.js" charset="utf-8"></script>
    <script type="text/javascript" src="/notorac/js/ace.js" charset="utf-8"></script>
    <script type="text/javascript" src="/notorac/js/theme-cobalt.js" charset="utf-8"></script>
    <script type="text/javascript" src="/notorac/js/mode-pgsql.js" charset="utf-8"></script>
	
	  <script type="text/javascript">
  $(function() {    
    var code = $("#code").val();
    $("#code").replaceWith($("<div>").attr({
      id: "code"
    }).css({
      position: "relative",
      width: "960px",
      height: "480px",
      marginBottom: "12px"
    }));
    window.editor = ace.edit("code");
    var textarea = $("textarea").attr("name", "code");
    editor.setTheme("ace/theme/cobalt");
    editor.getSession().setUseSoftTabs(true);
    editor.getSession().setValue(code);
    editor.renderer.setShowPrintMargin(false);
    
    var language_modes = {
      c:    { tabSize: 4, mode: require("ace/mode/pgsql").Mode },
    };
    language_modes.cpp = language_modes.c;
    language_modes.plaintext = { tabSize: 4, mode: editor.getSession().getMode().constructor };
    
    $("form").submit(function() {
      textarea.val(editor.getSession().getValue());
    })
    
    function setModeForLanguage() {
      var lang = $("#attempt_language option:selected").val();
      if(typeof language_modes[lang] !== "undefined") {
        var sess = editor.getSession(), mode = language_modes[lang];
        sess.setTabSize(mode.tabSize);
        sess.setMode(new mode.mode);
      }
    }
    
    $("#attempt_language").bind("change", setModeForLanguage);
    setModeForLanguage();
  });
  </script>

</html>
