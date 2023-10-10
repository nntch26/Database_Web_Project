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

        <form method="post" action="booking_cancel_db.php">
            <div class="col-md-6 ps-0 mb-3">
                <label for="transactionNumber">เลขการทำรายการ:</label>
                <input type="text" class="form-control" id="transactionNumber" placeholder="กรอกเลขการทำรายการ">
            </div>

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
                <input type="text" name="address" value="<?php echo isset($_SESSION["address"]) ? $_SESSION["address"] : ''; ?>" class="form-control shadow-none">
            </div>

            <div class="col-md-6 ps-0 mb-3">
                <label class="form-label">หมายเลขโทรศัพท์</label>
                <input type="text" name="phone" value="<?php echo isset($_SESSION["phonenumber"]) ? $_SESSION["phonenumber"] : ''; ?>" class="form-control shadow-none">
            </div>




            <div class="form-group">
                <label for="reason">เหตุผลที่ยกเลิก:</label>
                <textarea class="form-control" id="reason" rows="4" placeholder="กรอกเหตุผลที่ยกเลิก"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">ยกเลิกคำขอ</button>
        </form>
    </div>








    <!-- เรียกใช้ Bootstrap JS และ jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
