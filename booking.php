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
    <h1 class="checkout">Booking</h1>
    <div class="row">
        <div class="col-25">
            <div class="container">
                    <h4>ข้อมูลผู้ใช้งาน</h4>
                    <label for="fname"> ชื่อ : </label>
                    <input type="text">
                    <label for="lname"> นามสกุล : </label>
                    <input type="text">
                    <label for="email"> Email : </label>
                    <input type="text">
                    <label for="phone"> หมายเลขโทรศัพท์ : </label>
                    <input type="text">
                    <label for="address"> ที่อยู่ : </label>
                    <input type="text">
                    <label for="city"> เมือง/จังหวัด : </label>
                    <input type="text">
                    <label for="postaddress"> รหัสไปรษณีย์ : </label>
                    <input type="text">
              
                <button type="summit" class="btn">Next</button>
            </div>
        </div>
        <div class="col-50">
            <div class="card">
                <img src="img/hotel-room-home.jpg" class="card-img-top" height="400">
                <h4>Hotel Name</h4>
                <label for="hotelname"> ชื่อโรงแรม :</label>
                <label for="phone"> เบอร์ติดต่อ :</label>
                <label for="information"> รายละเอียดโรงแรม :</label>
                <label for="address"> ที่อยู่ :</label>
                <label for="city"> เมือง/จังหวัด :</label>
                <label for="postaddress"> รหัสไปรษณีย์ :</label>
                <br>
                <p class="card-text">Price <span class="price">฿150</span></p>
                <hr>
                <p class="card-text">Total <span class="price">฿150</span></p>
            </div>
        </div>
    </div>

</body>
</html>