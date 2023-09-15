<?php 
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="login-background-blue">

    <div class="flex-login-form">

        <h1 class="text-white mb-5">สมัครสมาชิก</h1>

        <!-- เช็คว่ามี error มั้ย  ถ้าเป็นค่าว่าง -->
        <?php if (isset($_SESSION['err_fill'])) : ?>
            <!-- ถ้ามี error ให้แสดง alert  ถ้าเป็นข้อมูลว่าง แสดงข้อความเตือน-->
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['err_fill']; ?> 
            </div>
        <?php endif; ?>

        <!-- เช็คว่ามี error มั้ย  รหัสไม่ตรงกัน -->
        <?php if (isset($_SESSION['err_pw'])) : ?>
            <!-- ถ้ามี error ให้แสดง alert -->
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['err_pw']; ?> 
            </div>
        <?php endif; ?>

        <!-- เช็คว่ามี error มั้ย  username มีแล้วในระบบ -->
        <?php if (isset($_SESSION['exist_uname'])) : ?>
            <!-- ถ้ามี error ให้แสดง alert -->
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['exist_uname']; ?> 
            </div>
        <?php endif; ?>

        <!-- เช็คว่ามี error มั้ย  มี email นี้แล้ว สมัครไม่สำเร็จ -->
        <?php if (isset($_SESSION['exist_email'])) : ?>
            <!-- ถ้ามี error ให้แสดง alert -->
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['exist_email']; ?> 
            </div>
        <?php endif; ?>

        <!-- เช็คว่ามี error มั้ย  สมัครไม่สำเร็จ -->
        <?php if (isset($_SESSION['err_insert'])) : ?>
            <!-- ถ้ามี error ให้แสดง alert -->
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['err_insert']; ?> 
            </div>
        <?php endif; ?>






        <!--action="บอกว่าจะดึงข้อมูลไปที่ไหน.php" method=" อันนี้เพิ่มข้อมูลใน db ใช้เป็น post"-->

        <form class="p-5 card login-card-custom" action="../BackEnd/register_db.php" method="post">

            <div class="form-outline mb-3">
                <label class="form-label" for="form1Example1">Username</label>
                <input type="text" name ="username" class="form-control" />
            </div>

            <div class="form-outline mb-3">
                <label class="form-label" for="form1Example1">Email</label>
                <input type="text" name ="email" class="form-control" />
            </div>

            <div class="form-outline mb-3">
                <label class="form-label" for="form1Example1">Password</label>
                <input type="password" name = "password" class="form-control" />
            </div>

            <div class="form-outline mb-3">
                <label class="form-label" for="form1Example1">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" />
            </div>

            <div class="row">
                <p class="text-center">Is a member ? <a href="login.php">Login</a></p>
            </div>

            <button type="submit" name="submit" class="btn login-btn-blue btn-block text-white">Register</button>

        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>


<!-- เมื่อตรวจสอบ error เสร็จแล้วให้ลบ session เพื่อรีหน้าใหม่--->
<?php 
    if(isset($_SESSION['err_fill'])){
        unset($_SESSION['err_fill']);

    }else if(isset($_SESSION['err_pw'])){
        unset($_SESSION['err_pw']);

    }else if(isset($_SESSION['exist_uname'])){
        unset($_SESSION['exist_uname']);

    }else if(isset($_SESSION['err_insert'])){
        unset($_SESSION['err_insert']);

    }else if(isset($_SESSION['exist_email'])){
        unset($_SESSION['exist_email']);
    }

?>