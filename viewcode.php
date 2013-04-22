<?php
include("./h2o-php/h2o.php");
include("config.php");
CheckSession();

if(!isset($_REQUEST['id'])) { header("Location: ./dashboard.php"); die(); } // Make sure they set the ID
$h2o = new h2o('./templates/viewcode.html');
//Time to fetch the attempt.
$safe_id = (int)$_REQUEST['id'];
$Query = mysql_query("SELECT * FROM `attempts` WHERE AttemptID = $safe_id LIMIT 1");
$Data = mysql_fetch_array($Query);
if(mysql_num_rows($Query) == 0)
{
    die(mysql_num_rows($Query));
     header("Location: ./dashboard.php"); die();
}
if($Data['Solved'] == 0)
{
    if(isset($_REQUEST['WaitC'])){
        $WaitCount = (int)$_REQUEST['WaitC'] + 1;
    } else {
        $WaitCount  = 1;
    }
     header("Location: ./submit_attempt.php?wid=$safe_id&id=1&WaitC=$WaitCount"); die();
}


// Ok good news, its been solved. right now lets fill the page out with dataaaa
$ShowError = false;
$Error = "";

if($Data['Output'] == "")
{
    $ShowError = true;
    $Error = "No output from program, Code might of failed. Check the compiler output for errors.";
}
else
{
    if($Data['Output'] != $Data['ExpectedOutput'])
    {
        $ShowError = true;
        $Error = "Code answer did not match up, Expected '" . $Data['ExpectedOutput'] . "'";
    }
}

$page = array(
  'SubmissionID' => $safe_id,
  'showerror' => $ShowError,
  'Error' => $Error,
  'OrigCode' => $Data['Code'],
  'Output' => $Data['Output'],
  'CompilerOutput' => $Data['CompilerOutput'],
  'ExecTime' => $Data['ExecTime']
);

echo $h2o->render(compact('page'));
?>