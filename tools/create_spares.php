<?php  
//starting the session
if ( !isset($_SESSION) ) session_start();
require_once 'connection.php';


$spareName = "";
$spareCategory = "";
$Description = "";
$spareCode = "";
$corespondingNumber = "";
$currentQuantity = "";
$quantitySold = "";
$location = "";
$quantityRemaining = "";
$task = 'Task';
$_SESSION['errorMessage'] = "";
$_SESSION['successMessage'] = "";
$_SESSION['inventoryClass']= "";

// Spare Sessions
// unset($_SESSION['spareName']);
// unset($_SESSION['spareCategory']);
// unset($_SESSION['spareCategory']);

if(ISSET($_POST['createSpares'])){
   $task = "Creation";
   $spareName = strtoupper(($_POST['spareName']));
   $cleck_spare = $store_db->query("SELECT * FROM spares WHERE spareName = '$spareName'");
   $row = $cleck_spare->fetch();
   if($row > 0 ){
      $_SESSION["errorMessage"] = "Spare Part already existing! Try a different name.";
      $_SESSION['inventoryClass']= "tab one";
         header('location:../inventory.php');
   }else{
      
         $spareCategory = strtoupper($_POST['spareCategory']);
         $Description = strtolower(($_POST['description']));
         $spareCode = ($_POST['spareCode']);
         $location = ($_POST['location']);
         $corespondingNumber = ($_POST['corespondingNumber']);
         if(empty($_POST['currentQuantity'])){
         $currentQuantity = 0;
         }else{
            $currentQuantity = ($_POST['currentQuantity']);
         }
         if(empty($_POST['quantitySold'])){
         $quantitySold = 0;
         }else{
            $quantitySold = ($_POST['quantitySold']);
         }
         $quantityRemaining = $currentQuantity - $quantitySold;


         $result = $store_db->exec("INSERT INTO spares ('spareName','description','spareCode','correspondingCode','category','location','quantityInStock','quantitySold', remainingStock) VALUES ('$spareName','$Description','$spareCode','$corespondingNumber','$spareCategory','$location','$currentQuantity','$quantitySold','$quantityRemaining')");

         if(!$result ){
            $_SESSION["errorMessage"] = "Spare Part ".$task." Failed! Try Again.";
               header('location:../inventory.php');

         }else{
            $_SESSION["successMessage"] = "Spare Part Created Successful";
            $_SESSION['inventoryClass']= "tab one";
               header('location:../inventory.php');
         }
   
   }


}else if(isset($_GET['editSpares'])){
   // transfers table value to input fields
         $task = "Editing";
         $editId = '';
         $editId = $_GET['editSpares'];
         $edit  = $store_db->query("SELECT * FROM spares WHERE id = '$editId'");
         $value = $edit->fetch();
         // var_dump($value['spareName']);
         //Return values in session
         $_SESSION['id'] = $value['id'];
         $_SESSION['spareName'] = $value['spareName'];
         $_SESSION['spareCategory'] = $value['category'];
         $_SESSION['description'] = $value['description'];
         $_SESSION['spareCode'] = $value['spareCode'];
         $_SESSION['corespondingNumber'] = $value['correspondingCode'];
         $_SESSION['currentQuantity'] = $value['quantityInStock'];
         $_SESSION['quantitySold'] = $value['quantitySold'];
         $_SESSION['locationBox'] = $value['location'];
         $_SESSION['dateCreated'] = $value['create_date'];
         $_SESSION['inventoryClass']= "tab one";
         header('location:../inventory.php');

}
else if(isset($_POST['clearSpares']) || isset($_GET['clearSpares'])){
   // clear input fields
   $task = "Clearing";
   clearField();

}else if(ISSET($_POST['updateSpares']) && !empty($_POST['spareId'])){
   // update table with input fields values.
         $task = "Update";
         $taskId = $_POST['spareId'];
         $spareName = ($_POST['spareName']);
         $category = strtoupper($_POST['spareCategory']);
         $Description = strtolower(($_POST['description']));
         $spareCode = ($_POST['spareCode']);
         $corespondingNumber = ($_POST['corespondingNumber']);
         $currentQuantity = ($_POST['currentQuantity']);
         $quantitySold = ($_POST['quantitySold']);
         $quantityRemaining = $currentQuantity - $quantitySold;
         $location = ($_POST['location']);   
   
         $query= "UPDATE spares SET spareName=:spareName,description =:Description,spareCode=:spareCode,correspondingCode=:corespondingNumber,category=:category,location=:location,quantityInStock=:currentQuantity,quantitySold=:quantitySold,remainingStock=:quantityRemaining WHERE id =:taskId";

         $updateCheck=$store_db->prepare($query);
        
         $updateCheck->bindParam(':spareName',$spareName,PDO::PARAM_STR);
         $updateCheck->bindParam(':Description',$Description,PDO::PARAM_STR);
         $updateCheck->bindParam(':spareCode',$spareCode,PDO::PARAM_STR);
         $updateCheck->bindParam(':corespondingNumber',$corespondingNumber,PDO::PARAM_STR);
         $updateCheck->bindParam(':category',$category,PDO::PARAM_STR);
         $updateCheck->bindParam(':location',$location,PDO::PARAM_STR);
         $updateCheck->bindParam(':currentQuantity',$currentQuantity,PDO::PARAM_STR);
         $updateCheck->bindParam(':quantitySold',$quantitySold,PDO::PARAM_STR);
         $updateCheck->bindParam(':quantityRemaining',$quantityRemaining,PDO::PARAM_STR);
         $updateCheck->bindParam(':taskId',$taskId,PDO::PARAM_STR);

         if($updateCheck->execute()){
            $_SESSION["successMessage"] = "Spare Part ".$task." Successful";
               $_SESSION['inventoryClass']= "tab one";
               clearField();
               header('location:../inventory.php');
         }
         else{
           $_SESSION["errorMessage"] = "Spare Part ".$task." Failed! Try Again.";
               header('location:../inventory.php');
         }

         $store_db = null;
   
}else if(ISSET($_GET['deleteSpares']) && !empty($_SESSION['id'])){
   $task = "Delete";
   $taskId = "";
   $taskId = $_SESSION['id'];

   $query= "DELETE FROM spares WHERE id ='$taskId'";
   $resetQuery = " UPDATE SQLITE_SEQUENCE SET SEQ=0 WHERE NAME='spares'";
   $deleteCheck=$store_db->prepare($query);
   $resetRow=$store_db->prepare($resetQuery);

   // $deleteCheck->bindParam(':taskId',$taskId,PDO::PARAM_STR);

   if($deleteCheck->execute()){
      $resetRow->execute();
      $_SESSION["successMessage"] = "Spare Part ".$task." Successful";
         $_SESSION['inventoryClass']= "tab one";
         clearField();
         header('location:../inventory.php');
   }
   else{
     $_SESSION["errorMessage"] = "Spare Part ".$task." Failed! Try Again.";
         header('location:../inventory.php');
   }

   $store_db = null;

}else if(isset($_POST['clearRestock']) || isset($_GET['clearRestock'])){
   clearField();
   $_SESSION['requestClass']= "tab three";
   header('location:../request.php');

}else if(isset($_POST['restockSpares']) || isset($_GET['restockSpares'])){
   // clearField();
   $spareId = $_POST['restockSpares'];

   $checkSpare = $store_db->query("SELECT * FROM spares WHERE id = '$spareId'");
   $feedback = $checkSpare->fetch();
   if($feedback > 0){
      echo json_encode($feedback);
   }else{

   }

}else if(isset($_POST['qtyRequest'])){
   // clearField();
   // echo "Restock Successful".$_POST['qtyRequest'];
   $requestQty = $_POST['qtyRequest'];
   $spareId = $_POST['spareId'];
   $overallStock = $_POST['totalStocked'] + $_POST['qtyRequest'];
   $remainingQty = $_POST['remaining'] + $_POST['qtyRequest'];
   $spareName = $_POST['spareName'];
   $initStock = $_POST['remaining'];
   $location = $_POST['location'];
   $userName = $_SESSION["activeUserFull"];
   $currentDate = date('Y-m-d H:i:s');

   $query = "UPDATE spares SET quantityInStock=:overallStock, remainingStock=:remainingQty WHERE id=:spareId";
   $addItems = $store_db->prepare($query);

   $addItems->bindParam(':overallStock',$overallStock,PDO::PARAM_STR);
   $addItems->bindParam(':remainingQty',$remainingQty,PDO::PARAM_STR);
   $addItems->bindParam(':spareId',$spareId,PDO::PARAM_STR);

   if($addItems->execute()){

      $addSpareHistory = $store_db->exec("INSERT INTO restockig (spareName, location, initialStock, newQuantity, currentStock, currentDate, processedBy) VALUES ('$spareName','$location','$initStock','$requestQty','$remainingQty','$currentDate', '$userName')");
    
     echo $_SESSION['requestClass']= "tab three";
     echo $_SESSION["successMessage"] = "Spare Part Restock Successful";
   }else{
      echo $_SESSION['requestClass']= "tab three";
      echo $_SESSION["errorMessage"] = "Spare Part Restock Failed! Try Again.";
   }

}
else{
   $_SESSION['inventoryClass']= "tab one";
   $_SESSION["errorMessage"] = "Spare Part ".$task." Failed! Try Again.";
   header('location:../inventory.php');

}

function clearField(){
   unset($_SESSION['id']);
   unset($_SESSION['spareName']);
   unset($_SESSION['spareCategory']);
   unset($_SESSION['description']);
   unset($_SESSION['spareCode']);
   unset($_SESSION['corespondingNumber']);
   unset($_SESSION['currentQuantity']);
   unset($_SESSION['quantitySold']);
   unset($_SESSION['locationBox']);
   unset($_SESSION['dateCreated']);
     $_SESSION['inventoryClass']= "tab one";
   header('location:../inventory.php');
}
?>