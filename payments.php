<?php
session_start();
include('BackEnd/includes/connect_database.php');

if (!isset($_SESSION['is_login'])) {
    header('location: login.php');
} else {
    // query ข้อมูลของคนที่ login เข้ามา เพื่อแสดงผลใน html
    $select_stmt3 = $db->prepare("SELECT * FROM users WHERE users_username = :username");
    $select_stmt3->bindParam(':username', $_SESSION["username"]);
    $select_stmt3->execute();
    $row = $select_stmt3->fetch(PDO::FETCH_ASSOC);  // ทำบรรทัดนี้ กรณีที่เราต้องการดึงข้อมูลมาแสดง
    // query ข้อมูลของคนที่ login เข้ามา 

    $select_stmt = $db->prepare("SELECT * FROM hotels
                                    JOIN rooms USING (hotel_id)
                                    WHERE hotel_id = :hotel_id AND room_id = :room_id");
    $select_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
    $select_stmt->bindParam(':room_id', $_SESSION["room_id"]);
    $select_stmt->execute();
    $result = $select_stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600&family=Noto+Sans+Thai:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/PaymentAndBooking.css">
    <title>Document</title>
</head>

<body>
    <h1 class="checkout">Payments</h1>
    <div class="row">
        <div class="col-75">
            <div class="container">
                <form action="BackEnd/sent_pay.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-50">
                            <h4>Billing Address</h4>
                            <label for="fname"> Full Name</label>
                            <?php echo "<pre>" . $row["users_first_name"] . " " . $row["users_last_name"] . "</pre>" ?>
                            <label for="email"> Email</label>
                            <?php echo "<pre>" . $row["users_email"] . "</pre>" ?>
                            <label for="phone"> Phone Number</label>
                            <?php echo "<pre>" . $row["users_phone_number"] . "</pre>" ?>
                            <div class="row">
                                <div class="col-50">
                                    <label for="check-in">Check-In</label>
                                    <?php echo "<pre>" . $_SESSION["checkin"] . "</pre>" ?>
                                </div>
                                <div class="col-50">
                                    <label for="check-out">Check-Out</label>
                                    <?php echo "<pre>" . $_SESSION["checkout"] . "</pre>" ?>
                                </div>
                            </div>
                            
                            <hr>

                            <div class="row">
                                <label class="form-label">อัปโหลดรูปภาพสลิปหลักฐานการโอนเงินของคุณ</label>
                                <input type="file" name="bill_img" class="form-control shadow-none">    
                            </div>

                           
                        </div>

                        <div class="col-50">
                            <hr>
                            <h5>กรุณาแสกนคิวอาร์โค้ดเพื่อชำระเงิน</h5>
                            <hr>
                            <img src="img/give_me_money.jpg" width="350" height="450">
                            <hr>
                        </div>
                    </div>
                    <button type="summit" class="btn">ชำระเงิน</button>
                </form>
            </div>
        </div>
        <div class="col-25">
            <div class="card">
                <img src="img/hotel-room-home.jpg" class="card-img-top" width="100" height="250">
                <?php echo '<h5 class="card-title">' . $result["hotels_name"] . '</h5>' ?>
                <hr>
                <p class="card-text">ราคา 1 ห้องต่อ 1 คืน
                    <span class="price">
                        <?php echo "฿" .  number_format($result['rooms_price'])  ?>
                    </span>
                </p>
                <br>
                <p class="card-text">ระยะเวลาที่พัก
                    <span class="price">
                        <?php echo $_SESSION["bookings_nights"] . " คืน" ?>
                    </span>
                </p>
                <br>
                <p class="card-text">จำนวนห้องพักที่จอง
                    <span class="price">
                        <?php echo $_SESSION["booking_number"] . " ห้อง" ?>
                    </span>
                </p>
                <hr>
                <p class="card-text">ยอดจ่ายทั้งหมด
                    <span class="price">
                        <?php echo "฿" . $_SESSION["total_pay"] ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

</body>

</html>