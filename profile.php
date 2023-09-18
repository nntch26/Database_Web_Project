<?php
session_start();
include('/BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


// เช็คว่า login หรือยัง ถ้ายัง ให้กลับไปยังหน้า login.php เพื่อทำการ login ก่อน
if (!isset($_SESSION['is_login'])) {
    header('location: login.php');
}
else{
    // query ข้อมูลของคนที่ login เข้ามา เพื่อแสดงผลใน html
    $select_stmt3 = $db->prepare("SELECT * FROM users WHERE users_username = :username");
    $select_stmt3->bindParam(':username', $_SESSION["username"]);
    $select_stmt3->execute();
    $row = $select_stmt3->fetch(PDO::FETCH_ASSOC);  // ทำบรรทัดนี้ กรณีที่เราต้องการดึงข้อมูลมาแสดง
    // query ข้อมูลของคนที่ login เข้ามา 

    $_SESSION["userid"] = $row['user_id'];
    $_SESSION["firstname"] = $row['users_first_name'];
    $_SESSION["lastname"] = $row['users_last_name'];
    $_SESSION["username"] = $row['users_username'];
    $_SESSION["email"] = $row['users_email'];
    $_SESSION["password"] = $row['users_password'];
    $_SESSION["phonenumber"] = $row['users_phone_number'];
    $_SESSION["address"] = $row['users_address'];
    $_SESSION["city"] = $row['users_city'];
    $_SESSION["postcode"] = $row['users_postcode'];
    $_SESSION["role"] = $row['users_role'];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600&family=Noto+Sans+Thai:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/styles.css">

    <title>Profile</title>

</head>

<body>

    <!---- Navbar ---->
    <?php require('navbar.php'); ?>

    <!-- profile -->
    <div class="container">
        <div class="row">
            <h1 class="mt-5">Profile Page</h1>
            <p>ข้อมูลส่วนตัว อัปเดตข้อมูลของคุณ</p>
            <div class="col-md-6">

                <div class="card mt-5">
                    <div class="card-body-profile" style="line-height: 3;">
                        <h4>รายละเอียดบัญชี</h4>
                        <span class="mt-5" style="font-weight: 700;">Username</span> : <?php echo $_SESSION["username"]; ?> <br>
                        <span style="font-weight: 700;">ชื่อ - นามสกุล</span> : <?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?> <br>
                        <span class="mt-5" style="font-weight: 700;">Email</span> : <?php echo $_SESSION["email"]; ?> <br>
                        <span style="font-weight: 700;">หมายเลขโทรศัพท์ </span> : <?php echo $_SESSION["phonenumber"]; ?> <br>
                        <span style="font-weight: 700;">ที่อยู่</span> : <?php echo $_SESSION["address"]; ?> <br>
                        <span style="font-weight: 700;">เมือง/จังหวัด</span> : <?php echo $_SESSION["city"]; ?> <br>
                        <span style="font-weight: 700;">รหัสไปรษณีย์</span> : <?php echo $_SESSION["postcode"]; ?> <br>
                        <span style="font-weight: 700;">Role</span> : <?php echo $_SESSION["role"]; ?>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body-profile" style="line-height: 3;">
                        <h4>แก้ไขข้อมูลส่วนตัวของคุณ</h4>
                        <a href="../FrontEnd/editprofile.php" class="btn btn-primary shadow-none mb-5 mt-4 me-lg-3 me-2">แก้ไขข้อมูล</a>

                        <h4>แสดงประวัติการจองของคุณ</h4>
                        <a href="#" class="btn btn-primary shadow-none mb-4 mt-4 me-lg-3 me-2">ดูประวัติการจอง</a>

                    </div>
                </div>

            </div>




        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>