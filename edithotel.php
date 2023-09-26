
<?php

session_start();

// ถ้ามี $_SESSION['is_logged_in'] แสดงว่ามีการ login เข้ามาแล้ว

if (!isset($_SESSION['is_login'])) {
    header('location: login.php'); // ถ้าไม่มีให้เด้งไป login
    
}elseif ($_SESSION["role"] != 'HOTELOWNER'){
    header('location: registerhotel.php');

}



?>

<!--+1-->

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
    <?php require('navbar.php'); ?>

    <!-- Change Profile-->
    <div class="container">
        <div class="row">
            <h1 class="mt-5">Change Hotel</h1>
            <p>แก้ไขข้อมูลโรงแรมของคุณ</p>

            <form class="p-5 card card-body-profile" action="BackEnd/edithotel_db.php" method="post">
                
                <!-- เช็คว่ามี error มั้ย  ถ้าเป็นค่าว่าง -->
                <?php if (isset($_SESSION['err_edithotel'])) : ?>
                    <!-- ถ้ามี error ให้แสดง alert  ถ้าเป็นข้อมูลว่าง แสดงข้อความเตือน-->
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['err_edithotel']; ?>
                    </div>
                <?php endif; ?>

                <!-- เช็คว่ามี error มั้ย  อัปเดตข้อมูลไม่สำเร็จ -->
                <?php if (isset($_SESSION['err_update'])) : ?>
                    <!-- ถ้ามี error ให้แสดง alert -->
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['err_update']; ?>
                    </div>
                <?php endif; ?>

                   <!-- เช็คว่ามี error มั้ย  เบอร์ติดต่อซ้ำ -->
                   <?php if (isset($_SESSION['exist_hotelp'])) : ?>
                    <!-- ถ้ามี error ให้แสดง alert -->
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['exist_hotelp']; ?>
                    </div>
                <?php endif; ?>

                    <!-- อัปเดตข้อมูลแล้ว -->
                <?php if (isset($_SESSION['hotel_update'])) : ?>
                    <!-- ให้แสดง alert -->
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['hotel_update']; ?>
                    </div>
                <?php endif; ?>

   


                <div class="modal-body">
                    <span class="rounded-pill bg-light text-dark mb-5 text-wrap lh-base">หมายเหตุ: รายละเอียดของคุณต้องตรงกับข้อมูลเท็จจริง

                <div class="container-fluid mt-5">
                    <div class="row">

                        <div class="col-md-6 ps-0 mb-3">
                            <label class="form-label">ชื่อโรงแรม</label>
                            <input type="text" name="hotel_name" class="form-control shadow-none">
                        </div>

                        <div class="col-md-6 ps-0 mb-3">
                            <label class="form-label">หมายเลขโทรศัพท์</label>
                            <input type="text" name="hotel_phone" class="form-control shadow-none">
                        </div>
                        
                        <div class="col-md-12 ps-0 mb-3">
                            <label class="form-label">รายละเอียดโรงแรม</label>
                            <textarea type="text" name="hotels_description" class="form-control shadow-none"></textarea>
                        </div>

                        
                        <div class="col-md-12 p-0 mb-3">
                            <label class="form-label">ที่อยู่</label>
                            <input type="text" name="hotel_address" class="form-control shadow-none">
                        </div>

                        <div class="col-md-6 ps-0 mb-3">
                            <label class="form-label">เมือง/จังหวัด</label>
                            <select name="hotel_city" class="form-select shadow-none">
                                <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
                                <option value="เชียงใหม่">เชียงใหม่</option>
                                <option value="เชียงราย">เชียงราย</option>
                                <option value="ภูเก็ต">ภูเก็ต</option>
                                <option value="พังงา">พังงา</option>
                                <option value="กระบี่">กระบี่</option>
                                <option value="เกาะสมุย">เกาะสมุย</option>
                                <option value="เขาใหญ่">เขาใหญ่</option>
                                <option value="นครศรีธรรมราช">นครศรีธรรมราช</option>
                                <option value="ชลบุรี">ชลบุรี</option>
                            </select>
                        </div>

                        <div class="col-md-6 ps-0 mb-3">
                            <label class="form-label">รหัสไปรษณีย์</label>
                            <input type="text" name="hotel_postcode" class="form-control shadow-none">
                        </div>

                        
                        <div class="col-md-6 ps-0 mb-3">
                            <label class="form-label">สิ่งอำนวยความสะดวก</label> <br>
                            <input type="checkbox" name="hotel_facility[]" value="1"> สระว่ายน้ำ<br>
                            <input type="checkbox" name="hotel_facility[]" value="2"> ร้านอาหาร<br>
                            <input type="checkbox" name="hotel_facility[]" value="3"> บริการทำความสะอาดแต่ละวัน<br>
                            <input type="checkbox" name="hotel_facility[]" value="4"> ห้องปลอดบุหรี่<br>
                            <input type="checkbox" name="hotel_facility[]" value="5"> Free Wi-Fi<br>
                        </div>

                        <div class="col-md-6 ps-0 mb-3">
                            <label class="form-label">อัปโหลดรูปภาพของคุณ</label>
                            <input type="file" name="hotel_img" class="form-control shadow-none">
                        </div>


                        
                         
                        
                        <div class="text-center my-1">
                            <!-- อัปเดตข้อมูลแล้ว -->
                            <?php if (isset($_SESSION['hotel_update'])) : ?>
                                <!-- ให้แสดง button back -->
                                <button type="submit" name="edithotel_back" class="btn btn-danger shadow-none mb-4 mt-4 me-lg-3 me-2">Go Back</button>
                                <button type="submit" name="edithotel_update" class="btn btn-primary shadow-none mb-4 mt-4 me-lg-3 me-2">Update</button>

                            <?php else : ?>
                                <button type="submit" name="edithotel_cancel" class="btn btn-secondary shadow-none mb-4 mt-4 me-lg-3 me-2">Cancel</button>
                                <button type="submit" name="edithotel_update" class="btn btn-primary shadow-none mb-4 mt-4 me-lg-3 me-2">Update</button>

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

if (isset($_SESSION['err_edithotel']) || isset($_SESSION['err_update']) 
|| isset($_SESSION['hotel_update']) || isset($_SESSION['exist_hotelp'])) {
    unset($_SESSION['err_edithotel']);
    unset($_SESSION['err_update']);
    unset($_SESSION['hotel_update']);
    unset($_SESSION['exist_hotelp']);
}


?>