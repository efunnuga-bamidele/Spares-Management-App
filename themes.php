<?php
 if ( !isset($_SESSION) ) session_start();

if(empty($_SESSION['activeUser'])) : header("location:./login.php");  else :
  require_once './navigation/header.php'; 
  require_once './navigation/stripes.php'; 
?>
    
</head>
      <body>
      <?php // require_once './navigation/nav.php'; ?>

    <div class="jumbotron " style="margin-top: 70px;">
        <div class="container text-center px-3 py-3 pt-md-5 pb-md-4 mx-auto">
          <h1 class="display-4">SPARE-PARTS MANAGEMENT SYSTEM</h1>
          <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
          <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
        </div>
      </div>
    <div class="container">
   

    <!-- Footer section -->
     <?php require_once './navigation/footer.php' ?>
      
    </div>
    <!-- Script Tags -->
    <script src="./renderer.js"></script>
    <script src="./assets/js/bootstrap.min.js" async defer></script>
    <script src="./assets/js/jquery-3.6.0.min.js" async defer></script>
    <script src="./assets/js/app.js" async defer></script>
</body>
</html>
<?php endif; ?>