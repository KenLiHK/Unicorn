<?php
	include_once("database.php");

	//[START] Registration function
	function sendEmail($Receiver, $Subject, $Content)
	{
		$Sender = "From: cs5281unicorn_admin@unicorn.com";

		try{
			mail($Receiver, $Subject, $Content, $Sender);
			//echo "Send email success!!";
		} catch(Exception $e){
		    //echo "<br>" . $e->getMessage();
		    go_to_exception_page("sendEmail() -> ".$e->getMessage());
		}
	}

	function optimizateInput($data) {
		if(isset($data)){
			$data = trim($data);
			//$data = stripslashes($data);
			//$data = htmlspecialchars($data);		
		}
		return $data;
	}
	
	//This function will be called by Registration function email validation link
	function login_after_activation($email, $regToken) {
		$_updated_row_count = db_update_user_lastLoginTime($email, $regToken);
		
		if(isset($_updated_row_count)){
			return true;	//login success
		}else{
			return false;	//login failure
		}		
	}
	//[END] Registration function
	
	//[START] Login and Logout function
	function login_by_userId_or_email_password($userIdOrEmail, $password) {
		$_user_in_db = array();
		$_user_in_db = db_select_user_by_UserID_or_Email_Password($userIdOrEmail, $password);
		$userID      = $_user_in_db[0];
		$email       = $_user_in_db[1];
		$privilege   = $_user_in_db[2];
		
		if(isset($_user_in_db)){
		    //User ID and email is case sensitive
		    if($userIdOrEmail != $userID && $userIdOrEmail != $email){
		        return "false";	//login failure
		    }
		    
			$_updated_row_count = db_update_user_lastLoginTime_by_Email($email);
			
			if(isset($_updated_row_count) && $_updated_row_count > 0){
				prepare_login_session($userID, $email, $privilege);
				return "true";	//login success
			}else{
				return "false";	//login failure
			}		
		}else{
			return "false";
		}
	}

	function login_by_userId_or_email_passwordFake($userIdOrEmail, $password) {
		$_user_in_db = array();
		$_user_in_db = db_select_user_by_UserID_or_Email_PasswordFake($userIdOrEmail, $password);
		$userID      = $_user_in_db[0];
		$email       = $_user_in_db[1];
		$privilege   = $_user_in_db[2];
		
		if(isset($_user_in_db)){
		    //User ID and email is case sensitive
		    if($userIdOrEmail != $userID && $userIdOrEmail != $email){
		        return "false";	//login failure
		    }
		    
			$_updated_row_count = db_update_user_lastLoginTime_by_Email($email);
			
			if(isset($_updated_row_count) && $_updated_row_count > 0){
				prepare_login_session($userID, $email, $privilege);
				return "true";	//login success
			}else{
				return "false";	//login failure
			}
		}else{
			return "false";
		}
	}
	
	function prepare_login_session($userID, $email, $privilege) {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		
		// Store Session Data
		$_SESSION['login_user_id']= $userID;
		$_SESSION['login_user_email']= $email;
		$_SESSION['login_user_privilege']= $privilege;	
		$_SESSION['login_date_time']= time(); //Current date time in second format
		$_SESSION['last_request_time']= time();
	}

	function check_session_timeout() {
	    if(checkUserLogon()){
    		$timeout = 3000;  //30 mins
    		if (session_status() == PHP_SESSION_NONE) {
    			session_start();
    		}
    		
    		if (isset($_SESSION['last_request_time']) && (time() - $_SESSION['last_request_time'] > $timeout)) {
    			// When last request time was more than 30 minutes ago, clear all session variables and destroy all sessions.
    			session_unset();
    			session_destroy();
    			
    			//go back to cart.php
    			$logoutMsg = "Session is timeout and logout automatically.";
    			header('Location: ../login/logout.php?logoutMsg=' . $logoutMsg);
    			exit;   
    		}else{
    			$_SESSION['last_request_time'] = time(); // update last activity time stamp
    		}
	    }
	}

	function refresh_session() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		
		if (isset($_SESSION['last_request_time'])) {
			$_SESSION['last_request_time'] = time(); // refresh session with current time
		}
	}

	function logout() {
			session_unset(); // clear all session variables
			session_destroy();
	}	
	
	function checkLogon() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		
		if(!isset($_SESSION['login_user_id'])){			
			$_msg = "Please login first!";
			go_to_exception_page($_msg);
			die();
		}
	}	
	
	function checkAdmin() {
	    if (session_status() == PHP_SESSION_NONE) {
	        session_start();
	    }
	    
	    if(!isset($_SESSION['login_user_privilege']) || $_SESSION['login_user_privilege'] != "A"){
	        $_msg = "Page access denied!";
	        go_to_exception_page($_msg);
	        die();
	    }
	}
	
	function checkUserLogon(){
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		
		//Double check if user logon
		if(isset($_SESSION['login_user_id'])){
			return true;
		}
		
		return false;
	}
	//[END] Login and Logout function
	
	//[START] User Profile function
	function select_user_all_info_by_UserID($userID){
		$user = db_select_user_all_info_by_UserID($userID);
		return $user;
	}
	//[END] User Profile function
	
	//[START] Place order function
	function prepare_order_detail_for_display($selectedFoodMapParam) {
		if (session_status() == PHP_SESSION_NONE) {
	    	session_start();
		}
		
	    /*
	    //Double check if user logon
	    $userID = $_SESSION['login_user_id'];
	    if(!isset($userID)){
	        return "";
	    }
	    */
	    
	    /*
	    $selectedFoodMap store the ID of food and corresponding quantity selected by customer
	    It is a 2 dimensional array,
	    [arrayIndex][foodID][Qty] 
	    e.g. 
	    [0][foodID->11][qty->3] 
	    [1][foodID->13][qty->2]
	    [2][foodID->21][qty->1]
	    */
	    //$selectedFoodMap = $_SESSION['selected_food_map'];
		$selectedFoodMap = $selectedFoodMapParam;
		
	    /*
	    //START: For testing
	    $selectedFood1 = array("F1",2);
	    $selectedFood2 = array("F2",7);
	    $selectedFood3 = array("F3",6);
	    
	    $selectedFoodMap = array($selectedFood1, $selectedFood2, $selectedFood3);
	    //END: For testing
	    */
	    
	    if(!isset($selectedFoodMap)){
	        return ""; //Customer has no selected food
	    }

	    $orderDetailInSession_array = [];  
	    
	    for ($row = 0; $row < count($selectedFoodMap); $row++) {
	    	//for ($col = 0; $col < 2; $col++) {
	    	$foodID = $selectedFoodMap[$row]["foodID"];
	    	$qty = $selectedFoodMap[$row]["qty"];
	    	$orderDetail4Display = new OrderDetail4Display("", $foodID, "", "", "", $qty, "");
	    	//echo "aa:".$orderDetail4Display->getFoodID();
	    	$orderDetailInSession_array[] = $orderDetail4Display;
	    	//}
	    }
	    
	    /*
	     for ($col = 0; $col < count($orderDetail4Display_array, 1); $col++) {
	     $orderDetail4Display = $orderDetail4Display_array[$col];
	     echo "a:".($orderDetail4Display->getFoodID());
	     echo "b:".($orderDetail4Display->getQty());
	     }
	     */
	    
	    $orderDetail4Display_array = [];
	    //select food category, food name and food price to display on screen for user verification
	    if(isset($orderDetailInSession_array) && count($orderDetailInSession_array) > 0){
	        $orderDetail4Display_array = db_select_food_by_FoodID($orderDetailInSession_array);
	    }
	    unset($orderDetailInSession_array);
	    return $orderDetail4Display_array;
	}
	
	function prepare_placed_order_detail_for_display($_placedOrderID) {	   	    
	    if(!isset($_placedOrderID)){
	        return ""; //Customer has no selected food
	    }
	    $_orderDetailArrayInDB = get_order_detail_by_OrderID($_placedOrderID);
	    
	    if(!isset($_orderDetailArrayInDB) || count($_orderDetailArrayInDB) == 0){
	        return "";
	    }
	    
	    $orderDetail4DisplayTmp_array = [];
	    
	    for ($row = 0; $row < count($_orderDetailArrayInDB); $row++) {
	        // OrderDetail4Display($orderID, $foodID, $foodCategory, $foodName, $price, $qty, $subtotal)

	        $orderDetail4Display = new OrderDetail4Display($_placedOrderID, $_orderDetailArrayInDB[$row]->getFoodID(), "", "", 
	            $_orderDetailArrayInDB[$row]->getPaymentAmt(), $_orderDetailArrayInDB[$row]->getQty(), "");
	        
	        array_push($orderDetail4DisplayTmp_array, $orderDetail4Display);
	    }
	    
	    $orderDetail4Display_array = [];
	    //select food category, food name and food price to display on screen for user verification
	    if(isset($orderDetail4DisplayTmp_array) && count($orderDetail4DisplayTmp_array) > 0){
	        $orderDetail4Display_array = db_select_food_info_by_FoodID($orderDetail4DisplayTmp_array);
	    }
	    unset($orderDetail4DisplayTmp_array);
	    return $orderDetail4Display_array;
	}
		
	function place_order($order, $orderDetailList) {
		$_orderID = db_insert_order($order);
		$now = date("Y-m-d");
		if(isset($_orderID)){
    		for ($row = 0; $row < count($orderDetailList); $row++) {
    			$orderDetail = $orderDetailList[$row];
    			$orderDetail->setOrderID($_orderID);
    			db_insert_order_detail($orderDetail);
    		}
		}
		
		//add notification
		$nSubject = "Order ID:" . $_orderID . " Placed order successfully!";
		$nContent = "Order ID:" . $_orderID . " Placed order successfully on " . $now . "!";
		$notification = new Notification("", "NT11", $nSubject, $nContent, $order->getCreateDate(), $order->getCreateDate());
		$_notificationID = db_insert_notification($notification);
		
		$userNotification = new UserNotification($_notificationID, $order->getUserID(), "NS01", $order->getCreateDate(), $order->getCreateDate());
		db_insert_user_notification($userNotification);
		return $_orderID;
	}
	
	function get_order_info_by_orderID($placedOrderID) {	  	    
	    $_orderColumnArray = db_select_order_by_OrderID($placedOrderID);

	    $_orderInDB = new Order(
	        $_orderColumnArray["order_id"],                    $_orderColumnArray["user_id"],                  $_orderColumnArray["status"],   
	        $_orderColumnArray["delivery_timeslot"],           $_orderColumnArray["order_effect_date"],        $_orderColumnArray["order_expiry_date"], 
	        $_orderColumnArray["total_payment_amt"],           $_orderColumnArray["total_discount_amt"],       $_orderColumnArray["payment_date"], 
	        $_orderColumnArray["payment_channel"],             $_orderColumnArray["credit_card_type"],         $_orderColumnArray["credit_card_no"], 
	        $_orderColumnArray["credit_card_security_code"],   $_orderColumnArray["credit_card_holder_name"],  $_orderColumnArray["credit_card_expiry_date"], 
	        $_orderColumnArray["cheque_no"],                   $_orderColumnArray["remark"],                   $_orderColumnArray["create_date"], 
	        $_orderColumnArray["update_date"]); 

	    return $_orderInDB;
	}
	
	function get_order_detail_by_OrderID($placedOrderID) {
	    $_orderDetailArrayInDB = [];
	    $_orderDetailArray = db_select_order_detail_by_OrderID($placedOrderID);	      
	    
	    foreach( $_orderDetailArray as $_orderDetailTmp ) {
    	    $_orderDetailInDB = new OrderDetail(
    	        $_orderDetailTmp["order_id"],        $_orderDetailTmp["food_id"],      $_orderDetailTmp["qty"],          $_orderDetailTmp["payment_amt"], 
    	        $_orderDetailTmp["discount_amt"],    $_orderDetailTmp["create_date"],  $_orderDetailTmp["update_date"]);
    	    
    	    array_push($_orderDetailArrayInDB, $_orderDetailInDB);
	    }
	    
	    return $_orderDetailArrayInDB;
	}
	
	
	function checkOutstandingOrderInSession()
	{
		$count = countOutstandingOrderedFoodInSession();
		if($count > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function countOutstandingOrderedFoodInSession()
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		
		$countAll = 0;
		if(isset($_SESSION['selected_food_map'])){
			$_selectedFoodMap_in_session = $_SESSION['selected_food_map'];
			
			for ($row = 0; $row < count($_selectedFoodMap_in_session); $row++) {
				$qty = $_selectedFoodMap_in_session[$row]["qty"];
				$countAll = $countAll + $qty;
			}
		}
		return $countAll;
	}
	//[END] Place order function
	
	//[START] Comment function
	function get_order_list_by_userID($userID){
	    return db_select_order_by_UserID($userID);
	}
	
	function save_comment($commentObj){
	    return db_insert_comment($commentObj);
	}
	
	//[END] Comment function
	
	//[START] Notification function
	function get_notification_list_by_userID($userID){
		return db_select_notification_by_UserID($userID);
	}
	
	function update_notification($notificationObj){
		return db_update_notification($notificationObj);
	}
	
	function get_notification_count_by_userID($userID){
	    return db_select_notification_count_by_UserID($userID);
	}
	//[END] Notification function
	
	//[START] Admin function
	function count_Food_By_Food_Cat_Name($foodCate, $foodName){
	    
	    return db_select_food_by_FoodCat_FoodName($foodCate, $foodName);
	}
	
	function add_food($foodObj){
	    
	    return db_insert_food($foodObj);
	}
	
	function add_food_tag($foodTag){
	    return db_insert_food_tag($foodTag);
	}
	//[END] Admin function
	
	/*
	test_smtp();

	function test_smtp()
	{
		$to = "customer1@gmail.com";
		$subject = "Food order 1";
		$txt = "Total: $1,500";
		$headers = "From: cs5281unicorn_admin@unicorn.com";

		try{
			mail($to,$subject,$txt,$headers);
			echo "Success!";
		} catch(Exception $e){
			echo "Fail :(";
		}
	}
	*/

?>