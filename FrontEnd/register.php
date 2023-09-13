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
            <label for="users_first_name">FirstName</label>
            <input type="text" name="users_first_name" id="users_first_name">
        </div>
        <br>
        <div class="input-group">
            <label for="users_last_name">LastName</label>
            <input type="text" name="users_last_name" id="users_last_name">
        </div>
        <br>
        <div class="input-group">
            <label for="users_username">UserName</label>
            <input type="text" name="users_username" id="users_username">
        </div>
        <br>
        <div class="input-group">
            <label for="users_email">Email</label>
            <input type="email" name="users_email" id="users_email">
        </div>
        <br>
        <div class="input-group">
            <label for="users_password">Password</label>
            <input type="Password" name="users_password" id="users_password">
        </div>
        <br>
        <div class="input-group">
            <label for="users_phone_number">PhoneNumber</label>
            <input type="text" name="users_phone_number" id="users_phone_number">
        </div>
        <br>
        <div class="input-group">
            <label for="users_address">Address</label>
            <input type="text" name="users_address" id="users_address">
        </div>
        <br>
        <label for="Role">Choose Role:</label>
        <!-- <select id="Role" name="role">
            <option value="Tourist" selected>Tourist</option>
            <option value="Hotel Manager">Hotel Manager</option>
        </select> -->
        <div class="input-group">
            <button type="submit" name="reg_user" class="btn">Register</button>
        </div>
        <p>Already a member?</a></p>
        <a href="login.php">Login</a>
    </form>

</body>

</html>