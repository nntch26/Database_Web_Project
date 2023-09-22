<?php
session_start();
include('BackEnd/includes/connect_database.php');

$_SESSION["location"] = $_GET['location'];
$_SESSION["checkin"] = $_GET['checkin'];
$_SESSION["checkout"] = $_GET['checkout'];
$_SESSION["num_guest"] = $_GET['num_guest'];
$_SESSION["search_name"] = $_GET['search_name'];

?>

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

  <!---- header ---->
  <header class="section__container header__container">
    <!----Backgrounds image---->
    <div class="header__image__container">
      <div class="header__content ">
        <h1>Enjoy Your Dream Vacation</h1>
        <p>จองโรงแรม ห้องพัก และแพ็คเกจการเข้าพักในราคาที่ถูกที่สุด</p>
      </div>
  </header>

  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-0">

        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
          <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2">FILTERS</h4>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">

              <div class="border bg-light p-3 rounded mb-3">

                <form action="rooms.php" method="get">
                  <h5 class="mb-3" style="font-size: 18px;">CHECK AVAILABILITY</h5>

                  <label class="form-label">Search</label>
                  <input type="text" class="form-control shadow-none mb-3" name="search_name" placeholder="ชื่อโรงแรมที่คุณต้องการค้นหา" />
                  
                  <label class="form-label">Location</label>
                  <input type="text" class="form-control shadow-none mb-3" placeholder="ชื่อจังหวัด" name="location" value="<?php echo isset($_SESSION["location"]) ? htmlspecialchars($_SESSION["location"]) : ''; ?>" />

                  <label class="form-label">Check-in</label>
                  <input type="date" class="form-control shadow-none mb-3" name="checkin" min="<?php echo date('Y-m-d') ?>" value="<?php echo $_SESSION["checkin"]; ?>">

                  <label class="form-label">Check-out</label>
                  <input type="date" class="form-control shadow-none" name="checkout" min="<?php echo date('Y-m-d') ?>" value="<?php echo $_SESSION["checkout"]; ?>">
                  
                  <label class="form-label">Guests</label>
                  <input type="number" class="form-control shadow-none" name="num_guest" value="<?php echo $_SESSION["num_guest"]; ?>" required>


                  <div class="form__group" style="text-align: center;">
                        <button type="submit" name="submit" class="btn btn-primary shadow-none me-lg-3 me-2 mt-3">Search</button>
                  </div>
                  
                </form>

              </div>
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="mb-3" style="font-size: 18px;">Property Class</h5>
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
                <div class="mb-2">
                  <input type="radio" id="f1" class="form-check-input shadow-none me-1">
                  <label class="form-check-label" value="6" for="f3" name="rating">ALL ★ - ★★★★★</label>
                </div>
              </div>
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="mb-3" style="font-size: 18px;">Price</h5>
                <div class="d-flex">
                  <div class="me-2">
                    <label class="form-label">Min</label>
                    <input type="text" class="form-control shadow-none">
                  </div>
                  <div>
                    <label class="form-label">Max</label>
                    <input type="text" class="form-control shadow-none">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>

      <div class="col-lg-9 col-md-12 px-4">

      <?php

        //ดึง Hotel ล่ะ JOIN กับตัว locations กับ rooms เพื่อดึงตัวโรงแรมที่ตรงตามเงื่อนไขที่ Tourist ค้นหา
        
        print_r($_SESSION["location"]);
        print_r($_SESSION["num_guest"]);

        if ($_SESSION['search_name'] != 'null'){
          $sql2 = "SELECT * FROM hotels
          WHERE hotels_name LIKE :text";

          $searchText = '%' . $_SESSION["search_name"] . '%'; // เพิ่ม % ด้านหน้าและด้านหลังของข้อความค้นหา

          $select_stmt = $db->prepare($sql2);
          $select_stmt->bindParam(':text', $searchText);
          $select_stmt->execute();

        }else if ($_SESSION["location"] == null && $_SESSION["num_guest"] == null) {
          $select_stmt = $db->prepare("SELECT * FROM hotels JOIN rooms USING (hotel_id)
                                      -- JOIN reviews USING (hotel_id) 
                                      ");
          $select_stmt->execute();
          
        } else if ($_SESSION["location"] != null && $_SESSION["num_guest"] == null) {
          $select_stmt = $db->prepare("SELECT * FROM hotels
                                JOIN locations USING (location_id) 
                                -- JOIN reviews USING (hotel_id) 
                                WHERE location_name = :get_location");
          $select_stmt->bindParam(':get_location', $_SESSION["location"]);
          $select_stmt->execute();

        } else if ($_SESSION["location"] == null && $_SESSION["num_guest"] != null) {
          $select_stmt = $db->prepare("SELECT * FROM hotels 
                                JOIN rooms USING (hotel_id)
                                -- JOIN reviews USING (hotel_id) 
                                WHERE rooms_size >= :num_guest");
          $select_stmt->bindParam(':num_guest', $_SESSION["num_guest"]);
          $select_stmt->execute();

        } else if ($_SESSION["location"] != null && $_SESSION["num_guest"] != null) {
          $select_stmt = $db->prepare("SELECT * FROM hotels 
                                JOIN locations USING (location_id) 
                                JOIN rooms USING (hotel_id)
                                -- JOIN reviews USING (hotel_id) 
                                WHERE location_name = :get_location AND rooms_size >= :num_guest");
          $select_stmt->bindParam(':get_location', $_SESSION["location"]);
          $select_stmt->bindParam(':num_guest', $_SESSION["num_guest"]);
          $select_stmt->execute();

        }

        //นับจำนวนข้อมูลที่มี
        $row_count = $select_stmt->rowCount(); 
    

      ?>

      <?php
      if ($row_count > 0) {
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <form action="book.php" method="post">
              <div class="card mb-4 border-0 shadow">
                  <div class="row g-0 p-3 align-items-center">
                    
                    <!-- ดึงรูปโรงแรม -->
                      <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                          <img src="BackEnd/uploads_img/<?= $row['hotels_img'] ?>" class="img-fluid rounded">
                      </div>

                      <!-- ชื่อโรงแรม -->
                      <div class="col-md-5 px-lg-3 px-md-3 px-0">
                          <h5 class="mb-3"><?= $row['hotels_name'] ?></h5>
                          <span class="badge rounded-pill bg-light text-dark text-wrap">คะแนนรีวิว : </span>
                          <span class="badge rounded-pill bg-light text-dark text-wrap">รีวิว : </span>

                          <!-- ที่อยู่ -->
                          <p class="mb-1 mt-2"><?= $row['hotels_address'] ?></p>

                          <!-- จำนวนคนพักได้ -->
                          <div class="guests">
                              <span class="badge rounded-pill bg-light text-dark text-wrap"><?= $row['rooms_size'] ?> Adults</span>
                              <span class="badge rounded-pill bg-light text-dark text-wrap">1 Children</span>
                          </div>


                          <!-- รายละเอียดห้อง
                          <div class="features mb-4">
                              <?php
                              $features = ['2 Rooms', '1 Bathroom', '1 Balcony', '3 Sofa'];
                              foreach ($features as $feature) {
                                  echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $feature . '</span>';
                              }
                              ?>
                          </div>-->
                          
                          <!-- สิ่งอำนวยความสะดวก -->
                          <div class="Facilities mb-3">
                              <?php
                              $facilities = ['Free WiFi', 'Television', 'City view', 'Air conditioning'];
                              foreach ($facilities as $facility) {
                                  echo '<span class="badge rounded-pill bg-light text-dark text-wrap">' . $facility . '</span>';
                              }
                              ?>
                          </div>

                          

                      </div>

                      <?php
                      // ราคาห้องถูกที่สุด
                      $sql = "SELECT hotel_id, MIN(rooms_price) AS min_price FROM hotels 
                              JOIN locations USING (location_id) 
                              JOIN rooms USING (hotel_id)
                              WHERE hotel_id = :hotel_id
                              GROUP BY hotel_id";

                      $select_stmt2 = $db->prepare($sql);
                      $select_stmt2->bindParam(':hotel_id', $row['hotel_id']);
                      $select_stmt2->execute();
                      $row2 = $select_stmt2->fetch(PDO::FETCH_ASSOC)
                      ?>

                      <!-- ราคาห้องพักเริ่มต้น -->
                      <div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">
                          <h6 class="mb-4">ราคาเริ่มต้น/คืน</h6>
                          <h2 class="mb-4">฿ <?= $row2['min_price'] ?></h2>
                          <button type="submit" name="submit" class="btn login-btn-blue btn-block text-white">Book Now</button>
                          <input type="hidden" name="hotel_id" value="<?= $row['hotel_id'] ?>">
                      </div>


                  </div>
              </div>
          </form>
      <?php
          }
      } else {
          echo "ไม่พบข้อมูลที่ตรงกับคำค้นหา";
      }
      ?>

      </div>
    </div>
  </div>




  <!-- footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="mt-5 mb-3 text-center">
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