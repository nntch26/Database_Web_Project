<?php
session_start();
include('BackEnd/includes/connect_database.php');

$_SESSION["location"] = $_GET['location'];
$_SESSION["checkin"] = $_GET['checkin'];
$_SESSION["checkout"] = $_GET['checkout'];
$_SESSION["search_name"] = $_GET['search_name'];
$_SESSION["num_guest"] = $_GET['num_guest'];


//ดึง Hotel ล่ะ JOIN กับตัว locations กับ rooms เพื่อดึงตัวโรงแรมที่ตรงตามเงื่อนไขที่ Tourist ค้นหา



// ค้นหาจาก ชื่อโรงแรม
if ($_SESSION['search_name'] != null){

  $searchText = '%' . $_SESSION["search_name"] . '%';

  $select_stmt = $db->prepare("SELECT hotels.*, locations.*, rooms.*
                              FROM hotels
                              JOIN locations USING (location_id)
                              JOIN rooms USING (hotel_id)
                              WHERE hotels_name LIKE :text
                              GROUP BY hotels.hotel_id;");

  $select_stmt->bindParam(':text', $searchText);
  $select_stmt->execute();

  


// ค้นหาจาก จำนวนคน
} else if ($_SESSION["location"] == null && $_SESSION["num_guest"] != null) {
  $select_stmt = $db->prepare("SELECT hotels.*, locations.*, rooms.*
                              FROM hotels
                              JOIN locations USING (location_id)
                              JOIN rooms USING (hotel_id)
                              WHERE rooms_size >= :num_guest
                              GROUP BY hotels.hotel_id ");

  $select_stmt->bindParam(':num_guest', $_SESSION["num_guest"]);
  $select_stmt->execute();

  

// ค้นหาจาก จังหวัด จำนวนคน
} else if ($_SESSION["location"] != null && $_SESSION["num_guest"] != null) {

  $searchText = '%' . $_SESSION["location"] . '%';

  $select_stmt = $db->prepare("SELECT hotels.*, locations.*, rooms.*
                              FROM hotels
                              JOIN locations USING (location_id)
                              JOIN rooms USING (hotel_id)
                              WHERE location_name LIKE :get_location AND rooms_size >= :num_guest
                              GROUP BY hotels.hotel_id ");

  $select_stmt->bindParam(':get_location', $searchText);
  $select_stmt->bindParam(':num_guest', $_SESSION["num_guest"]);
  $select_stmt->execute();

}


//นับจำนวนข้อมูลที่มี
$row_count = $select_stmt->rowCount(); 

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
  <?php require('inc/navbar.php'); ?>

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

        <!-- Filters -->
        <?php require('inc/filters.php'); ?>
      </div>

      <div class="col-lg-9 col-md-12 px-4">

      <!-- Hotel listings -->

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
                          <p class="mb-1 mt-2"><?= $row['hotels_address']?></p>
                          <p class="mb-1 mt-2"><?= $row['location_name'] ?></p>


                          <!-- จำนวนคนพักได้ -->
                      
                          <div class="guests">
                            <span class="badge rounded-pill bg-light text-dark text-wrap"><?= $row['rooms_size'] ?> Adults</span>
                          </div>

                          
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
                          <h2 class="mb-4">฿ <?= number_format($row2['min_price']) ?></h2>

                          <button type="submit" name="Book_now" class="booknow">Book Now</button>

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