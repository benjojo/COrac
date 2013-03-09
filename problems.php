<?php
if(!isset($_GET['id'])) { header("Location: ./dashboard.php"); die(); } // Make sure they set the ID

include("./h2o-php/h2o.php");
include("config.php");
CheckSession();

$h2o = new h2o('./templates/problem.html');
//Time to fetch the problem.

$ClassID = mysql_real_escape_string($_SESSION['ClassID']);
$SafeID = mysql_real_escape_string($_GET['id']);
$ProblemSQL = mysql_query("SELECT * FROM  `Problems` WHERE `ProblemID` = $SafeID LIMIT 1;");
$ProblemData = mysql_fetch_array($ProblemSQL);
//print_r($ProblemData);
$page = array(
  'username' => $_SESSION['UserName'],
  'ProblemName' => $ProblemData[2],
  'ProblemID' => $ProblemData[0],
  'TimeLimit' => $ProblemData[4],
  'SampleInput' => "none",
  'SampleOutput' => "none"
);

echo $h2o->render(compact('page'));
?>