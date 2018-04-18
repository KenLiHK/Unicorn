<?php
	include_once("init.php");
	
	//[START] Database table entity class
	class User {    
		private $userID;
		private $imgPath;
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
				
		public function __construct($userID, $imgPath, $sex, $engSurname, $engMidName, $engName, 
									$email, $tel, $address1, $address2, $address3, $address4, $encrypttedPassword, $regToken)
		{
			$this->userID 				= $userID;
			$this->imgPath 				= $imgPath;
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

		public function getImgPath() {
			return $this->imgPath;
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
		private $orderID; //Increased automatically by MySQL database, no need to set this value when insert new record in Order table
		private $userID;
		private $status;
		private $deliveryTimeslot;
		private $orderEffectDate;
		private $orderExpiryDate;
		private $totalPaymentAmt;
		private $totalDiscountAmt;
		private $paymentDate;
		private $paymentChannel;
		private $creditCardType;
		private $creditCardNo;
		private $creditCardSecurityCode;
		private $creditCardHolderName;
		private $creditCardExpiryDate;
		private $chequeNo;
		private $remark;
		private $createDate;
		private $updateDate;
				
		public function __construct($orderID, $userID, $status, $deliveryTimeslot, $orderEffectDate, $orderExpiryDate, $totalPaymentAmt, $totalDiscountAmt, 
		    $paymentDate, $paymentChannel, $creditCardType, $creditCardNo, $creditCardSecurityCode, $creditCardHolderName, 
		    $creditCardExpiryDate, $chequeNo, $remark, $createDate, $updateDate)
		{
		    $this->orderID				  	  = $orderID;
		    $this->userID                     = $userID;
		    $this->status                     = $status;
		    $this->deliveryTimeslot			  = $deliveryTimeslot;
		    $this->orderEffectDate            = $orderEffectDate;
		    $this->orderExpiryDate            = $orderExpiryDate;
		    $this->totalPaymentAmt            = $totalPaymentAmt;
		    $this->totalDiscountAmt           = $totalDiscountAmt;
		    $this->paymentDate                = $paymentDate;
		    $this->paymentChannel             = $paymentChannel;
		    $this->creditCardType             = $creditCardType;
		    $this->creditCardNo               = $creditCardNo;
		    $this->creditCardSecurityCode     = $creditCardSecurityCode;
		    $this->creditCardHolderName       = $creditCardHolderName;
		    $this->creditCardExpiryDate       = $creditCardExpiryDate;
		    $this->chequeNo                   = $chequeNo;
		    $this->remark                     = $remark;
		    $this->createDate                 = $createDate;
		    $this->updateDate                 = $updateDate;
		}

		public function getOrderID() {
		    return $this->orderID;
		}
		
		public function getUserID() { 
			return $this->userID; 
		}

		public function getStatus() { 
		    return $this->status; 
		}

		public function getDeliveryTimeslot() {
			return $this->deliveryTimeslot;
		}
		
		public function getOrderEffectDate() { 
		    return $this->orderEffectDate; 
		}

		public function getOrderExpiryDate() { 
		    return $this->orderExpiryDate; 
		}

		public function getTotalPaymentAmt() { 
		    return $this->totalPaymentAmt; 
		}

		public function getTotalDiscountAmt() { 
		    return $this->totalDiscountAmt; 
		}

		public function getPaymentDate() { 
		    return $this->paymentDate; 
		}

		public function getPaymentChannel() { 
		    return $this->paymentChannel; 
		}

		public function getCreditCardType() { 
		    return $this->creditCardType; 
		}

		public function getCreditCardNo() { 
		    return $this->creditCardNo; 
		}

		public function getCreditCardSecurityCode() { 
		    return $this->creditCardSecurityCode; 
		}

		public function getCreditCardHolderName() { 
		    return $this->creditCardHolderName; 
		}

		public function getCreditCardExpiryDate() { 
		    return $this->creditCardExpiryDate; 
		}

		public function getChequeNo() {
		    return $this->chequeNo;
		}	
		
		public function getRemark() {
		    return $this->remark;
		}	
		
		public function getCreateDate() {
		    return $this->createDate;
		}	
		
		public function getUpdateDate() {
		    return $this->updateDate;
		}	
	}
	
	class OrderDetail {
	    private $orderID;
	    private $foodID;
	    private $qty;
	    private $paymentAmt;
	    private $discountAmt;	   
	    private $createDate;
	    private $updateDate;
	    
	    public function __construct($orderID, $foodID, $qty, $paymentAmt, $discountAmt, $createDate, $updateDate)
	    {
	        $this->orderID 					  = $orderID;
	        $this->foodID                     = $foodID;
	        $this->qty                        = $qty;
	        $this->paymentAmt                 = $paymentAmt;
	        $this->discountAmt                = $discountAmt;
	        $this->createDate                 = $createDate;
	        $this->updateDate                 = $updateDate;	       
	    }
	    
	    public function getOrderID() {
	       return $this->orderID;
	    }
	    
	    public function getFoodID() {
	        return $this->foodID;
	    }
	    
	    public function getQty() {
	        return $this->qty;
	    }
	    
	    public function getPaymentAmt() {
	        return $this->paymentAmt;
	    }
	    
	    public function getDiscountAmt() {
	        return $this->discountAmt;
	    }	    	    
	    
	    public function getCreateDate() {
	        return $this->createDate;
	    }
	    
	    public function getUpdateDate() {
	        return $this->updateDate;
	    }
	    
	    public function setOrderID($orderID) {
	    	$this->orderID= $orderID;
	    }
	}
	
	class OrderDetail4Display {
	    private $orderID;
	    private $foodID;
	    private $foodCategory;
	    private $foodName;
	    private $price;
	    private $qty;
	    private $subtotal;
	    
	    public function __construct($orderID, $foodID, $foodCategory, $foodName, $price, $qty, $subtotal)
	    {
	        $this->orderID 					  = $orderID;
	        $this->foodID                     = $foodID;
	        $this->foodCategory               = $foodCategory;
	        $this->foodName                   = $foodName;
	        $this->price                      = $price;
	        $this->qty                        = $qty;
	        $this->subtotal                   = $subtotal;
	    }
	    
	    public function getOrderID() {
	        return $this->orderID;
	    }
	    
	    public function getFoodID() {
	        return $this->foodID;
	    }
	    
	    public function getFoodCategory() {
	        return $this->foodCategory;
	    }
	    
	    public function getFoodName() {
	        return $this->foodName;
	    }
	    
	    public function getPrice() {
	        return $this->price;
	    }
	    
	    public function getQty() {
	        return $this->qty;
	    }
	    
	    public function getSubtotal() {
	        return $this->subtotal;
	    }
	    
	    public function setOrderID($orderID) {
	    	$this->orderID= $orderID;
	    }
	    
	    public function setFoodID($foodID) {
	    	$this->foodID= $foodID;
	    }
	    
	    public function setFoodCategory($foodCategory) {
	    	$this->foodCategory= $foodCategory;
	    }
	    
	    public function setFoodName($foodName) {
	    	$this->foodName= $foodName;
	    }
	    
	    public function setPrice($price) {
	    	$this->price= $price;
	    }
	    
	    public function setQty($qty) {
	    	$this->qty= $qty;
	    }
	    
	    public function setSubtotal($subtotal) {
	    	$this->subtotal= $subtotal;
	    }
	}
	
	class Food {
	    private $foodID;
	    private $foodCategory;
	    private $foodName;
	    private $available;
	    private $price;
	    private $discount;
	    private $discountEffectDate;
	    private $discountExpiryDate;
	    private $imgPath;
	    private $remark;
	    private $createDate;
	    private $updateDate;
	    
	    public function __construct()
	    {
	    	$a = func_get_args(); 							// Get number of functions defined in the class
	    	$i = func_num_args(); 							// Get number of parameters passed in the constructor, e.g. 1 or 12 parameters
	    	if (method_exists($this,$f='__construct'.$i)) { // Check if the constructor exist. e.g. is construct12 exist?
	    		call_user_func_array(array($this,$f),$a);	// Call the construct12 method and pass the parameters array into the method	
	    	}
	    }
	    
	    public function __construct1($foodID)
	    {
	    	$this->foodID 					  = $foodID;
	    }
	   	    
	    public function __construct12($foodID, $foodCategory, $foodName, $available, $price, $discount, $discountEffectDate, $discountExpiryDate, 
	        $imgPath, $remark, $createDate, $updateDate)
	    {
	        $this->foodID 					  = $foodID;
	        $this->foodCategory               = $foodCategory;
	        $this->foodName                   = $foodName;
	        $this->available                  = $available;
	        $this->price                      = $price;
	        $this->discount                   = $discount;
	        $this->discountEffectDate 		  = $discountEffectDate;
	        $this->discountExpiryDate         = $discountExpiryDate;
	        $this->imgPath                    = $imgPath;
	        $this->remark                     = $remark;
	        $this->createDate                 = $createDate;
	        $this->updateDate                 = $updateDate;
	    }
	    	    
	    public function getFoodID() {
	        return $this->foodID;
	    }
	    
	    public function setFoodID($foodID) {
	    	$this->foodID= $foodID;
	    }
	    
	    public function getFoodCategory() {
	        return $this->foodCategory;
	    }
	    
	    public function setFoodCategory($foodCategory) {
	    	$this->foodCategory= $foodCategory;
	    }
	    
	    public function getFoodName() {
	        return $this->foodName;
	    }
	    
	    public function setFoodName($foodName) {
	    	$this->foodName= $foodName;
	    }
	    
	    public function getAvailable() {
	        return $this->available;
	    }
	    
	    public function setAvailable($available) {
	    	$this->available= $available;
	    }
	    
	    public function getPrice() {
	        return $this->price;
	    }

	    public function setPrice($price) {
	    	$this->price= $price;
	    }
	    
	    public function getDiscount() {
	        return $this->discount;
	    }
	    
	    public function setDiscount($discount) {
	    	$this->discount= $discount;
	    }
	    
	    public function getDiscountEffectDate() {
	        return $this->discountEffectDate;
	    }
	    
	    public function setDiscountEffectDate($discountEffectDate) {
	    	$this->discountEffectDate= $discountEffectDate;
	    }
	    
	    public function getDiscountExpiryDate() {
	        return $this->discountExpiryDate;
	    }
	    
	    public function setDiscountExpiryDate($discountExpiryDate) {
	    	$this->discountExpiryDate= $discountExpiryDate;
	    }
	    
	    public function getImgPath() {
	        return $this->imgPath;
	    }
	    
	    public function setImgPath($imgPath) {
	    	$this->imgPath= $imgPath;
	    }
	    
	    public function getRemark() {
	        return $this->remark;
	    }
	    
	    public function setRemark($remark) {
	    	$this->remark= $remark;
	    }
	    
	    public function getCreateDate() {
	        return $this->createDate;
	    }
	    
	    public function setCreateDate($createDate) {
	    	$this->createDate= $createDate;
	    }
	    
	    public function getUpdateDate() {
	        return $this->updateDate;
	    }
	    
	    public function setUpdateDate($updateDate) {
	    	$this->updateDate= $updateDate;
	    }
	}
	
	class Food_tag {
	    private $tagID;
	    private $foodID;
	    private $tagDes;
	    private $createDate;
	    private $updateDate;
	    
	    public function __construct($_tagID, $_foodID, $_tagDes, $_createDate, $_updateDate)
	    {
	        $this->tagID			          = $_tagID;
	        $this->foodID					  = $_foodID;
	        $this->tagDes					  = $_tagDes;
	        $this->createDate				  = $_createDate;
	        $this->updateDate				  = $_updateDate;
	    }
	    
	    public function getTagID() {
	        return $this->tagID;
	    }
	    
	    public function setTagID($tagID) {
	        $this->tagID= $tagID;
	    }
	    
	    public function getFoodID() {
	        return $this->foodID;
	    }
	    
	    public function setFoodID($foodID) {
	        $this->foodID= $foodID;
	    }
	    
	    public function getTagDes() {
	        return $this->tagDes;
	    }
	    
	    public function setTagDes($tagDes) {
	        $this->tagDes= $tagDes;
	    }	    	  
	    
	    public function getCreateDate() {
	        return $this->createDate;
	    }
	    
	    public function setCreateDate($createDate) {
	        $this->createDate= $createDate;
	    }
	    
	    public function getUpdateDate() {
	        return $this->updateDate;
	    }
	    
	    public function setUpdateDate($updateDate) {
	        $this->updateDate= $updateDate;
	    }
	}
	
	class Notification {
		private $notificationID;
		private $type;
		private $subject;
		private $content;	
		private $createDate;
		private $updateDate;
		
		public function __construct($notificationID, $type, $subject, $content, $createDate, $updateDate)
		{
			$this->notificationID			  = $notificationID;
			$this->type						  = $type;
			$this->subject					  = $subject;
			$this->content					  = $content;
			$this->createDate				  = $createDate;
			$this->updateDate				  = $updateDate;
		}
		
		public function getNotificationID() {
			return $this->notificationID;
		}
		
		public function setNotificationID($notificationID) {
			$this->notificationID = $notificationID;
		}
		
		public function getType() {
			return $this->type;
		}
		
		public function setType($type) {
			$this->type = $type;
		}
		
		public function getSubject() {
			return $this->subject;
		}
		
		public function setSubject($subject) {
			$this->subject= $subject;
		}
		
		public function getContent() {
			return $this->content;
		}
		
		public function setContent($content) {
			$this->content= $content;
		}
		
		public function getCreateDate() {
			return $this->createDate;
		}
		
		public function setCreateDate($createDate) {
			$this->createDate= $createDate;
		}
		
		public function getUpdateDate() {
			return $this->updateDate;
		}
		
		public function setUpdateDate($updateDate) {
			$this->updateDate= $updateDate;
		}		
	}
	
	class UserNotification {
		private $notificationID;
		private $userID;
		private $status;
		private $createDate;
		private $updateDate;
		
		public function __construct($notificationID, $userID, $status, $createDate, $updateDate)
		{
			$this->notificationID			  = $notificationID;
			$this->userID					  = $userID;
			$this->status					  = $status;
			$this->createDate				  = $createDate;
			$this->updateDate				  = $updateDate;
		}
		
		public function getNotificationID() {
			return $this->notificationID;
		}
		
		public function setNotificationID($notificationID) {
			$this->notificationID = $notificationID;
		}
		
		public function getUserID() {
			return $this->userID;
		}
		
		public function setType($userID) {
			$this->userID= $userID;
		}
		
		public function getStatus() {
			return $this->status;
		}
		
		public function setStatus($status) {
			$this->status= $status;
		}
		
		public function getCreateDate() {
			return $this->createDate;
		}
		
		public function setCreateDate($createDate) {
			$this->createDate= $createDate;
		}
		
		public function getUpdateDate() {
			return $this->updateDate;
		}
		
		public function setUpdateDate($updateDate) {
			$this->updateDate= $updateDate;
		}
	}
	
	class Comment {
	    private $commentID;
	    private $userID;
	    private $orderID;
	    private $rating;
	    private $content;
	    private $createDate;
	    private $updateDate;
	    
	    public function __construct($commentID, $userID, $orderID, $rating, $content, $createDate, $updateDate)
	    {
	        $this->commentID			      = $commentID;
	        $this->userID					  = $userID;
	        $this->orderID					  = $orderID;
	        $this->rating					  = $rating;
	        $this->content					  = $content;
	        $this->createDate				  = $createDate;
	        $this->updateDate				  = $updateDate;
	    }
	    
	    public function getCommentID() {
	        return $this->commentID;
	    }
	    
	    public function setCommentID($commentID) {
	        $this->commentID = $commentID;
	    }
	    
	    public function getUserID() {
	        return $this->userID;
	    }
	    
	    public function setUserID($userID) {
	        $this->userID = $userID;
	    }
	    
	    public function getOrderID() {
	        return $this->orderID;
	    }
	    
	    public function setOrderID($orderID) {
	        $this->orderID = $orderID;
	    }
	    
	    public function getRating() {
	        return $this->rating;
	    }
	    
	    public function setRating($rating) {
	        $this->rating = $rating;
	    }
	    
	    public function getContent() {
	        return $this->content;
	    }
	    
	    public function setContent($content) {
	        $this->content = $content;
	    }
	    
	    public function getCreateDate() {
	        return $this->createDate;
	    }
	    
	    public function setCreateDate($createDate) {
	        $this->createDate= $createDate;
	    }
	    
	    public function getUpdateDate() {
	        return $this->updateDate;
	    }
	    
	    public function setUpdateDate($updateDate) {
	        $this->updateDate= $updateDate;
	    }
	}
	//[END] Database table entity class

?>