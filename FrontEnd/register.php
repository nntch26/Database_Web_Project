<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register System</title>
</head>

<body>
    <div class="header">
        <h1> Hello php T^T </h1>
    </div>

    <form action="../BackEnd/registerdb.php" method="post">
        <div class="input-group">
            <label for="FirstName">FirstName</label>
            <input type="text" name="FirstName" id="FirstName">
        </div>
        <br>
        <div class="input-group">
            <label for="LastName">LastName</label>
            <input type="text" name="LastName" id="LastName">
        </div>
        <br>
        <div class="input-group">
            <label for="UserName">UserName</label>
            <input type="text" name="UserName" id="UserName">
        </div>
        <br>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <br>
        <div class="input-group">
            <label for="Password">Password</label>
            <input type="Password" name="Password" id="Password">
        </div>
        <br>
        <div class="input-group">
            <label for="PhoneNumber">PhoneNumber</label>
            <input type="text" name="PhoneNumber" id="PhoneNumber">
        </div>
        <br>
        <div class="input-group">
            <label for="Address">Address</label>
            <input type="text" name="Address" id="Address">
        </div>
        <br>
        <label for="Role">Choose Role:</label>

        <select id="Role" name="role">
            <option value="Tourist" selected>Tourist</option>
            <option value="Hotel Manager">Hotel Manager</option>
        </select>
        <div class="input-group">
            <button type="submit" name="reg_user" class="btn">Register</button>
        </div>
        <p>Already a member?</a></p>
        <a href="login.php">Login</a>
    </form>

</body>

</html>