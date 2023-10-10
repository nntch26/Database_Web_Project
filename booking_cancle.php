<?php
session_start();
include('BackEnd/includes/connect_database.php');

if (!isset($_SESSION['is_login'])) {
    header('location: login.php');
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600&family=Noto+Sans+Thai:wght@100&display=swap" rel="stylesheet">

    <title>ฟอร์มยกเลิก</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>ฟอร์มยกเลิก</h2>

        <!-- อัปเดตข้อมูลแล้ว -->
        <?php if (isset($_SESSION['cancle'])) : ?>
        <!-- ให้แสดง alert -->
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['cancle']; ?>
        </div>                            
        <?php endif; ?>



        <form method="post" action="BackEnd/booking_cancle_db.php">

                <div class="form-group">
                    <label for="transactionNumber">เลขการทำรายการ:</label>
                    <input type="text" class="form-control" id="transactionNumber" value="<?php echo isset($_SESSION["booking_id"]) ? $_SESSION["booking_id"] : ''; ?>">
                </div>
                
            <div class="row">
                <div class="col-md-6 ps-0 mb-3">
                    <label class="form-label">ชื่อ</label>
                    <input type="text" name="firstname" value="<?php echo isset($_SESSION["firstname"]) ? $_SESSION["firstname"] : ''; ?>" class="form-control shadow-none">
                </div>

                <div class="col-md-6 ps-0 mb-3">
                    <label class="form-label">นามสกุล</label>
                    <input type="text" name="lastname" value="<?php echo isset($_SESSION["lastname"]) ? $_SESSION["lastname"] : ''; ?>" class="form-control shadow-none">
                </div>

                <div class="col-md-6 ps-0 mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="address" value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : ''; ?>" class="form-control shadow-none">
                </div>

                <div class="col-md-6 ps-0 mb-3">
                    <label class="form-label">หมายเลขโทรศัพท์</label>
                    <input type="text" name="phone" value="<?php echo isset($_SESSION["phonenumber"]) ? $_SESSION["phonenumber"] : ''; ?>" class="form-control shadow-none">
                </div>

                <div class="col-md-6 ps-0 mb-3">
                    <label class="form-label">หมายเลขบัญชีธนาคาร</label>
                    <input type="text" name="banknum" class="form-control shadow-none">
                </div>

                <div class="col-md-6 ps-0 mb-3">
                    <label class="form-label">ธนาคาร</label>
                    <input type="text" name="bank" class="form-control shadow-none">
                </div>
            </div>

            <div class="form-group">
                <label for="reason">เหตุผลที่ยกเลิก:</label>
                <textarea class="form-control" id="reason" name="reason" rows="4" placeholder="กรอกเหตุผลที่ยกเลิก"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">ยกเลิกคำขอ</button>
        </form>
    </div>








    <!-- เรียกใช้ Bootstrap JS และ jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php

if (isset($_SESSION['cancle'])) {
    unset($_SESSION['cancle']);
}


?>