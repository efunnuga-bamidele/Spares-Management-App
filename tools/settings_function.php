<?php  
//starting the session
if ( !isset($_SESSION) ) session_start();
require_once 'connection.php';

if(ISSET($_POST["changePassword"])){
    $emailAddress = rtrim(strtolower($_POST['emailAddress']));
    $oldPassword = md5($_POST['oldPassword']);
    $newPassword = md5($_POST['newPassword']);
    $confirmPassword = md5($_POST['confirmPassword']);

    // Confirm old password
    $checkPass = $user_db->query("SELECT * FROM userprofile WHERE password='$oldPassword'");
    $feedBack = $checkPass->fetch();
    if($feedBack  > 0){
        if($newPassword == $confirmPassword){
            $updatePass = "UPDATE userprofile SET password='$newPassword' WHERE email='$emailAddress'";
            $updateRow=$user_db->prepare($updatePass);
            $updateRow->execute();
            $_SESSION["successMessage"] = "Password Change Successful";
            $_SESSION['preferenceClass']= "tab one";
            header("Location:../preference.php"); 

        }else{
            $_SESSION['preferenceClass']= "tab one";
            $_SESSION["errorMessage"] = "New Password and Confirm Password are not a match! Try Again.";
            header("Location:../preference.php"); 
        }
    }else{
        $_SESSION['preferenceClass']= "tab one";
        $_SESSION["errorMessage"] = "Old Password is not correct! Try Again.";
        header("Location:../preference.php");
    }


    // confirm new password is a match 

    // update password with new one

}else if(ISSET($_POST["updateProfile"])){
    $userId = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = rtrim(strtolower($_POST['emailAddress']));
    $country = $_POST['contry'];
    $theme = $_POST['theme'];

    $updateData = "UPDATE userprofile SET firstName='$firstName',lastName='$lastName',email='$emailAddress',country='$country',theme='$theme' WHERE id='$userId'";
    $dataRow=$user_db->prepare($updateData);
  if ($dataRow->execute()) {
      $_SESSION["successMessage"] = "User Profile Update Successful";
      $_SESSION['preferenceClass']= "tab one";
      $_SESSION['theme'] = $theme;
      $_SESSION["activeUser"]  =  $firstName;
      $_SESSION["activeUserFull"] = $firstName.' '.$lastName ;
      $_SESSION["activeEmail"] = $emailAddress ;
      header("Location:../preference.php");
  }else{
    $_SESSION['preferenceClass']= "tab one";
    $_SESSION["errorMessage"] = "User Profile Update Failed! Try Again.";
    header("Location:../preference.php");
  }


}else if(ISSET($_POST["cancel"])){
    header("Location:../preference.php");

}else if(ISSET($_GET["resetPassword"])){
    $userID = $_GET["resetPassword"];
    $defaultPass = "defaultuser";
    $resetPassword = md5($defaultPass);

    $resetPass = "UPDATE userprofile SET password='$resetPassword' WHERE id='$userID'";
    $resetRow=$user_db->prepare($resetPass);

  if ($resetRow->execute()) {
      $_SESSION["successMessage"] = "User Password Reset Successful ";
      $_SESSION['preferenceClass']= "tab four";
      header("Location:../preference.php");
  }else{

  }
}else if(ISSET($_GET["makeUser"])){
    $userID = $_GET["makeUser"];
    $resetLevel = 2;

    $setLevel = "UPDATE userprofile SET accessLevel='$resetLevel' WHERE id='$userID'";
    $setRow=$user_db->prepare($setLevel);
    
  if ($setRow->execute()) {
    $_SESSION["successMessage"] = "User Access Successfully Changed to Normal ";
    $_SESSION['preferenceClass']= "tab four";
    $_SESSION["activeEmail"] = $resetLevel;
    header("Location:../preference.php");
}
}else if(ISSET($_GET["makeAdmin"])){
    $userID = $_GET["makeAdmin"];
    $resetLevel = 4;

    $setLevel = "UPDATE userprofile SET accessLevel='$resetLevel' WHERE id='$userID'";
    $setRow=$user_db->prepare($setLevel);
    
  if ($setRow->execute()) {
      $_SESSION["successMessage"] = "User Access Successfully Changed to Admin ";
      $_SESSION['preferenceClass']= "tab four";
      $_SESSION["activeEmail"] = $resetLevel;
      header("Location:../preference.php");
  }
}else if(ISSET($_GET["deleteProfile"])){
    $userID = $_GET["deleteProfile"];

    $deleteUser= "DELETE FROM userprofile WHERE id='$userID'";
    $deleteRow=$user_db->prepare($deleteUser);
    
  if ($deleteRow->execute()) {
      $_SESSION["successMessage"] = "User Profile Successful Deleted";
      $_SESSION['preferenceClass']= "tab four";
      header("Location:../preference.php");
  }
}else if(ISSET($_POST["content-1"])){
    $rowId = $_POST["id-1"];
    $heading = $_POST["head-1"];
    $content = $_POST["body-1"];

    $updateContent = "UPDATE content SET heading='$heading', content='$content' WHERE id='$rowId'";
    $updateRow = $setting_db->prepare($updateContent);

  if ($updateRow->execute()) {
    $_SESSION["successMessage"] = "Content ".$rowId." Update Successful";
      $_SESSION['preferenceClass']= "tab three";
      header("Location:../preference.php");
  }
}else if(ISSET($_POST["content-2"])){
    $rowId = $_POST["id-2"];
    $heading = $_POST["head-2"];
    $content = $_POST["body-2"];

    $updateContent = "UPDATE content SET heading='$heading', content='$content' WHERE id='$rowId'";
    $updateRow = $setting_db->prepare($updateContent);

  if ($updateRow->execute()) {
    $_SESSION["successMessage"] = "Content ".$rowId." Update Successful";
      $_SESSION['preferenceClass']= "tab three";
      header("Location:../preference.php");
  }
}else if(ISSET($_POST["content-3"])){
    $rowId = $_POST["id-3"];
    $heading = $_POST["head-3"];
    $content = $_POST["body-3"];

    $updateContent = "UPDATE content SET heading='$heading', content='$content' WHERE id='$rowId'";
    $updateRow = $setting_db->prepare($updateContent);

  if ($updateRow->execute()) {
    $_SESSION["successMessage"] = "Content ".$rowId." Update Successful";
      $_SESSION['preferenceClass']= "tab three";
      header("Location:../preference.php");
  }
}else if(ISSET($_POST["content-4"])){
    $rowId = $_POST["id-4"];
    $heading = $_POST["head-4"];
    $content = $_POST["body-4"];

    $updateContent = "UPDATE content SET heading='$heading', content='$content' WHERE id='$rowId'";
    $updateRow = $setting_db->prepare($updateContent);

  if ($updateRow->execute()) {
      $_SESSION["successMessage"] = "Content ".$rowId." Update Successful";
      $_SESSION['preferenceClass']= "tab three";
      header("Location:../preference.php");
  }
}
else{
    $_SESSION['preferenceClass']= "tab four";
    $_SESSION["errorMessage"] = "Action Failed! Try Again.";
    header("Location:../preference.php");
}






?>