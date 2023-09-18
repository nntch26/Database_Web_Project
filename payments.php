<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600&family=Noto+Sans+Thai:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/payments.css">
    <title>Document</title>
</head>
<body>
    <h1 class="checkout">Booking</h1>
    <div class="row">
        <div class="col-75">
            <div class="container">
            <form action="/action_page.php">
            
                <div class="row">
                <div class="col-50">
                    <h4>Billing Address</h4>
                    <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                    <pre>Phum Butsricha</pre>
                    <label for="email"><i class="fa fa-envelope"></i> Email</label>
                    <pre>pizza1150@bestfood.com</pre>
                    <label for="phone"><i class="fa fa-envelope"></i> Phone Number</label>
                    <pre>086-666-6666</pre>
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

                </div>

                <div class="col-50">
                    <h4>Payment</h4>
                    <hr>
                    <img src="img/2xc9z0.png" width="400" height="400">
                    <hr>
                    <h5>กรุณาแสกนคิวอาร์โค้ดเพื่อชำระเงิน</h5>
                </div>
                
                </div>
                <input type="submit" value="Checkout" class="btn">
            </form>
            </div>
        </div>
        <div class="col-25">
            <div class="card">
                <img src="img/hotel-room-home.jpg" class="card-img-top" width="100" height="250">
                <h5 class="card-title">Room Name</h5>
                <p class="card-text">Price <span class="price">฿150</span></p>
                <hr>
                <p class="card-text">Total <span class="price">฿150</span></p>
            </div>
        </div>
    </div>

</body>
</html>