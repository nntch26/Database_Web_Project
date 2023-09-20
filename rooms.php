<?php
session_start();
include('BackEnd/includes/connect_database.php');

$_SESSION["location"] = $_GET['location'];
$_SESSION["checkin"] = $_GET['checkin'];
$_SESSION["checkout"] = $_GET['checkout'];
$_SESSION["num_guest"] = $_GET['num_guest'];

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

                <form action="/BackEnd/search_db.php" method="post">
                  <h5 class="mb-3" style="font-size: 18px;">CHECK AVAILABILITY</h5>

                  <label class="form-label">Search</label>
                  <input type="text" class="form-control shadow-none mb-3" name="search_name" placeholder="ชื่อโรงแรมที่คุณต้องการค้นหา" />

                  <label class="form-label">Location</label>
                  <input type="text" class="form-control shadow-none mb-3" placeholder="ชื่อจังหวัด" name="location" value="<?php echo isset($_SESSION["location"]) ? htmlspecialchars($_SESSION["location"]) : ''; ?>" />

                  <label class="form-label">Check-in</label>
                  <input type="date" class="form-control shadow-none mb-3" name="checkin" min="<?php echo date('Y-m-d') ?>" value="<?php echo $_SESSION["checkin"]; ?>">

                  <label class="form-label">Check-out</label>
                  <input type="date" class="form-control shadow-none" name="checkout" min="<?php echo date('Y-m-d') ?>" value="<?php echo $_SESSION["checkout"]; ?>">

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
        <!-- ************************************* -->
        <?php

        //ดึง Hotel ล่ะ JOIN กับตัว locations กับ rooms เพื่อดึงตัวโรงแรมที่ตรงตามเงื่อนไขที่ Tourist ค้นหา
        if ($_SESSION["location"] == null && $_SESSION["num_guest"] == null) {
          $select_stmt = $db->prepare("SELECT * FROM hotels");
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

        if ($row_count > 0) {
          while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<form action="book.php" method="post">';
            echo '<div class="card mb-4 border-0 shadow">';
            echo '<div class="row g-0 p-3 align-items-center">';
            echo '<div class="col-md-5 mb-lg-0 mb-md-0 mb-3">';
            echo '<img src="img/hotel-room-home.jpg" class="img-fluid rounded">';
            echo '</div>';
            echo '<div class="col-md-5 px-lg-3 px-md-3 px-0">';
            echo '<h5 class="mb-3">Simple Room Name</h5>';
            echo '<div class="features mb-4">';
            echo '<h6 class="mb-1">' . $row['hotel_id'] . '</h6>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap">
                    2 Rooms
                  </span>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap">
                    1 Bathroom
                  </span>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap">
                    1 Balcony
                  </span>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap">
                    3 Sofa
                  </span>';
            echo '</div>';
            echo '<div class="Facilities mb-3">';
            echo '<h6 class="mb-1">' . $row['hotels_name'] . '</h6>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap">
                    Wifi
                  </span>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap">
                    Television
                  </span>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap">
                    AC
                  </span>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap">
                    Room Heater
                  </span>';
            echo '</div>';
            echo '<div class="guests">';
            echo '<h6 class="mb-1">' . $row['hotels_address'] . '</h6>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap">
                    5 Adults
                  </span>';
            echo '<span class="badge rounded-pill bg-light text-dark text-wrap">
                    4 Children
                    </span>';
            echo '</div>';
            echo '</div>';
            echo '<div class="col-md-2 mt-lg-0 mt-md-0 mt-4 text-center">';
            echo '<h6 class="mb-4"> ฿ 2000 per night </h6>';
            echo '<button type="submit" name="submit" class="btn login-btn-blue btn-block text-white">Book Now</button>';
            echo '<input type="hidden" name="hotel_id" value="' . $row['hotel_id'] . '">';
            echo  '</div>';
            echo '</div>';
            echo '</div>';
            echo '</form>';
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