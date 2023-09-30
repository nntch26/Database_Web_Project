<?php
session_start();
include('BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามาecho $_SESSION['checkout'] . '1111';

if (($_SERVER["REQUEST_METHOD"] == "GET" & !isset($_SESSION['GetSearch'])) & ($_SESSION['checkin'] == null | $_SESSION['checkout'] == null)) {
  $_SESSION["hotel_id"] = $_GET["hotel_id"];
  $select_stmt = $db->prepare("SELECT * FROM hotels 
                              JOIN locations l USING (location_id) JOIN rooms r USING (hotel_id)  
                              WHERE hotel_id = :hotel_id");

  $select_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
} else if (isset($_SESSION['checkin']) && isset($_SESSION['checkout']) && $_SERVER["REQUEST_METHOD"] == "GET" && !isset($_SESSION['GetSearch'])) {
  $_SESSION["hotel_id"] = $_GET["hotel_id"];
  $select_stmt = $db->prepare("SELECT * FROM hotels 
  JOIN locations l USING (location_id) JOIN rooms r USING (hotel_id)  
  WHERE hotel_id = :hotel_id");
  $select_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);




  $sql = "SELECT r.room_id, rooms_img, rooms_type, rooms_size, rooms_number - IFNULL(num_booked, 0) AS available_rooms, rooms_description, rooms_price
    FROM hotels h
    JOIN rooms r USING (hotel_id)
    LEFT JOIN (
      SELECT b.room_id, COUNT(bookings_status), SUM(bookings_number)AS num_booked
      FROM hotels h
      JOIN rooms r USING (hotel_id)
      LEFT JOIN bookings b USING (hotel_id, room_id)
      WHERE hotel_id = :hotel_id
      AND bookings_status = 'Confirmed'
      AND (
        (bookings_check_in >= :checkin AND bookings_check_in < :checkout)
        OR (bookings_check_out > :checkin AND bookings_check_out <= :checkout)
        OR (bookings_check_in <= :checkin AND bookings_check_out >= :checkout)
      )
      GROUP BY b.room_id
    ) AS booked_rooms ON r.room_id = booked_rooms.room_id
    WHERE h.hotel_id = :hotel_id";

  $stmt = $db->prepare($sql);
  $stmt->bindParam(':hotel_id',  $_SESSION["hotel_id"], PDO::PARAM_INT);
  $stmt->bindParam(':checkin',  $_SESSION["checkin"], PDO::PARAM_STR);
  $stmt->bindParam(':checkout', $_SESSION["checkout"], PDO::PARAM_STR);
  $stmt->execute();
} else if (($_SESSION['checkin'] != null && $_SESSION['checkout'] != null) & isset($_SESSION['GetSearch'])) {
  $select_stmt = $db->prepare("SELECT * FROM hotels 
  JOIN locations l USING (location_id) JOIN rooms r USING (hotel_id)  
  WHERE hotel_id = :hotel_id");
  $select_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  $sql = "SELECT r.room_id, rooms_img, rooms_type, rooms_size, rooms_number - IFNULL(num_booked, 0) AS available_rooms, rooms_description, rooms_price
    FROM hotels h
    JOIN rooms r USING (hotel_id)
    LEFT JOIN (
      SELECT b.room_id, COUNT(bookings_status), SUM(bookings_number)AS num_booked
      FROM hotels h
      JOIN rooms r USING (hotel_id)
      LEFT JOIN bookings b USING (hotel_id, room_id)
      WHERE hotel_id = :hotel_id
      AND bookings_status = 'Confirmed'
      AND (
        (bookings_check_in >= :checkin AND bookings_check_in < :checkout)
        OR (bookings_check_out > :checkin AND bookings_check_out <= :checkout)
        OR (bookings_check_in <= :checkin AND bookings_check_out >= :checkout)
      )
      GROUP BY b.room_id
    ) AS booked_rooms ON r.room_id = booked_rooms.room_id
    WHERE h.hotel_id = :hotel_id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':hotel_id',  $_SESSION["hotel_id"], PDO::PARAM_INT);
  $stmt->bindParam(':checkin',  $_SESSION["checkin"], PDO::PARAM_STR);
  $stmt->bindParam(':checkout', $_SESSION["checkout"], PDO::PARAM_STR);
  $stmt->execute();
} else {
  // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง room
  $sql = "SELECT * FROM hotels 
    JOIN locations l USING (location_id) JOIN rooms r USING (hotel_id) 
    WHERE hotel_id = :hotel_id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
  $stmt->execute();
  //echo 'inelse';

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600&family=Noto+Sans+Thai:wght@100&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/bookcss.css" />
  <title>Document</title>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
  <?php require('inc/navbar.php'); ?>

  <!---- hotel img des  ---->
  <div class="wrapper">
    <div class="info">
      <div class="img">
        <img src="<?php echo 'BackEnd/uploads_img/' . $row["hotels_img"]; ?>" alt="รูปภาพของเรา">
      </div>
      <div class="info-txt">
        <h2 class="name-info"><?php echo $row["hotels_name"] ?></h2>
        <p class="txt-info">
          <?php echo $row["hotels_description"] ?>
        </p>
        <h2 class="name-info">ที่อยู่ของโรงแรม</h2>
        <p class="txt-info">
          <?php echo $row["hotels_address"] . " " . $row["location_name"] . " " . $row["hotels_postcode"]?>
        </p> 
      </div>
    </div>

    <!---- hotel facility ---->
    <?php
    $select_stmt2 = $db->prepare("SELECT facility_name from hotels h join hotelsfacility h2 using (hotel_id) join facilityname 
           using (facility_id)  WHERE hotel_id = :hotel_id");
    $select_stmt2->bindParam(':hotel_id', $_SESSION["hotel_id"]);
    $select_stmt2->execute();
    ?>
    <!---- css มีปัญหา ---->

    <div class="desc">
      <div class="desc-over">
        <h3 class="desc-txt">Property Overview</h3>
        <div class="propertyover"> <!---- css มีปัญหา ตรงนี้เลยลบ tag class --->
          <p class="desc-info1"><?php while ($row2 = $select_stmt2->fetch(PDO::FETCH_ASSOC)) : ?><?php echo $row2["facility_name"]; ?></p>
        <?php endwhile ?>
        </div>
      </div>
    </div>



    <!---- hotels rooms & roomfaciti ---->

    <div class="mos">
      <div class="mos2">
        <form class="p-5 card" action="BackEnd/searchbydate.php" method="get">
          <div class="row">
            <input type="hidden" name="hotel_id" value=<?php echo $_SESSION['hotel_id']; ?>>
            <div class="col-md-6 ps-0 mb-3">
              <label class="form-label">วันเช็คอิน</label>
              <input type="date" name="checkin_date" class="form-control shadow-none" min="<?php echo date('Y-m-d') ?>" value="<?php echo $_SESSION["checkin"] ?>" />
            </div>
            <div class="col-md-6 ps-0 mb-3">
              <label class="form-label">วันเช็คเอ้าต์</label>
              <input type="date" name="checkout_date" class="form-control shadow-none" min="<?php echo date('Y-m-d') ?> " value="<?php echo $_SESSION["checkout"] ?>" />
            </div>
            <div class="row">
              <div class="col-md-12 ps-0 mb-3">
                <button type="submit" name="search" class="btn btn-primary">บันทึก</button>
              </div>

            </div>
        </form>
      </div>
    </div>

    <!--ส่วนแสดงห้องพัก และจองห้องพัก-->

    <div class="ta-desc">

      <table class="table">
        <thead>
          <tr>
            <th>รูปภาพ</th>
            <th>ประเภทห้อง</th>
            <th>คน</th>
            <th>Description</th>
            <th>จำนวนห้อง</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

          <?php


          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
          ?>

            <tr style="height: 100px; width: 200px;">

              <td style="max-width: 200px;"><img src="<?php echo 'BackEnd/uploads_img/' . $row["rooms_img"]; ?>" alt="รูปภาพของเรา"></td>
              <td><?php echo $row["rooms_type"]; ?></td>
              <td><?php echo $row["rooms_size"]; ?></td>
              <?php
              $select_stmt_romfacility = $db->prepare("SELECT facility_name from rooms r join roomsfacility rf using (room_id) join facilityname 
                                                  using (facility_id)  WHERE room_id = :room_id");
              $select_stmt_romfacility->bindParam(':room_id', $row["room_id"]);
              $select_stmt_romfacility->execute();

              ?>

              <td><?php echo $row["rooms_description"] . '<br>'; ?>
                <?php
                $select_stmt_romfacility = $db->prepare("SELECT facility_name from rooms r join roomsfacility rf using (room_id) join facilityname using (facility_id)  WHERE room_id = :room_id");
                $select_stmt_romfacility->bindParam(':room_id', $row["room_id"]);
                $select_stmt_romfacility->execute();
                while ($row3 = $select_stmt_romfacility->fetch(PDO::FETCH_ASSOC)) :
                ?>
                  <?php echo $row3["facility_name"] . '<br>';  ?>
                <?php endwhile ?>
              <td> <?php
                    if ((isset($_SESSION['GetSearch']) && $_SESSION['GetSearch'] === 'getsearch') || ($_SESSION['checkin'] != null && $_SESSION['checkout'] != null)) {

                      echo $row["available_rooms"];
                    } else {
                      echo 'กรุณาใส่วันที่';
                    } ?></td>
              <td>
                <form class="p-5 card" action="booking.php" method="get">
                  <!-- เช็คว่าเป็น hotelowner หรือไม่ ไม่ให้จอง -->
                  <?php if ((isset($_SESSION['userid'])) && ($_SESSION["role"] == 'HOTELOWNER')) : ?>

                    <div class="alert alert-danger" role="alert">
                      <?php echo $_SESSION['ur_hotel']; ?>
                    </div>
                  <?php else : ?>
                    <h6 class="mb-2">ราคาหัองพัก/คืน</h6>
                    <h2 class="mb-4">฿ <?= number_format($row['rooms_price']) ?></h2>
                    <button type="submit2" name="submit2" class="btn btn-primary">จอง</button>
                  <?php endif; ?>

                  <input type="hidden" name="room_id" value=<?php echo $row["room_id"] ?>>
                  <input type="hidden" name="hotel_id" value=<?php echo $_SESSION["hotel_id"] ?>>

                  <?php
                  if (isset($_SESSION["checkin"]) && isset($_SESSION["checkout"])) {
                    echo '<input type="hidden" name="checkout_date" value="' . $_SESSION["checkout"] . '">';
                    echo '<input type="hidden" name="checkin_date" value="' . $_SESSION["checkin"] . '">';
                    echo '<input type="hidden" name="available_rooms" value="' . $row["available_rooms"] . '">';
                  }
                  ?>
                </form>
              </td>
            </tr>

          <?php endwhile ?>

        </tbody>
      </table>
    </div>
    </table>
  </div>
  <div>
  </div>

  <?php
  $review_stmt = $db->prepare("SELECT COALESCE(AVG(COALESCE(reviews_rating, 0)), 0) AS average_rating
                              FROM reviews 
                              WHERE hotel_id = :hotel_id");
  $review_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
  $review_stmt->execute();
  $result = $review_stmt->fetch(PDO::FETCH_ASSOC);
  ?>

  <div class="wrapper">
    <div class="review">
      <h3 class="name-re">รีวิวจากผู้เข้าพัก</h3> <br>
      <h4 class="name-re">คะแนนรีวิว : <?php echo $result["average_rating"] . " / 5"?></h4>
    </div>

    <div class="box">
      <?php
      $select_stmt = $db->prepare("SELECT * FROM reviews 
                                    JOIN hotels
                                    USING (hotel_id) 
                                    JOIN users ON (reviews.user_id = users.user_id) 
                                    WHERE hotel_id = :hotel_id");

      $select_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
      $select_stmt->execute();

      $row_count = $select_stmt->rowCount();
      if ($row_count > 0) {
        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <div class="scroll-box">
            <h5 class="pro-re"> <?php echo $row["users_username"] ?> </h5>
            <h6 class="pro-re"> <?php echo "คะแนนรีวิว : " . $row["reviews_rating"] . " / 5" ?> </h6>
            <hr>
            <h6 class="txt-re"> <?php echo $row["reviews_comment"] ?> </h6>
          </div>

      <?php
        }
      } else {
        echo "ไม่พบข้อมูลที่ตรงกับคำค้นหา";
      } ?>
    </div>
  </div>
  </div>
</body>

</html>