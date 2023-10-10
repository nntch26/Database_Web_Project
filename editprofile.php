
<?php

session_start();

// ถ้ามี $_SESSION['is_logged_in'] แสดงว่ามีการ login เข้ามาแล้ว

if (!isset($_SESSION['is_login'])) {
    header('location: login.php'); // ถ้าไม่มีให้เด้งไป login
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

    <title>Hotel Project</title>

</head>

<body>

    <!---- Navbar ---->
    <?php require('inc/navbar.php'); ?>


    <!-- Change Profile-->
    <div class="container">
        <div class="row">
            <h1 class="mt-5">Change Profile</h1>
            <p>แก้ไขข้อมูลส่วนตัวของคุณ</p>

            <form class="p-5 card card-body-profile" action="BackEnd/editprofile_db.php" method="post">
                
                <!-- เช็คว่ามี error มั้ย  ถ้าเป็นค่าว่าง -->
                <?php if (isset($_SESSION['err_edit'])) : ?>
                    <!-- ถ้ามี error ให้แสดง alert  ถ้าเป็นข้อมูลว่าง แสดงข้อความเตือน-->
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['err_edit']; ?>
                    </div>
                <?php endif; ?>

                <!-- เช็คว่ามี error มั้ย  อัปเดตข้อมูลไม่สำเร็จ -->
                <?php if (isset($_SESSION['err_update'])) : ?>
                    <!-- ถ้ามี error ให้แสดง alert -->
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['err_update']; ?>
                    </div>
                <?php endif; ?>

                    <!-- อัปเดตข้อมูลแล้ว -->
                <?php if (isset($_SESSION['profile_update'])) : ?>
                    <!-- ให้แสดง alert -->
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['profile_update']; ?>
                    </div>
                <?php endif; ?>


                <div class="modal-body">
                    <span class="rounded-pill bg-light text-dark mb-5 text-wrap lh-base">หมายเหตุ: รายละเอียดของคุณต้องตรงกับบัตรประจำตัวของคุณ (บัตรประชาชน หนังสือเดินทาง ใบขับขี่ ฯลฯ) ที่จำเป็นในการเช็คอิน
                    </span>

                <div class="container-fluid mt-5 ">
                    <div class="row">
                        <div class="col-md-6 ps-0 mb-3">
                            <label class="form-label">ชื่อ</label>
                            <input type="text" name="firstname" value="<?php echo isset($_SESSION["firstname"]) ? $_SESSION["firstname"] : ''; ?>" class="form-control shadow-none">
                        </div>

                        <div class="col-md-6 ps-0 mb-3">
                            <label class="form-label">นามสกุล</label>
                            <input type="text" name="lastname" value="<?php echo isset($_SESSION["lastname"]) ? $_SESSION["lastname"] : ''; ?>" class="form-control shadow-none">
                        </div>

                        <div class="col-md-12 ps-0 mb-3">
                            <label class="form-label">ที่อยู่</label>
                            <input type="text" name="address" value="<?php echo isset($_SESSION["address"]) ? $_SESSION["address"] : ''; ?>" class="form-control shadow-none">
                        </div>

                        <div class="col-md-6 ps-0 mb-3">
                            <label class="form-label">หมายเลขโทรศัพท์</label>
                            <input type="text" name="phone" value="<?php echo isset($_SESSION["phonenumber"]) ? $_SESSION["phonenumber"] : ''; ?>" class="form-control shadow-none">
                        </div>

                        
                        <div class="text-center my-1">
                            <!-- อัปเดตข้อมูลแล้ว -->
                            <?php if (isset($_SESSION['profile_update'])) : ?>
                                <!-- ให้แสดง button back -->
                                <button type="submit" name="back" class="btn btn-danger shadow-none mb-4 mt-4 me-lg-3 me-2">Go Back</button>
                                <button type="submit" name="update" class="btn btn-primary shadow-none mb-4 mt-4 me-lg-3 me-2">Update</button>

                            <?php else : ?>
                                <button type="submit" name="cancel" class="btn btn-secondary shadow-none mb-4 mt-4 me-lg-3 me-2">Cancel</button>
                                <button type="submit" name="update" class="btn btn-primary shadow-none mb-4 mt-4 me-lg-3 me-2">Update</button>

                            <?php endif; ?>
                        
                        </div>
                    </div>
                </div>	
            </form>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

<?php

if (isset($_SESSION['err_edit']) || isset($_SESSION['err_update']) || isset($_SESSION['profile_update'])) {
    unset($_SESSION['err_edit']);
    unset($_SESSION['err_update']);
    unset($_SESSION['profile_update']);
}


?>