<?php
session_start();
include('BackEnd/includes/connect_database.php');
$_SESSION["room_id"] = $_GET["room_id"];
$checkin_date = $_SESSION["checkin"]; // วันที่เช็คอิน
$checkout_date = $_SESSION["checkout"]; // วันที่เช็คเอาท์

// แปลงวันที่เช็คอินและเช็คเอาท์เป็น timestamp
$checkin_timestamp = strtotime($checkin_date);
$checkout_timestamp = strtotime($checkout_date);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link
        href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600&family=Noto+Sans+Thai:wght@100&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/PaymentAndBooking.css">
    <title>Document</title>
</head>

<body>
    <?php
    $select_stmt = $db->prepare("SELECT * FROM users");
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <h1 class="checkout">Booking</h1>
    <div class="row">
        <div class="col-25">
            <div class="container">
                <form method="post" action="BackEnd/process_booking.php">
                    <h4>ข้อมูลผู้ใช้งาน</h4>
                    <label for="fname"> ชื่อ : </label>
                    <input type="text" id="fname" name="fname" value="<?php echo $row["users_first_name"] ?> " required>
                    <label for="lname"> นามสกุล : </label>
                    <input type="text" id="lname" name="lname" value="<?php echo $row["users_last_name"] ?>" required>
                    <label for="email"> Email : </label>
                    <input type="email" id="email" name="email" value="<?php echo $row["users_email"] ?>" required>
                    <label for="phone"> หมายเลขโทรศัพท์ : </label>
                    <input type="text" id="phone" name="phone" value="<?php echo $row["users_phone_number"] ?>"
                        required>
                    <label for="address"> ที่อยู่ : </label>
                    <input type="text" id="address" name="address" value="<?php echo $row["users_address"] ?>" required>
                    <button type="submit" class="btn">Next</button>
                </form>
            </div>
        </div>

        <?php
        $select_stmt = $db->prepare("SELECT * FROM hotels
                                    JOIN rooms USING (room_id)
                                    WHERE hotel_id = :hotel_id AND room_id = :room_id");
        $select_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
        $select_stmt->bindParam(':room_id', $_SESSION["room_id"]);
        $select_stmt->execute();
        $result = $select_stmt->fetch(PDO::FETCH_ASSOC);

        $price_with_night = $number_of_nights * $result['rooms_price'];
        ?>
        <div class="col-50">
            <div class="card">
                <img src="img/hotel-room-home.jpg" class="card-img-top" height="400">
                <h4>
                    <?php echo $result['hotels_name'] ?>
                </h4>
                <div class="row">
                        <div class="col-50">
                            <label for="check-in">Check-In</label>
                            <pre>mm/dd/yyyy</pre>
                        </div>
                        <div class="col-50">
                            <label for="check-out">Check-Out</label>
                            <pre>mm/dd/yyyy</pre>
                        </div>
                    </div>
                <label for="phone">
                    <?php echo 'เบอร์ติดต่อ : ' . $result['hotels_name'] ?>
                </label>
                <label for="information">
                    <?php echo 'รายละเอียดโรงแรม : ' . $result['hotels_name'] ?>
                </label>
                <label for="address">
                    <?php echo 'ที่อยู่ : ' . $result['hotels_name'] ?>
                </label>
                <label for="city">
                    <?php echo 'เมือง/จังหวัด : ' . $result['hotels_name'] ?>
                </label>
                <label for="postaddress">
                    <?php echo 'รหัสไปรษณีย์ : ' . $result['hotels_name'] ?>
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
                <p class="card-text">Total <span class="price">
                        <?php echo "฿" . $price_with_night ?>
                    </span></p>
            </div>
        </div>
    </div>

</body>

</html>