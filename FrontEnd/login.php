<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
</head>

<body>
    <div class="header">
        <h1> bruh bruh bruh </h1>
    </div>

    <form action="../BackEnd/logindb.php" method="post">

        <div class="input-group">
            <label for="UserName">UserName</label>
            <input type="text" name="UserName" id="UserName">
        </div>
        <div class="input-group">
            <label for="Password">Password</label>
            <input type="Password" name="Password" id="Password">
        </div>
        <div class="input-group">
            <button type="submit" name="login_user" class="btn">Login</button>
        </div>
        <p>Not a member?</p>
        <a href="register.php">Register here</a>
    </form>

</body>

</html>