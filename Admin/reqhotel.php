<div class="container">
    <h2>Requests Table</h2>
    <hr>
    <div style="height: 100%; overflow: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Hotel Name</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Details</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php

                    include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

                    // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง Requests
                    $sql = "SELECT *
                    FROM hotels h
                    JOIN users u ON h.user_id = u.user_id
                    JOIN requests r ON r.request_id = h.request_id
                    JOIN locations l ON h.location_id = l.location_id
                    ORDER BY req_sent_date DESC";

                    $stmt = $db->prepare($sql);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                ?>
                    <tr>
                        <form method="POST" action="regis_db.php">
                            <td><?php echo $row["users_username"]; ?></td>
                            <td><?php echo $row["hotels_name"]; ?></td>
                            <td><?php echo $row["location_name"]; ?></td>
                            <td><?php echo $row["req_sent_date"]; ?></td>
                            <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $row["request_id"]; ?>">View Details</a></td>
                            <td>
                                <input type="hidden" name="user_id" value="<?php echo $row["user_id"]; ?>"> <!-- ส่งค่าไป php แบบซ้อน-->
                                <input type="hidden" name="request_id" value="<?php echo $row["request_id"]; ?>">
                                <input type="hidden" name="location_id" value="<?php echo $row["location_id"]; ?>">

                                <!-- อัปเดตข้อมูลแล้ว -->
                                <?php if ($row["req_status"] == 'Approved') : ?>
                                    <!-- ถ้าเป็น APPROVE ให้แสดงสถานะ -->
                                    <span style="color: green;"><b><?php echo $row["req_status"]; ?></b></span>

                                <?php else : ?>
                                    <!-- ถ้าไม่ใช่ APPROVE ให้แสดงปุ่ม Confirm และ Cancel -->
                                    <button type="submit" name="ad_submit" class="btn btn-success">Confirm</button>
                                    <button type="submit" name="ad_cancel" class="btn btn-danger">Cancel</button>
                                <?php endif; ?>

                            </td>
                        </form>
                    </tr>

                    <!-- ตำแหน่งที่ตั้ง Modal ใน HTML -->
                    <div class="modal fade" id="myModal<?php echo $row["request_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">รายละเอียดคำขอ</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- ส่วนนี้จะแสดงข้อมูลรายละเอียดใน Modal -->
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><b>ชื่อโรงแรม :</b> <?php echo $row["hotels_name"]; ?></h5>
                                            <p class="card-text"><b>รายละเอียดโรงแรม : </b> <?php echo $row["hotels_description"]; ?></p>
                                            <p class="card-text"> <b>เบอร์ติดต่อ :</b> <?php echo $row["hotels_phone"]; ?></p>
                                            <p class="card-text"> <b>ที่อยู่ :</b> <?php echo  $row["hotels_address"]. " ".$row["location_name"]." ".$row["hotels_postcode"] ; ?></p>
                                            <p class="card-text">  <b>วันเวลาส่งคำร้องขอ :</b> <?php echo $row["req_sent_date"]; ?></p>

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
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>