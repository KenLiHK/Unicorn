<?php
	include_once("entity.php");
		
    function go_to_exception_page($exceptionMsg)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['exception_msg'] = $exceptionMsg;
        //go to success page
        $url = "../exception/exception.php";
        
        if (!headers_sent())
        {            
            header('Location: '.$url);
            exit;
        }
        else
        {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$url.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
            echo '</noscript>'; exit;
        }     
    }
    
	function db_connect()
	{
	    /*
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "unicorn";
		
	    $servername = "localhost";
	    $username = "id5362689_unicornuser";
	    $password = "!@QW12qw";
		$dbname = "id5362689_unicorn";
		*/
	    
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

	function healthCheckDB(){
	    $dbconnection = db_connect();
	    //close db connection to release memory
	    $dbconnection = null;	    
	}
	
	function healthCheckDBTables(){
	    try {
	        $dbconnection = db_connect();
	        
	        $tableArray = ['unicorn_user', 'food', 'food_tag', 'order', 'order_detail', 'comment', 'notification', 'user_notification', 'sys_config'];
	        for ($index = 0; $index < count($tableArray); $index++) {
	            $tableName = $tableArray[$index];
	           //Prepared SQL statement
	           $sql = "select 1 from `$tableName` limit 1";
	           $stmt = $dbconnection->prepare($sql);	     
	           $stmt->execute();
	        }
	    }catch(PDOException $e){
	        go_to_exception_page("healthCheckDBTables() -> ".$e);
	    }
	}
	
	//[START] Registration function
	function db_insert_user($user)
	{
		try {
			$dbconnection = db_connect();
			$now = date("Y-m-d h:i:sa");
		
			//Prepared SQL statement
			$stmt = $dbconnection->prepare("insert into `unicorn_user` (`user_id`, `img_path`, `sex`, `privilege`, `eng_surname`, `eng_middle_name`, 
				`eng_name`, `email`, `tel`, `address_1`, `address_2`, `address_3`, `address_4`, `last_login_date`, 
				`reset`, `locked`, `password`, `reg_token`, `effect_date`, `expiry_date`, `remark`, `create_date`, `update_date`) 
				values (:userID, :imgPath, :sex, 'U', :engSurname, :engMidName, 
				:engName, :email, :tel, 
				:address1, :address2, :address3, :address4, NULL, 
				'N', 'N', :encrypttedPassword, :regToken, '" . $now . "', NULL, NULL,'" . $now . "', '" . $now . "')");
		
			$defaultImgPath = "/resources/userProfileImg/default.jpg";
			
			$_userID                 = $user->getUserID();
			$_sex                    = $user->getSex();
			$_engSurname             = $user->getEngSurname();
			$_engMidName             = $user->getEngMidName();
			$_engName                = $user->getEngName();
			$_email                  = $user->getEmail();
			$_tel                    = $user->getTel();
			$_address1               = $user->getAddress1();
			$_address2               = $user->getAddress2();
			$_address3               = $user->getAddress3();
			$_address4               = $user->getAddress4();
			$_encrypttedPassword     = $user->getEncrypttedPassword();
			$_regToken               = $user->getRegToken();
			
			$stmt->bindParam(':userID', 			$_userID);
			$stmt->bindParam(':imgPath', 			$defaultImgPath);
			$stmt->bindParam(':sex', 				$_sex);
			$stmt->bindParam(':engSurname', 		$_engSurname);
			$stmt->bindParam(':engMidName', 		$_engMidName);
			$stmt->bindParam(':engName', 			$_engName);
			$stmt->bindParam(':email', 				$_email);
			$stmt->bindParam(':tel', 				$_tel);
			$stmt->bindParam(':address1', 			$_address1);
			$stmt->bindParam(':address2', 			$_address2);
			$stmt->bindParam(':address3', 			$_address3);
			$stmt->bindParam(':address4', 			$_address4);
			$stmt->bindParam(':encrypttedPassword', $_encrypttedPassword);
			$stmt->bindParam(':regToken', 			$_regToken);
			
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
			$sql = "select user_id from `unicorn_user` where user_id=:userID";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':userID' => $userID);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			echo $fetch['user_id'];
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
			$sql = "select email from `unicorn_user` where email=:email";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':email' => $email);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			return $fetch['email'];
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
			$sql = "select email from `unicorn_user` where email=:email and user_id!=:userID";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':email' => $email, ':userID' => $userID);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			return $fetch['email'];
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
			$sql = "select user_id, email, privilege from `unicorn_user` where email=:email and reg_token=:regToken";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':email' => $email, ':regToken' => $regToken);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			$column_arr = array();
			$column_arr[] = $fetch['user_id'];
			$column_arr[] = $fetch['email'];
			$column_arr[] = $fetch['privilege'];
			
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
			$sql = "update `unicorn_user` set reg_token = '' where email=:email and reg_token=:regToken";
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
			$sql = "update `unicorn_user` set last_login_date='".$now."' where email=:email and reg_token=:regToken";
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
			$sql = "select user_id, email, privilege from `unicorn_user` where (user_id = :userIdOrEmail or email=:userIdOrEmail) and password=:encryptedPassword";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':userIdOrEmail' => $userIdOrEmail, ':encryptedPassword' => $encryptedPassword);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			$column_arr = array();
			$column_arr[] = $fetch['user_id'];
			$column_arr[] = $fetch['email'];
			$column_arr[] = $fetch['privilege'];
						
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
			$sql = "select user_id, email, privilege from `unicorn_user` where (user_id = :userIdOrEmail or email=:userIdOrEmail)";
			$stmt = $dbconnection->prepare($sql);
			$paramArray = array(':userIdOrEmail' => $userIdOrEmail);
			$stmt->execute($paramArray);
			$fetch = $stmt->fetch();
			
			$column_arr = array();
			$column_arr[] = $fetch['user_id'];
			$column_arr[] = $fetch['email'];
			$column_arr[] = $fetch['privilege'];
			
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
			$sql = "update `unicorn_user` set last_login_date='".$now."' where email=:email";
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
			$sql = "select * from `unicorn_user` where user_id=:userID";
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
			$sql = $sql . "update `unicorn_user` set 					       " ;
			
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
			$sql = $sql . "	     where user_id=:userID               " ;
			
			echo $sql;
			
			$stmt = $dbconnection->prepare($sql);
			
			
			if(isset($imgPathTmp) && $imgPathTmp != ""){
				$stmt->bindParam(':imgPath', 			$imgPathTmp);
			}
			
			if(isset($encrypttedPasswordTmp) && $encrypttedPasswordTmp != ""){
				$stmt->bindParam(':newPass', 			$encrypttedPasswordTmp);
			}
			
			$_email                  = $user->getEmail();
			$_sex                    = $user->getSex();
			$_engSurname             = $user->getEngSurname();
			$_engMidName             = $user->getEngMidName();
			$_engName                = $user->getEngName();
			$_tel                    = $user->getTel();
			$_address1               = $user->getAddress1();
			$_address2               = $user->getAddress2();
			$_address3               = $user->getAddress3();
			$_address4               = $user->getAddress4();
			$_userID                 = $user->getUserID();
			
			$stmt->bindParam(':email', 				$_email);
			$stmt->bindParam(':sex', 				$_sex);
			$stmt->bindParam(':engSurname', 		$_engSurname);
			$stmt->bindParam(':engMidName', 		$_engMidName);
			$stmt->bindParam(':engName', 			$_engName);
			$stmt->bindParam(':tel', 				$_tel);
			$stmt->bindParam(':address1', 			$_address1);
			$stmt->bindParam(':address2', 			$_address2);
			$stmt->bindParam(':address3', 			$_address3);
			$stmt->bindParam(':address4', 			$_address4);
			$stmt->bindParam(':userID', 			$_userID);
			
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
			$sql = "delete from `notification` n where n.notification_id in 
			(select un.notification_id from user_notification un where un.status = :status and un.update_date = :updateDate)";
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
			$sql = "select food_id, food_category, food_name, price from `food` where food_id in (".$inConditions.") order by food_category, food_name";
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
										
					if($foodRow["food_id"] == $orderDetail4Display->getFoodID()){
						$orderDetail4Display->setFoodCategory($foodRow["food_category"]);
						$orderDetail4Display->setFoodName($foodRow["food_name"]);
						$orderDetail4Display->setPrice($foodRow["price"]);
						
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
	        $sql = "select food_id, food_category, food_name, price from `food` where food_id in (".$inConditions.")";
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
	                
	                if($foodRow["food_id"] == $orderDetail4Display->getFoodID()){
	                    $orderDetail4Display->setFoodCategory($foodRow["food_category"]);
	                    $orderDetail4Display->setFoodName($foodRow["food_name"]);
	                    
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
	        $sql = "select concat(address_1, ',', address_2, ',', address_3, ',', address_4) as address, tel from `unicorn_user` where user_id=:userID";
	        $stmt = $dbconnection->prepare($sql);
	        $paramArray = array(':userID' => $userID);
	        $stmt->execute($paramArray);
	        $fetch = $stmt->fetch();
	        
	        $column_arr = array();
	        $column_arr[] = $fetch['address'];
	        $column_arr[] = $fetch['tel'];
	        
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
	        $sql = "select * from `order` where order_id = :orderID";
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
	        $sql = "select * from `order_detail` where order_id=:orderID";
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
			$stmt = $dbconnection->prepare("insert into `order` (`order_id`, `user_id`, `status`, `delivery_timeslot`, `order_effect_date`,
				`order_expiry_date`, `total_payment_amt`, `total_discount_amt`, `payment_date`, `payment_channel`,
				`credit_card_type`, `credit_card_no`, `credit_card_security_code`, `credit_card_holder_name`,
				`credit_card_expiry_date`, `cheque_no`, `remark`, `create_date`, `update_date`)
				values(NULL, :userID, :status, :deliveryTimeslot, :orderEffectDate,
				:orderExpiryDate, :totalPaymentAmt, :totalDiscountAmt, :paymentDate, :paymentChannel,
				:creditCardType, :creditCardNo, :creditCardSecurityCode, :creditCardHolderName,
				:creditCardExpiryDate, :chequeNo, :remark, :createDate, :updateDate)");
			
			//$stmt->bindParam(':orderID', 					$order->getOrderID()); //auto increased by MySQL database
			
			$_userID                         = $order->getUserID();
			$_status                         = $order->getStatus();
			$_deliveryTimeslot               = $order->getDeliveryTimeslot();
			$_orderEffectDate                = $order->getOrderEffectDate();
			$_orderExpiryDate                = $order->getOrderExpiryDate();
			$_totalPaymentAmt                = $order->getTotalPaymentAmt();
			$_totalDiscountAmt               = $order->getTotalDiscountAmt();
			$_paymentDate                    = $order->getPaymentDate();
			$_paymentChannel                 = $order->getPaymentChannel();
			$_creditCardType                 = $order->getCreditCardType();
			$_creditCardNo                   = $order->getCreditCardNo();
			$_creditCardSecurityCode         = $order->getCreditCardSecurityCode();
			$_creditCardHolderName           = $order->getCreditCardHolderName();
			$_creditCardExpiryDate           = $order->getCreditCardExpiryDate();
			$_chequeNo                       = $order->getChequeNo();
			$_remark                         = $order->getRemark();
			$_createDate                     = $order->getCreateDate();
			$_updateDate                     = $order->getUpdateDate();	
			
			
			$stmt->bindParam(':userID', 					$_userID);
			$stmt->bindParam(':status', 					$_status);
			$stmt->bindParam(':deliveryTimeslot', 			$_deliveryTimeslot);
			$stmt->bindParam(':orderEffectDate', 			$_orderEffectDate);
			$stmt->bindParam(':orderExpiryDate', 			$_orderExpiryDate);
			$stmt->bindParam(':totalPaymentAmt', 			$_totalPaymentAmt);
			$stmt->bindParam(':totalDiscountAmt', 			$_totalDiscountAmt);
			$stmt->bindParam(':paymentDate', 				$_paymentDate);
			$stmt->bindParam(':paymentChannel', 			$_paymentChannel);
			$stmt->bindParam(':creditCardType', 			$_creditCardType);
			$stmt->bindParam(':creditCardNo', 				$_creditCardNo);
			$stmt->bindParam(':creditCardSecurityCode', 	$_creditCardSecurityCode);
			$stmt->bindParam(':creditCardHolderName', 		$_creditCardHolderName);
			$stmt->bindParam(':creditCardExpiryDate', 		$_creditCardExpiryDate);
			$stmt->bindParam(':chequeNo', 					$_chequeNo);
			$stmt->bindParam(':remark', 					$_remark);
			$stmt->bindParam(':createDate', 				$_createDate);
			$stmt->bindParam(':updateDate', 				$_updateDate);		
			
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
			$stmt = $dbconnection->prepare("insert into `order_detail` (`order_id`, `food_id`, `qty`, `payment_amt`,
				`discount_amt`, `create_date`, `update_date`)
				values(:orderID, :foodID, :qty, :paymentAmt,
				:discountAmt, :createDate, :updateDate)");
			
			$_orderID                    = $orderDetail->getOrderID();
			$_foodID                     = $orderDetail->getFoodID();
			$_qty                        = $orderDetail->getQty();
			$_paymentAmt                 = $orderDetail->getPaymentAmt();
			$_discountAmt                = $orderDetail->getDiscountAmt();
			$_createDate                 = $orderDetail->getCreateDate();
			$_updateDate                 = $orderDetail->getUpdateDate();
			
			$stmt->bindParam(':orderID', 					$_orderID);
			$stmt->bindParam(':foodID', 					$_foodID);
			$stmt->bindParam(':qty', 						$_qty);
			$stmt->bindParam(':paymentAmt', 				$_paymentAmt);
			$stmt->bindParam(':discountAmt', 				$_discountAmt);
			$stmt->bindParam(':createDate', 				$_createDate);
			$stmt->bindParam(':updateDate', 				$_updateDate);
			
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
			$stmt = $dbconnection->prepare("insert into `notification` (`notification_id`, `type`, `subject`, `content`,
				`create_date`, `update_date`)
				values(NULL, :type, :subject, :content,
				:createDate, :updateDate)");
			
			//$stmt->bindParam(':notification_id', 			$notification->getNotificationID()); //automatically increased by MySQL DB
			$_type                         = $notification->getType();
			$_subject                      = $notification->getSubject();
			$_content                      = $notification->getContent();
			$_createDate                   = $notification->getCreateDate();
			$_updateDate                   = $notification->getUpdateDate();
			
			$stmt->bindParam(':type', 						$_type);
			$stmt->bindParam(':subject', 					$_subject);
			$stmt->bindParam(':content', 					$_content);
			$stmt->bindParam(':createDate', 				$_createDate);
			$stmt->bindParam(':updateDate', 				$_updateDate);

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
			$stmt = $dbconnection->prepare("insert into `user_notification` (`notification_id`, `user_id`, `status`, 
				`create_date`, `update_date`)
				values(:notificationID, :userID, :status,
				:createDate, :updateDate)");
			
			$_notificationID          = $userNotification->getNotificationID();
			$_userID                  = $userNotification->getUserID();
			$_status                  = $userNotification->getStatus();
			$_createDate              = $userNotification->getCreateDate();
			$_updateDate              = $userNotification->getUpdateDate();
			
			$stmt->bindParam(':notificationID', 			$_notificationID);
			$stmt->bindParam(':userID', 					$_userID);
			$stmt->bindParam(':status', 					$_status);
			$stmt->bindParam(':createDate', 				$_createDate);
			$stmt->bindParam(':updateDate', 				$_updateDate);
			
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
	        $sql = "select order_id from `order` where user_id=:userID order by order_id desc limit 5";
	        $stmt = $dbconnection->prepare($sql);
	        $paramArray = array(':userID' => $userID);
	        $stmt->execute($paramArray);
	        $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
	        
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
	        $stmt = $dbconnection->prepare("insert into `comment` (`comment_id`, `user_id`, `order_id`,
                `rating`,`content`,
				`create_date`, `update_date`)
				values(NULL, :userID, :orderID,
                :rating, :content,
				:createDate, :updateDate)");
	        
	        $_userID                    = $commentObj->getUserID();
	        $_orderID                   = $commentObj->getOrderID();
	        $_rating                    = $commentObj->getRating();
	        $_content                   = $commentObj->getContent();
	        $_createDate                = $commentObj->getCreateDate();
	        $_updateDate                = $commentObj->getUpdateDate();
	        
	        $stmt->bindParam(':userID', 					$_userID);
	        $stmt->bindParam(':orderID', 					$_orderID);
	        $stmt->bindParam(':rating', 		            $_rating);
	        $stmt->bindParam(':content', 					$_content);
	        $stmt->bindParam(':createDate', 				$_createDate);
	        $stmt->bindParam(':updateDate', 				$_updateDate);
	        
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
			$sql = "select * from `comment` where user_id=:userID order by comment_id desc limit 5";
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
	
	//[START] Notification function
	function db_select_notification_by_UserID($userID)
	{
		try {
			$dbconnection = db_connect();
			
			//Prepared SQL statement
			$sql = "select un.notification_id, un.create_date, un.status, n.subject, n.content, n.type 
					from `user_notification` un, `notification` n 
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
			$sql = "update `user_notification` set status = :status, update_date = :updateDate where notification_id = :notificationID and user_id = :userID";
			$stmt = $dbconnection->prepare($sql);
			
			$_userID                    = $notificationObj->getUserID();
			$_notificationID            = $notificationObj->getNotificationID();
			$_status                    = $notificationObj->getStatus();
			$_updateDate                = $notificationObj->getUpdateDate();
			
			$stmt->bindParam(':userID', 					$_userID);
			$stmt->bindParam(':notificationID', 			$_notificationID);
			$stmt->bindParam(':status', 		            $_status);
			$stmt->bindParam(':updateDate', 				$_updateDate);
			
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
					from `user_notification` 
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
	//[END] Notification function
		
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
	
	//[START] Recommendation home functions
	function db_select_all_food_category_name()
	{
	    try {
	        $dbconnection = db_connect();
	        $stmt = $dbconnection->prepare("SELECT distinct `food_category` FROM `food` where `available` = 'Y'");
	        $stmt->execute();
	        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	        $dbconnection = null;
	        return $results;
	        
	    } catch (PDOException $e) {
	        go_to_exception_page("db_select_all_food_category_name() -> ".$e);
	    }
	    
	    $dbconnection = null;
	}
	//[END] Recommendation home functions
	
	//[START] Admin functions
	function db_select_food_by_FoodCat_FoodName($foodCat, $foodName)
	{
	    try {
	        $dbconnection = db_connect();
	        	        
	        //Prepared SQL statement
	        $sql = "select * from `food` where food_category=:foodCat and food_name=:foodName";
	        $stmt = $dbconnection->prepare($sql);
	        $paramArray = array(':foodCat' => $foodCat, ':foodName' => $foodName);
	        $stmt->execute($paramArray);
	        
	        return $stmt->rowCount();
	    }catch(PDOException $e){
	        go_to_exception_page("db_select_food_by_FoodCat_FoodName() -> ".$e);
	    }
	    
	    //close db connection to release memory
	    $dbconnection = null;
	}
	
	
	function db_insert_food($foodObj)
	{
	    try {
	        $dbconnection = db_connect();
	        
	        //Prepared SQL statement
	        $stmt = $dbconnection->prepare("insert into `food` (`food_id`, `food_category`, `food_name`, `available`, `price`, `discount`,
				`discount_effect_date`, `discount_expiry_date`, `img_path`, `remark`, `create_date`, `update_date`)
				values (NULL, :foodCat, :foodName, :available, :price, :discount, 
                        :discDffDate, :discExpDate, :imgPath, :remark, :createDate, :updateDate)");
	        
	        $defaultImgPath = "/resources/foodImg/defaultFood.jpg";
	        
	        $_foodCat                   = $foodObj->getFoodCategory();
	        $_foodName                  = $foodObj->getFoodName();
	        $_available                 = $foodObj->getAvailable();
	        $_price                     = $foodObj->getPrice();
	        $_discount                  = $foodObj->getDiscount();
	        $_discDffDate               = $foodObj->getDiscountEffectDate();
	        $_discExpDate               = $foodObj->getDiscountExpiryDate();
	        $_imgPath                   = $foodObj->getImgPath();
	        $_remark                    = $foodObj->getRemark();
	        $_createDate                = $foodObj->getCreateDate();
	        $_updateDate                = $foodObj->getUpdateDate();
	        
	        $stmt->bindParam(':foodCat', 			$_foodCat);
	        $stmt->bindParam(':foodName', 			$_foodName);
	        $stmt->bindParam(':available', 		    $_available);
	        $stmt->bindParam(':price', 		        $_price);
	        $stmt->bindParam(':discount', 			$_discount);
	        $stmt->bindParam(':discDffDate', 		$_discDffDate);
	        $stmt->bindParam(':discExpDate', 		$_discExpDate);
	        $stmt->bindParam(':imgPath', 			$_imgPath);
	        $stmt->bindParam(':remark', 			$_remark);
	        $stmt->bindParam(':createDate', 		$_createDate);
	        $stmt->bindParam(':updateDate', 		$_updateDate);
	        
	        $stmt->execute();
	        $result = $dbconnection->lastInsertId();
	        
	        return $result;
	    }catch(PDOException $e){
	        go_to_exception_page("db_insert_food() -> ".$e);
	    }
	    
	    //close db connection to release memory
	    $dbconnection = null;
	}
	
	function db_insert_food_tag($foodTag)
	{
	    try {
	        $dbconnection = db_connect();
	        
	        //Prepared SQL statement
	        $stmt = $dbconnection->prepare("insert into `food_tag` (`tag_id`, `food_id`, `tag_des`, `create_date`, `update_date`)
				values (NULL, :foodID, :tagDes, :createDate, :updateDate)");
	        	        	        
	        $_foodID                    = $foodTag->getFoodID();
	        $_tagDes                    = $foodTag->getTagDes();
	        $_createDate                = $foodTag->getCreateDate();
	        $_updateDate                = $foodTag->getUpdateDate();
	        
	        $stmt->bindParam(':foodID', 			$_foodID);
	        $stmt->bindParam(':tagDes', 			$_tagDes);
	        $stmt->bindParam(':createDate', 		$_createDate);
	        $stmt->bindParam(':updateDate', 		$_updateDate);
	        
	        $stmt->execute();
	        $result = $dbconnection->lastInsertId();
	        
	        return $result;
	    }catch(PDOException $e){
	        go_to_exception_page("db_insert_food_tag() -> ".$e);
	    }
	    
	    //close db connection to release memory
	    $dbconnection = null;
	}
	//[END] Admin functions
?>