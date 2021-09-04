<?php 
 if ( !isset($_SESSION) ) session_start();
 require_once './navigation/header.php'; 
 require_once './navigation/stripes.php'; 

  // Create (connect to) SQLite database in file
  $setting_db = new PDO('sqlite:./schema/settings.db');
  // Set errormode to exceptions
  $setting_db->setAttribute(PDO::ATTR_ERRMODE, 
                          PDO::ERRMODE_EXCEPTION);
 

?>
<link rel="stylesheet" href="./assets/css/indexStyle.css">
</head>

<body>
      <div class="jumbotron " style="margin-top: 70px;">
        <div class="container text-center px-3 py-3 pt-md-5 pb-md-4 mx-auto">
            <?php  $getContent = $setting_db->query("SELECT * FROM content WHERE id=1");
            $feedBack = $getContent->fetch();
            if($feedBack > 0) : ?>
            <h1 class="display-4"><?php echo $feedBack["heading"]; ?></h1>
            <p><?php echo $feedBack["content"]; ?></p>
            <?php endif; ?>
            <p><a class="btn btn-primary btn-lg" href="./dashboard.php" role="button">Get Started &raquo;</a></p>
        </div>
    </div>

    <div class="container h-100">

        <div class="row align-middle">
            <div class="card-deck">
                <div class="col-md-6 col-lg-4 column">
                    <div class="card gr-1">
                        <img src="./assets/images/CSB.png" class="bd-placeholder-img card-img-top" width="100%"
                            height="200" alt="...">
                            <?php  $getContent = $setting_db->query("SELECT * FROM content WHERE id=2");
                            $feedBack = $getContent->fetch();
                            if($feedBack > 0) : ?>
                        <div class="txt">
                            <h1><?php echo $feedBack["heading"]; ?></h1>
                            <p><?php echo $feedBack["content"]; ?></p>
                        </div>
                        <?php endif; ?>
                        <a href="#">more</a>
                        <div class="ico-card">
                            <i class="fa fa-rebel"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 column">
                    <div class="card gr-2">
                        <img src="./assets/images/wsm3.png" class="bd-placeholder-img card-img-top" width="100%"
                            height="200" alt="...">
                            <?php  $getContent = $setting_db->query("SELECT * FROM content WHERE id=3");
                            $feedBack = $getContent->fetch();
                            if($feedBack > 0) : ?>
                        <div class="txt">
                            <h1><?php echo $feedBack["heading"]; ?></h1>
                            <p><?php echo $feedBack["content"]; ?></p>
                        </div>
                        <?php endif; ?>
                        <a href="#">more</a>
                        <div class="ico-card">
                            <i class="fa fa-codepen"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 column">
                    <div class="card gr-3">
                        <img src="./assets/images/uls.png" class="bd-placeholder-img card-img-top" width="100%"
                            height="200" alt="...">
                            <?php  $getContent = $setting_db->query("SELECT * FROM content WHERE id=4");
                            $feedBack = $getContent->fetch();
                            if($feedBack > 0) : ?>
                        <div class="txt">
                            <h1><?php echo $feedBack["heading"]; ?></h1>
                            <p><?php echo $feedBack["content"]; ?></p>
                        </div>
                        <?php endif; ?>
                        <a href="#">more</a>
                        <div class="ico-card">
                            <i class="fa fa-empire"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Footer section -->
        <?php require_once './navigation/footer.php' ?>

    </div>

</body>

</html>

