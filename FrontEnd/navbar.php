
 
 <!---- Navbar ---->
 <nav class="navbar navbar-expand-lg bg-light px-lg-3 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">หาแรมนอน</a>

            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link me-2" href="rooms.php">Rooms</a>
                    </li>
                </ul>
                <div class="d-flex" role="search">

                <?php if(isset($_SESSION['is_login'])) : ?>

                    <a class="nav-link me-5" href="profile.php"><i class="fas fa-user-circle"></i> Profile</a>
                    <a class="nav-link me-5" href="../BackEnd/logout_db.php"><i class="fas fa-sign-out-alt"></i> Logout</a>

                <?php else : ?>
                    <!-- แสดง Navbar สำหรับผู้ไม่ได้เข้าสู่ระบบ -->
                    <a href="login.php" type="button" class="btn btn-primary shadow-none me-lg-3 me-2">Login	</a>
                    <a href="register.php" type="button" class="btn btn-outline-primary shadow-none" >Register	</a>
                <?php endif; ?>

                </div>
            </div>
        </div>
    </nav>