<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600&family=Noto+Sans+Thai:wght@100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">

    <title>Hotel Project</title>

</head>
<body>

    <!---- Navbar ---->
    <?php require('navbar.php'); ?>

    <!---- header ---->
    <header class="section__container header__container">
        <!----Backgrounds image---->
        <div class="header__image__container">
            <div class="header__content ">
            <h1>Enjoy Your Dream Vacation</h1>
            <p>จองโรงแรม ห้องพัก และแพ็คเกจการเข้าพักในราคาที่ถูกที่สุด</p>
            </div>

            <!----Booking bar---->
            <div class="booking__container">
                <form>
                    <div class="form__group ">
                        <div class="input__group ">
                            <input type="text" />
                            <label>Location</label>
                        </div>
                        <p>Where are you going?</p>
                    </div>

                    <div class="form__group">
                        <div class="input__group">
                            <input type="date" />
                            <label>Check In</label>
                        </div>
                        <p>Add date</p>
                    </div>

                    <div class="form__group">
                        <div class="input__group">
                            <input type="date" />
                            <label>Check Out</label>
                        </div>
                        <p>Add date</p>
                    </div>

                    <div class="form__group">
                        <div class="input__group">
                            <input type="text" />
                            <label>Guests</label>
                        </div>
                        <p>Add guests</p>
                    </div>

                </form>
                <button type="button" class="btn btn-primary shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#submitModel">Submit</button>
            </div>
        </div>
    </header>
    <!---- end header ---->




    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="mt-5 mb-3 text-center">
                    <small class="text-center">
                        Copyright © 2023 Haramnon.com. All Rights Reserved.
                    </small>
               
                </div>
                
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>
