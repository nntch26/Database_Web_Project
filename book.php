<?php
session_start();
include('BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

// if (!isset($_SESSION['is_login'])) {
//     header('location: login.php');
// } else {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $select_stmt = $db->prepare("SELECT * FROM hotels 
                                    WHERE hotel_id = :hotel_id");
    $select_stmt->bindParam(':hotel_id', $_POST["hotel_id"]);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "ไม่พบข้อมูลที่ต้องการ";
}
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600&family=Noto+Sans+Thai:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap');

    :root {
        --primary-color: #2c3855;
        --primary-color-dark: #435681;
        --text-dark: #333333;
        --text-light: #767268;
        --extra-light: #f3f4f6;
        --white: #ffffff;
        --max-width: 1200px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .section__container {
        max-width: var(--max-width);
        margin: auto;
        padding: 5rem 1rem;
    }

    .section__header {
        font-size: 2rem;
        font-weight: 600;
        color: var(--text-dark);
        text-align: center;
    }

    a {
        text-decoration: none;
    }

    img {
        width: 100%;
        display: flex;
    }

    body {
        font-family: 'Kanit', sans-serif;
    }


    /* login - register*/

    .flex-login-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0 auto;
        max-width: 100%;
    }

    .login-background-blue {
        background-color: #77bbff;
    }

    .login-btn-blue {
        background-color: rgb(39, 86, 255);
    }

    .login-card-custom {
        border-radius: 12px;
        width: 30%;
    }


    /* Header image  */
    .header__container {
        padding: 1rem 1rem 5rem 1rem;
    }

    .header__image__container {
        position: relative;
        min-height: 500px;
        background-image: linear-gradient(to right,
                rgba(44, 56, 85, 0.9),
                rgba(100, 125, 187, 0.1)),
            url("../img/hotel-room-home.jpg");
        background-position: center center;
        background-size: cover;
        background-repeat: no-repeat;
        border-radius: 2rem;
    }

    .header__content {
        max-width: 600px;
        padding: 5rem 2rem;
    }

    .header__content h1 {
        margin-bottom: 1rem;
        font-size: 3.5rem;
        line-height: 4rem;
        font-weight: 600;
        color: var(--white);
    }

    .header__content p {
        color: var(--extra-light);
    }

    .booking__container {
        position: absolute;
        bottom: -5rem;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 6rem);
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 3rem 2rem;
        border-radius: 2rem;
        background-color: rgba(255, 255, 255, 0.873);

        box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.1);
    }


    /* Header booking  */
    .booking__container form {
        width: 100%;
        flex: 1;
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
    }

    .booking__container .input__group {
        width: 100%;
        position: relative;
    }

    .booking__container label {
        position: absolute;
        left: 0;
        transform: translateY(-80%);
        font-size: 1.2rem;
        font-weight: 500;
        color: var(--text-dark);
        pointer-events: none;
        transition: 0.3s;
    }

    .booking__container input {
        width: 100%;
        padding: 10px 0;
        font-size: 1rem;
        outline: none;
        border: none;
        background-color: transparent;
        border-bottom: 1px solid var(--primary-color);
        color: var(--text-dark);
    }

    .booking__container input:focus~label {
        font-size: 0.8rem;
        top: 0;
    }

    .booking__container .form__group p {
        margin-top: 0.5rem;
        font-size: 0.8rem;
        color: var(--text-light);
    }

    .booking__container .btn {
        padding: 0.8rem;
        outline: none;
        border: none;
        font-size: 1.2rem;
        color: var(--white);
        /*background-color: var(--primary-color);*/
        cursor: pointer;
        transition: 0.3s;
    }


    .booking__container .btn:hover {
        padding: 1.2rem;
        outline: none;
        border: 5;
        font-size: 1.2rem;
        color: rgb(39, 86, 255);
        background-color: rgba(255, 255, 255, 0.547);
        border-bottom: 5px solid;
        cursor: pointer;
        transition: 0.3s;

        /*background-color: var(--primary-color-dark);*/
    }



    /* card room  */

    /* Profile*/
    .card-body-profile {
        flex: 1 1 auto;
        padding: 3rem 3rem;
        box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
    }



    .footer {
        background-color: var(--extra-light);
    }





    @media (width < 900px) {
        .booking__container form {
            grid-template-columns: repeat(2, 1fr);
        }



    }

    @media (width < 600px) {
        .nav__links {
            display: none;
        }

        .header__container {
            padding-bottom: 25rem;
        }

        .booking__container {
            flex-direction: column;
            bottom: -25rem;
        }

        .booking__container form {
            grid-template-columns: repeat(1, 1fr);
        }


    }







    /*book*/
    .wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .name-info {
        color: rgb(39, 86, 255);
    }

    .desc-txt {
        display: flex;
        justify-content: flex-start;
        padding-right: calc(var(--bs-gutter-x) * .5);
        padding-left: calc(var(--bs-gutter-x) * .5);
        margin-top: 100px;
        margin-right: auto;
        margin-left: auto;
        margin-bottom: 2%;
        color: rgb(39, 86, 255);
    }

    .desc {
        margin-top: 3%;
        display: grid;
        grid-template-columns: auto auto;
        justify-content: flex-start;
    }



    .desc-over {
        position: absolute;
        left: 5%;
    }


    .desc-prop {
        display: grid;
        grid-template-areas: 'i1 info1 info1 i5 info5 info5'
            'i2 info2 info2 i6 info6 info6'
            'i3 info3 info3 i4 info4 info4'
        ;
        gap: 20px;
        padding: 15px;
        align-items: stretch
    }

    .desc-info1 {
        grid-area: info1;
    }

    .desc-info2 {
        grid-area: info2;
    }

    .desc-info3 {
        grid-area: info3;
    }

    .desc-info4 {
        grid-area: info4;
    }

    .desc-info5 {
        grid-area: info5;
    }

    .desc-info6 {
        grid-area: info6;
    }

    .img-i1 {
        max-width: 25px;
        max-height: 25px;
        grid-area: i1;
    }

    .img-i2 {
        max-width: 25px;
        max-height: 25px;
        grid-area: i2;
    }

    .img-i3 {
        max-width: 25px;
        max-height: 25px;
        grid-area: i3;
    }

    .img-i4 {
        max-width: 25px;
        max-height: 25px;
        grid-area: i4;
    }

    .img-i5 {
        max-width: 25px;
        max-height: 25px;
        grid-area: i5;
    }

    .img-i6 {
        max-width: 25px;
        max-height: 25px;
        grid-area: i6;
    }


    .info-txt {
        position: absolute;
        left: 5%;
    }


    .btn-book {
        margin-top: 20%;
        position: absolute;
        right: 5%;
        border: none;
        padding: 10px 20px;
        background-color: rgb(39, 86, 255);
        color: white;
        font-weight: bold;
        border-radius: 5px;
        align-items: stretch;
    }




    .img {
        display: grid;
        grid-template-areas: 'img-f img-f  img-s'
            'img-f img-f img-t';
        justify-content: center;
        gap: 10px;
        padding: 5%;
    }


    .img-first {
        grid-area: img-f;
        margin-top: 20px;
        border-radius: 25px;
    }


    .img-second {
        grid-area: img-s;
        position: relative;
        margin-top: 20px;
        border-radius: 25px;
    }


    .img-third {
        grid-area: img-t;
        position: relative;
        border-radius: 25px;
    }


    .review {
        margin-top: 35%;
        position: relative;
        margin-bottom: 15px;
    }


    .name-re {
        margin-bottom: 15px;
        margin-left: 5%;
        color: rgb(39, 86, 255);
    }

    .txt-re {
        color: rgb(128, 128, 128);
    }

    .box {
        margin-bottom: 5%;
    }

    .scroll-box {
        margin-left: 5%;
        width: 90%;
        overflow: auto;
        border: 0.5px solid #e1e1e1;
        padding: 15px;

    }
</style>

<body>

    <?php require('navbar.php'); ?>

    <div class="wrapper">
        <div class="info">
            <div class="img">
                <img src="https://static.leonardo-hotels.com/image/leonardohotelbucharestcitycenter_room_comfortdouble2_2022_4000x2600_7e18f254bc75491965d36cc312e8111f_1200x780_mobile_3.jpeg" class="img-first" alt="รูปโรงแรม">
                <img src="https://static.leonardo-hotels.com/image/leonardohotelbucharestcitycenter_room_comfortdouble2_2022_4000x2600_7e18f254bc75491965d36cc312e8111f_1200x780_mobile_3.jpeg" class="img-second" alt="รูปโรงแรม">
                <img src="https://static.leonardo-hotels.com/image/leonardohotelbucharestcitycenter_room_comfortdouble2_2022_4000x2600_7e18f254bc75491965d36cc312e8111f_1200x780_mobile_3.jpeg" class="img-third" alt="รูปโรงแรม">
            </div>
            <div class="info-txt">
                <?php echo '<h2 class="name-info">' . $row["hotels_name"] . '</h2>' ?>
                <?php echo '<p class="txt-info">' . $row["hotels_description"] . '</p>' ?>
                <?php echo '<p class="txt-info">' . "Address : " . $row["hotels_address"] . '</p>' ?>
                <?php echo '<p class="txt-info">' . "Contract Tel. " . $row["hotels_phone"] . '</p> <br>' ?>
            </div>
        </div>
        <div class="desc">
            <div class="desc-over">
                <h3 class="desc-txt">Property Overview</h3>
                <div class="desc-prop">
                    <img src="https://cdn-icons-png.flaticon.com/512/72/72234.png" class="img-i1" alt="Icon Description">
                    <img src="https://cdn-icons-png.flaticon.com/512/6869/6869912.png" class="img-i2" alt="Icon Description">
                    <img src="https://cdn-icons-png.flaticon.com/512/637/637270.png" class="img-i3" alt="Icon Description">
                    <img src="https://cdn-icons-png.flaticon.com/512/818/818416.png" class="img-i4" alt="Icon Description">
                    <img src="https://cdn-icons-png.flaticon.com/512/4162/4162840.png" class="img-i5" alt="Icon Description">
                    <img src="https://cdn-icons-png.flaticon.com/512/59/59252.png" class="img-i6" alt="Icon Description">
                    <p class="desc-info1">Free Wifi</p>
                    <p class="desc-info2">Air conditioning</p>
                    <p class="desc-info3">Private bathroom</p>
                    <p class="desc-info4">Key card access</p>
                    <p class="desc-info5">Free parking</p>
                    <p class="desc-info6">24-hours font desk</p>
                </div>
            </div>
            <div class="book">
                <button type="submit" class="btn-book">Booking for now</button>
            </div>
        </div>
        <div class="wrapper">
            <div class="review">
                <h3 class="name-re">Review</h3>
            </div>
            <div class="box">
                <?php
                $select_stmt = $db->prepare("SELECT * FROM reviews
                JOIN hotels USING (hotel_id)
                JOIN users ON (reviews.user_id = users.user_id)
                WHERE hotel_id = :hotel_id");
                $select_stmt->bindParam(':hotel_id', $_POST["hotel_id"]);
                $select_stmt->execute();

                $row_count = $select_stmt->rowCount();

                if ($row_count > 0) {
                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="scroll-box">';
                echo    '<h5 class="pro-re">' . $row["users_username"] . '</h5>';
                echo    '<h6 class="txt-re">' . $row["reviews_comment"] . '</h6>';
                echo '</div>';
                    }
                }else{
                    echo "ไม่พบข้อมูลที่ตรงกับคำค้นหา";
                }
                ?>

            </div>
        </div>
    </div>
</body>

</html>