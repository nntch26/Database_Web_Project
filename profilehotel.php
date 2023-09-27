<?php 
    session_start(); 
    include('BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


    // เช็คว่า login หรือยัง ถ้ายัง ให้กลับไปยังหน้า login.php เพื่อทำการ login ก่อน
    if (!isset($_SESSION['is_login'])) {
        header('location: login.php');
    }

    // เช็คว่า ได้ลงทะเบียนที่พักหรือยัง
    elseif ($_SESSION["role"] != 'HOTELOWNER'){
        header('location: registerhotel.php');

    }
    else{
        // query ข้อมูลของคนที่ login เข้ามา เพื่อแสดงผลใน html
        $select_stmt3 = $db->prepare("SELECT * FROM hotels 
        JOIN locations l USING (location_id) 
        WHERE user_id = :user_id");

        $select_stmt3->bindParam(':user_id', $_SESSION["userid"]);
        $select_stmt3->execute();
 
        $row = $select_stmt3->fetch(PDO::FETCH_ASSOC); // กรณีที่เราต้องการดึงข้อมูลมาแสดง
        $_SESSION["hotel_id"] = $row['hotel_id']; // เอาไปใช้ต่อ
        $_SESSION["user_id"] = $row['user_id'];
        $_SESSION["hotelname"] = $row['hotels_name'];
        $_SESSION["hotelphone"] = $row['hotels_phone'];
        $_SESSION["hoteladdress"] = $row['hotels_address'];
        $_SESSION["hotelpostcode"] = $row['hotels_postcode'];
        $_SESSION['hoteldes'] = $row['hotels_description'];
           
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
    <style>

        .item {
            background-color: #3498db; /* สีพื้นหลัง */
            color: #fff; /* สีข้อความ */
            padding: 10px;
            text-align: center;
            height: 200px; /* กำหนดความสูง */
            width: 600px; /* กำหนดความกว้าง */
        }
    </style>
    <title>Profile Hotel</title>
    

</head>

<body>

    <!---- Navbar ---->
    <?php require('navbar.php'); ?>

    <!-- profile -->
    <div class="container">
        <div class="row">
            <h1 class="mt-5">Profile Hotel</h1>
            <p>ข้อมูลส่วนของที่พัก อัปเดตข้อมูลที่พักของคุณ</p>
            <div class="col-md-12 mb-3">
                <div class="card mt-5">
                    <div class="card-body-profile" style="line-height: 3;">
                        <h4>รายละเอียด</h4>
                        <span class="mt-5" style="font-weight: 700;">ชื่อโรงแรม</span> : <?php echo $row['hotels_name']; ?> <br>
                        <span style="font-weight: 700;">เบอร์ติดต่อ</span> : <?php echo $row['hotels_phone'] ;?> <br>
                        <span class="mt-5" style="font-weight: 700;">รายละเอียดโรงแรม</span> : <p><?php echo $row['hotels_description']; ?></p>  <!--+1-->
                        <span style="font-weight: 700;">ที่อยู่</span> : <?php echo $row['hotels_address']; ?> <br>
                        <span style="font-weight: 700;">เมือง/จังหวัด</span> : <?php echo $row['location_name']; ?>  <br>
                        <span style="font-weight: 700;">รหัสไปรษณีย์</span> : <?php echo $row['hotels_postcode']; ?>  <br>
                    </div>
                </div>

            </div>

            <div class="col-md-4 mb-5">
                <div class="card mt-5">
                    <div class="card-body-profile" style="line-height: 3;">
                        <h4>แก้ไขข้อมูล โรงแรมของคุณ</h4>
                        <a href="edithotel.php" class="btn btn-primary shadow-none mb-4 mt-4 me-lg-3 me-2">แก้ไขข้อมูล</a>
                    </div>
                </div>

            </div>

            <div class="col-md-4 mb-5">
                <div class="card mt-5">
                    <div class="card-body-profile" style="line-height: 3;">
                        <h4>ข้อมูลห้องพักของคุณ</h4>
                        <a href="insertroom.php" class="btn btn-primary shadow-none mb-4 mt-4 me-lg-3 me-2">เพิ่มข้อมูลห้องพัก</a>
                        <a href="editroom_main.php" class="btn btn-primary shadow-none mb-4 mt-4 me-lg-3 me-2">แก้ไขข้อมูล</a>

                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-5">
                <div class="card mt-5">
                    <div class="card-body-profile" style="line-height: 3;">
                        <h4>แสดงประวัติการชำระของลูกค้า</h4>
                        <a href="#" class="btn btn-primary shadow-none mb-4 mt-4 me-lg-3 me-2">ดูประวัติชำระเงิน</a>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>