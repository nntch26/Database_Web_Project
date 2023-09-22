<?php
session_start();
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
    <div class="wrapper">
        <div class="rapper">
            <div class="card">
                <img src="https://static.leonardo-hotels.com/image/leonardohotelbucharestcitycenter_room_comfortdouble2_2022_4000x2600_7e18f254bc75491965d36cc312e8111f_1200x780_mobile_3.jpeg" class="card-img-top" width="100" height="250">
                <div class="info-name">
                    <h4 class="card-title">Room Name</h4>
                    <h6 class="locad">location hotel</h6><br>
                </div>
                <div class="date">
                    <label class="card-text">Check-in</label>
                    <span class="day">day, 00 month 2023</span><br>
                    <label class="card-text">Check-out</label>
                    <span class="day">day, 00 month 2023</span><hr>
                    <label class="type">1 เตียงคิงไซส์</label>
                </div>
            </div>
        </div>
        <div class="desc">
            <h5 class="txt">ทริปของคุณเริ่มเมื่อ day 00 month 2023</h5>
            <div class="ch-in">
                <ion-icon name="calendar"></ion-icon>
                <span class="check-in">Check-in</span>
                <span class="ch-in-txt">day, 00 month 2023</span><br><br>
            </div>
            <div class="ch-out">
                <ion-icon name="calendar-clear"></ion-icon>
                <span class="check-in">Check-out</span>
                <span class="ch-out-txt">day, 00 month 2023</span>
            </div><hr>
            <div class="info-hotel">
                <div class="info-ho-add">
                    <label class="la-name">ที่อยู่โรงแรม</label>
                    <span class="info-la1">Sukhumvit 2, 10270 Bangpee, Thailand</span><br><br>
                </div>
                <div class="info-ho-tel">
                    <label class="la-name">เบอร์โทรติดต่อ</label>
                    <span class="info-la3">+99 123 456 789</span>
                </div><hr>
                <div class="foot">
                    <label class="la-name">ราคารวม</label>
                    <span class="info-la4">4 ล้าน</span>
                    <button class="con-color">paid</button>
                </div><hr>
                <div class="button">
                    <button type="submit" class="btn-cancel">ยกเลิกการจอง</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>