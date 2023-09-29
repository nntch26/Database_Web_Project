

<?php
session_start();

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
          <h1>History Payments</h1>
          <h2>ประวัติการชำระเงิน</h2>
          <thead class="table-warning">
            <tr>
              <th scope="col">หมายเลขชำระเงิน</th>
              <th scope="col">ชื่อ</th>
              <th scope="col">เบอร์ติดต่อ</th>
              <th scope="col">หมายเลขห้อง</th>
              <th scope="col">ประเภทห้อง</th>
              <th scope="col">วันที่ชำระเงิน</th>
              <th scope="col">ยอดรวม</th>
              <th scope="col">สถานะการชำระเงิน</th>
              <th scope="col"></th>


            </tr>
          </thead>

          <tbody>
          <?php

              include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

              // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง booking
              $sql = "SELECT *
                      FROM bookings
                      JOIN hotels USING (hotel_id)
                      JOIN rooms USING (room_id)
                      JOIN users u ON bookings.user_id = u.user_id
                      JOIN payments p  ON p.booking_id  = bookings.booking_id 
                      WHERE hotels.hotel_id = :hotel_id
                      ORDER BY bookings.booking_id DESC";

              $stmt = $db->prepare($sql);
              $stmt->bindParam(':hotel_id',  $_SESSION["hotel_id"]);

              $stmt->execute();

              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
              ?>
              <tr>
                  <form method="POST" action="ad_pay_db.php">
                      <td><?php echo $row["payment_id"]; ?></td>
                      <td><?php echo $row["users_first_name"]. ' '. $row["users_last_name"]; ?></td>
                      <td><?php echo $row["users_phone_number"]; ?></td>
                      <td><?php echo $row["room_id"]; ?></td>
                      <td><?php echo $row["rooms_type"]; ?></td>
                      <td><?php echo $row["payment_date"]; ?></td>
                      <td><?php echo number_format($row["bookings_total_price"]); ?></td>
                      <td><?php echo $row["payments_status"]; ?></td>
                      <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $row["payment_id"]; ?>">View Details</a></td>

                      
                  </form>
              </tr>

              <div class="modal fade" id="myModal<?php echo $row["payment_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">รายละเอียดการชำระเงิน</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <!-- ส่วนนี้จะแสดงข้อมูลรายละเอียดใน Modal -->
                            <div class="card">
                                <div class="card-body">
                                    <img src="../BackEnd/bill_img/<?= $row['payments_img'] ?>" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
              </div>
              <?php endwhile ?>

          </tbody>
        </table>
        <br>
        <a href="../profilehotel.php" class="btn btn-primary btn-lg" type="submit">ย้อนกลับ</a>
    </div>
 </div>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>