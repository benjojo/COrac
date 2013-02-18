<?php
/*
Things that are stored in the session var.
UserID
UserName
ClassID
*/
include("config.php");
function MakeHash($password,$username)
{
    //Some Servers do not have BlowFish, So I provide a failover that could be as hard to solve.
    //Because there are two alrgro's the first letter of the string states what one it was done in.
    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) 
    {
        $salt = '$2a$07$R.SeEmSLe.GiTaGoOdPasS$';
        return ("C" . crypt($username . $password, $salt));
    }
    else 
    {
        $FinalHash = "";
        for ($i = 1; $i <= 10000; $i++) 
        {
            $FinalHash = md5(md5($i).$password.$username.$FinalHash); // I'm pretty sure this is a b*itch to solve.
        }
        return("M" . $FinalHash);
    }
}
if(isset($_POST['login']) && isset($_POST['password']))
{
    $Safe_Username = mysql_real_escape_string($_POST['login']);
    $Safe_Password = mysql_real_escape_string(MakeHash($_POST['password'],$_POST['login']));
    $Login_Query = mysql_query("SELECT * FROM `Users` WHERE `Name` = '$Safe_Username' AND `Hash` = '$Safe_Password'");
    $Login_Results = mysql_fetch_array($Login_Query);
    if(mysql_num_rows($Login_Query) != 0)
    {
        // The Correct Login was Entered.
        $_SESSION['UserID'] = $Login_Results['UserID'];
        $_SESSION['UserName'] = $Login_Results['Name'];
        $_SESSION['ClassID'] = $Login_Results['ClassID'];
        header("location: dashboard.php");
        die("Redirecting...");
    }
    else
    {
        sleep(1); //Stop the ~attacker~ from moving too fast.
        die("Incorrect Username or Password. Please try again.");
    }
}
else
{
    if(isset($_SERVER['HTTP_REFERER']))
    {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Send the user back to where they came from.
    }
    else
    {
        header("Location: ../"); // If not. then just send them back to the root dir.
    }
}
?>