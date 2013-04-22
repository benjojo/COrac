<?php
include("./h2o-php/h2o.php");
include("config.php");
CheckSession();

//die(print_r($_REQUEST));
/*

Array
(
    [utf8] => ✓
    [id] => 1
    [attempt] => Array
        (
            [language] => c
        )

    [code] => class App {
    public static void main(String[] args) {
        System.out.println("This is a string."); // This is a comment
        
    }
}
    
    [commit] => Submit
)
*/
if(!isset($_REQUEST['id'])) { header("Location: ./dashbord.php"); die(); } // Make sure they set the ID
$h2o = new h2o('./templates/submitting.html');
//Time to fetch the problem.



/*
Ok, so what we need to do here is to put the problem in the que to make sure that the code running service picks it up and runs it correctly,
To do this we will put it in a table and work from that.
*/
//INSERT INTO `attempts` (`AttemptOwner`, `ProblemID`, `Code`, `Output`, `ExpectedOutput`, `CompilerOutput`, `ExecTime`) VALUES (1, 1, 'code', 'o1', 'o2', 'co', 1);
$code = mysql_real_escape_string($_REQUEST['code']);

if(isset($_REQUEST['code']))
{
    mysql_query("INSERT INTO `attempts` (`AttemptOwner`, `ProblemID`, `Code`, `Output`, `ExpectedOutput`, `CompilerOutput`, `ExecTime`) VALUES (1, 1, '$code', '', '', '', 1);");
    $AttemptID = mysql_insert_id ();
}
else
{
    if(isset($_REQUEST['wid']))
    {
         $AttemptID = (int) $_REQUEST['wid'];
    }
    else
    {
        header("Location: ./dashbord.php");
    }
}

//print_r($ProblemData);
$page = array(
  'ProblemID' => $AttemptID
);

echo $h2o->render(compact('page'));
?>