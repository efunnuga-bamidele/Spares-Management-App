<?php 
 if ( !isset($_SESSION) ) session_start();
 require_once './navigation/header.php'; 
 require_once './navigation/stripes.php'; 

?>


<style>
    body{
        background-color: #f5f5f5;
    }
    .container {
  max-width: 960px;
}

.lh-condensed { line-height: 1.25; }

input {
  height: 7.125rem;
  padding: 5.75rem;
}

</style>
</head>
<body>
<?php // require_once './navigation/nav.php'; ?>

<div class="container" style="margin-top:50px;">
  <div class="py-5 text-center">
  <img class="mb-4" src="./assets/images/Bosch-logo.png" alt="" width="15%" height="15%">
              <h1 class="h3 mb-3 font-weight-normal">User Registration</h1>
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
  <div class="row">

    <div class="col-md-12 order-md-1">
      <h4 class="mb-3">New User Form</h4>
      <form class="needs-validation" method="POST" action="./tools/create_user.php" novalidate >
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="firstName">First name</label>
            <input type="text" class="form-control" name="firstName" placeholder="" required value="<?php if(ISSET($_SESSION['firstName'])) echo $_SESSION['firstName'] ;?>">
            <div class="invalid-feedback">
              Valid first name is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="lastName">Last name</label>
            
            <input type="text" class="form-control" name="lastName" placeholder="" value="<?php if(ISSET($_SESSION['lastName'])) echo $_SESSION['lastName'] ;?>" required>

            <div class="invalid-feedback">
              Valid last name is required.
            </div>
          </div>
        </div>
        <div class="row">

        <div class="col-md-6 mb-3">
              <label for="username">Email</label>
                <div class="input-group">
                     <input type="email" class="form-control" name="email" placeholder="Please enter a valid email address" required value="<?php if(ISSET($_SESSION['email'])) echo $_SESSION['email'] ;?>">
                    <div class="invalid-feedback" style="width: 100%;">
                    Please enter a valid email address
                </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="country">Country</label>
            <input type="text" class="form-control" name="country" placeholder="" value="<?php if(ISSET($_SESSION['lastName'])) echo $_SESSION['lastName'] ;?>" required>
            <div class="invalid-feedback">
              Please select a valid country.
            </div>
          </div>
          
        
        </div>


        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="" value="<?php if(ISSET($_SESSION['password'])) echo $_SESSION['password'] ;?>" required>
            <div class="invalid-feedback">
            Please check that you've entered and confirmed your password!
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="password">Retype Password</label>
            <input type="password" class="form-control" name="retypePassword" placeholder="" value="<?php if(ISSET($_SESSION['retypePassword'])) echo $_SESSION['retypePassword'] ;?>" required>
            <div class="invalid-feedback" name="retype">
            Please check that you've entered and confirmed your password!
            </div>
          </div>
        </div>
        
       
        <hr class="mb-4">
        <div class="row">
          <div class="col-md-6 mb-3">
          <button class="btn btn-primary btn-lg btn-block" type="submit" name="signup">Register User</button>
          </div>
          <div class="col-md-6 mb-3">
          <a class="btn btn-danger btn-lg btn-block" type="submit" href="./tools/create_user.php" name="cancel">Cancel Registration</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  </form>
  <hr>
  <p class="mt-5 mb-3 text-muted text-center">&copy; Robert Bosch GmbH <?php echo date("Y"); ?>, all rights reserved</p>
         
    </div>
</div>
        <script src="./assets/js/jquery-3.6.0.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src=" ./assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="./assets/js/dataTables.bootstrap4.min.js"></script>
          <script src="./assets/js/app.js"></script>
</body>
</html>