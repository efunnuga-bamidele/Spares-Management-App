<?php  
//starting the session
// session_start();
require_once 'connection.php';

$password = "";
$hashed_password = "";
$email = "";
$_SESSION['errorMessage'] = "";
$_SESSION['successMessage'] = "";


if(ISSET($_POST['signin'])){
   // Setting variables
   $email = $_POST['email'];
   $password = $_POST['password'];
   $md5_password = md5($password);


   $result = $user_db->query("SELECT * FROM userprofile WHERE email = '$email' AND password = '$md5_password'");
   $row = $result->fetch();
   if($row > 0 ){
         $_SESSION["activeUser"]  =  $row['firstName'] ;
         header('location:../dashboard.php');

   }else{
      $_SESSION["errorMessage"] = "Invalid Credentials";
      header('location:../login.php?error="Invalid%20Credentials"');
   }
  
}
// bamidele.efunnuga@bosch.com
?>