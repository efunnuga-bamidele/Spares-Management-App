<?php  
//starting the session
if ( !isset($_SESSION) ) session_start();
require_once 'connection.php';


$locationName = "";
$task = 'Task';
$_SESSION['errorMessage'] = "";
$_SESSION['successMessage'] = "";
$_SESSION['inventoryClass']= "";

if(ISSET($_POST['createLocation'])){
$locationName = strtoupper(($_POST['location']));

   $result = $store_db->exec("INSERT INTO location ('locationBox') VALUES ('$locationName')");

   if(!$result ){
      $_SESSION["errorMessage"] = "Location Creation Failed! Try Again.";
         header('location:../inventory.php');

   }else{
      $_SESSION["successMessage"] = "Location Created Successfully";
      $_SESSION['inventoryClass']= "tab two";
         header('location:../inventory.php');
   }
   
}else if(ISSET($_GET['editLocation'])){
   // transfers table value to input fields
         $task = "Editing";
         $editId = '';
         $editId = $_GET['editLocation'];
         $edit  = $store_db->query("SELECT * FROM location WHERE id = '$editId'");
         $value = $edit->fetch();

         $_SESSION['id'] = $value['id'];
         $_SESSION['locationBox'] = $value['locationBox'];
         $_SESSION['inventoryClass']= "tab two";
         header('location:../inventory.php');

}
else if(ISSET($_POST['clearLocation']) || isset($_GET['clearLocation'])){
   // clear input fields
   $task = "Clearing";
   clearField();

}else if(ISSET($_POST['updateLocation']) && !empty($_SESSION['id']) ){
   // update table with input fields values.
         $task = "Update";
         $taskId = $_SESSION['id'];
         $location = strtoupper($_POST['location']);   
   
         $query= "UPDATE location SET locationBox=:locationBox WHERE id =:taskId";

         $updateCheck=$store_db->prepare($query);
         $updateCheck->bindParam(':locationBox',$location,PDO::PARAM_STR);
         $updateCheck->bindParam(':taskId',$taskId,PDO::PARAM_STR);

         if($updateCheck->execute()){
            // var_dump(("success"));
            $_SESSION["successMessage"] = "Location ".$task." Successful";
               $_SESSION['inventoryClass']= "tab two";
               clearField();
               header('location:../inventory.php');
         }
         else{
           $_SESSION["errorMessage"] = "Location".$task." Failed! Try Again.";
               header('location:../inventory.php');
               var_dump(("failed :" .$_POST['id']));
         }

         $store_db = null;
   
}else if(ISSET($_GET['deleteLocation']) && !empty($_SESSION['id'])){
   $task = "Delete";
   $taskId = "";
   $taskId = $_SESSION['id'];

   $query= "DELETE FROM location WHERE id ='$taskId'";
   $resetQuery = " UPDATE SQLITE_SEQUENCE SET SEQ=0 WHERE NAME='location'";
   $deleteCheck=$store_db->prepare($query);
   $resetRow=$store_db->prepare($resetQuery);

   // $deleteCheck->bindParam(':taskId',$taskId,PDO::PARAM_STR);

   if($deleteCheck->execute()){
      $resetRow->execute();
      $_SESSION["successMessage"] = "Location ".$task." Successful";
         $_SESSION['inventoryClass']= "tab two";
         clearField();
         header('location:../inventory.php');
   }
   else{
     $_SESSION["errorMessage"] = "Location".$task." Failed! Try Again.";
         header('location:../inventory.php');
   }

   $store_db = null;

}else{
   // var_dump("error");
   $_SESSION['inventoryClass']= "tab two";
   $_SESSION["errorMessage"] = "Location ".$task." Failed! Try Again.";
   header('location:../inventory.php');

}

function clearField(){

   unset($_SESSION['id']);
   unset($_SESSION['locationBox']);
     $_SESSION['inventoryClass']= "tab two";
   header('location:../inventory.php');

}
?>