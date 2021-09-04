<?php
 if ( !isset($_SESSION) ) session_start();
  require_once './navigation/header.php'; 
  require_once './navigation/stripes.php';

?>


     <!-- Custom styles for this template -->
     <link href="./assets/css/floating-labels.css" rel="stylesheet">

    <meta name="msapplication-config" content="/docs/4.6/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">
       
</head>
    <body>

     <?php //require_once './navigation/nav.php'; ?>


        <div class="container text-center">
        <form class="form-signin" method="POST" action="./tools/check_user.php">
            <div class="text-center mb-4">
              <img class="mb-4" src="./assets/images/Bosch-logo.png" alt="" width="30%" height="30%">
              <h1 class="h3 mb-3 font-weight-normal">User Log-In</h1>
            </div>

                <?php
                  if(!empty($_SESSION['errorMessage']) && empty($_SESSION['successMessage'])){
                    echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
                      unset($_SESSION['errorMessage']);
                    }else if(!empty($_SESSION['successMessage']) && empty($_SESSION['errorMessage'])){
                      echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';
                      unset($_SESSION['successMessage']);
                  }
                ?>
            
            <div class="form-label-group">
              <input type="email" name="email" id="inputEmail" class="form-control text-left" placeholder="Email address"  autofocus>
              <label for="inputEmail" class="text-left">Email address</label>
            </div>
          

            <div class="form-label-group">
              <input type="password" name="inputPassword" id="inputPassword" class="form-control text-left" placeholder="Password" >
              <label for="inputPassword" class="text-left">Password</label>
            </div>
          
            <!-- <div class="checkbox mb-3">
              <label>
                <input type="checkbox" value="remember-me"> Remember me
              </label>
            </div> -->
            <button class="btn btn-lg btn-primary btn-block" name="signin" type="submit">Sign in</button>
            <hr>
            <p class="mt-5 mb-3 text-muted text-center">&copy; Robert Bosch GmbH <?php echo date("Y"); ?>, all rights reserved</p>
           

          </form>
        
          </div>
          <script src="./assets/js/jquery-3.6.0.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src=" ./assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="./assets/js/dataTables.bootstrap4.min.js"></script>
          <script src="./assets/js/app.js"></script>
</body>
</html>