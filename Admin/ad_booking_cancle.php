

<div class="container">
    <div class="card-body-profile">
        <h2>Cancle Booking</h2>
        <hr>
        <div style="height: 100%; overflow: auto;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Booking Id</th>
                        <th>User Id</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Receipt</th>
                        <th>status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        session_start();

                        include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

                        // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง payment
                        $sql = " SELECT * FROM payments 
                        JOIN bookings USING (booking_id)
                        JOIN users ON (users.user_id = bookings.user_id)
                        JOIN canclebooking ON (canclebooking.booking_id = bookings.booking_id)
                        WHERE bookings_status = 'Cancle Booking'
                        ORDER BY payment_date DESC
                        ";

                        $stmt = $db->prepare($sql);
                        $stmt->execute();

                        
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                    ?>
                        <tr>
                            <form method="POST" action="ad_cancle_db.php">
                                <td><?php echo $row["cancle_id"]; ?></td>
                                <td><?php echo $row["booking_id"]; ?></td>
                                <td><?php echo $row["user_id"]; ?></td>
                                <td><?php echo $row["payments_amount"]; ?></td>
                                <td><?php echo $row["payment_date"]; ?></td>
                                <td>
                                    <?php if ($row["bookings_status"] == 'Cancle Booking'): ?>
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $row["payment_id"]; ?>">View Details</a>
                                    <?php endif; ?>
                                
                                </td>
                                
                                <td>
                                <?php if ($row["cancle_status"] == 'Confirmed'): ?>
                                    <span style="color: green;"><b><?php echo $row["cancle_status"]; ?></b></span>

                                <?php else: ?>
                                        <span style="color: red;"><b><?php echo $row["cancle_status"]; ?></b></span>
                                <?php endif; ?>

                                </td>

                                                            
                                <td>

                                    <input type="hidden" name="payment_id" value="<?php echo $row["payment_id"]; ?>"> 
                                    <input type="hidden" name="booking_id" value="<?php echo $row["booking_id"]; ?>">
                                    <input type="hidden" name="payment_id" value="<?php echo $row["user_id"]; ?>"> 

                                   
                                <?php if ($row['cancle_status'] != 'WAITING'): ?>

                                <?php else : ?>
                                    <button type="submit" name="ad_submitpay" class="btn btn-success">Confirm</button>
                                    <button type="submit" name="ad_cancelpay" class="btn btn-danger">Cancle</button>
                                
                                <?php endif; ?>
                                </td>

                            
                            </form>
                        </tr>


                        
                        <!-- ยกเลิกการจอง -->
                        <div class="modal fade" id="myModal<?php echo $row["payment_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">รายละเอียดการขอคืนเงิน</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <!-- ส่วนนี้จะแสดงข้อมูลรายละเอียดใน Modal -->
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><b>หมายเลขการจอง :</b> <?php echo $row["booking_id"]; ?></h5>
                                                <p class="card-text"><b>ชื่อ-นามสุกล : </b> <?php echo $row["users_first_name"]. " ". $row["users_last_name"] ; ?></p>
                                                <p class="card-text"> <b>เบอร์ติดต่อ :</b> <?php echo $row["users_phone_number"]; ?></p>
                                                <p class="card-text"> <b>Email :</b> <?php echo  $row["users_email"]; ?></p>
                                                <hr>
                                                <p class="card-text">  <b>หมายเลขบัญชีธนาคาร :</b> <?php echo $row['cancle_banknum'] ?></p>
                                                <p class="card-text">  <b>ธนาคาร :</b> <?php echo $row['cancle_bankname'] ?></p>
                                                <p class="card-text">  <b>วันเวลาส่งคำขอคืนเงิน :</b> <?php echo $row['cancle_date'] ?></p>
                                                <p class="card-text">  <b>เหตุผลที่ยกเลิก :</b> <?php echo $row['cancle_reason'] ?></p>

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
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>