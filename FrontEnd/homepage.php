<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
} else {
    $username = $_SESSION["username"];
    $userid = $_SESSION["userid"];
    $firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];
    $username = $_SESSION["username"];
    $email = $_SESSION["email"];
    $password = $_SESSION["password"];
    $phonenumber = $_SESSION["phonenumber"];
    $address = $_SESSION["address"];
    $role = $_SESSION["role"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        .box {
            background-color: black;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        p {
            font-size: 17px;
            align-items: center;
        }

        .box a {
            display: inline-block;
            background-color: #fff;
            padding: 15px;
            border-radius: 3px;
        }

        .modal {
            align-items: center;
            display: flex;
            justify-content: center;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(254, 126, 126, 0.7);
            transition: all 0.4s;
            visibility: hidden;
            opacity: 0;
        }

        .content {
            position: absolute;
            background: white;
            width: 400px;
            padding: 1em 2em;
            border-radius: 4px;
        }

        .modal:target {
            visibility: visible;
            opacity: 1;
        }

        .box-close {
            position: absolute;
            top: 0;
            right: 15px;
            color: #fe0606;
            text-decoration: none;
            font-size: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2> Home Page <?php echo $firstname . $lastname ?></h2>
    </div>

    <div class="content">
        <div class="box">
            <a href="#popup-box">
                LOGOUT
            </a>
        </div>
        <div id="popup-box" class="modal">
            <div class="content">
                <h1> <a href="../BackEnd/logoutdb.php">Sure</a></h1>
                <b>
                <h1> <a href="homepage.php">No</a></h1>
                </b>
                <a href="#" class="box-close">
                    ×
                </a>
            </div>
        </div>
        <h1>Hello </h1>
    </div>
</body>

</html>