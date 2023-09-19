<div class="container">
    <h2>User Table</h2>
    <hr>
    <div style="height: 100%; overflow: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Fistname</th>
                    <th>Lastname</th>
                    <th>Phonenumber</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Postcode</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>

                <?php

                    include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

                    // คำสั่ง SQL สำหรับดึงข้อมูลจากตาราง Requests
                    $sql = "SELECT *
                            FROM users";

                    $stmt = $db->prepare($sql);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                ?>
                    <tr>
                        <form>
                            <td><?php echo $row["user_id"]; ?></td>
                            <td><?php echo $row["users_username"]; ?></td>
                            <td><?php echo $row["users_email"]; ?></td>
                            <td><?php echo $row["users_first_name"]; ?></td>
                            <td><?php echo $row["users_last_name"]; ?></td>
                            <td><?php echo $row["users_phone_number"]; ?></td>
                            <td><?php echo $row["users_address"]; ?></td>
                            <td><?php echo $row["users_city"]; ?></td>
                            <td><?php echo $row["users_postcode"]; ?></td>
                            <td><?php echo $row["users_role"]; ?></td>
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