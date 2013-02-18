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
if ($_SESSION['authlevel'] < 2){
	$challenge = mysql_query("INSERT INTO `notorac`.`alerts` (`userid`, `issue`) VALUES ('$idnumber', 'Attemped to load teacher only page.');");
	die('You are not allowed to view this page. This offence has been logged.');
}
if(isset($_POST['code'])){

	shell_exec("bash clear.sh");
	$myFile = "file.lua";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = $_POST['code'];
	fwrite($fh, $stringData);
	fclose($fh);
	$testoutput = shell_exec("lua file.lua");
	shell_exec("bash clear.sh");
	
	$prepArr = explode("#",$testoutput);
	$counter = 0;
	foreach ($prepArr as $pop){
		if ($counter == 1){
				$stout = $pop;
		}else{
				$stin = $pop;
				$counter = 1;
		}
	}


}
$idnumber = $_SESSION['id'];
include('header.php');
?>

<h2>Testing Lua:</h2>
<form accept-charset="UTF-8" action="teacher_lua.php" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" />
    </div>
	<fieldset class="submission">
	<?php
	if(isset($stin)){echo "
    <h2>Input</h2>
	<p>$stin</p>
    <h2>Output</h2>
	<p>$stout</p>
	";
	}
	?>
	<label for="">Source Code To Submit</label>
    <label for="attempt_language">Language</label>
    <select id="attempt_language" name="attempt[language]"><option value="c">Lua</option>
    <label for="attempt[source]">Source Code</label>
    <textarea cols="40" id="code" name="code" rows="20" style="position:relative">print ("Hello World!")</textarea>

    <input name="commit" type="submit" value="Submit" />
  </fieldset>

</form>

<?php

mysql_close($con); // I hate when I have to do this...

?>
</body>
    <script type="text/javascript" src="/notorac/js/jq.js" charset="utf-8"></script>
    <script type="text/javascript" src="/notorac/js/ace.js" charset="utf-8"></script>
    <script type="text/javascript" src="/notorac/js/theme-cobalt.js" charset="utf-8"></script>
    <script type="text/javascript" src="/notorac/js/mode-lua.js" charset="utf-8"></script>
	
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
      c:    { tabSize: 4, mode: require("ace/mode/lua").Mode },
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
