<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="login-background-blue">

    <div class="flex-login-form">

        <h1 class="text-white mb-5">เข้าสู่ระบบ</h1>


        <?php if (isset($_SESSION['err_fill'])) : ?>
            <!-- ถ้ามี error ให้แสดง alert  ถ้าเป็นข้อมูลว่าง แสดงข้อความเตือน-->
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['err_fill']; ?>
            </div>
        <?php endif; ?>


        <?php if (isset($_SESSION['exist_uname'])) : ?>
            <!-- ถ้ามี error ให้แสดง alert  ถ้าไม่มี Username นี้ในระบบ-->
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['exist_uname']; ?>
            </div>
        <?php endif; ?>

        <!-- เช็คว่ามี error มั้ย  รหัสไม่ตรงกัน -->
        <?php if (isset($_SESSION['err_pw'])) : ?>
            <!-- ถ้ามี error ให้แสดง alert -->
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['err_pw']; ?>
            </div>
        <?php endif; ?>



        <form class="p-5 card login-card-custom" action="BackEnd/login_db.php" method="post">
            <div class="form-outline mb-3">
                <label class="form-label" for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" />
            </div>

            <div class="form-outline mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" />
            </div>

            <div class="row">
                <p class="text-center">Is not a member ? <a href="register.php">Register</a></p>
            </div>

            <button type="submit" name="submit" class="btn login-btn-blue btn-block text-white">Login</button>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>

<?php

if (isset($_SESSION['err_fill']) || isset($_SESSION['exist_uname']) || isset($_SESSION['err_pw'])) {
    unset($_SESSION['err_fill']);
    unset($_SESSION['exist_uname']);
    unset($_SESSION['err_pw']);
}


?>