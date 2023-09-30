
<nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
    <div class="container-fluid flex-lg-column align-items-stretch">
        <h4 class="mt-2">FILTERS</h4>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <form action="rooms.php" method="get">
            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">

                <div class="border bg-light p-3 rounded mb-3">

                    <h5 class="mb-3" style="font-size: 18px;">CHECK AVAILABILITY</h5>

                    <label class="form-label">Search</label>
                    <input type="text" class="form-control shadow-none mb-3" name="search_name" placeholder="ชื่อโรงแรมที่คุณต้องการค้นหา" />
                    
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control shadow-none mb-3" placeholder="ชื่อจังหวัด" name="location" value="<?php echo isset($_SESSION["location"]) ? htmlspecialchars($_SESSION["location"]) : ''; ?>"  />

                    <label class="form-label">Check-in</label>
                    <input type="date" class="form-control shadow-none mb-3" name="checkin" min="<?php echo date('Y-m-d') ?>" value="<?php echo $_SESSION["checkin"]; ?>">

                    <label class="form-label">Check-out</label>
                    <input type="date" class="form-control shadow-none" name="checkout" min="<?php echo date('Y-m-d') ?>" value="<?php echo $_SESSION["checkout"]; ?>">
                    
                    <label class="form-label">Guests</label>
                    <input type="number" class="form-control shadow-none" name="num_guest" value="<?php echo $_SESSION["num_guest"]; ?>" required>


                    <div class="form__group" style="text-align: center;">
                        <button type="submit" name="submit" class="btn btn-primary shadow-none me-lg-3 me-2 mt-3">Search</button>
                    </div>
            
                </div>

                <div class="border bg-light p-3 rounded mb-3">
                    <h5 class="mb-3" style="font-size: 18px;">Property Class</h5>
                    <div class="mb-2">
                        <input type="radio" id="f1" class="form-check-input shadow-none me-1" value="1" name="rating">
                        <label class="form-check-label" for="f1">1 ★</label>
                    </div>
                    <div class="mb-2">
                        <input type="radio" id="f2" class="form-check-input shadow-none me-1" value="2" name="rating">
                        <label class="form-check-label" for="f2">2 ★★</label>
                    </div>
                    <div class="mb-2">
                        <input type="radio" id="f3" class="form-check-input shadow-none me-1" value="3" name="rating">
                        <label class="form-check-label" for="f3">3 ★★★</label>
                    </div>
                    <div class="mb-2">
                        <input type="radio" id="f4" class="form-check-input shadow-none me-1" value="4" name="rating">
                        <label class="form-check-label" for="f4">4 ★★★★</label>
                    </div>
                    <div class="mb-2">
                        <input type="radio" id="f5" class="form-check-input shadow-none me-1" value="5" name="rating">
                        <label class="form-check-label" for="f5">5 ★★★★★</label>
                    </div>
                </div>
                
                <div class="border bg-light p-3 rounded mb-3">
                    <h5 class="mb-3" style="font-size: 18px;">Price</h5>
                    <div class="d-flex">
                        <div class="me-2">
                            <label class="form-label">Min</label>
                            <input type="text" class="form-control shadow-none" name="min" value="<?php echo $_SESSION["min"] ?>">
                        </div>
                        <div>
                            <label class="form-label">Max</label>
                            <input type="text" class="form-control shadow-none" name="max" value="<?php echo $_SESSION["max"] ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</nav>