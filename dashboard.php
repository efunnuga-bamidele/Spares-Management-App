<?php 
 if ( !isset($_SESSION) ) session_start();

if(empty($_SESSION['activeUser'])) : header("location:./login.php");  else :
    require_once './navigation/header.php'; 
    require_once './navigation/stripes.php'; 
$store_db = new PDO('sqlite:./schema/store.db');
$users_db = new PDO('sqlite:./schema/users.db');


?>


<link href="./assets/css/dashboardStyle.css" rel="stylesheet">
<link href="./assets/css/font-awesome.min.css" rel="stylesheet">
<style type="text/css">
.notification{background:#f5f5f5}
.text-white-50 { color: rgba(255, 255, 255, .5); }
.bg-blue { background-color:#00b5ec; }
.border-bottom { border-bottom: 1px solid #e5e5e5; }
.box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
    </style>
</head>

<body>
    <?php // require_once './navigation/nav.php'; ?>


<div class="container-fluid">
  <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-blue">
                <div class="inner">
              
                 
                    <?php $pOrderCount = 0; $processed = $store_db->query("SELECT * FROM orders"); foreach($processed as $process) : $pOrderCount +=1; ?>
                <?php endforeach; ?>
                <h2> <?php echo $pOrderCount?>  </h2>
                    <p> Orders Precessed </p>
                </div>
                <div class="icon">
                    <i class="fa fa-cart-plus" aria-hidden="true"></i>
                </div>
                <a href="./request.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-green">
                <div class="inner">
                <?php $pOrderCount = 0; $processed = $store_db->query("SELECT * FROM orders WHERE orderCompleted = 'Completed'"); foreach($processed as $process) : $pOrderCount +=1; ?>
                <?php endforeach; ?>
                <h2> <?php echo $pOrderCount?>  </h2>
                    <p> Orders Completed </p>
                </div>
                <div class="icon">
                    <i class="fa fa-money" aria-hidden="true"></i>
                </div>
                <a href="./request.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-orange">
                <div class="inner">
                <?php $pOrderCount = 0; $processed = $store_db->query("SELECT * FROM orders WHERE orderCompleted = 'Pending'"); foreach($processed as $process) : $pOrderCount +=1; ?>
                <?php endforeach; ?>
                <h2> <?php echo $pOrderCount?>  </h2>
                    <p> Pending Orders </p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                </div>
                <a href="./request.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-red">
                <div class="inner">
                <?php $userCount = 0; $users = $users_db->query("SELECT * FROM userprofile"); foreach($users as $user) : $userCount +=1; ?>
                <?php endforeach; ?>
                    <h2> <?php echo $userCount?> </h2>
           
                    <p> Users Registered </p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <!-- <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
    </div>

    <!-- section two -->


    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h3 class="m-b-20">Spares </h3>
                    <?php $spareCount = 0; $spares = $store_db->query("SELECT * FROM spares"); foreach($spares as $spare) : $spareCount +=1; ?>
                    <?php endforeach; ?>
                    <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span><?php echo $spareCount; ?></span></h2>
                    <p class="m-b-0">Profile Created<span class="f-right"></span></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                <h3 class="m-b-20">Storage </h3>
                    <?php $locationCount = 0; $locations = $store_db->query("SELECT * FROM location"); foreach($locations as $location) : $locationCount +=1; ?>
                    <?php endforeach; ?>
                    <h2 class="text-right"><i class="fa fa-map-marker f-left"></i><span><?php echo $locationCount; ?></span></h2>
                    <p class="m-b-0">Location Available<span class="f-right"></span></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                <h3 class="m-b-20">Category </h3>
                    <?php $categotyCount = 0; $categories = $store_db->query("SELECT * FROM category"); foreach($categories as $categoy) : $categotyCount +=1; ?>
                    <?php endforeach; ?>
                    <h2 class="text-right"><i class="fa fa-th-large f-left"></i><span><?php echo $categotyCount; ?></span></h2>
                    <p class="m-b-0">Of Spares Created<span class="f-right"></span></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                <h3 class="m-b-20">Spares </h3>
                    <?php $spareCount = 0; $spares = $store_db->query("SELECT * FROM spares"); foreach($spares as $spare) : if($spare['remainingStock'] == 0) : $spareCount +=1; ?>
                    <?php endif; endforeach; ?>
                    <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span><?php echo $spareCount; ?></span></h2>
                    <p class="m-b-0">Out of Stock<span class="f-right"></span></p>
                </div>
            </div>
        </div>
	</div>
     <!-- section Three -->
<!-- ========================================================================== -->
     <div class="row">
        <div class="col-md-4 col-xl-3">
        <main role="main" class="container notification">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h6 class="border-bottom border-gray pb-2 mb-0 text-primary text-sm-center">Out Of Stock Spares</h6>

                <?php $Count = 0;  $emptyStock = $store_db->query("SELECT * FROM spares WHERE remainingStock = 0"); foreach($emptyStock as $stock): $data=""; $Count +=1;?>
                
                <div class="media text-muted pt-3">
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <?php  echo '<strong class="text-gray-dark">'.$Count." : ".'</strong>'. $stock["spareName"]; ?>
                </p>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
        </div>
  <!-- ========================================================================== -->      
  <div class="col-md-4 col-xl-3">
        <main role="main" class="container notification">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h6 class="border-bottom border-gray pb-2 mb-0 text-success text-sm-center">Top 6 Sold Spares</h6>

                <?php $Count = 0;  $emptyStock = $store_db->query("SELECT * FROM spares ORDER BY quantitySold DESC LIMIT 6"); foreach($emptyStock as $stock): $data=""; $Count +=1;?>
                
                <div class="media text-muted pt-3">
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <?php  echo '<strong class="text-gray-dark">'.$Count." : ".'</strong>'. $stock["spareName"].'<strong class="text-gray-dark">'." : Qty = ".$stock["quantitySold"].'</strong>'; ?>
                </p>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
        </div>
  <!-- ========================================================================== -->      
  <div class="col-md-4 col-xl-3">
        <main role="main" class="container notification">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h6 class="border-bottom border-gray pb-2 mb-0 text-warning text-sm-center">Top 6 Restocked Spares</h6>

                <?php $Count = 0;  $emptyStock = $store_db->query("SELECT spareName, newQuantity FROM restockig ORDER BY newQuantity DESC LIMIT 6"); foreach($emptyStock as $stock): $data=""; $Count +=1;?>
                
                <div class="media text-muted pt-3">
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <?php  echo '<strong class="text-gray-dark">'.$Count." : ".'</strong>'. $stock["spareName"].'<strong class="text-gray-dark">'." : Qty = ".$stock["newQuantity"].'</strong>'; ?>
                </p>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
        </div>
  <!-- ========================================================================== -->      
  <div class="col-md-4 col-xl-3">
  <main role="main" class="container notification">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h6 class="border-bottom border-gray pb-2 mb-0 text-danger text-sm-center">Top 6 Spares With Locked Units</h6>

                <?php $Count = 0;  $emptyStock = $store_db->query("SELECT * FROM spares WHERE lockedUnit >= 1 ORDER BY lockedUnit DESC LIMIT 6"); foreach($emptyStock as $stock): $Count +=1;?>
                
                <div class="media text-muted pt-3">
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <?php  echo '<strong class="text-gray-dark">'.$Count." : ".'</strong>'. $stock["spareName"].'<strong class="text-gray-dark">'." : Qty = ".$stock["lockedUnit"].'</strong>'; ?>
                </p>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
        </div>
  <!-- ========================================================================== -->      
  </div>
      
  <!-- THird -->
    <!-- </div> -->
    <!-- Footer section -->
    <div class="container footer">
        <?php require_once './navigation/footer.php' ?>
    </div>

    </div>

</body>

</html>

<?php endif; ?>