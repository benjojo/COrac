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
		<form accept-charset="UTF-8" action="reg.php" method="post"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" />
    </div> <fieldset>
    <label for="user_login">Login</label>
    <input id="user_login" name="user[login]" size="30" type="text" />

    <label for="user_email">Email</label>
    <input id="user_email" name="user[email]" size="30" type="text" />

    <label for="user_password">Password</label>
    <input id="user_password" name="user[password]" size="30" type="password" />

    <label for="user_password_confirmation">Password confirmation</label>
    <input id="user_password_confirmation" name="user[password_confirmation]" size="30" type="password" />

    <input name="commit" type="submit" value="Register" />
  </fieldset>
</form>
	</div>
</body>

</html>
