
<?php

session_start();
include('BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


if (!isset($_SESSION['is_login'])) {
    header('location: login.php'); // ถ้าไม่มีให้เด้งไป login

}elseif ($_SESSION["role"] != 'HOTELOWNER'){
    header('location: registerhotel.php');

}
else{
      // query ข้อมูลของคนที่ login เข้ามา เพื่อแสดงผลใน html
      $select_stmt3 = $db ->prepare("SELECT * FROM rooms 
      WHERE hotel_id = :hotel_id");
  
      $select_stmt3->bindParam(':hotel_id', $_SESSION["hotel_id"]);
      $select_stmt3->execute();
  
      $row = $select_stmt3->fetch(PDO::FETCH_ASSOC); // กรณีที่เราต้องการดึงข้อมูลมาแสดง
      $_SESSION["room_id"] = $row["room_id"]; // เอาไปใช้ต่อ
      $_SESSION["rooms_price"] = $row['rooms_price'];
      $_SESSION["rooms_type"] = $row['rooms_type'];
      $_SESSION["rooms_size"] = $row['rooms_size'];
      $_SESSION["rooms_description"] = $row['rooms_description'];
      $_SESSION["rooms_number"] = $row['rooms_number'];
}



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


    <!-- Change Profile-->
    <div class="container">
        <div class="row">
            <h1 class="mt-5">Edit Room</h1>
            <p>แก้ไขข้อมูลห้องพักของคุณ</p>

             <!-- อัปเดตข้อมูลแล้ว -->
             <?php if (isset($_SESSION['is_roomedit'])) : ?>
                    <!-- ให้แสดง alert -->
                    <div class="alert alert-success" role="alert">
                        <?php echo "การลบข้อมูลของคุณเรียบร้อยแล้ว"; ?>
                    </div>
                <?php endif; ?>

                <div class="modal-body card-body-profile">
                    <hr>
                    <div style="height: 100%; overflow: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Room Id</th>
                                    <th>Room Image</th>
                                    <th>Room Type</th>
                                    <th>Room Size</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                    include('BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


                                    // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง room
                                    $sql = "SELECT * FROM hotels 
                                    JOIN locations l USING (location_id) 
                                    JOIN rooms r USING (hotel_id) 
                                    WHERE user_id = :user_id";

                                    $stmt = $db->prepare($sql);
                                    $stmt->bindParam(':user_id', $_SESSION["user_id"]);
                                    $stmt->execute();
                                    

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                                ?>
                                     <tr style="height: 100px; width: 200px;">
                                        <form method="POST" action="BackEnd/editroommain_db.php">
                                            <td><?php echo $row["room_id"]; ?></td>
                                            <td style="max-width: 100px;" ><img src="<?php echo 'BackEnd/uploads_img/'.$row["rooms_img"]; ?>" alt="รูปภาพของเรา"></td>
                                            <td><?php echo $row["rooms_type"]; ?></td>
                                            <td><?php echo $row["rooms_size"]; ?></td>
                                            <td><?php echo $row["rooms_description"]; ?></td>
                                            <td>
                                                <?php $_SESSION["room_id"] = $row['room_id']; ?> 
                                                <?php $_SESSION["hotel_id"] = $row['hotel_id']; ?>
                                                
                                                <input type="hidden" name="room_id" value="<?php echo $row['room_id']; ?>"> 
                                                <input type="hidden" name="hotel_id" value="<?php echo $row["hotel_id"]; ?>">


                                                <button type="submit" name="editroom" class="btn btn-success">Edit</button>
                                                <button type="submit" name="editroom_delete" class="btn btn-danger">Delete</button>

                                            </td>
                                        </form>
                                    </tr>
                                <?php endwhile ?>

                            </tbody>
                        </table>
                    </div>
                </div>	
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php

if (isset($_SESSION['is_roomedit'])){
    unset($_SESSION['is_roomedit']);
   
}


?>