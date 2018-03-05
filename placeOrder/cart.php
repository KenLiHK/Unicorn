<?php
include_once("../common/functions.php");

$isFormDataValid = true;

$cartInfoMsg_php = "";
$cartMsg_php = "";
$creditCardNoMsg_php = "";
$chequeNoMsg_php = "";
$creditCardCVVMsg_php = "";
$creditCardHolderNameMsg_php = "";
$creditCardExpiryDateMsg_php = "";

$_selectedFoodMap = [];
$orderDetail4Display_array = [];
$_address = "";
$_tel = "";
$_deliveryTimeslot = "DT01";
$_paymentMethod = "CR";

$_cardType = "VS";
$_creditCardNo = "";
$_creditCardCVV = "";
$_creditCardHolderName = "";
$_creditCardExpiryDate = "";
$_chequeNo = "";

$_visaCardDisabled = "disabled";
$_masterCardDisabled = "disabled";
$_creditCardNoDisabled = "disabled";
$_creditCardCVVDisabled = "disabled";
$_creditCardHolderNameDisabled = "disabled";
$_creditCardExpiryDateDisabled = "disabled";
$_chequeNoDisabled = "disabled";

if (!empty($_POST["SubmitBtn"]) && $_SERVER["REQUEST_METHOD"] == "POST") {             
	// ******** [START] Quantity validation ********
	if(isset($_POST['selectedFood'])){
		$_selectedFood = $_POST['selectedFood'];
		foreach( $_selectedFood as $v ) {
			if(isset($_POST["qtyID".$v])){
				$qtyTmp = $_POST["qtyID".$v];
				if($qtyTmp > 5){			
					$cartMsg_php= 											"[E201] Quantity of a food must be less than or equal to 5!";
					$isFormDataValid = false;
				}
			}
		}
	}
	// ******** [END] Quantity validation ********
	
	// ******** [START] Total price validation ********
	if(isset($_POST['totalPayAmt'])){
		$_totalPayAmt = $_POST['totalPayAmt'];
		if($_totalPayAmt < 1){
			$cartMsg_php= 													"[E202] Total payment amount must be greater than 0!";
			$isFormDataValid = false;
		}
	}
	// ******** [END] Total price validation ********
	
	
	// ******** [START] Payment validation ********
	if(isset($_POST['paymentMethod'])){
		$_paymentMethod = $_POST['paymentMethod'];		
		if($_paymentMethod == "CR"){ //paid by credit card
		    if(isset($_POST['cardType'])){
		        $_cardType = $_POST['cardType'];
		    }else{
		        $_cardType = "";
		    }
		    
		    if(!isset($_POST['creditCardNo']) || $_POST['creditCardNo'] == ""){
				$creditCardNoMsg_php = 										"[E203] Credit card no. must be input!";
				$isFormDataValid = false;
			}else{				
				$_creditCardNo = str_replace('-', '', trim($_POST['creditCardNo']));
				if (!is_numeric($_creditCardNo)) {
					$creditCardNoMsg_php = 									"[E204] Credit card no. must be numeric!";
					$isFormDataValid = false;
				}else if (strlen($_creditCardNo) != 16) {
					$creditCardNoMsg_php = 									"[E205] Credit card no. length must be 16 digits!";
					$isFormDataValid = false;
				}
			}
			
			if(!isset($_POST['creditCardCVV']) || $_POST['creditCardCVV'] == ""){
			    $creditCardCVVMsg_php= 										"[E206] Credit card CVV no. must be input!";
			    $isFormDataValid = false;
			}else{
			    $_creditCardCVV = trim($_POST['creditCardCVV']);
			    if (!is_numeric($_creditCardCVV)) {
			        $creditCardCVVMsg_php = 								"[E207] Credit card CVV no. must be numeric!";
			        $isFormDataValid = false;
			    }else if (strlen($_creditCardCVV) != 3) {
			        $creditCardCVVMsg_php = 								"[E208] Credit card CVV no. length must be 3 digits!";
			        $isFormDataValid = false;
			    }
			}
			
			if(!isset($_POST['creditCardHolderName']) || $_POST['creditCardHolderName'] == ""){
			    $creditCardHolderNameMsg_php= 								"[E209] Credit card holder name must be input!";
			    $isFormDataValid = false;
			}else{
			    $_creditCardHolderName = trim($_POST['creditCardHolderName']);
			}
			
			if(!isset($_POST['creditCardExpiryDate']) || $_POST['creditCardExpiryDate'] == ""){
			    $creditCardExpiryDateMsg_php= 								"[E210] Credit card expiry date must be input!";
			    $isFormDataValid = false;
			}else{			    
			    $_creditCardExpiryDate = preg_replace('/[\/]/', '', trim($_POST['creditCardExpiryDate']));
			    if (!is_numeric($_creditCardExpiryDate)) {
			        $creditCardExpiryDateMsg_php = 							"[E211] Credit card expiry date must be numeric!";
			        $isFormDataValid = false;
			    }else if (strlen($_creditCardExpiryDate) != 4) {
			        $creditCardExpiryDateMsg_php = 							"[E212] Credit card expiry date must be 4 digits!";
			        $isFormDataValid = false;
			    }else {
			        $_mm = substr($_creditCardExpiryDate, 0, 2);
			        $_yy = substr($_creditCardExpiryDate, 2, 2);
			        $_yyyy = date('Y');
			        $_currentYear = substr($_yyyy, 2, 2);
			        
			        if($_mm <= 0 || $_mm > 12 || $_yy < $_currentYear){
			            $creditCardExpiryDateMsg_php = 						"[E213] Credit card expiry date is invalid!";
			            $isFormDataValid = false;
			        }
			    }
			}
		}else if($_paymentMethod == "CH"){ //paid by cheque
		    $_cardType = "";
		    
			if(!isset($_POST['chequeNo'])){
				$chequeNoMsg_php= 											"[E214] Cheque no. must be input!";
				$isFormDataValid = false;
			}else{				
				$_chequeNo= $_POST['chequeNo'];
				if (!is_numeric($_chequeNo)) {
					$chequeNoMsg_php= 										"[E215] Cheque no. must be numeric!";
					$isFormDataValid = false;
				}else if (strlen($_chequeNo) < 10) {
					$chequeNoMsg_php= 										"[E216] Cheque no. length must be 10 digits!";
					$isFormDataValid = false;
				}
			}
		}else{
		    $_cardType = "";
		}
	}
	// ******** [END] Payment validation ********
	
	if($isFormDataValid){
		//[START] Put form data into session for passing to cartConfirmation.php
		if(isset($_POST['selectedFood'])){
			$_selectedFood = $_POST['selectedFood'];
			unset($_selectedFoodMap);
			$_selectedFoodMap= array();
			foreach( $_selectedFood as $v ) {
				if(isset($_POST["qtyID".$v])){
					$qtyTmp = $_POST["qtyID".$v];
					$foodID_qty = array("foodID" => $v, "qty" => $qtyTmp);
					array_push($_selectedFoodMap,$foodID_qty);
				}
			}
		}
		
	    if (session_status() == PHP_SESSION_NONE) {
	    	session_start();
	    }
	    
	    $_SESSION['selected_food_map']         = $_selectedFoodMap;	
	    if(isset($_POST['deliveryTimeslot'])){
	    	$_deliveryTimeslot= $_POST['deliveryTimeslot'];
	    }
	    $_SESSION['delivery_timeslot']         = $_deliveryTimeslot;
	    $_SESSION['payment_method']            = $_paymentMethod;
	    $_SESSION['card_type']                 = $_cardType;
	    $_SESSION['credit_card_no']            = $_creditCardNo;
	    $_SESSION['credit_card_cvv']           = $_creditCardCVV;
	    $_SESSION['credit_card_holder_name']   = $_creditCardHolderName;
	    $_SESSION['credit_card_expiry_date']   = $_creditCardExpiryDate;
	    $_SESSION['cheque_no']                 = $_chequeNo;
	    //[END] Put form data into session for passing to cartConfirmation.php
	    
	    //go to success page
	    header('Location: ./cartConfirm.php');
	    exit;
	}else{
		//[START] Keep form data, when server side validation is failed, we have to put these data into the form
		if(isset($_POST['selectedFood'])){
			$_selectedFood = $_POST['selectedFood'];
			unset($_selectedFoodMap);
			$_selectedFoodMap= array();
			foreach( $_selectedFood as $v ) {
				if(isset($_POST["qtyID".$v])){
					$qtyTmp = $_POST["qtyID".$v];					
					$foodID_qty = array("foodID" => $v, "qty" => $qtyTmp);
					array_push($_selectedFoodMap,$foodID_qty);					
				}
			}
		}
		
		$orderDetail4Display_array = prepare_order_detail_for_display($_selectedFoodMap);
		
		//Retrieve user contact information (address and contact no.)
		$userID = $_SESSION['login_user_id'];
		
		if(isset($userID)){
			$_result = array();
			$_result = get_user_address_contactNo_by_userId($userID);
			
			if(isset($_result)){
				$_address = $_result[0];
				$_tel = $_result[1];
			}else{
				return null;
			}
		}
		
		if(isset($_POST['deliveryTimeslot'])){
			$_deliveryTimeslot = $_POST['deliveryTimeslot'];
		}
		
		if(isset($_POST['paymentMethod'])){
			$_paymentMethod= $_POST['paymentMethod'];
			if($_paymentMethod == "CR"){
			    $_visaCardDisabled = "";
			    $_masterCardDisabled = "";
				$_creditCardNoDisabled = "";
				$_creditCardCVVDisabled = "";
				$_creditCardHolderNameDisabled = "";
				$_creditCardExpiryDateDisabled = "";
				
				$_chequeNoDisabled = "disabled";
			}else if($_paymentMethod == "CH"){
			    $_visaCardDisabled = "disabled";
			    $_masterCardDisabled = "disabled";
				$_creditCardNoDisabled = "disabled";
				$_creditCardCVVDisabled = "disabled";
				$_creditCardHolderNameDisabled = "disabled";
				$_creditCardExpiryDateDisabled = "disabled";
				
				$_chequeNoDisabled = "";
			}else{
			    $_visaCardDisabled = "disabled";
			    $_masterCardDisabled = "disabled";
				$_creditCardNoDisabled = "disabled";
				$_creditCardCVVDisabled = "disabled";
				$_creditCardHolderNameDisabled = "disabled";
				$_creditCardExpiryDateDisabled = "disabled";
				
				$_chequeNoDisabled = "disabled";
			}
		}else{
		    if($_paymentMethod == "CR"){
		        $_visaCardDisabled = "";
		        $_masterCardDisabled = "";
		        $_creditCardNoDisabled = "";
		        $_creditCardCVVDisabled = "";
		        $_creditCardHolderNameDisabled = "";
		        $_creditCardExpiryDateDisabled = "";
		        
		        $_chequeNoDisabled = "disabled";
		    }else if($_paymentMethod == "CH"){
		        $_visaCardDisabled = "disabled";
		        $_masterCardDisabled = "disabled";
		        $_creditCardNoDisabled = "disabled";
		        $_creditCardCVVDisabled = "disabled";
		        $_creditCardHolderNameDisabled = "disabled";
		        $_creditCardExpiryDateDisabled = "disabled";
		        
		        $_chequeNoDisabled = "";
		    }else{
		        $_visaCardDisabled = "disabled";
		        $_masterCardDisabled = "disabled";
		        $_creditCardNoDisabled = "disabled";
		        $_creditCardCVVDisabled = "disabled";
		        $_creditCardHolderNameDisabled = "disabled";
		        $_creditCardExpiryDateDisabled = "disabled";
		        
		        $_chequeNoDisabled = "disabled";
		    }
		}
		
		if(isset($_POST['cardType'])){
			$_cardType= $_POST['cardType'];
		}
		
		if(isset($_POST['creditCardNo'])){
		    $_creditCardNo= $_POST['creditCardNo'];
		}
		
		if(isset($_POST['creditCardCVV'])){
		    $_creditCardCVV= $_POST['creditCardCVV'];
		}
		
		if(isset($_POST['creditCardHolderName'])){
		    $_creditCardHolderName= $_POST['creditCardHolderName'];
		}
		
		if(isset($_POST['creditCardExpiryDate'])){
		    $_creditCardExpiryDate= $_POST['creditCardExpiryDate'];
		}
		
		if(isset($_POST['chequeNo'])){
			$_chequeNo= $_POST['chequeNo'];
		}
		//[START] Keep form data, when server side validation is failed, we have to put these data into the form
	}
}else{
    /*
     $_selectedFoodMap store the ID of food and corresponding quantity selected by customer
     It is a 2 dimensional array,
     [arrayIndex][foodID][Qty]
     e.g.
     [0][11][3]
     [1][13][2]
     [2][21][1]
     */
    //$_selectedFoodMap = $_SESSION['selected_food_map'];
    
    /*
    //START: For testing
    //$selectedFood1 = array("F1", "2");
    //$selectedFood2 = array("F1", "6");
    //$selectedFood3 = array("F1", "8");
    $selectedFood1 = array("foodID" => "1", "qty" => "2");
    $selectedFood2 = array("foodID" => "2", "qty" => "6");
    $selectedFood3 = array("foodID" => "3", "qty" => "8");
    
    $_selectedFoodMap = array($selectedFood1, $selectedFood2, $selectedFood3);
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['selected_food_map'] = $_selectedFoodMap;

    //$orderDetail4Display_array = [];
    //$orderDetail4Display_array = prepare_order_detail_for_display();
    
    for ($row = 0; $row < count($orderDetail4Display_array); $row++) {
        $orderDetail4Display = $orderDetail4Display_array[$row];
        
        //echo "foodID:".$orderDetail4Display->getFoodID()."\t";
        //echo "foodCategory:".$orderDetail4Display->getFoodCategory()."\t";
        //echo "foodName:".$orderDetail4Display->getFoodName()."\t";
        //echo "foodPrice:".$orderDetail4Display->getPrice()."\n<br>";
    }
    $_SESSION['login_user_id'] = "kenli";    
    //END: For testing
    */
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    //unset($_SESSION['selected_food_map']);
    unset($_SESSION['delivery_timeslot']);
    unset($_SESSION['payment_method']);
    unset($_SESSION['card_type']);
    unset($_SESSION['credit_card_no']);
    unset($_SESSION['credit_card_cvv']);
    unset($_SESSION['credit_card_holder_name']);
    unset($_SESSION['credit_card_expiry_date']);
    unset($_SESSION['cheque_no']);
    
    $_selectedFoodMap = isset($_SESSION['selected_food_map']) ? $_SESSION['selected_food_map'] : array();
    $orderDetail4Display_array = prepare_order_detail_for_display($_selectedFoodMap);
    
    //Retrieve user contact information (address and contact no.)
    $userID = isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : "";
    
    if(isset($userID)){
    	$_result = array();
    	$_result = get_user_address_contactNo_by_userId($userID);
    	
    	if(isset($_result)){
    		$_address = $_result[0];
    		$_tel = $_result[1];
    	}else{
    		return null;
    	}
    }
    
    /*
    //[START] Get data from session. When user click cancel button in cartConfirm.php, the following data will be kept in session
    $_deliveryTimeslot      = isset($_SESSION['delivery_timeslot'])         ? $_SESSION['delivery_timeslot']        : "";
    $_paymentMethod         = isset($_SESSION['payment_method'])            ? $_SESSION['payment_method']           : "CR";
    $_cardType              = isset($_SESSION['card_type'])                 ? $_SESSION['card_type']                : "VS";
    $_creditCardNo          = isset($_SESSION['credit_card_no'])            ? $_SESSION['credit_card_no']           : "";
    $_creditCardCVV         = isset($_SESSION['credit_card_cvv'])           ? $_SESSION['credit_card_cvv']          : "";
    $_creditCardHolderName  = isset($_SESSION['credit_card_holder_name'])   ? $_SESSION['credit_card_holder_name']  : "";
    $_creditCardExpiryDate  = isset($_SESSION['credit_card_expiry_date'])   ? $_SESSION['credit_card_expiry_date']  : "";
    $_creditCardNoTmp = "";
    
    for($i=0; $i<strlen($_creditCardNo); $i+=4){
        if($i != 12){
            $_creditCardNoTmp = $_creditCardNoTmp.substr($_creditCardNo, $i, 4)."-";
        }else {
        	$_creditCardNoTmp = $_creditCardNoTmp.substr($_creditCardNo, $i, 4);
        }
    }
    $_creditCardNo = $_creditCardNoTmp;
    $_chequeNo = isset($_SESSION['cheque_no']) ? $_SESSION['cheque_no'] : "";
    
    unset($_SESSION['selected_food_map']);
    unset($_SESSION['delivery_timeslot']);
    unset($_SESSION['payment_method']);
    unset($_SESSION['card_type']);
    unset($_SESSION['credit_card_no']);
    unset($_SESSION['credit_card_cvv']);
    unset($_SESSION['credit_card_holder_name']);
    unset($_SESSION['credit_card_expiry_date']);
    unset($_SESSION['cheque_no']);
    //[END] Get data from session. When user click cancel button in cartConfirm.php, the following data will be kept in session
    */
    
    if($_paymentMethod == "CR"){
        $_visaCardDisabled = "";
        $_masterCardDisabled = "";
    	$_creditCardNoDisabled = "";
    	$_creditCardCVVDisabled = "";
    	$_creditCardHolderNameDisabled = "";
    	$_creditCardExpiryDateDisabled = "";
    	
    	$_chequeNoDisabled = "disabled";
    }else if($_paymentMethod == "CH"){
        $_visaCardDisabled = "disabled";
        $_masterCardDisabled = "disabled";
    	$_creditCardNoDisabled = "disabled";
    	$_creditCardCVVDisabled = "disabled";
    	$_creditCardHolderNameDisabled = "disabled";
    	$_creditCardExpiryDateDisabled = "disabled";
    	
    	$_chequeNoDisabled = "";
    }else{
        $_visaCardDisabled = "disabled";
        $_masterCardDisabled = "disabled";
    	$_creditCardNoDisabled = "disabled";
    	$_creditCardCVVDisabled = "disabled";
    	$_creditCardHolderNameDisabled = "disabled";
    	$_creditCardExpiryDateDisabled = "disabled";
    	
    	$_chequeNoDisabled = "disabled";
    }
}
?>

<html>
	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant - Shopping Cart</title>
		
		<!-- Using Icon library and refer to https://www.w3schools.com/w3css/w3css_icons.asp -->
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../unicorn.css">
		<link rel="stylesheet" href="./placeOrder.css">
		
		<!-- include jQuery for Ajax call -->
		<script type="text/javascript" src="../jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="../unicorn.js"></script>
		<script type="text/javascript" src="./placeOrder.js"></script>
	</head>

	<body>	
		<form name="cartForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return formSubmit()">
			<div id="app">
				<div>
				
					<!-- ******** [START] Left panel ******** -->
					<aside id="left-panel" class="left-panel">
						<nav class="navbar navbar-expand-lg">
						
							<!-- ******** [START] Logo ******** -->
							<div class="navbar-header">
								<a href="#/" class="navbar-brand">
									<img src="../resources/cs5281unicorn2_6.png" alt="Logo" class="float-left">
								</a> 
							</div>
							<!-- ******** [END] Logo ******** -->
							
							
							<!-- ******** [START] Left function menu ******** -->
							<div id="main-menu" class="navbar-collapse">
								<ul class="navbar-nav">
									<h3 class="menu-title"> Unicorn Restaurant </h3>
									
									<li class="nav-item">
										<a href="#/components/tables" class="">
											<i class="menu-icon fa fa-search"></i>
											<span class="menu-title-text"> Search Dish </span>
										</a>
									</li>				
		
									<li class="nav-item mt-auto">
										<a>
											<i class="menu-icon fa fa-shopping-cart"></i>
											<span class="menu-title-text"> Place Order </span>
										</a>
									</li>
											
									<li class="nav-item">
										<a href="#/components/icons" class="">
											<i class="menu-icon fa fa-star"></i>
											<span class="menu-title-text">Map</span>
										</a>
									</li>
									
								</ul>
							</div>
							<!-- ******** [END] Left function menul ******** -->
							
							
							
						</nav>
						
						<div></div>
					</aside>
					<!-- ******** [END] Left panel ******** -->
					
					
					
					<!-- ******** [START] Right panel ******** -->
					<div id="right-panel" class="right-panel">
						
						
						
						<!-- ******** [START] Navigation Header Bar ******** -->			
						<header id="header" class="header">
							<div>							
								<div class="header-right">
									<div>
										<a href="#"><i class="fa fa-power-off"></i> Logout </a> <span>&nbsp;</span>
									</div>								
								</div>						
							</div>
						</header>
						<!-- ******** [START] Navigation Header Bar ******** -->
						
						
						
						
						<!-- ******** [START] Navigation Body ******** -->
						<div>
							<div>
							
								<!-- ******** [START] Alert Message Display ******** -->
								<div class="alert mt-4 alert-success">
									<span class="cart_info" id="cartInfoMsg" ><?php if(isset($cartInfoMsg_php)){echo $cartInfoMsg_php;} ?></span>
									<span class="cart_err" id="cartMsg" ><?php if(isset($cartMsg_php)){echo $cartMsg_php;} ?></span>
								</div>
								<!-- ******** [END] Alert Message Display ******** -->
								
								
								
								<!-- ******** [START] Shopping Cart Division ******** -->
								<!-- ******** Confirm Order Details ******** -->
								<h5>Order Details</h5>
                				<div class="orderTable">
                    				<div class="orderTableHeading">
                    					<div class="orderTableHead"><strong>Food Category</strong></div>
                        				<div class="orderTableHead"><strong>Food Name</strong></div>
                        				<div class="orderTableCellAmt">Price</div>
                        				<div class="orderTableHead">Quantity</div>
                        				<div class="orderTableCellAmt">Sub-total</div>
                    				</div>
                    				<?php
                    				$_totalPrice = 0;
                    				$_totalQty = 0;
                    				
                    				for ($row = 0; $row < count($orderDetail4Display_array); $row++) {
                    					$orderDetail4Display = $orderDetail4Display_array[$row];

                    					$_foodID           = $orderDetail4Display->getFoodID();
                    					$_foodCategory     = $orderDetail4Display->getFoodCategory();
                    					$_foodName         = $orderDetail4Display->getFoodName();
                    					$_price            = $orderDetail4Display->getPrice();
                    					$_qty              = $orderDetail4Display->getQty();
                    					
                    					$_subtotal         = $_price * $_qty;                    					
                    					$_totalPrice       = $_totalPrice+ $_subtotal;
                    					$_totalQty         = $_totalQty + $_qty;
                    					
                    					echo "<div class='orderTableRow'>";
                    					echo "<div class='orderTableCell'>".$_foodCategory."</div>";
                    					echo "<div class='orderTableCell'>".$_foodName."</div>";
                    					echo "<div class='orderTableCellAmt'>$".$_price."</div>";
                    					echo "<div class='orderTableCell'><input type='hidden' name='selectedFood[]' value='".$_foodID."'><input type='number' id='qtyID".$_foodID."' name='qtyID".$_foodID."' maxlength='3' value='".$_qty."' min='0' max='5' onchange='updateSubtotal(\"qtyID".$_foodID."\", \"".$_price."\", \"subtotalID".$_foodID."\")'></div>";
                    					echo "<div class='orderTableCellAmt'>$<span id='subtotalID".$_foodID."'>".$_subtotal."</span></div>";
                    					echo "</div>";
                    				}
                    				
                    				echo "<div class='orderTableFoot'>";
                    					echo "<div class='orderTableCell'></div>";
                        				echo "<div class='orderTableCell'></div>";
                        				echo "<div class='orderTableCellAmt'>Total:</div>";
                        				echo "<div class='orderTableCell'><span id='totalQty'>".$_totalQty."</span></div>";
                        				echo "<div class='orderTableCellAmt'>$<span id='totalPrice'>".$_totalPrice."</span></div>";
                    				echo "</div>";
                    				?>
                				  </div>
				
								  <hr>
								  <!-- ******** Confirm Delivery Address, Contact Phone No. and Delivery Timeslot ******** -->
                                  <div class="info">
                                  	<div>
                                  		<label class="cart_label">Delivery Address : </label>
                                		<label class="cart_label2"><?php if(isset($_address)){echo $_address;} ?></label> <a href="../userProfile/userProfile.php"><label class="cart_label3"> Go to update contact information.</label></a><br>
                                		
                                		<label class="cart_label">Contact Phone No. : </label>
                                		<label class="cart_label2"><?php if(isset($_tel)){echo $_tel;} ?></label><br>
                                		
                                		<label class="cart_label">Delivery Timeslot : </label>
                                    	<select id="deliveryTimeslot" name="deliveryTimeslot">
                                    		<option value="DT01" <?php if (isset($_deliveryTimeslot) && $_deliveryTimeslot=="DT01") echo "selected";?>>Immediately</option>
                                     		<option value="DT11" <?php if (isset($_deliveryTimeslot) && $_deliveryTimeslot=="DT11") echo "selected";?>>After 1 hour</option>
                                     		<option value="DT21" <?php if (isset($_deliveryTimeslot) && $_deliveryTimeslot=="DT21") echo "selected";?>>After 2 hours</option>
                                    	</select> 
                                	</div>
                                	
                                	<hr>
                                	<!-- ******** Confirm Payment Method and Payment Information ******** -->
                                    <div>
                                    	<label class="cart_label">Total Payment Amount : </label>
                                    	<label class="cart_label2">$<span id="confirmedTotalPrice"><?php if(isset($_totalPrice)){echo $_totalPrice;} ?></span><input type='hidden' id='totalPayAmt' name='totalPayAmt' value='<?php if(isset($_totalPrice)){echo $_totalPrice;} ?>'></label><br>
                                    	<label class="cart_label">Payment Method : </label>
                                        <div>
                                            <input type="radio" id="paymentMethod1" name="paymentMethod" value="CR" onclick="clickCreditCard()" <?php if (isset($_paymentMethod) && $_paymentMethod=="CR") echo "checked";?>>Credit Card <br>
                                            	<input class="cart_input_card_type" type="radio" id="cardType1" name="cardType" value="VS" onclick="clickVisaCard()" <?php if (isset($_cardType) && $_cardType=="VS") echo "checked";?> <?php if (isset($_visaCardDisabled)) echo $_visaCardDisabled;?>>Visa Card
                                            	<input class="cart_input_card_type" type="radio" id="cardType2" name="cardType" value="MA" onclick="clickMasterCard()" <?php if (isset($_cardType) && $_cardType=="MA") echo "checked";?> <?php if (isset($_masterCardDisabled)) echo $_masterCardDisabled;?>>Master Card <br>
                                            	<input class="cart_input" type="text" id="creditCardNo" name="creditCardNo" placeholder="Credit Card No." maxlength="19" value="<?php if(isset($_creditCardNo)){echo $_creditCardNo;} ?>" <?php if (isset($_creditCardNoDisabled)) echo $_creditCardNoDisabled;?> onblur="creditCardFormatting()"> <span class="cart_err" id="creditCardNoMsg" ><?php if(isset($creditCardNoMsg_php)){echo $creditCardNoMsg_php;} ?></span><br>
                                            	<input class="cart_input2" type="text" id="creditCardCVV" name="creditCardCVV" placeholder="Credit Card CVV" maxlength="3" value="<?php if(isset($_creditCardCVV)){echo $_creditCardCVV;} ?>" <?php if (isset($_creditCardCVVDisabled)) echo $_creditCardCVVDisabled;?>> <span class="cart_err" id="creditCardCVVMsg" ><?php if(isset($creditCardCVVMsg_php)){echo $creditCardCVVMsg_php;} ?></span><br>
                                            	<input class="cart_input" type="text" id="creditCardHolderName" name="creditCardHolderName" placeholder="Credit Card Holder Name" maxlength="50" value="<?php if(isset($_creditCardHolderName)){echo $_creditCardHolderName;} ?>" <?php if (isset($_creditCardHolderNameDisabled)) echo $_creditCardHolderNameDisabled;?>> <span class="cart_err" id="creditCardHolderNameMsg" ><?php if(isset($creditCardHolderNameMsg_php)){echo $creditCardHolderNameMsg_php;} ?></span><br>
                                            	<input class="cart_input" type="text" id="creditCardExpiryDate" name="creditCardExpiryDate" placeholder="Credit Card Expiry Date (MM/YY)" maxlength="5" value="<?php if(isset($_creditCardExpiryDate)){echo $_creditCardExpiryDate;} ?>" <?php if (isset($_creditCardExpiryDateDisabled)) echo $_creditCardExpiryDateDisabled;?> onblur="creditCardExpiryDateFormatting()"> <span class="cart_err" id="creditCardExpiryDateMsg" ><?php if(isset($creditCardExpiryDateMsg_php)){echo $creditCardExpiryDateMsg_php;} ?></span><br>                                				                                            
                                            <input type="radio" id="paymentMethod2" name="paymentMethod" value="CA" onclick="clickCash()" <?php if (isset($_paymentMethod) && $_paymentMethod=="CA") echo "checked";?>>Cash <br>                                            
                                            <input type="radio" id="paymentMethod3" name="paymentMethod" value="CH" onclick="clickCheque()" <?php if (isset($_paymentMethod) && $_paymentMethod=="CH") echo "checked";?>>Cheque <input class="cart_input3" type="text" id="chequeNo" name="chequeNo" placeholder="Cheque No." maxlength="10" value="<?php if(isset($_chequeNo)){echo $_chequeNo;} ?>" <?php if (isset($_chequeNoDisabled)) echo $_chequeNoDisabled;?>> <span class="cart_err" id="chequeNoMsg" ><?php if(isset($chequeNoMsg_php)){echo $chequeNoMsg_php;} ?></span><br>
                                        </div>
                                    </div>                  
                                  </div>
                                  
								  <div>								  	  
									  <input class="cart_input" type="submit" id="SubmitBtn" name="SubmitBtn" value="Submit">
								   </div>				
								</div>
								<!-- ******** [END] Shopping Cart Division ******** -->
								
								<!-- ******** [START] Footer ******** -->						
									<div class="col-md-12">
										<div class="card">						
											<div class="card-footer">
												<ul>									
													<li>
														<div class="text-muted">Email</div>
														<strong>cs5281unicorn@unicorn.com</strong>											
													</li>
													<li class="hidden-sm-down">
														<div class="text-muted">Tel</div>
														<strong>+852 5281-2018</strong>
													</li>
													<li class="hidden-sm-down">
														<div class="text-muted">Fax</div>
														<strong>+852 5281-2019</strong>
													</li>												
												</ul>
												
											</div>
											
											<div class="card-footer">										
												<ul>
													<li>
														<div class="text-muted">Service Hour</div>
														<strong>Monday - Sunday 09:00-23:00</strong>
													</li>										
													<li>
														<div class="text-muted">Address</div>
														<strong>Li Dak Sum Yip Yio Chin A Bldg 5606, Hong Kong</strong>
													</li>
												</ul>										
											</div>
											
											
										</div>
									</div>
								<!-- ******** [END] Footer ******** -->
								
								
								
							</div>
						</div>
						<!-- ******** [END] Navigation Body ******** -->
						
						
						
					</div>
					<!-- ******** [END] Right panel ******** -->
					
					
				</div>
			</div>
		</form>
	</body>
</html>