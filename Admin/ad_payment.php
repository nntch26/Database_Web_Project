<div class="container">
    <div class="card-body-profile">
        <h2>Confirm Payments</h2>
        <hr>
        <div style="height: 100%; overflow: auto;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Payment Id</th>
                        <th>Booking Id</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Receipt</th>
                        <th>status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                        include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

                        // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง payment
                        $sql = "SELECT * FROM payments ORDER BY payment_date DESC
                                -- JOIN bookings USING (room_id)
                                ";

                        $stmt = $db->prepare($sql);
                        $stmt->execute();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                    ?>
                        <tr>
                            <form method="POST" action="ad_pay_db.php">
                                <td><?php echo $row["payment_id"]; ?></td>
                                <td><?php echo $row["booking_id"]; ?></td>
                                <td><?php echo $row["payments_amount"]; ?></td>
                                <td><?php echo $row["payment_date"]; ?></td>
                                <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $row["payment_id"]; ?>">View Details</a></td>
                                
                                <td>
                                    <?php if ($row["payments_status"] == 'Paid'): ?>
                                        <!-- ถ้าเป็น Paid ให้แสดงสถานะ -->
                                        <span style="color: green;"><b><?php echo $row["payments_status"]; ?></b></span>
                                    <?php elseif ($row["payments_status"] == 'Declined'): ?>
                                        <span style="color: red;"><b><?php echo $row["payments_status"]; ?></b></span>
                                    <?php else: ?>
                                        <?php echo $row["payments_status"]; ?>
                                    <?php endif; ?>
                                </td>


                                                             
                                <td>

                                    <input type="hidden" name="payment_id" value="<?php echo $row["payment_id"]; ?>"> <!-- ส่งค่าไป php แบบซ้อน-->
                                    <input type="hidden" name="booking_id" value="<?php echo $row["booking_id"]; ?>">
                                   
                                 <!-- อัปเดตข้อมูลแล้ว -->
                                 <?php if ($row["payments_status"] == 'Paid' || $row["payments_status"] == 'Declined') : ?>

                                <?php else : ?>
                                    <!-- ถ้าไม่ใช่ APPROVE ให้แสดงปุ่ม Confirm และ Cancel -->
                                    <button type="submit" name="ad_submitpay" class="btn btn-success">Confirm</button>
                                    <button type="submit" name="ad_cancelpay" class="btn btn-danger">Cancel</button>
                                
                                <?php endif; ?>
                                </td>

                            
                            </form>
                        </tr>


                        <!-- รูปการชำระเงิน -->
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
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>