<?php
	include_once("../init.php");
	
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
	    
	    public function __construct($foodID, $foodCategory, $foodName, $available, $price, $discount, $discountEffectDate, $discountExpiryDate, 
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

		public static function __constructById($foodID)
		{
			$this->foodID = $foodID;
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
	    
	    public function getAvailable() {
	        return $this->available;
	    }
	    
	    public function getPrice() {
	        return $this->price;
	    }

	    public function getDiscount() {
	        return $this->discount;
	    }
	    
	    public function getDiscountEffectDate() {
	        return $this->discountEffectDate;
	    }
	    
	    public function getDiscountExpiryDate() {
	        return $this->discountExpiryDate;
	    }
	    
	    public function getImgPath() {
	        return $this->imgPath;
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

		public function setFoodCategory($cate) {
			$this->foodCategory = $cate;
		}

		public function setFoodName($foodName) {
			$this->foodName = $foodName;
		}

		public function setAvailable($isAval) {
			$this->available = $isAval;
		}

		public function setPrice($price) {
			$this->price = $price;
		}

		public function setDiscount($discount) {
			$this->discount = $discount;
		}

		public function setDiscountEffectDate($effectDate) {
			$this->discountEffectDate = $effectDate;
		}

		public function setDiscountExpiryDate($expireDate) {
			$this->discountExpiryDate = $expireDate;
		}

		public function setImgPath($imgPath) {
			$this->imgPath = $imgPath;
		}

		public function setRemark($remark) {
			$this->remark = $remark;
		}

		public function setCreateDate($createDate) {
			$this->createDate = $createDate;
		}

		public function setUpdateDate($updateDate) {
			$this->updateDate = $updateDate;
		}
	}
	//[END] Database table entity class

?>