<?php
session_start();
include('BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

// if (!isset($_SESSION['is_login'])) {
//     header('location: login.php');
// } else {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $select_stmt = $db->prepare("SELECT * FROM hotels 
  JOIN locations l USING (location_id) JOIN rooms r USING (hotel_id)  
  WHERE hotel_id = :hotel_id");
  $select_stmt->bindParam(':hotel_id', $_POST["hotel_id"]);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  $_SESSION["hotel_id"] = $_POST["hotel_id"];
  echo '';
} else if (isset($_SESSION['GetSearch'])) {
  echo $_SESSION['GetSearch'];
  echo $_SESSION["hotel_id"];
  echo $_SESSION["checkin_date"];
  $select_stmt = $db->prepare("SELECT * FROM hotels 
  JOIN locations l USING (location_id) JOIN rooms r USING (hotel_id)  
  WHERE hotel_id = :hotel_id");
  $select_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
} // } 
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
  <style>
    .mos {
      margin-top: 10%;
    }

    .ta-desc {
      width: 90%;
    }

    .mos2 {
      margin-left: 5%;
      font-size: 2em;
      text-align: center;
      color: red;
      margin-top: 5%;
      width: 90%;
    }
  </style>
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
      </div>
    </div>

    <!---- hotel facility ---->
    <?php include('BackEnd/includes/connect_database.php');
    $select_stmt2 = $db->prepare("SELECT facility_name from hotels h join hotelsfacility h2 using (hotel_id) join facilityname 
           using (facility_id)  WHERE hotel_id = :hotel_id");
    $select_stmt2->bindParam(':hotel_id', $_SESSION["hotel_id"]);
    $select_stmt2->execute();

    ?>
    <!---- css มีปัญหา ---->

    <div class="desc">
      <div class="desc-over">
        <h3 class="desc-txt">Property Overview</h3>
        <div> <!---- css มีปัญหา ตรงนี้เลยลบ tag class --->
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
              <input type="date" name="checkin_date" class="form-control shadow-none" min="<?php echo date('Y-m-d') ?>" />
            </div>
            <div class="col-md-6 ps-0 mb-3">
              <label class="form-label">วันเช็คเอ้าต์</label>
              <input type="date" name="checkout_date" class="form-control shadow-none" min="<?php echo date('Y-m-d') ?>" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 ps-0 mb-3">
              <button type="submit" name="search" class="btn btn-primary">บันทึก</button>
            </div>

          </div>
        </form>
      </div>
    </div>

    <div class="ta-desc">

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>รูปภาพ</th>
            <th>ประเถทห้อง</th>
            <th>คน</th>
            <th>Description</th>

            <th>จำนวนห้องตอนนี้</th>
            <th>จำนวนที่จะจอง</th>
          </tr>
        </thead>
        <tbody>

          <?php


          if (isset($_SESSION['GetSearch'])) {
            $sql = "SELECT r.room_id, rooms_img, rooms_type, rooms_size, rooms_number - IFNULL(num_booked, 0) AS available_rooms, rooms_description
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
            $stmt->bindParam(':checkin',  $_SESSION["checkin_date"], PDO::PARAM_STR);
            $stmt->bindParam(':checkout', $_SESSION["checkout_date"], PDO::PARAM_STR);
            $stmt->execute();
          } else {
            // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง room
            $sql = "SELECT * FROM hotels 
                                    JOIN locations l USING (location_id) 
                                    JOIN rooms r USING (hotel_id) 
                                    WHERE hotel_id = :hotel_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
            $stmt->execute();
          }

          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
          ?>

            <tr style="height: 100px; width: 200px;">

              <td style="max-width: 100px;"><img src="<?php echo 'BackEnd/uploads_img/' . $row["rooms_img"]; ?>" alt="รูปภาพของเรา"></td>
              <td><?php echo $row["rooms_type"]; ?></td>
              <td><?php echo $row["rooms_size"]; ?></td>
              <td><?php echo $row["rooms_description"]; ?></td>
              <td> <?php
                    if (isset($_SESSION['GetSearch']) && $_SESSION['GetSearch'] === 'getsearch') {
                      echo $row["available_rooms"];
                    } else {
                      echo 'ควย';
                    } ?></td>
              <td>
                <form class="p-5 card" action="booking.php" method="get">
                  <?php if ($_SESSION["role"] == 'HOTELOWNER') : ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $_SESSION['ur_hotel']; ?>
                    </div>
                  <?php else : ?>
                    <button type="submit2" name="submit2" class="btn btn-primary">จอง</button>
                  <?php endif; ?>
                  <input type="hidden" name="room_id" value=<?php echo $row["room_id"] ?>>
                  <input type="hidden" name="checkin_date" value=<?php echo $_SESSION["checkin_date"] ?>>
                  <input type="hidden" name="checkout_date" value=<?php echo $_SESSION["checkout_date"] ?>>
                  <input type="hidden" name="hotel_id" value=<?php echo $_SESSION["hotel_id"] ?>>
                  <input type="hidden" name="available_rooms" value=<?php echo $row["available_rooms"] ?>>
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

  <div class="wrapper">
    <div class="review">
      <h3 class="name-re">Review</h3>
    </div>
    <div class="box">
      <?php
      $select_stmt = $db->prepare("SELECT * FROM reviews 
        JOIN hotels
        USING (hotel_id) 
        JOIN users ON (reviews.user_id = users.user_id) 
        WHERE hotel_id = :hotel_id");
      $select_stmt->bindParam(
        ':hotel_id',
        $_POST["hotel_id"]
      );
      $select_stmt->execute();
      $row_count =
        $select_stmt->rowCount();
      if ($row_count > 0) {
        while ($row =
          $select_stmt->fetch(PDO::FETCH_ASSOC)
        ) {
          echo '
          <div class="scroll-box">
            ';
          echo '
            <h5 class="pro-re">' . $row["users_username"] . '</h5>
            ';
          echo '
            <h6 class="txt-re">' . $row["reviews_comment"] . '</h6>
            ';
          echo '
          </div>
          ';
        }
      } else {
        echo "ไม่พบข้อมูลที่ตรงกับคำค้นหา";
      } ?>
    </div>
  </div>
  </div>
</body>

</html>

<?php

if (isset($_SESSION['GetSearch'])) {
  unset($_SESSION['GetSearch']);
}


?>