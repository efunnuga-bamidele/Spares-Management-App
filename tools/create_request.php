<?php
 if ( !isset($_SESSION) ) session_start();
require_once 'connection.php';
// $dumps = '';
$dumps = '';
$newdumps = '';
// var characters = [];
if(!empty($_GET['customerName'])){

    // collect GET request

$customerName = strtoupper($_GET['customerName']);
$processNumber = $_GET['processNumber'];
$purchaseOrder = $_GET['purchaseOrder'];
$offerNumber = $_GET['offerNumber'];
$address = $_GET['address'];
$country = strtoupper($_GET['country']);
$state = strtoupper($_GET['state']);
$processesBy = $_GET['processesBy'];
$memo = $_GET['memo'];
$array = json_decode($_GET['cartItemList'], true);

  $dumps = serialize($array);

// Check Offer

$check_request = $store_db->query("SELECT * FROM orders WHERE customerName = '$customerName' AND offerNumber = '$offerNumber' AND poNumber = '$purchaseOrder'");
$row = $check_request->fetch();
if($row > 0 ){
   $_SESSION["errorMessage"] = " Request already existing!";
   echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
    
   unset($_SESSION['errorMessage']);
}else{
    
    // create the process in table
$createRequest = $store_db->exec("INSERT INTO orders ('customerName','processNumber','poNumber','offerNumber','customerLocation','country','state','processedBy', 'memo','sparesList','orderCompleted') VALUES ('$customerName','$processNumber','$purchaseOrder','$offerNumber','$address','$country','$state','$processesBy','$memo','$dumps','Pending')");




if($createRequest ){
    foreach($array as $key=>$value){

        // Select Spare From DB
		$getSpareCount  = $store_db->query("SELECT lockedUnit FROM spares WHERE spareName = '$key'");

		$getSpares = $getSpareCount->fetch();

        $lockedSparesCheck = $getSpares['lockedUnit'] + $value;
		// $spareIdCheck = $update['id'];

        //Loop through array and lock items Update Spare to DB 
        $blockItem = "UPDATE spares SET lockedUnit=:lockedUnitValue WHERE spareName=:spareName";

        $updateCheck = $store_db->prepare($blockItem);
        $updateCheck->bindParam(':lockedUnitValue', $lockedSparesCheck);
        $updateCheck->bindParam(':spareName', $key);
        if($updateCheck->execute()){}
    }
    $store_db = null;

    $_SESSION['requestClass'] = 'tab one';
    $_SESSION["successMessage"] = $_GET['processNumber']." Request Created Successful";
    echo '<div class="alert alert-success">'. $_SESSION['successMessage'].'</div>';

    // echo 'success';
    unset($_SESSION['successMessage']);

 

}else{
    $_SESSION['requestClass'] = 'tab one';
    $_SESSION["errorMessage"] ="Request Creation Failed! Try Again";
    echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
    // echo 'failure';
    unset($_SESSION['errorMessage']);
}


}

}else if(isset($_POST['clearProcess']) || isset($_GET['clearProcess'])){

    $_SESSION['requestClass'] = 'tab one';
    header('location:../request.php');
}
else{
    $_SESSION["errorMessage"] ="Request Creation Failed! Try Again";
    echo '<div class="alert alert-danger">'. $_SESSION['errorMessage'].'</div>';
    unset($_SESSION['errorMessage']);
}



function clearField(){
    unset($_SESSION['id']);
    unset($_SESSION['status']);
    unset($_SESSION['customerName']);
    unset($_SESSION['processNumber']);
    unset($_SESSION['purchaseOrder']);
    unset($_SESSION['offerNumber']);
    unset($_SESSION['sparesList']);
    unset($_SESSION['country']);
    unset($_SESSION['createdDate']);
    unset($_SESSION['processesBy']);
    unset($_SESSION['memo']);
    $_SESSION['requestClass'] = 'tab two';
    header('location:../request.php');
 }

?>

