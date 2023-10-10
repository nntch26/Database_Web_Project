<?php
session_start();
          include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


// เช็คว่า login หรือยัง ถ้ายัง ให้กลับไปยังหน้า login.php เพื่อทำการ login ก่อน
if (!isset($_SESSION['is_login'])) {
  header('location: ../login.php');
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600&family=Noto+Sans+Thai:wght@100&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/historybookandpay.css">
  <title>Document</title>

<body>


  <div class="container">
    <div class="card-body-profile">
      <table class="table table-bordered">
        <h1>History Booking</h1>
        <h2>ประวัติการจอง</h2>

        <!-- search --->
        <div class="input-group mt-5 mb-5" >
          <div class="input-group-prepend">
            <button class="btn btn-primary btn-lg mr-2" type="button">All</button>

          </div>
            <input type="search" class="form-control rounded ml-5" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            <button type="button" class="btn btn-outline-primary btn-lg">search</button>
          </div>
        </div>




        <thead class="table-primary">
          <tr>
            <th scope="col">ชื่อโรงแรม</th>
            <th scope="col">ประเภทห้อง</th>
            <th scope="col">วันที่เข้าพัก</th>
            <th scope="col">ยอดรวม</th>
            <th scope="col">สถานะการจอง</th>
            <th scope="col"></th>

          </tr>
        </thead>

        <tbody>
          <?php

          // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง booking
          $sql = "SELECT * FROM bookings
              JOIN hotels USING (hotel_id)
              JOIN rooms USING (room_id)
              WHERE bookings.user_id = :user_id
              ORDER BY booking_id DESC ";

          $stmt = $db->prepare($sql);
          $stmt->bindParam(':user_id', $_SESSION["userid"]);

          $stmt->execute();

          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
          ?>
            <tr>
              <form method="POST" action="../BackEnd/before_confirm.php">
                <td><?php echo $row["hotels_name"]; ?></td>
                <td><?php echo $row["rooms_type"]; ?></td>
                <td><?php echo $row["bookings_check_in"] . ' - ' . $row["bookings_check_out"]; ?></td>
                <td><?php echo number_format($row["bookings_total_price"]); ?></td>
                <td><?php echo $row["bookings_status"]; ?></td>
                <td>

                <?php if($row["bookings_status"] != 'Cancel') : ?>
                  <input type="hidden" name="booking_id" value="<?php echo $row["booking_id"]; ?>">
                  <button type="submit" name="confirm_pay" class="btn btn-primary btn-lg">รายละเอียดการจอง</button>
                
                <?php endif; ?>

                </td>
              </form>
            </tr>
          <?php endwhile ?>

        </tbody>
      </table>
      <br>
      <a href="../profile.php" class="btn btn-danger btn-lg" type="submit">ย้อนกลับ</a>
    </div>
  </div>
</body>

</html>