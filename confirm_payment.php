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

    $select_stmt = $db->prepare("SELECT * FROM bookings
                                    JOIN users ON (bookings.user_id = users.user_id)
                                    JOIN hotels ON (bookings.hotel_id = hotels.hotel_id)
                                    JOIN rooms ON (bookings.room_id = rooms.room_id)
                                    WHERE booking_id = :booking_id");
    $select_stmt->bindParam(':booking_id', $_SESSION["booking_id"]);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/confirm.css">
    <title>Document</title>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <h1>Confirm Payments</h1>
    <div class="row">
    <div class="col align-self-center">
            <div class="ch-in">
                <ion-icon name="calendar"></ion-icon>
                <span class="check-in">Check-in</span>
                <span class="ch-in-txt"><?php echo $result["bookings_check_in"] ?></span><br><br>
            </div>
            <div class="ch-out">
                <ion-icon name="calendar-clear"></ion-icon>
                <span class="check-in">Check-out</span>
                <span class="ch-out-txt"><?php echo $result["bookings_check_out"] ?></span>
            </div>
            <hr>
            <div class="info-hotel">
                <div class="info-ho-add">
                    <label class="la-name">ที่อยู่โรงแรม</label>
                    <span class="info-la1"><?php echo $result["hotels_address"] ?></span><br><br>
                </div>
                <div class="info-ho-tel">
                    <label class="la-name">เบอร์โทรติดต่อ</label>
                    <span class="info-la3"><?php echo $result["hotels_phone"] ?></span>
                </div>
                <hr>
                <div class="box">
                    <div class="rating">
                        <h3 class="txtcomm">Rating</h3>
                        <div class="mb-2">
                            <input type="radio" id="f1" class="form-check-input shadow-none me-1">
                            <label class="form-check-label" value="1" for="f1" name="rating">1 ★</label>
                        </div>
                        <div class="mb-2">
                            <input type="radio" id="f1" class="form-check-input shadow-none me-1">
                            <label class="form-check-label" value="2" for="f2" name="rating">2 ★★</label>
                        </div>
                        <div class="mb-2">
                            <input type="radio" id="f1" class="form-check-input shadow-none me-1">
                            <label class="form-check-label" value="3" for="f3" name="rating">3 ★★★</label>
                        </div>
                        <div class="mb-2">
                            <input type="radio" id="f1" class="form-check-input shadow-none me-1">
                            <label class="form-check-label" value="4 " for="f3" name="rating">4 ★★★★</label>
                        </div>
                        <div class="mb-2">
                            <input type="radio" id="f1" class="form-check-input shadow-none me-1">
                            <label class="form-check-label" value="5" for="f3" name="rating">5 ★★★★★</label>
                        </div>
                    </div>
                    <div class="comment">
                        <h3 class="txtcomm">Comment</h3>
                        <div class="commentbox">
                            <textarea class="inputcomment" type="text"></textarea>
                        </div>
                        <div class="btnbox">
                            <button class="btn" type="summit"> โพสต์</button>
                        </div>

                    </div>
                </div>
                <div class="button">
                    <button type="submit" class="btn-cancel">ยกเลิกการจอง</button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
            <img src="<?php echo 'BackEnd/uploads_img/' . $result["rooms_img"]; ?>" class="card-img-top" width="100" height="350" alt="รูปภาพของเรา">
                <div class="info-name">
                    <h4 class="card-title"><?php echo $result["rooms_type"] ?></h4>
                    <h6 class="locad"><?php echo $result["rooms_description"] ?></h6><br>
                </div>
                <div class="date">
                    <label class="card-text">จำนวนคนต่อห้อง</label>
                    <span class="day"><?php echo $result["rooms_size"] ?></span><br>
                    <label class="card-text">ยอดชำระเงิน</label>
                    <span class="day"><?php echo "฿ " . $result["bookings_total_price"] ?></span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>