<?php
if(!isset($_GET['id'])) { header("Location: ./dashboard.php"); die(); } // Make sure they set the ID

include("./h2o-php/h2o.php");
include("config.php");
CheckSession();

$h2o = new h2o('./templates/problem.html');
//Time to fetch the problem.

$ClassID = mysql_real_escape_string($_SESSION['ClassID']);
$SafeID = mysql_real_escape_string($_GET['id']);
$ProblemsSQL = mysql_query("SELECT * FROM  `Problems` WHERE `ClassID` = '$ClassID' AND `ProblemID` = $SafeID LIMIT 1;");
$ProblemArray = array();
$Count = 0;
while($row = mysql_fetch_array($ProblemsSQL))
{
    $Prob = array(
        'id' => $row['ProblemID'],
        'name' => $row['ProblemName']
    );
    $ProblemArray[$Count] = $Prob;
    $Count++;
}
//print_r(array('problems' => $ProblemArray));
// Now to fill out the array

$page = array(
  'username' => $_SESSION['UserName'],
  'probs' => $ProblemArray
);

echo $h2o->render($page);
?>