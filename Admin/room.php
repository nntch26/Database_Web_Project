<div class="container">
    <div class="card-body-profile">
        <h2>Rooms Table</h2>
        <hr>
        <div style="height: 100%; overflow: auto;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Room id</th>
                        <th>Hotel id</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>Size</th>
                        <th>description</th>
                        <th>img</th>
                        <th>status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                        include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

                        // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง Requests
                        $sql = "SELECT *
                                FROM rooms
                                -- JOIN bookings USING (room_id)
                                ";

                        $stmt = $db->prepare($sql);
                        $stmt->execute();

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                    ?>
                        <tr>
                            <form>
                                <td><?php echo $row["room_id"]; ?></td>
                                <td><?php echo $row["hotel_id"]; ?></td>
                                <td><?php echo $row["rooms_price"]; ?></td>
                                <td><?php echo $row["rooms_type"]; ?></td>
                                <td><?php echo $row["rooms_size"]; ?></td>
                                <td><?php echo $row["rooms_description"]; ?></td>

                                <!-- <td><?php //echo $row["bookings_status"]; ?></td> -->
                            </form>
                        </tr>

                    <?php endwhile ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>