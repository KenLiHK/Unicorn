<?php

	//[START] Database table entity class
	class User {    
		private $userID;
		private $sex;
		private $engSurname;
		private $engMidName;
		private $engName;
		private $email;
		private $tel;
		private $address1;
		private $address2;
		private $address3;
		private $address4;
		private $encrypttedPassword;
		private $regToken;
				
		public function __construct($userID, $sex, $engSurname, $engMidName, $engName, 
									$email, $tel, $address1, $address2, $address3, $address4, $encrypttedPassword, $regToken)
		{
			$this->userID 				= $userID;
			$this->sex 					= $sex;
			$this->engSurname 			= $engSurname;
			$this->engMidName 			= $engMidName;
			$this->engName 				= $engName;
			$this->email 				= $email;
			$this->tel 					= $tel;
			$this->address1 			= $address1;
			$this->address2 			= $address2;
			$this->address3 			= $address3;
			$this->address4 			= $address4;
			$this->encrypttedPassword 	= $encrypttedPassword;
			$this->regToken 			= $regToken;
		}

		public function getUserID() { 
			return $this->userID; 
		}

		public function getSex() { 
			return $this->sex; 
		}

		public function getEngSurname() { 
			return $this->engSurname; 
		}

		public function getEngMidName() { 
			return $this->engMidName; 
		}

		public function getEngName() { 
			return $this->engName; 
		}

		public function getEmail() { 
			return $this->email; 
		}

		public function getTel() { 
			return $this->tel; 
		}

		public function getAddress1() { 
			return $this->address1; 
		}

		public function getAddress2() { 
			return $this->address2; 
		}

		public function getAddress3() { 
			return $this->address3; 
		}

		public function getAddress4() { 
			return $this->address4; 
		}

		public function getEncrypttedPassword() { 
			return $this->encrypttedPassword; 
		}

		public function getRegToken() { 
			return $this->regToken; 
		}	
	}
	
	class Order {    
		private $orderID;
		private $userID;
		private $status;
		private $orderEffectDate;
		private $orderExpiryDate;
		private $totalPaymentAmt;
		private $totalDiscountAmt;
		private $paymentDate;
		private $paumentChannel;
		private $address3;
		private $address4;
		private $encrypttedPassword;
		private $regToken;
				
		public function __construct($userID, $sex, $engSurname, $engMidName, $engName, 
									$email, $tel, $address1, $address2, $address3, $address4, $encrypttedPassword, $regToken)
		{
			$this->userID 				= $userID;
			$this->sex 					= $sex;
			$this->engSurname 			= $engSurname;
			$this->engMidName 			= $engMidName;
			$this->engName 				= $engName;
			$this->email 				= $email;
			$this->tel 					= $tel;
			$this->address1 			= $address1;
			$this->address2 			= $address2;
			$this->address3 			= $address3;
			$this->address4 			= $address4;
			$this->encrypttedPassword 	= $encrypttedPassword;
			$this->regToken 			= $regToken;
		}

		public function getUserID() { 
			return $this->userID; 
		}

		public function getSex() { 
			return $this->sex; 
		}

		public function getEngSurname() { 
			return $this->engSurname; 
		}

		public function getEngMidName() { 
			return $this->engMidName; 
		}

		public function getEngName() { 
			return $this->engName; 
		}

		public function getEmail() { 
			return $this->email; 
		}

		public function getTel() { 
			return $this->tel; 
		}

		public function getAddress1() { 
			return $this->address1; 
		}

		public function getAddress2() { 
			return $this->address2; 
		}

		public function getAddress3() { 
			return $this->address3; 
		}

		public function getAddress4() { 
			return $this->address4; 
		}

		public function getEncrypttedPassword() { 
			return $this->encrypttedPassword; 
		}

		public function getRegToken() { 
			return $this->regToken; 
		}	
	} 	
	//[END] Database table entity class
	
	//[START] Registration function
	function sendEmail($Receiver, $Subject, $Content)
	{
		$Sender = "From: cs5281unicorn_admin@unicorn.com";

		try{
			mail($Receiver, $Subject, $Content, $Sender);
			//echo "Send email success!!";
		} catch(Exception $e){
			echo "Send email failed: " . $e->getMessage();
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
		$userID = $_user_in_db[0];
		$email = $_user_in_db[1];
		
		if(isset($_user_in_db)){
			$_updated_row_count = db_update_user_lastLoginTime_by_Email($email);
			
			if(isset($_updated_row_count) && $_updated_row_count > 0){
				prepare_login_session($userID, $email);
				return "true";	//login success
			}else{
				return "false";	//login failure
			}		
		}else{
			return "false";
		}
	}

	function prepare_login_session($userID, $email) {
		session_start();
		// Store Session Data
		$_SESSION['login_user_id']= $userID;
		$_SESSION['login_user_email']= $email;	
		$_SESSION['login_date_time']= time(); //Current date time in second format
		$_SESSION['last_request_time']= time();
	}

	function check_session_timeout() {
		$timeout = 1800;  //30 mins
		if (isset($_SESSION['last_request_time']) && (time() - $_SESSION['last_request_time'] > $timeout)) {
			// When last request time was more than 30 minutes ago, clear all session variables and destroy all sessions.
			session_unset();
			session_destroy();
		}else{
			$_SESSION['last_request_time'] = time(); // update last activity time stamp
		}		
	}

	function refresh_session() {
		if (isset($_SESSION['last_request_time'])) {
			$_SESSION['last_request_time'] = time(); // refresh session with current time
		}
	}

	function logout() {
			session_unset(); // clear all session variables
			session_destroy();
	}		
	//[END] Login and Logout function
	
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