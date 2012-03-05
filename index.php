<!DOCTYPE html>
<html>
<head>
        <title>COrac</title>
        <link href='http://fonts.googleapis.com/css?family=Expletus+Sans' rel='stylesheet' type='text/css'>
        <link href="style.css" rel="stylesheet" />

</head>
<body>
        <div class="container">
                <header>
                        <h1>COrac</h1>
                        <ul class="nav">
						
										<li><img src="/notorac/i/key.png" alt="Key" width="32" height="32" /></li>
                                        <li><a href="index.php">Login</a></li>
										<li><img src="/notorac/i/pen.png" alt="Key" width="32" height="32" /></li>
                                        <li><a href="reg.php">Register</a></li>
                        </ul>
                </header>
                <form accept-charset="UTF-8" action="login.php" method="post">
        <fieldset>
                <label for="user_session_login">Login</label>
                <input id="user_session_login" name="login" size="30" type="text" />
                <label for="user_session_password">Password</label>
                <input id="user_session_password" name="password" size="30" type="password" />
                <input name="commit" type="submit" value="Login" />
        </fieldset>
</form>
        </div>
</body>
</html>
