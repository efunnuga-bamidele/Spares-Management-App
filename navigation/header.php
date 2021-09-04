<?php  if ( !isset($_SESSION) ) session_start();

$user_db = new PDO('sqlite:./schema/users.db');
  // Set errormode to exceptions
  $user_db->setAttribute(PDO::ATTR_ERRMODE, 
                          PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>INVENTORY APP</title>
        <!-- CSS STYLES Tags -->
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="<?php if(empty($_SESSION['theme'])){ echo "./assets/css/bootstrap.min.css" ;} else{ 
        $theme = $_SESSION['theme'];
        $getTheme = $user_db->query("SELECT * FROM theme WHERE themeName = '$theme'");
        $feedBack = $getTheme->fetch();
        if ($feedBack > 0) {
            echo $feedBack["themeLink"];
            // echo "./assets/css/bootstrap.min.css" ;
        }else{
            echo "./assets/css/bootstrap.min.css" ;
        }
         }?>">
    <link rel="stylesheet" href="./assets/css/responsive.bootstrap4.min.css" />
     <link rel="stylesheet" href="./assets/DataTables/datatables.css">
     <link rel="stylesheet" href="./assets/css/bootstrap-side-modals.css">
     <!-- <link rel="stylesheet" href="./assets/css/drawer.css"> -->
     <script src="./assets/js/jquery-3.6.0.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./assets/DataTables/datatables.js"></script>
    <script src="./assets/js/app.js"></script>
    <script src="./assets/js/app.js"></script>
    

    
    <style>
        /* body{
            font-size: x-small !important;
        }`
        input{
            font-size: x-small !important; 
        }
        button{
            font-size: x-small !important;
        }
        a{
            font-size: x-small !important;
        }
        span{
            font-size: x-small !important;
        } */
    </style>
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/4.6/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="./assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="./assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="./assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="./assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
    <link rel="icon" href="./assets/images/favicon-png.png">
    <meta name="msapplication-config" content="./assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">

    
    <?php  require_once './navigation/nav.php'; ?>



    