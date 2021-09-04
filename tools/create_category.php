<?php  
//starting the session
if ( !isset($_SESSION) ) session_start();
require_once 'connection.php';


$categoryName = "";

$task = 'Task';
$_SESSION['errorMessage'] = "";
$_SESSION['successMessage'] = "";
$_SESSION['inventoryClass']= "";


if(ISSET($_POST['createCategory'])){
$categoryName = strtoupper($_POST['category']);

   $result = $store_db->exec("INSERT INTO category ('category') VALUES ('$categoryName')");

   if(!$result ){
      $_SESSION["errorMessage"] = "Category Creation Failed! Try Again.";
         header('location:../inventory.php');

   }else{
      $_SESSION["successMessage"] = "Category Created Successfully";
      $_SESSION['inventoryClass']= "tab three";
         header('location:../inventory.php');

   }
   
}else if(ISSET($_GET['editCategory'])){
   // transfers table value to input fields
         $task = "Editing";
         $editId = '';
         $editId = $_GET['editCategory'];
         $edit  = $store_db->query("SELECT * FROM category WHERE id = '$editId'");
         $value = $edit->fetch();

         $_SESSION['id'] = $value['id'];
         $_SESSION['category'] = $value['category'];
         $_SESSION['inventoryClass']= "tab three";
         header('location:../inventory.php');



}else if(ISSET($_POST['clearCategory']) || isset($_GET['clearCategory'])){
   // clear input fields
   $task = "Clearing";
   clearField();

}else if(ISSET($_POST['updateCategory']) && !empty($_SESSION['id']) ){
   // update table with input fields values.
         $task = "Update";
         $taskId = $_SESSION['id'];
         $category = strtoupper($_POST['category']);   
   
         $query= "UPDATE category SET category=:category WHERE id =:taskId";

         $updateCheck=$store_db->prepare($query);
         $updateCheck->bindParam(':category',$category,PDO::PARAM_STR);
         $updateCheck->bindParam(':taskId',$taskId,PDO::PARAM_STR);

         if($updateCheck->execute()){
            // var_dump(("success"));
            $_SESSION["successMessage"] = "Category ".$task." Successful";
               $_SESSION['inventoryClass']= "tab three";
               clearField();
               header('location:../inventory.php');
         }
         else{
           $_SESSION["errorMessage"] = "Category".$task." Failed! Try Again.";
               header('location:../inventory.php');
               var_dump(("failed :" .$_POST['id']));
         }

         $store_db = null;
   
}else if(ISSET($_GET['deleteCategory']) && !empty($_SESSION['id'])){
   $task = "Delete";
   $taskId = "";
   $taskId = $_SESSION['id'];

   $query= "DELETE FROM category WHERE id ='$taskId'";
   $resetQuery = " UPDATE SQLITE_SEQUENCE SET SEQ=0 WHERE NAME='category'";
   $deleteCheck=$store_db->prepare($query);
   $resetRow=$store_db->prepare($resetQuery);

   // $deleteCheck->bindParam(':taskId',$taskId,PDO::PARAM_STR);

   if($deleteCheck->execute()){
      $resetRow->execute();
      $_SESSION["successMessage"] = "Category ".$task." Successful";
         $_SESSION['inventoryClass']= "tab three";
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
   $_SESSION['inventoryClass']= "tab three";
   $_SESSION["errorMessage"] = "Category ".$task." Failed! Try Again.";
   header('location:../inventory.php');

}

function clearField(){

   unset($_SESSION['id']);
   unset($_SESSION['category']);
     $_SESSION['inventoryClass']= "tab three";
   header('location:../inventory.php');

}
?>