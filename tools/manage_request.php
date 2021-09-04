<?php

if ( !isset($_SESSION) ) session_start();
require_once 'connection.php';

	if(isset($_POST['editOrder']) && !empty($_POST['editOrder'])) {

			$editId = '';
			$editId = $_POST['editOrder'];
			$edit  = $store_db->query("SELECT * FROM orders WHERE id = '$editId'");
			$value = $edit->fetch();
			
			echo json_encode(array("value"=>$value, "parts"=>unserialize($value["sparesList"])));

	// // 		  //Return values in session

			  $_SESSION['id'] = $value['id'];
			  $_SESSION['status'] = $value['orderCompleted'];
			  $_SESSION['customerName'] = $value['customerName'];
			  $_SESSION['processNumber'] = $value['processNumber'];
			  $_SESSION['purchaseOrder'] = $value['poNumber'];
			  $_SESSION['offerNumber'] = $value['offerNumber'];

			  $_SESSION['decodedSpareList'] = unserialize($value["sparesList"]);
			  $_SESSION['sparesList'] = $value['sparesList'];
			  $_SESSION['country'] = $value['country'];
			  $_SESSION['createdDate'] = $value['createDate'];
			  $_SESSION['processesBy'] = $value['processedBy'];
			  $_SESSION['memo']= $value['memo'];
			  $_SESSION['requestClass'] = 'tab two';

	 
	 }else if(isset($_POST['clearRequest']) || isset($_GET['clearRequest'])){
		clearField();

	 }else if(isset($_POST['completeRequest']) || isset($_GET['completeRequest'])){
		 $idRequest = $_GET['completeRequest'];
		 $orderCompleted = "Completed";
		 $userName = $_SESSION["activeUserFull"];
		 $dateCompleted = date("Y-m-d H:i:s");  

		$update= "UPDATE orders SET orderCompleted=:orderCompleted, completedBy=:completedBy, completedDate=:completedDate WHERE id =:idRequest";
		
		$updateCheck=$store_db->prepare($update);
		$updateCheck->bindParam(':orderCompleted',$orderCompleted,PDO::PARAM_STR);
		$updateCheck->bindParam(':completedBy',$userName,PDO::PARAM_STR);
		$updateCheck->bindParam(':completedDate',$dateCompleted,PDO::PARAM_STR);
		$updateCheck->bindParam(':idRequest',$idRequest,PDO::PARAM_STR);

		if($updateCheck->execute()){


			createHistory();
            $_SESSION["successMessage"] = "Request Completed Successful";
               $_SESSION['inventoryClass']= "tab two";
               clearField();
			   header('location:../request.php');
         }
         else{
           $_SESSION["errorMessage"] = "Request Completion Failed! Try Again.";
		   $_SESSION['inventoryClass']= "tab two";
		   header('location:../request.php');
         }

         $store_db = null;
	
	 
	 }else if(isset($_POST['cancelRequest']) || isset($_GET['cancelRequest'])){
		$idRequest = $_GET['cancelRequest'];
		$orderCompleted = "Canceled";
		$userName = $_SESSION["activeUserFull"];
		$dateCompleted = date("Y-m-d H:i:s");  

	   $update= "UPDATE orders SET orderCompleted=:orderCompleted, completedBy=:completedBy, completedDate=:completedDate WHERE id =:idRequest";
	   
	   $updateCheck=$store_db->prepare($update);
	   $updateCheck->bindParam(':orderCompleted',$orderCompleted,PDO::PARAM_STR);
	   $updateCheck->bindParam(':completedBy',$userName,PDO::PARAM_STR);
	   $updateCheck->bindParam(':completedDate',$dateCompleted,PDO::PARAM_STR);
	   $updateCheck->bindParam(':idRequest',$idRequest,PDO::PARAM_STR);

	   if($updateCheck->execute()){


		cancelProcess();
		   $_SESSION["successMessage"] = "Request Canceled Successful";
			  $_SESSION['inventoryClass']= "tab two";
			  clearField();
			  header('location:../request.php');
		}
		else{
		  $_SESSION["errorMessage"] = "Request Completion Failed! Try Again.";
		  $_SESSION['inventoryClass']= "tab two";
		  header('location:../request.php');
		}

		$store_db = null;
   
	
	}

	 function createHistory(){

	
	// Create (connect to) SQLite database in file
	$storage_db = new PDO('sqlite:../schema/store.db');
	// Set errormode to exceptions
	$storage_db->setAttribute(PDO::ATTR_ERRMODE, 
							PDO::ERRMODE_EXCEPTION);

		$sparesList = unserialize($_SESSION['sparesList']);
		// print_r(count($users_str));
		
		foreach($sparesList as $x=>$x_value)
		{
	// Select Spare From DB
		$getSpareCount  = $storage_db->query("SELECT * FROM spares WHERE spareName = '$x'");
		$value = $getSpareCount->fetch();
		$quantityInStock = $value['quantityInStock'];
		$lockedUnitCheck = $value['lockedUnit'] - $x_value;
		$newQuantity = $quantityInStock  - $x_value;
		$newSoldQuantity = $value['quantitySold'] + $x_value;
		$quantityRemaining = $quantityInStock - $newSoldQuantity;
		$spareId = $value['id'];
	//Update Spare to DB 
		$query= "UPDATE spares SET quantitySold=:newSoldQuantity,remainingStock=:quantityRemaining, lockedUnit=:lockedUnitCheck WHERE id =:spareId";
		$updateCheck=$storage_db->prepare($query);
        $updateCheck->bindParam(':newSoldQuantity',$newSoldQuantity,PDO::PARAM_STR);
        $updateCheck->bindParam(':quantityRemaining',$quantityRemaining,PDO::PARAM_STR);
		$updateCheck->bindParam(':lockedUnitCheck',$lockedUnitCheck,PDO::PARAM_STR);
		$updateCheck->bindParam(':spareId',$spareId,PDO::PARAM_STR);
		if($updateCheck->execute()){}

	//Create Order History
		$processNumber = $_SESSION['processNumber'];
		$customer = $_SESSION['customerName'];
		$spareName = $x;
		$quantity = $x_value;
		$createdBy = $_SESSION['processesBy'];
		$completedBy = $_SESSION['activeUserFull'];

		$historyQuery = $storage_db->exec("INSERT INTO orderHistory ('processNumber','customer','spareName', 'quantity','createdBy','completedBy') VALUES ('$processNumber','$customer','$spareName','$quantity','$createdBy','$completedBy')");
		}
		$storage_db = null;
	 }


	 function cancelProcess(){

	
		// Create (connect to) SQLite database in file
		$storage_db = new PDO('sqlite:../schema/store.db');
		// Set errormode to exceptions
		$storage_db->setAttribute(PDO::ATTR_ERRMODE, 
								PDO::ERRMODE_EXCEPTION);
	
			$sparesList = unserialize($_SESSION['sparesList']);
			// print_r(count($users_str));
			
			foreach($sparesList as $x=>$x_value)
			{
				// var_dump($x);
		// // Select Spare From DB
			$getSpareCount  = $storage_db->query("SELECT * FROM spares WHERE spareName = '$x'");
			$toDelete = $getSpareCount->fetch();
			$lockedUnitCheck = $x_value - $x_value;
			$spareId = $toDelete['id'];
		//Update Spare to DB 
			$query= "UPDATE spares SET lockedUnit=:lockedUnitCheck WHERE id =:spareId";
			$deleteCheck=$storage_db->prepare($query);
			$deleteCheck->bindParam(':lockedUnitCheck',$lockedUnitCheck,PDO::PARAM_STR);
			$deleteCheck->bindParam(':spareId',$spareId,PDO::PARAM_STR);
			if($deleteCheck->execute()){}

		 }
		 $storage_db = null;
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