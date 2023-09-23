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
} else {
  echo "ไม่พบข้อมูลที่ต้องการ";
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
</head>

<body>
  <?php require('navbar.php'); ?>
<!---- hotel img des  ---->
  <div class="wrapper">
    <div class="info">
      <div class="img">
      <img src="<?php echo 'BackEnd/uploads_img/'.$row["hotels_img"]; ?>" alt="รูปภาพของเรา">
      </div>
      <div class="info-txt">
        <h2 class="name-info"><?php echo $row["hotels_name"]?></h2>
        <p class="txt-info">
        <?php echo $row["hotels_description"]?>
        </p>
      </div>
    </div>
    <!---- hotel facility ---->
    <?php include('BackEnd/includes/connect_database.php');
           $select_stmt2 = $db->prepare("SELECT facility_name from hotels h join hotelsfacility h2 using (hotel_id) join hotelsfacilityname 
           using (facility_id)  WHERE hotel_id = :hotel_id");
           $select_stmt2->bindParam(':hotel_id', $_POST["hotel_id"]);
           $select_stmt2->execute();
           

           
      ?>
      <!---- css มีปัญหา ---->
    <div>
      <div >
        <h3 class="desc-txt">Property Overview</h3>
        <div">
          <?php  while ($row2 = $select_stmt2->fetch(PDO::FETCH_ASSOC)) :?>
          <p class="desc-info1"><?php  echo $row2["facility_name"];?></p>
          <?php endwhile?>
        </div>
      </div>
    </div>

    <!---- hotels rooms & roomfaciti ---->
    
    <div class="center">
      <div class="table">
        <table class="table-type">
          <tr>
            <th>ห้องพัก</th>
            <th>สิ่งอำนวยความสะดวก</th>
            <th>ผู้เข้าพัก</th>
            <th>การชำระเงินและการยกเลิกการจอง</th>
            <th>ราคาห้องต่อคืน</th>
          </tr>
          <tr>
            <td>
              <p class="col-head">เตียงเดี่ยว</p>
              <hr />
              <ion-icon name="contract-outline"></ion-icon> ขนาดห้อง 22
              ตร.ม.<br /><ion-icon name="tv-outline"></ion-icon>
              โทรทัศน์<br /><ion-icon name="business-outline"></ion-icon>
              วิวเมือง<br /><ion-icon name="water-outline"></ion-icon>
              ห้องน้ำในตัว<br />
              <ion-icon name="wifi-outline"></ion-icon> wi-fi ทุกห้อง(ฟรี)<br /><ion-icon name="snow-outline"></ion-icon>
              เครื่องปรับอากาศ<br /><ion-icon name="wine-outline"></ion-icon>
              มินิบาร์<br /><ion-icon name="logo-no-smoking"></ion-icon>
              ห้องปลอดบุหรี่
            </td>
            <td>
              <ion-icon name="megaphone-outline"></ion-icon>
              ไดร์เป่าผม<br /><ion-icon name="accessibility-outline"></ion-icon>
              ผ้าเช็ดตัว<br /><ion-icon name="call-outline"></ion-icon>
              โทรศัพท์ <br /><ion-icon name="partly-sunny-outline"></ion-icon>
              ม่านทึบแสง<br /><ion-icon name="thermometer-outline"></ion-icon>
              ตู้เย็น<br /><ion-icon name="water-outline"></ion-icon>
              น้ำดื่มบรรจุขวด<br /><ion-icon name="car-outline"></ion-icon>
              ที่จอดรถ(ฟรี)
            </td>
            <td>1</td>
            <td>
              การยกเลิกการจอง<br />
              <p class="col-col">ขอรับเงินคืนไม่ได้</p>
              การชำระเงิน<br />
              <p class="col-col">ชำระเงินทันที</p>
            </td>
            <td>
              <p class="price"><br />650 บาท</p>
              <div class="container">
                <button type="submit" class="btn-booking">
                  Booking for now
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="col-head">เตียงเดี่ยว</p>
              <hr />
              <ion-icon name="contract-outline"></ion-icon> ขนาดห้อง 22
              ตร.ม.<br /><ion-icon name="tv-outline"></ion-icon>
              โทรทัศน์<br /><ion-icon name="business-outline"></ion-icon>
              วิวเมือง<br /><ion-icon name="water-outline"></ion-icon>
              ห้องน้ำในตัว<br />
              <ion-icon name="wifi-outline"></ion-icon> wi-fi ทุกห้อง(ฟรี)<br /><ion-icon name="snow-outline"></ion-icon>
              เครื่องปรับอากาศ<br /><ion-icon name="wine-outline"></ion-icon>
              มินิบาร์<br /><ion-icon name="logo-no-smoking"></ion-icon>
              ห้องปลอดบุหรี่
            </td>
            <td>
              <ion-icon name="megaphone-outline"></ion-icon>
              ไดร์เป่าผม<br /><ion-icon name="accessibility-outline"></ion-icon>
              ผ้าเช็ดตัว<br /><ion-icon name="call-outline"></ion-icon>
              โทรศัพท์ <br /><ion-icon name="partly-sunny-outline"></ion-icon>
              ม่านทึบแสง<br /><ion-icon name="thermometer-outline"></ion-icon>
              ตู้เย็น<br /><ion-icon name="water-outline"></ion-icon>
              น้ำดื่มบรรจุขวด<br /><ion-icon name="car-outline"></ion-icon>
              ที่จอดรถ(ฟรี)
            </td>
            <td>1</td>
            <td>
              การยกเลิกการจอง<br />
              <p class="col-col">ขอรับเงินคืนไม่ได้</p>
              การชำระเงิน<br />
              <p class="col-col">ชำระเงินทันที</p>
            </td>
            <td>
              <p class="price"><br />650 บาท</p>
              <div class="container">
                <button type="submit" class="btn-booking">
                  Booking for now
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <p class="col-head">เตียงเดี่ยว</p>
              <hr />
              <ion-icon name="contract-outline"></ion-icon> ขนาดห้อง 22
              ตร.ม.<br /><ion-icon name="tv-outline"></ion-icon>
              โทรทัศน์<br /><ion-icon name="business-outline"></ion-icon>
              วิวเมือง<br /><ion-icon name="water-outline"></ion-icon>
              ห้องน้ำในตัว<br />
              <ion-icon name="wifi-outline"></ion-icon> wi-fi ทุกห้อง(ฟรี)<br /><ion-icon name="snow-outline"></ion-icon>
              เครื่องปรับอากาศ<br /><ion-icon name="wine-outline"></ion-icon>
              มินิบาร์<br /><ion-icon name="logo-no-smoking"></ion-icon>
              ห้องปลอดบุหรี่
            </td>
            <td>
              <ion-icon name="megaphone-outline"></ion-icon>
              ไดร์เป่าผม<br /><ion-icon name="accessibility-outline"></ion-icon>
              ผ้าเช็ดตัว<br /><ion-icon name="call-outline"></ion-icon>
              โทรศัพท์ <br /><ion-icon name="partly-sunny-outline"></ion-icon>
              ม่านทึบแสง<br /><ion-icon name="thermometer-outline"></ion-icon>
              ตู้เย็น<br /><ion-icon name="water-outline"></ion-icon>
              น้ำดื่มบรรจุขวด<br /><ion-icon name="car-outline"></ion-icon>
              ที่จอดรถ(ฟรี)
            </td>
            <td>1</td>
            <td>
              การยกเลิกการจอง<br />
              <p class="col-col">ขอรับเงินคืนไม่ได้</p>
              การชำระเงิน<br />
              <p class="col-col">ชำระเงินทันที</p>
            </td>
            <td>
              <p class="price"><br />650 บาท</p>
              <div class="container">
                <button type="submit" class="btn-booking">
                  Booking for now
                </button>
              </div>
            </td>
          </tr>
        </table>
      </div>
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