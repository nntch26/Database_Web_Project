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
    <link rel="stylesheet" href="css/styles.css">

    <title>Hotel Project</title>

</head>

<body>

    <!---- Navbar ---->
    <?php require('navbar.php'); ?>
   

    <!---- header ---->
    <header class="section__container header__container">
        <!----Backgrounds image---->
        <div class="header__image__container">
            <div class="header__content ">
                <h1>Enjoy Your Dream Vacation</h1>
                <p>จองโรงแรม ห้องพัก และแพ็คเกจการเข้าพักในราคาที่ถูกที่สุด</p>
            </div>

            <!----Booking bar---->
            <div class="booking__container">
                <form action="../BackEnd/search_db.php" method="post">
                    <div class="form__group ">
                        <div class="input__group" for="location">
                            <input type="text" placeholder="ชื่อจังหวัด" name="location" />
                            <label>Location</label>
                        </div>
                        <p>Where are you going?</p>
                    </div>

                    <div class="form__group">
                        <div class="input__group" for="checkin">
                            <input type="date" name="checkin" />
                            <label>Check In</label>
                        </div>
                        <p>Add date</p>
                    </div>

                    <div class="form__group">
                        <div class="input__group" for="checkout">
                            <input type="date" name="checkout" />
                            <label>Check Out</label>
                        </div>
                        <p>Add date</p>
                    </div>

                    <div class="form__group">
                        <div class="input__group" for="num_guest">
                            <input type="text" placeholder="จำนวนผู้ที่มาพัก" name="num_guest" />
                            <label>Guests</label>
                        </div>
                        <p>Add guests</p>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary shadow-none me-lg-3 me-2">Search</button>
                </form>
            </div>
        </div>
    </header>
    <!---- end header ---->


    <!---- card  ---->
    <div class="container mt-5 mb-5">
        <h1 class="text-primary mb-2">จุดหมายที่กำลังมาแรง</h1>
        <p>ตัวเลือกยอดนิยมที่สุดสำหรับผู้เดินทางจากไทย</p>
        <div class="row">
            <!-- Card แรก -->
            <div class="col-md-3">
                <div class="card">
                    <img src="https://storage-wp.thaipost.net/2022/04/%E0%B8%A7%E0%B8%B1%E0%B8%94%E0%B8%AD%E0%B8%A3%E0%B8%B8%E0%B8%93%E0%B8%AF.jpg" class="card-img-top" alt="Image 1">
                    <div class="card-body">
                        <a href="page1.html">กรุงเทพมหานคร</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="https://ik.imagekit.io/tvlk/blog/2018/07/Doi-Inthanon-ChiangMai-Traveloka-1.jpg?tr=dpr-2,w-675" class="card-img-top" alt="Image 1">
                    <div class="card-body">
                        <a href="page1.html">เชี่ยงใหม่</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="https://wp-assets.dotproperty-kh.com/wp-content/uploads/sites/9/2016/11/03152051/pattaya.jpg" class="card-img-top" alt="Image 1">
                    <div class="card-body">
                        <a href="page1.html">พัทยา</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="https://travel.mthai.com/app/uploads/2019/03/ultOz2d0-e1552276693420.jpeg" class="card-img-top" alt="Image 1">
                    <div class="card-body">
                        <a href="page1.html">กาญจนบุรี</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!---- end card ---->

    <!---- room card ---->
    <div class="container mt-5 mb-5">
        <h1 class="text-primary mb-2">ที่พักสไตล์ที่อยู่อาศัยที่คุณอาจชื่นชอบ</h1>
        <p>ตัวเลือกห้องพักที่ลูกค้าอาจชื่นชอบ</p>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/184305239.jpg?k=2d22fe63ae1f8960e057238c98fb436f7bd9f65854e3a5e918607c5cfa1d0a52&o=&hp=1" class="card-img-top" alt="รูปโรงแรม">
                    <div class="card-body">
                        <h5 class="card-title">โรงแรมชื่อ: โรงแรมที่หนึ่ง</h5>
                        <p class="card-text">จังหวัด: BKK</p>
                        <p class="card-text">คะแนนรีวิว: 4.5/5</p>
                        <p class="card-text">ราคาเริ่มต้น/คืน: 2,500 บาท</p>
                        <a href="#" class="btn btn-primary">จองห้อง</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="https://static.leonardo-hotels.com/image/leonardohotelbucharestcitycenter_room_comfortdouble2_2022_4000x2600_7e18f254bc75491965d36cc312e8111f_1200x780_mobile_3.jpeg" class="card-img-top" alt="รูปโรงแรม">
                    <div class="card-body">
                        <h5 class="card-title">โรงแรมชื่อ: โรงแรมที่สอง</h5>
                        <p class="card-text">จังหวัด: CNX</p>
                        <p class="card-text">คะแนนรีวิว: 4.2/5</p>
                        <p class="card-text">ราคาเริ่มต้น/คืน: 2,000 บาท</p>
                        <a href="#" class="btn btn-primary">จองห้อง</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="https://www.kayak.co.th/rimg/himg/47/ec/7e/ice-115522-63352612_3XL-307131.jpg?width=1366&height=768&crop=true" class="card-img-top" alt="รูปโรงแรม">
                    <div class="card-body">
                        <h5 class="card-title">โรงแรมชื่อ: โรงแรมที่สอง</h5>
                        <p class="card-text">จังหวัด: CNX</p>
                        <p class="card-text">คะแนนรีวิว: 4.2/5</p>
                        <p class="card-text">ราคาเริ่มต้น/คืน: 2,000 บาท</p>
                        <a href="#" class="btn btn-primary">จองห้อง</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <img src="https://image-tc.galaxy.tf/wijpeg-68348kpk1umj01sjidmalztjd/jprerovsky-hotel-clement-807-16a2955.jpg" class="card-img-top" alt="รูปโรงแรม">
                    <div class="card-body">
                        <h5 class="card-title">โรงแรมชื่อ: โรงแรมที่สอง</h5>
                        <p class="card-text">จังหวัด: CNX</p>
                        <p class="card-text">คะแนนรีวิว: 4.2/5</p>
                        <p class="card-text">ราคาเริ่มต้น/คืน: 2,000 บาท</p>
                        <a href="#" class="btn btn-primary">จองห้อง</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---- end room card ---->


    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mt-5">
                    <h4>เกี่ยวกับเรา</h4>
                    <p>เว็บไซต์จองโรงแรม เพื่อให้คุณพบประสบการณ์ที่ดีที่สุดในการเดินทางของคุณ</p>
                </div>
                <div class="col-md-6 mt-5">
                    <h4>ติดต่อเรา</h4>
                    <address>
                        <p>1/1 ถนนสุขุมวิท, กรุงเทพฯ, ประเทศไทย</p>
                        <p>อีเมล: haramnon@gmail.com</p>
                        <p>โทรศัพท์: +66 893456789</p>
                    </address>
                </div>
                <div class="mt-5 mb-5 text-center">
                    <small class="text-center">
                        Copyright © 2023 Haramnon.com. All Rights Reserved.
                    </small>

                </div>

            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>