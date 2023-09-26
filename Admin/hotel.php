<div class="container">
    <h2>Hotels Table</h2>
    <hr>
    <div style="height: 100%; overflow: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Location</th>
                    <th>Postcode</th>
                    <th>Description</th>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php

                    include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

                    // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง 
                    $sql = "SELECT * FROM hotels h
                    JOIN locations USING (location_id)
                    JOIN users USING (user_id)
                    JOIN requests r ON r.request_id = h.request_id
                    WHERE r.req_status = 'Approved'";

                    $stmt = $db->prepare($sql);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                ?>
                    <tr>
                        <form method="POST" action="hotel_db.php">
                            <td><?php echo $row["hotel_id"]; ?></td>
                            <td><?php echo $row["hotels_name"]; ?></td>
                            <td><?php echo $row["hotels_phone"]; ?></td>
                            <td><?php echo $row["hotels_address"]; ?></td>
                            <td><?php echo $row["location_name"]; ?></td>
                            <td><?php echo $row["hotels_postcode"]; ?></td>
                            <td><?php echo $row["hotels_description"]; ?></td>
                            <td><?php echo $row["users_username"]; ?></td>
                            <td>
                                <input type="hidden" name="user_id" value="<?php echo $row["user_id"]; ?>"> 
                                <input type="hidden" name="hotel_id" value="<?php echo $row["hotel_id"]; ?>">

                                <button type="submit" name="ad_delete" class="btn btn-danger">Delete</button>
                               
                            </td>
                        </form>
                    </tr>

                <?php endwhile ?>

            </tbody>
        </table>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>