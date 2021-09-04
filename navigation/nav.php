       <?php 
        if ( !isset($_SESSION) ) session_start();
        ?>
       
       <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm fixed-top" >
        <!-- <h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5> -->
            <img class="my-0 mr-md-auto logo" src="./assets/images/Bosch-logo.png" alt="" width="10%" height="10%">
            <?php if(isset($_SESSION['activeUser'])) : ?>
               
            <nav class="my-2 my-md-0 mr-md-4 text-center">
                <span class="p-2 text-success"> <strong><?php echo "Welcome ". $_SESSION['activeUser']; ?> </strong></span>
                <a class="p-2 text-dark" href="./index.php">Home</a>
                <a class="p-2 text-dark" href="./dashboard.php">Dashboard</a>
                <a class="p-2 text-dark" href="./inventory.php">Inventory</a>
                <a class="p-2 text-dark" href="./request.php">Request</a>
                <a class="p-2 text-dark" href="./history.php">History</a>
                <a class="p-2 text-dark" href="./preference.php">Preference</a>
            </nav>
            <div class="col-xm-4">
                <a class="btn btn-outline-danger" href="./tools/sign_out.php">Sign Out</a>
            </div>
    

            <?php  else : ?>
                <nav class="my-2 my-md-0 mr-md-4 text-center">
                <a class="p-2 text-dark" href="./index.php">Home</a>
                </nav>
                <div class="col-xm-4">
                
                <a href="./login.php" class="btn btn-outline-success">Login</a>
                <a class="btn btn-outline-primary" href="./sign_up.php">Sign up</a>
                </div>
            <?php endif; ?>
        </div>
