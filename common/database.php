<?php
	include_once("entity.php");

    function go_to_exception_page($exceptionMsg)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['exception_msg'] = $exceptionMsg;
        //go to success page
        header('Location: ../exception/exception.php');
        exit;        
    }
    
	function db_connect()
	{
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "unicorn";
		$dbconnection=null;
	
		try {
			$dbconnection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			
			// set the PDO error mode to exception
			$dbconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			return $dbconnection;
		} catch(PDOException $e){
		    go_to_exception_page("db_connect() -> ".$e);
		}
	}

	//[START] Registration function
	function db_insert_user($user)
	{
		try {
			$dbconnection = db_connect();
			$now = date("Y-m-d h:i:sa");
		
			//Prepared SQL statement
			$stmt = $dbconnection->prepare("INSERT INTO `user` (`user_id`, `img_path`, `sex`, `privilege`, `eng_surname`, `eng_middle_name`, 
				`eng_name`, `email`, `tel`, `address_1`, `address_2`, `address_3`, `address_4`, `last_login_date`, 
				`reset`, `locked`, `password`, `reg_token`, `effect_date`, `expiry_date`, `remark`, `create_date`, `update_date`) 
				VALUES (:userID, NULL, :sex, 'U', :engSurname, :engMidName, 
				:engName, :email, :tel, 
				:address1, :address2, :address3, :address4, NULL, 
				'N', 'N', :encrypttedPassword, :regToken, '" . $now . "', NULL, NULL,'" . $now . "', '" . $now . "')");
		
			$stmt->bindParam(':userID', 			$user->getUserID());
			$stmt->bindParam(':sex', 				$user->getSex());
			$stmt->bindParam(':engSurname', 		$user->getEngSurname());
			$stmt->bindParam(':engMidName', 		$user->getEngMidName());
			$stmt->bindParam(':engName', 			$user->getEngName());
			$stmt->bindParam(':email', 				$user->getEmail());
			$stmt->bindParam(':tel', 				$user->getTel());
			$stmt->bindParam(':address1', 			$user->getAddress1());
			$stmt->bindParam(':address2', 			$user->getAddress2());
			$stmt->bindParam(':address3', 			$user->getAddress3());
			$stmt->bindParam(':address4', 			$user->getAddress4());
			$stmt->bindParam(':encrypttedPassword', $user->getEncrypttedPassword());
			$stmt->bindParam(':regToken', 			$user->getRegToken());
			
			//execute prepared sql statement to insert user table
			$stmt->execute();
			$result = $dbconnection->lastInsertId();
			
			return $result;
		}catch(PDOException $e){
		    go_to_exception_page("db_insert_user() -> ".$e);
		}

		//close db connection to release memory
		$dbconnection = null;
	}
	
	function db_select_user_by_UserID($userID)
	{
		try {	    
			$dbconnection = db_connect();
		
			//Prepared SQL statement
			$sql = "SELECT USER_ID FROM UNICORN.USER WHERE USER_ID=:userID";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':userID' => $userID);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			echo $fetch['USER_ID'];
		}catch(PDOException $e){
		    go_to_exception_page("db_select_user_by_UserID() -> ".$e);
		}

		//close db connection to release memory
		$dbconnection = null;	
	}
	
	function db_select_user_by_Email($email)
	{
		try {		    
			$dbconnection = db_connect();
		
			//Prepared SQL statement
			$sql = "SELECT EMAIL FROM UNICORN.USER WHERE EMAIL=:email";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':email' => $email);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			return $fetch['EMAIL'];
		}catch(PDOException $e){
		    go_to_exception_page("db_select_user_by_Email() -> ".$e);
		}

		//close db connection to release memory
		$dbconnection = null;	
	}
	
	function db_select_user_by_Email_UserID($email, $userID)
	{
		try {
			$dbconnection = db_connect();
			
			//Prepared SQL statement
			$sql = "SELECT EMAIL FROM UNICORN.USER WHERE EMAIL=:email and USER_ID!=:userID";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':email' => $email, ':userID' => $userID);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			return $fetch['EMAIL'];
		}catch(PDOException $e){
			go_to_exception_page("db_select_user_by_Email_UserID() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	
	function db_select_user_by_Email_RegToken($email, $regToken)
	{
		try {
			$dbconnection = db_connect();
		
			//Prepared SQL statement
			$sql = "SELECT USER_ID, EMAIL FROM UNICORN.USER WHERE EMAIL=:email and REG_TOKEN=:regToken";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':email' => $email, ':regToken' => $regToken);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			$column_arr = array();
			$column_arr[] = $fetch['USER_ID'];
			$column_arr[] = $fetch['EMAIL'];
			
			return $column_arr;
		}catch(PDOException $e){
		    go_to_exception_page("db_select_user_by_Email_RegToken() -> ".$e);
		}

		//close db connection to release memory
		$dbconnection = null;	
	}
	
	function db_update_user_remove_RegToken($email, $regToken)
	{
		try {
			$dbconnection = db_connect();
		
			//Prepared SQL statement
			$sql = "UPDATE USER SET REG_TOKEN='' WHERE EMAIL=:email and REG_TOKEN=:regToken";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':email' => $email, ':regToken' => $regToken);
			$stmt->execute($paramArray);
			
			return $stmt->rowCount();
		}catch(PDOException $e){
		    go_to_exception_page("db_update_user_remove_RegToken() -> ".$e);
		}

		//close db connection to release memory
		$dbconnection = null;	
	}

	function db_update_user_lastLoginTime($email, $regToken)
	{		
		try {
			$dbconnection = db_connect();
			$now = date("Y-m-d h:i:sa");
			
			//Prepared SQL statement
			$sql = "UPDATE USER SET last_login_date='".$now."' WHERE EMAIL=:email and REG_TOKEN=:regToken";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':email' => $email, ':regToken' => $regToken);
			$stmt->execute($paramArray);
			
			return $stmt->rowCount();
		}catch(PDOException $e){
		    go_to_exception_page("db_update_user_lastLoginTime() -> ".$e);
		}

		//close db connection to release memory
		$dbconnection = null;	
	}	
	//[END] Registration function
		
	//[START] Login and Logout function
	function db_select_user_by_UserID_or_Email_Password($userIdOrEmail, $password)
	{
		try {
			$dbconnection = db_connect();		
			$encryptedPassword = md5($password);
		
			//Prepared SQL statement
			$sql = "SELECT USER_ID, EMAIL FROM UNICORN.USER WHERE (USER_ID = :userIdOrEmail or EMAIL=:userIdOrEmail) and PASSWORD=:encryptedPassword";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':userIdOrEmail' => $userIdOrEmail, ':encryptedPassword' => $encryptedPassword);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			$column_arr = array();
			$column_arr[] = $fetch['USER_ID'];
			$column_arr[] = $fetch['EMAIL'];
			
			return $column_arr;
		}catch(PDOException $e){
			go_to_exception_page("db_select_user_by_UserID_or_Email_Password() -> ".$e);
		}

		//close db connection to release memory
		$dbconnection = null;	
	}
	
	function db_select_user_by_UserID_or_Email_PasswordFake($userIdOrEmail, $password)
	{
		try {
			$dbconnection = db_connect();
			$encryptedPassword = md5($password);
			
			//Prepared SQL statement
			$sql = "SELECT USER_ID, EMAIL FROM UNICORN.USER WHERE (USER_ID = :userIdOrEmail or EMAIL=:userIdOrEmail)";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':userIdOrEmail' => $userIdOrEmail);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			$column_arr = array();
			$column_arr[] = $fetch['USER_ID'];
			$column_arr[] = $fetch['EMAIL'];
			
			return $column_arr;
		}catch(PDOException $e){
			go_to_exception_page("db_select_user_by_UserID_or_Email_Password() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	
	function db_update_user_lastLoginTime_by_Email($email)
	{		
		try {
			$dbconnection = db_connect();
			$now = date("Y-m-d h:i:sa");
			
			//Prepared SQL statement
			$sql = "UPDATE USER SET last_login_date='".$now."' WHERE EMAIL=:email";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':email' => $email);
			$stmt->execute($paramArray);
			
			return $stmt->rowCount();
		}catch(PDOException $e){
		    go_to_exception_page("db_update_user_lastLoginTime_by_Email() -> ".$e);
		}

		//close db connection to release memory
		$dbconnection = null;	
	}	
	//[END] Login and Logout function	
	
	//[START] User Profile function
	function db_select_user_all_info_by_UserID($userID)
	{
		try {
			$dbconnection = db_connect();
			
			//Prepared SQL statement
			$sql = "SELECT * FROM UNICORN.USER WHERE USER_ID=:userID";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':userID' => $userID);
			$stmt->execute($paramArray);
			$result = $stmt->fetch();
			
			return $result;
		}catch(PDOException $e){
			go_to_exception_page("db_select_user_all_info_by_UserID() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	
	function db_update_user_profile($user)
	{
		$sql = "";
		try {
			$dbconnection 			= db_connect();
			$imgPathTmp 			= $user->getImgPath();
			$encrypttedPasswordTmp 	= $user->getEncrypttedPassword();
			
			//Prepared SQL statement
			$sql = $sql . "UPDATE UNICORN.USER SET 					       " ;
			
			if(isset($imgPathTmp) && $imgPathTmp != ""){
				$sql = $sql . "	      img_path=:imgPath, 			   " ;
			}
			
			if(isset($encrypttedPasswordTmp) && $encrypttedPasswordTmp != ""){
				$sql = $sql . "	      password=:newPass, 			   " ;
			}
			
			$sql = $sql . "		         email=:email, 			   " ;
			$sql = $sql . "		           sex=:sex,                 " ;
			$sql = $sql . "	       eng_surname=:engSurname,          " ;
			$sql = $sql . "    eng_middle_name=:engMidName,          " ;
			$sql = $sql . "           eng_name=:engName,             " ;
			$sql = $sql . "			       tel=:tel,                 " ;
			$sql = $sql . "		     address_1=:address1,            " ;
			$sql = $sql . "		     address_2=:address2,            " ;
			$sql = $sql . "		     address_3=:address3,            " ;
			$sql = $sql . "		     address_4=:address4             " ;
			$sql = $sql . "	     WHERE user_id=:userID               " ;
			
			echo $sql;
			
			$stmt = $dbconnection->prepare($sql);
			
			
			if(isset($imgPathTmp) && $imgPathTmp != ""){
				$stmt->bindParam(':imgPath', 			$imgPathTmp);
			}
			
			if(isset($encrypttedPasswordTmp) && $encrypttedPasswordTmp != ""){
				$stmt->bindParam(':newPass', 			$encrypttedPasswordTmp);
			}
			
			$stmt->bindParam(':email', 				$user->getEmail());
			$stmt->bindParam(':sex', 				$user->getSex());
			$stmt->bindParam(':engSurname', 		$user->getEngSurname());
			$stmt->bindParam(':engMidName', 		$user->getEngMidName());
			$stmt->bindParam(':engName', 			$user->getEngName());
			$stmt->bindParam(':tel', 				$user->getTel());
			$stmt->bindParam(':address1', 			$user->getAddress1());
			$stmt->bindParam(':address2', 			$user->getAddress2());
			$stmt->bindParam(':address3', 			$user->getAddress3());
			$stmt->bindParam(':address4', 			$user->getAddress4());
			$stmt->bindParam(':userID', 			$user->getUserID());
			
			$stmt->execute();
			return $stmt->rowCount();
		}catch(PDOException $e){
			go_to_exception_page("db_update_user_profile() -> " . $e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	//[END] User Profile function
	
	//[START] Notification function		
	function db_delete_notification_by_status_date($status, $updateDate)
	{		
		try {
			$dbconnection = db_connect();

			//Prepared SQL statement
			$sql = "delete from unicorn.notification n where n.notification_id in 
			(select un.notification_id from unicorn.user_notification un where un.status = :status and un.update_date = :updateDate)";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':status' => $status, ':updateDate' => $updateDate);
			$stmt->execute($paramArray);
			
			return $stmt->rowCount();
		}catch(PDOException $e){
		    go_to_exception_page("db_delete_notification_by_status_date() -> ".$e);
		}

		//close db connection to release memory
		$dbconnection = null;	
	}	
	//[END] Notification function	
	
	//[START] Place order function
	function db_select_food_by_FoodID($orderDetail4Display_array)
	{
		try {
			$dbconnection = db_connect();
			
			$foodIDList = [];
			for ($index = 0; $index< count($orderDetail4Display_array); $index++) {
				$orderDetail4Display = $orderDetail4Display_array[$index];
				$foodIDList[] = $orderDetail4Display->getFoodID();
			}

			//Prepared SQL statement
			$inConditions = join(',', array_fill(0, count($foodIDList), '?'));
			$sql = "SELECT FOOD_ID, FOOD_CATEGORY, FOOD_NAME, PRICE FROM UNICORN.FOOD WHERE FOOD_ID IN (".$inConditions.") ORDER BY FOOD_CATEGORY, FOOD_NAME";
			$stmt = $dbconnection->prepare($sql);
			$stmt->execute($foodIDList);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
			
			if(!isset($result)){
				return "";
			}
			
			$orderDetail_array = [];  
			for ($row = 0; $row< count($result); $row++) {
				$foodRow = $result[$row];
				
				for ($index = 0; $index< count($orderDetail4Display_array); $index++) {
					$orderDetail4Display = $orderDetail4Display_array[$index];
										
					if($foodRow["FOOD_ID"] == $orderDetail4Display->getFoodID()){
						$orderDetail4Display->setFoodCategory($foodRow["FOOD_CATEGORY"]);
						$orderDetail4Display->setFoodName($foodRow["FOOD_NAME"]);
						$orderDetail4Display->setPrice($foodRow["PRICE"]);
						
						$orderDetail_array[] = $orderDetail4Display;
						break;
					}
				}
			}
			
			return $orderDetail_array;
		}catch(PDOException $e){
		    go_to_exception_page("db_select_food_by_FoodID() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	
	function db_select_food_info_by_FoodID($orderDetail4Display_array)
	{
	    try {
	        $dbconnection = db_connect();
	        
	        $foodIDList = [];
	        for ($index = 0; $index< count($orderDetail4Display_array); $index++) {
	            $orderDetail4Display = $orderDetail4Display_array[$index];
	            $foodIDList[] = $orderDetail4Display->getFoodID();
	        }
	        
	        //Prepared SQL statement
	        $inConditions = join(',', array_fill(0, count($foodIDList), '?'));
	        $sql = "SELECT FOOD_ID, FOOD_CATEGORY, FOOD_NAME, PRICE FROM UNICORN.FOOD WHERE FOOD_ID IN (".$inConditions.")";
	        $stmt = $dbconnection->prepare($sql);
	        $stmt->execute($foodIDList);
	        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	        
	        if(!isset($result)){
	            return "";
	        }
	        
	        $orderDetail_array = [];
	        for ($row = 0; $row< count($result); $row++) {
	            $foodRow = $result[$row];
	            
	            for ($index = 0; $index< count($orderDetail4Display_array); $index++) {
	                $orderDetail4Display = $orderDetail4Display_array[$index];
	                
	                if($foodRow["FOOD_ID"] == $orderDetail4Display->getFoodID()){
	                    $orderDetail4Display->setFoodCategory($foodRow["FOOD_CATEGORY"]);
	                    $orderDetail4Display->setFoodName($foodRow["FOOD_NAME"]);
	                    
	                    $orderDetail_array[] = $orderDetail4Display;
	                    break;
	                }
	            }
	        }
	        
	        return $orderDetail_array;
	    }catch(PDOException $e){
	        go_to_exception_page("db_select_food_info_by_FoodID() -> ".$e);
	    }
	    
	    //close db connection to release memory
	    $dbconnection = null;
	}
	
	function get_user_address_contactNo_by_userId($userID)
	{
	    try {
	        $dbconnection = db_connect();
	        
	        //Prepared SQL statement
	        $sql = "select concat(address_1, ',', address_2, ',', address_3, ',', address_4) as ADDRESS, TEL from unicorn.user WHERE user_id=:userID";
	        $stmt = $dbconnection->prepare($sql);
	        $paramArray = array(':userID' => $userID);
	        $stmt->execute($paramArray);
	        $fetch = $stmt->fetch();
	        
	        $column_arr = array();
	        $column_arr[] = $fetch['ADDRESS'];
	        $column_arr[] = $fetch['TEL'];
	        
	        return $column_arr;
	    }catch(PDOException $e){
	        go_to_exception_page("get_user_address_contactNo_by_userId() -> ".$e);
	    }
	    
	    //close db connection to release memory
	    $dbconnection = null;
	}
	
	function db_select_order_by_OrderID($orderID)
	{
	    try {
	        $dbconnection = db_connect();
	        
	        //Prepared SQL statement
	        $sql = "SELECT * FROM UNICORN.ORDER WHERE ORDER_ID=:orderID";
	        $stmt = $dbconnection->prepare($sql);
	        $paramArray = array(':orderID' => $orderID);
	        $stmt->execute($paramArray);
	        $resultArray = $stmt->fetch(PDO::FETCH_ASSOC);
	        
	        return $resultArray;
	    }catch(PDOException $e){
	        go_to_exception_page("db_select_order_by_OrderID() -> ".$e);
	    }
	    
	    //close db connection to release memory
	    $dbconnection = null;	
	}
	
	function db_select_order_detail_by_OrderID($orderID)
	{
	    try {
	        $dbconnection = db_connect();
	        
	        //Prepared SQL statement
	        $sql = "SELECT * FROM UNICORN.ORDER_DETAIL WHERE ORDER_ID=:orderID";
	        $stmt = $dbconnection->prepare($sql);
	        $paramArray = array(':orderID' => $orderID);
	        $stmt->execute($paramArray);
	        $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
	        
	        return $resultArray;
	    }catch(PDOException $e){
	        go_to_exception_page("db_select_order_detail_by_OrderID() -> ".$e);
	    }
	    
	    //close db connection to release memory
	    $dbconnection = null;
	}
	
	function db_insert_order($order)
	{
		try {
			$dbconnection = db_connect();
			$now = date("Y-m-d h:i:sa");
			
			//Prepared SQL statement
			$stmt = $dbconnection->prepare("INSERT INTO `order` (`order_id`, `user_id`, `status`, `delivery_timeslot`, `order_effect_date`,
				`order_expiry_date`, `total_payment_amt`, `total_discount_amt`, `payment_date`, `payment_channel`,
				`credit_card_type`, `credit_card_no`, `credit_card_security_code`, `credit_card_holder_name`,
				`credit_card_expiry_date`, `cheque_no`, `remark`, `create_date`, `update_date`)
				VALUES(NULL, :userID, :status, :deliveryTimeslot, :orderEffectDate,
				:orderExpiryDate, :totalPaymentAmt, :totalDiscountAmt, :paymentDate, :paymentChannel,
				:creditCardType, :creditCardNo, :creditCardSecurityCode, :creditCardHolderName,
				:creditCardExpiryDate, :chequeNo, :remark, :createDate, :updateDate)");
			
			//$stmt->bindParam(':orderID', 					$order->getOrderID()); //auto increased by MySQL database
			$stmt->bindParam(':userID', 					$order->getUserID());
			$stmt->bindParam(':status', 					$order->getStatus());
			$stmt->bindParam(':deliveryTimeslot', 			$order->getDeliveryTimeslot());
			$stmt->bindParam(':orderEffectDate', 			$order->getOrderEffectDate());
			$stmt->bindParam(':orderExpiryDate', 			$order->getOrderExpiryDate());
			$stmt->bindParam(':totalPaymentAmt', 			$order->getTotalPaymentAmt());
			$stmt->bindParam(':totalDiscountAmt', 			$order->getTotalDiscountAmt());
			$stmt->bindParam(':paymentDate', 				$order->getPaymentDate());
			$stmt->bindParam(':paymentChannel', 			$order->getPaymentChannel());
			$stmt->bindParam(':creditCardType', 			$order->getCreditCardType());
			$stmt->bindParam(':creditCardNo', 				$order->getCreditCardNo());
			$stmt->bindParam(':creditCardSecurityCode', 	$order->getCreditCardSecurityCode());
			$stmt->bindParam(':creditCardHolderName', 		$order->getCreditCardHolderName());
			$stmt->bindParam(':creditCardExpiryDate', 		$order->getCreditCardExpiryDate());
			$stmt->bindParam(':chequeNo', 					$order->getChequeNo());
			$stmt->bindParam(':remark', 					$order->getRemark());
			$stmt->bindParam(':createDate', 				$order->getCreateDate());
			$stmt->bindParam(':updateDate', 				$order->getUpdateDate());		
			
			$stmt->execute();
			$result = $dbconnection->lastInsertId();			
			return $result;
		}catch(PDOException $e){
			go_to_exception_page("db_insert_order() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	
	function db_insert_order_detail($orderDetail)
	{
		try {
			$dbconnection = db_connect();
			$now = date("Y-m-d h:i:sa");
			
			//Prepared SQL statement
			$stmt = $dbconnection->prepare("INSERT INTO `order_detail` (`order_id`, `food_id`, `qty`, `payment_amt`,
				`discount_amt`, `create_date`, `update_date`)
				VALUES(:orderID, :foodID, :qty, :paymentAmt,
				:discountAmt, :createDate, :updateDate)");
			
			$stmt->bindParam(':orderID', 					$orderDetail->getOrderID());
			$stmt->bindParam(':foodID', 					$orderDetail->getFoodID());
			$stmt->bindParam(':qty', 						$orderDetail->getQty());
			$stmt->bindParam(':paymentAmt', 				$orderDetail->getPaymentAmt());
			$stmt->bindParam(':discountAmt', 				$orderDetail->getDiscountAmt());
			$stmt->bindParam(':createDate', 				$orderDetail->getCreateDate());
			$stmt->bindParam(':updateDate', 				$orderDetail->getUpdateDate());
			
			$stmt->execute();
			$result = $dbconnection->lastInsertId();
			return $result;
		}catch(PDOException $e){
			go_to_exception_page("db_insert_order() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	
	function db_insert_notification($notification)
	{
		try {
			$dbconnection = db_connect();
			$now = date("Y-m-d h:i:sa");
			
			//Prepared SQL statement
			$stmt = $dbconnection->prepare("INSERT INTO `notification` (`notification_id`, `type`, `subject`, `content`,
				`create_date`, `update_date`)
				VALUES(NULL, :type, :subject, :content,
				:createDate, :updateDate)");
			
			//$stmt->bindParam(':notification_id', 			$notification->getNotificationID()); //automatically increased by MySQL DB
			$stmt->bindParam(':type', 						$notification->getType());
			$stmt->bindParam(':subject', 					$notification->getSubject());
			$stmt->bindParam(':content', 					$notification->getContent());
			$stmt->bindParam(':createDate', 				$notification->getCreateDate());
			$stmt->bindParam(':updateDate', 				$notification->getUpdateDate());

			$stmt->execute();
			$result = $dbconnection->lastInsertId();
			return $result;
		}catch(PDOException $e){
			go_to_exception_page("db_insert_notification() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	
	function db_insert_user_notification($userNotification)
	{
		try {
			$dbconnection = db_connect();
			$now = date("Y-m-d h:i:sa");
			
			//Prepared SQL statement
			$stmt = $dbconnection->prepare("INSERT INTO `user_notification` (`notification_id`, `user_id`, `status`, 
				`create_date`, `update_date`)
				VALUES(:notificationID, :userID, :status,
				:createDate, :updateDate)");
			
			$stmt->bindParam(':notificationID', 			$userNotification->getNotificationID());
			$stmt->bindParam(':userID', 					$userNotification->getUserID());
			$stmt->bindParam(':status', 					$userNotification->getStatus());
			$stmt->bindParam(':createDate', 				$userNotification->getCreateDate());
			$stmt->bindParam(':updateDate', 				$userNotification->getUpdateDate());
			
			$stmt->execute();
			$result = $dbconnection->lastInsertId();
			return $result;
		}catch(PDOException $e){
			go_to_exception_page("db_insert_user_notification() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	//[END] Place order function
	
	//[START] Comment function
	function db_select_order_by_UserID($userID)
	{
	    try {
	        $dbconnection = db_connect();
	        
	        //Prepared SQL statement
	        $sql = "SELECT ORDER_ID FROM UNICORN.ORDER WHERE USER_ID=:userID ORDER BY ORDER_ID DESC LIMIT 5";
	        $stmt = $dbconnection->prepare($sql);
	        $paramArray = array(':userID' => $userID);
	        $stmt->execute($paramArray);
	        $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
	        
	        $dbconnection = null;
	        return $resultArray;
	    }catch(PDOException $e){
	        go_to_exception_page("db_select_order_by_UserID() -> ".$e);
	    }
	    
	    //close db connection to release memory
	    $dbconnection = null;
	}
	
	function db_insert_comment($commentObj)
	{
	    try {
	        $dbconnection = db_connect();
	        
	        //Prepared SQL statement
	        $stmt = $dbconnection->prepare("INSERT INTO `comment` (`comment_id`, `user_id`, `order_id`,
                `rating`,`content`,
				`create_date`, `update_date`)
				VALUES(NULL, :userID, :orderID,
                :rating, :content,
				:createDate, :updateDate)");
	        
	        $stmt->bindParam(':userID', 					$commentObj->getUserID());
	        $stmt->bindParam(':orderID', 					$commentObj->getOrderID());
	        $stmt->bindParam(':rating', 		            $commentObj->getRating());
	        $stmt->bindParam(':content', 					$commentObj->getContent());
	        $stmt->bindParam(':createDate', 				$commentObj->getCreateDate());
	        $stmt->bindParam(':updateDate', 				$commentObj->getUpdateDate());
	        
	        $stmt->execute();
	        $result = $dbconnection->lastInsertId();
	        
	        $dbconnection = null;
	        return $result;
	    }catch(PDOException $e){
	        go_to_exception_page("db_insert_comment() -> ".$e);
	    }
	    
	    //close db connection to release memory
	    $dbconnection = null;
	}
	
	function db_select_comment_by_UserID($userID)
	{
		try {
			$dbconnection = db_connect();
			
			//Prepared SQL statement
			$sql = "SELECT * FROM UNICORN.COMMENT WHERE USER_ID=:userID ORDER BY COMMENT_ID DESC LIMIT 5";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':userID' => $userID);
			$stmt->execute($paramArray);
			$resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return $resultArray;
		}catch(PDOException $e){
			go_to_exception_page("db_select_order_detail_by_OrderID() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	//[END] Comment function
	
	//[START] Notificationfunction
	function db_select_notification_by_UserID($userID)
	{
		try {
			$dbconnection = db_connect();
			
			//Prepared SQL statement
			$sql = "select un.notification_id, un.create_date, un.status, n.subject, n.content 
					from user_notification un, notification n 
					where un.notification_id = n.notification_id and un.user_id = :userID 
					order by un.create_date desc;";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':userID' => $userID);
			$stmt->execute($paramArray);
			$resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $resultArray;
		}catch(PDOException $e){
			go_to_exception_page("db_select_notification_by_UserID() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
	
	function db_update_notification($notificationObj)
	{
		try {
			$dbconnection = db_connect();
			
			//Prepared SQL statement
			$sql = "UPDATE USER_NOTIFICATION SET STATUS = :status, UPDATE_DATE = :updateDate WHERE NOTIFICATION_ID= :notificationID AND USER_ID = :userID";
			$stmt = $dbconnection->prepare($sql);
			
			$stmt->bindParam(':userID', 					$notificationObj->getUserID());
			$stmt->bindParam(':notificationID', 			$notificationObj->getNotificationID());
			$stmt->bindParam(':status', 		            $notificationObj->getStatus());
			$stmt->bindParam(':updateDate', 				$notificationObj->getUpdateDate());
			
			$stmt->execute();
			return $stmt->rowCount();
			
			
		}catch(PDOException $e){
			go_to_exception_page("db_insert_comment() -> ".$e);
		}
		
		//close db connection to release memory
		$dbconnection = null;
	}
		
	function db_select_notification_count_by_UserID($userID)
	{
	    try {
	        $dbconnection = db_connect();
	        
	        //Prepared SQL statement
	        $sql = "select *
					from user_notification 
					where status = 'NS01' and user_id = :userID";
	        $stmt = $dbconnection->prepare($sql);
	        $paramArray = array(':userID' => $userID);
	        
	        $stmt->execute($paramArray);	        
	        return $stmt->rowCount();
	    }catch(PDOException $e){
	        go_to_exception_page("db_select_notification_count_by_UserID() -> ".$e);
	    }
	    
	    //close db connection to release memory
	    $dbconnection = null;
	}
	//[END] Notificationfunction
	/*
	//Not prefer to use the following function, we should use prepared statement to prevent SQL Injection hacking
	function db_insert($sql)
	{
		try {
			$dbconnection = db_connect();

			//execute sql to insert record
			$dbconnection->exec($sql);
			
			//echo "New record created successfully";
		}catch(PDOException $e){
			//echo "<br>" . $e->getMessage();
	        go_to_exception_page("db_insert() -> ".$e);
		}

		//close db connection to release memory
		$dbconnection = null;
	}
	*/
?>