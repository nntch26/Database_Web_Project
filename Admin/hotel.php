<div class="container">
    <h2>Hotels Table</h2>
    <hr>
    <div style="height: 100%; overflow: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Postcode</th>
                    <th>Description</th>
                    <th>img</th>
                    <th>location id</th>
                    <th>user id</th>
                </tr>
            </thead>
            <tbody>

                <?php

                    include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

                    // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง Requests
                    $sql = "SELECT *
                            FROM hotels";

                    $stmt = $db->prepare($sql);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                ?>
                    <tr>
                        <form>
                            <td><?php echo $row["hotel_id"]; ?></td>
                            <td><?php echo $row["hotels_name"]; ?></td>
                            <td><?php echo $row["hotels_phone"]; ?></td>
                            <td><?php echo $row["hotels_address"]; ?></td>
                            <td><?php echo $row["hotels_postcode"]; ?></td>
                            <td><?php echo $row["hotels_description"]; ?></td>
                            <td><?php echo $row["hotels_img"]; ?></td>
                            <td><?php echo $row["location_id"]; ?></td>
                            <td><?php echo $row["user_id"]; ?></td>
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