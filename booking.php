<?php
session_start();
include('BackEnd/includes/connect_database.php');
if (isset($_GET['submit2']) && isset($_SESSION['userid']) && ($_SESSION["role"] != "HOTELOWNER")) {
    $_SESSION["room_id"] = $_GET["room_id"];
    $_SESSION["checkin"] = $_GET["checkin_date"]; // วันที่เช็คอิน
    $_SESSION["checkout"] = $_GET["checkout_date"]; // วันที่เช็คเอาท์
    $_SESSION["hotel_id"] = $_GET["hotel_id"];
    $_SESSION["available_rooms"] = $_GET["available_rooms"];
}else if ($_SESSION["role"] == "HOTELOWNER" && isset($_SESSION['userid'])){
    $_SESSION['ur_hotel'] = "คุณไม่สามารถจองได้";
    header('location: book.php');
}else{
    header('location: login.php');
}

// แปลงวันที่เช็คอินและเช็คเอาท์เป็น timestamp
$checkin_timestamp = strtotime($_SESSION["checkin"]);
$checkout_timestamp = strtotime($_SESSION["checkout"]);

// คำนวณจำนวนวินาทีที่แตกต่างกัน
$time_difference = $checkout_timestamp - $checkin_timestamp;

// แปลงจำนวนวินาทีเป็นจำนวนคืน
$number_of_nights = $time_difference / (60 * 60 * 24);

// แปลงผลลัพธ์ให้เป็นจำนวนเต็ม แล้วก็ได้จำนวนคืนมาใช้คำนวณ
$number_of_nights = intval($number_of_nights);

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
    <?php
    $select_stmt = $db->prepare("SELECT * FROM users
                                WHERE user_id = :user_id");
    $select_stmt->bindParam(':user_id', $_SESSION["userid"]);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    $select_stmt = $db->prepare("SELECT * FROM hotels
                                    JOIN rooms USING (hotel_id)
                                    WHERE hotel_id = :hotel_id AND room_id = :room_id");
    $select_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
    $select_stmt->bindParam(':room_id', $_SESSION["room_id"]);
    $select_stmt->execute();
    $result = $select_stmt->fetch(PDO::FETCH_ASSOC);

    $price_with_night = $number_of_nights * $result['rooms_price'];
    ?>

    <h1 class="checkout">Booking</h1>
    <div class="row">
        <div class="col-25">
            <div class="container">
                <form method="post" action="BackEnd/process_booking.php">
                    <h4>ข้อมูลผู้ใช้งาน</h4>
                    <label for="fname"> ชื่อ : </label>
                    <input type="text" id="fname" name="fname" placeholder="โปรดระบุชื่อจริงของคุณ" value="<?php echo isset($row["users_first_name"]) ? $row["users_first_name"] : ''; ?>" required>
                    <label for="lname"> นามสกุล : </label>
                    <input type="text" id="lname" name="lname" placeholder="โปรดระบุนามสกุลของคุณ" value="<?php echo isset($row["users_last_name"]) ? $row["users_last_name"] : ''; ?>" required>
                    <label for="email"> Email : </label>
                    <input type="email" id="email" name="email" value="<?php echo $row["users_email"] ?>" readonly>
                    <label for="phone"> หมายเลขโทรศัพท์ : </label>
                    <input type="text" id="phone" name="phone" placeholder="โปรดระบุหมายเลขโทรศัพท์" value="<?php echo isset($row["users_phone_number"]) ? $row["users_phone_number"] : ''; ?>" required>
                    <label for="address"> ที่อยู่ : </label>
                    <input type="text" id="address" name="address" placeholder="โปรดระบุที่อยู่ของคุณ" value="<?php echo isset($row["users_address"]) ? $row["users_address"] : ''; ?>" required>
                    <label for="address"> จำนวนห้องที่จะเข้าพัก : </label>
                    <input type="text" id="bookings_number" name="bookings_number" placeholder="เลขจำนวนห้อง" required>
                    <input type="hidden" name="price_with_night" value="<?= $price_with_night ?>">
                    <input type="hidden" name="number_of_nights" value="<?= $number_of_nights ?>">
                    <button type="submit" class="btn">Next</button>
                </form>
            </div>
        </div>

        <div class="col-50">
            <div class="card">
                <img src="<?php echo 'BackEnd/uploads_img/' . $result['rooms_img']; ?>" class="card-img-top" height="400">
                <h4>
                    <?php echo $result['hotels_name'] ?>
                </h4>
                <div class="row">
                    <div class="col-50">
                        <label for="check-in">Check-In</label>
                        <pre><?php echo $_SESSION["checkin"] ?></pre>
                    </div>
                    <div class="col-50">
                        <label for="check-out">Check-Out</label>
                        <pre><?php echo $_SESSION["checkout"] ?></pre>
                    </div>
                </div>
                <label for="phone">
                    <?php echo 'เบอร์ติดต่อ : ' . $result['hotels_phone'] ?>
                </label>
                <label for="information">
                    <?php echo 'รายละเอียดโรงแรม : ' . $result['hotels_description'] ?>
                </label>
                <label for="address">
                    <?php echo 'ที่อยู่ : ' . $result['hotels_address'] ?>
                </label>
                <label for="city">
                    <?php echo 'เมือง/จังหวัด : ' . $result['location_id'] ?>
                </label>
                <label for="postaddress">
                    <?php echo 'รหัสไปรษณีย์ : ' . $result['hotels_postcode'] ?>
                </label>
                <label for="roomdes">
                    <?php echo 'รายละเอียดห้อง : ' . $result['rooms_description'] ?>
                </label>
                <br>
                <p class="card-text">ราคา 1 ห้องต่อ 1 คืน <span class="price">
                        <?php echo "฿" . $result['rooms_price'] ?>
                    </span></p>
                <br>
                <p class="card-text">ระยะเวลาที่พัก <span class="price">
                        <?php echo $number_of_nights . " คืน" ?>
                    </span></p>
                <hr>
                <p class="card-text">Total
                    <span class="price">
                        <?php echo "฿" . $price_with_night ?>
                    </span>
                </p>
            </div>
        </div>
    </div>

</body>

</html>