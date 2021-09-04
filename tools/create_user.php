<?php  
//starting the session
if ( !isset($_SESSION) ) session_start();
require_once 'connection.php';


$firstName = "";
$lastName = "";
$email = "";
$country = "";
$password = "";
$retypePassword = "";
$hashed_password = "";

$_SESSION['errorMessage'] = "";
$_SESSION['successMessage'] = "";


if(ISSET($_POST['signup'])){
   // Setting variables
   
   $firstName = $_POST['firstName'];
   $lastName = $_POST['lastName'];
   $email =  rtrim(strtolower($_POST['email'])," ");
   $country = $_POST['country'];
   $password = $_POST['password'];
   $retypePassword = $_POST['retypePassword'];

   // var_dump($password);

   if($password == $retypePassword ){
      $md5_password = md5($password);

      $checkUser = $user_db->query("SELECT * FROM userprofile WHERE email = '$email' OR firstName = '$firstName' AND lastName ='$lastName'");

      $feedback = $checkUser->fetch();

      if($feedback > 0){
         $_SESSION["errorMessage"] = "User profile already exist";
         $_SESSION["firstName"] = $firstName;
         $_SESSION["lastName"] = $lastName;
         $_SESSION["email"] = $email;
         $_SESSION["country"] = $country;
         $_SESSION["password"] = $password;
         $_SESSION["retypePassword"] = $retypePassword;
            header('location:../sign_up.php'); 

      }else{

      $result = $user_db->exec("INSERT INTO userprofile ('firstName', 'lastName', 'email', 'password','country' ) VALUES ('$firstName', '$lastName','$email','$md5_password', '$country')");

      if(!$result ){
            $_SESSION["errorMessage"] = "User Creation Failed! Try Again.";
         header('location:../sign_up.php');
   
      }else{
         $_SESSION["successMessage"] = "User Created Successfully";
         header('location:../login.php');
      }
   }
     
   }else{
      $_SESSION["errorMessage"] = "Password does not match";
      $_SESSION["firstName"] = $firstName;
      $_SESSION["lastName"] = $lastName;
      $_SESSION["email"] = $email;
      $_SESSION["country"] = $country;
      $_SESSION["password"] = $password;
      $_SESSION["retypePassword"] = $retypePassword;
         header('location:../sign_up.php'); 
   }
   
}else{
   session_unset();
   header('location:../login.php'); 

}
?>