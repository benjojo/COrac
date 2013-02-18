<?php
include("./h2o-php/h2o.php");
include("config.php");
CheckSession();

$h2o = new h2o('./templates/home.html');

$page = array(
  'username' => $_SESSION['UserName'],
  'problems' => 'Insert DataHere'
);

# render your awesome page
echo $h2o->render(compact('page'));
?>