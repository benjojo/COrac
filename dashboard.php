<?php
include("./h2o-php/h2o.php");
include("config.php");
CheckSession();

$h2o = new h2o('./templates/home.html');
//Time to fetch the problems.

$ClassID = mysql_real_escape_string($_SESSION['ClassID']);
$ProblemsSQL = mysql_query("SELECT * FROM  `Problems` WHERE `ClassID` = '$ClassID' ORDER BY `Problems`.`ProblemID` DESC LIMIT 5;");
$ProblemArray = json_decode("[[],[],[],[],[]]"); // wat.
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

// Now to fill out the array
$page = array(
  'username' => $_SESSION['UserName'],
  'problems' => $ProblemArray
);

# render your awesome page
echo $h2o->render(compact('page'));
?>