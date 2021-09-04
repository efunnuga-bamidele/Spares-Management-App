<?php  
//starting the session
if ( !isset($_SESSION) ) session_start();
require_once 'connection.php';

$password = "";
$hashed_password = "";
$email = "";
$_SESSION['errorMessage'] = "";
$_SESSION['successMessage'] = "";


if(ISSET($_POST['signin'])){
   // Setting variables
   $email = rtrim(strtolower($_POST['email'])," ");
   $password = $_POST['inputPassword'];
   $md5_password = md5($password);
   

   $result = $user_db->query("SELECT * FROM userprofile WHERE email = '$email' AND password = '$md5_password'");
   $row = $result->fetch();
   // var_dump($row['firstName'].' '.$row['lastName'] . $md5_password . $email .$password);
   if($row > 0 ){
      $_SESSION["activeUser"]  =  $row['firstName'] ;
      $_SESSION["activeUserFull"] = $row['firstName'].' '.$row['lastName'] ;
      $_SESSION["accessLevel"] = $row['accessLevel'] ;
      $_SESSION["activeEmail"] = $row['email'] ;
      $_SESSION["font"] = $row['font'] ;
      $_SESSION["theme"] = $row['theme'] ;

      $date = date("Y-m-d H:i:s"); 
      $fullName = $row['firstName'].' '.$row['lastName'] ;
      $email = $row['email'] ;
      $createLog = $user_db->exec("INSERT INTO userlog ('fullName','email','date') VALUES ('$fullName','$email','$date')");
      
         header('location:../dashboard.php');

   }else{
      $_SESSION["errorMessage"] = "Invalid Credentials";
      header('location:../login.php?error="Invalid%20Credentials"');
   }
  
}
// bamidele.efunnuga@bosch.com
?>