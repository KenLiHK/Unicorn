<?php
include_once("../common/functions.php");

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_SESSION['login_user_id'])){
	$userID_In_Session = $_SESSION['login_user_id'];
}

$isFormDataValid = true;

$cartInfoMsg_php = "";
$cartMsg_php = "";
$creditCardNoMsg_php = "";
$chequeNoMsg_php = "";
$creditCardCVVMsg_php = "";
$creditCardHolderNameMsg_php = "";
$creditCardExpiryDateMsg_php = "";

$_selectedFoodMap = [];
$_selectedOrderDetailMap = [];
$orderDetail4Display_array = [];
$_address = "";
$_tel = "";
$_deliveryTimeslot = "";
$_paymentMethod = "";
$_cardType = "";
$_creditCardNo = "";
$_creditCardCVV = "";
$_creditCardHolderName = "";
$_creditCardExpiryDate = "";
$_chequeNo = "";

$_visaCardDisabled = "disabled";
$_masterCardDisabled = "disabled";
$_creditCardNoDisabled = "disabled";
$_chequeNoDisabled = "disabled";
$_creditCardCVVDisabled = "disabled";
$_creditCardHolderNameDisabled = "disabled";
$_creditCardExpiryDateDisabled = "disabled";

if (!empty($_POST["okBtn"]) && $_SERVER["REQUEST_METHOD"] == "POST") {    
    header('Location: ../home.php');
    exit;  
}else{
    $_placedOrderID = htmlspecialchars($_GET["placedOrderID"]);
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    unset($_SESSION['selected_food_map']);
    unset($_SESSION['delivery_timeslot']);
    unset($_SESSION['payment_method']);
    unset($_SESSION['card_type']);
    unset($_SESSION['credit_card_no']);
    unset($_SESSION['credit_card_cvv']);
    unset($_SESSION['credit_card_holder_name']);
    unset($_SESSION['credit_card_expiry_date']);
    unset($_SESSION['cheque_no']);
    
    $_orderInDB = get_order_info_by_orderID($_placedOrderID);
    $orderDetail4Display_array = prepare_placed_order_detail_for_display($_placedOrderID);
    
	//Retrieve user contact information (address and contact no.)
    if(isset($_SESSION['login_user_id'])){
    	$userID = $_SESSION['login_user_id'];
    }
	
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
	
	$_deliveryTimeslot         = $_orderInDB -> getDeliveryTimeslot();
	$_paymentMethod            = $_orderInDB -> getPaymentChannel();
	$_cardType                 = $_orderInDB -> getCreditCardType();
	$_creditCardNo             = $_orderInDB -> getCreditCardNo();
	$_creditCardCVV            = $_orderInDB -> getCreditCardSecurityCode();
	$_creditCardHolderName     = $_orderInDB -> getCreditCardHolderName();
	$_creditCardExpiryDate     = $_orderInDB -> getCreditCardExpiryDate();
	$_chequeNo                 = $_orderInDB -> getChequeNo();
	
	$_creditCardNoTmp = "";
	
	for($i=0; $i<strlen($_creditCardNo); $i+=4){
	    if($i != 12){
	        $_creditCardNoTmp = $_creditCardNoTmp.substr($_creditCardNo, $i, 4)."-";
	    }else {
	        $_creditCardNoTmp = $_creditCardNoTmp.substr($_creditCardNo, $i, 4);
	    }
	}
	$_creditCardNo = $_creditCardNoTmp;

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
		<form name="cartForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return confirmFormSubmit()">
			<div id="app">
				<div>
				
					<!-- ******** [START] Left panel ******** -->
					<aside id="left-panel" class="left-panel">
						<nav class="navbar navbar-expand-lg">
						
							<!-- ******** [START] Logo ******** -->
							<div class="navbar-header">
								<a href="../recommend/recom_home.php" class="navbar-brand">
									<img src="../resources/cs5281unicorn2_6.png" alt="Logo" class="float-left">
								</a> 
							</div>
							<!-- ******** [END] Logo ******** -->
							
							
							<!-- ******** [START] Left function menu ******** -->
							<div id="main-menu" class="navbar-collapse">
								<ul class="navbar-nav">
									<a href="../recommend/recom_home.php">
										<h3 class="menu-title"> Unicorn Restaurant </h3>
									</a>
									
									<li class="nav-item">
										<a href="../searchDish/search.php">
											<i class="menu-icon fa fa-search"></i>
											<span class="menu-title-text"> Search Dish </span>
										</a>
									</li>				
		
									<li class="nav-item mt-auto">
										<a href="../placeOrder/cart.php">
											<i class="menu-icon fa fa-shopping-cart"></i>
											<span class="menu-title-text"> Place Order </span>
										</a>
									</li>
											
									<li class="nav-item mt-auto">
										<a href="../comment/comment_section.php">
											<i class="menu-icon fa fa-comments"></i>
											<span class="menu-title-text"> Comment </span>
										</a>
									</li>															
									
									<li class="nav-item mt-auto">
										<a href="../userProfile/userProfile.php">
											<i class="menu-icon fa fa-user"></i>
											<span class="menu-title-text"> User Profile </span>
										</a>
									</li>
									
																			
									<li class="nav-item">
										<a href="../login/login.php">
											<i class="menu-icon fa fa-sign-in"></i>
											<span class="menu-title-text">Login</span>
										</a>
									</li>
	
									<li class="nav-item">
										<a href="../registration/registerForm.php">
											<i class="menu-icon fa fa-user-plus"></i>
											<span class="menu-title-text">Sign Up</span>
										</a>
									</li>
									
									<li class="nav-item">
										<a href="../contactUs/contactUs.php">
											<i class="menu-icon fa fa-globe"></i>
											<span class="menu-title-text">Contact Us</span>
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
										<?php
											if(isset($userID_In_Session )){
												echo
													'<a href="../notification/notification.php"><i class="fa fa-envelope"></i> </a> <span>&nbsp;</span>
											 		 <a href="../userProfile/userProfile.php"><i class="fa fa-profile"></i>' .@$userID_In_Session . '</a> <span>&nbsp;</span>
											 		 <a href="../login/logout.php"><i class="fa fa-sign-out"></i> Logout </a> <span>&nbsp;</span>';
											}else{
												echo
													'<a href="../login/login.php"><i class="fa fa-sign-in"> Login </i></a> <span>&nbsp;</span>
			            					 		 <a href="../registration/registerForm.php"><i class="fa fa-user-plus"> Sign-up </i></a> <span>&nbsp;</span>';
											}
					        			?>
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

                    				    $_foodID            = $orderDetail4Display->getFoodID();
                    				    $_foodCategory      = $orderDetail4Display->getFoodCategory();
                    				    $_foodName          = $orderDetail4Display->getFoodName();
                    				    $_price             = $orderDetail4Display->getPrice();
                    				    $_qty               = $orderDetail4Display->getQty();
                    					
                    				    $_subtotal          = $_price * $_qty;                    					
                    					$_totalPrice        = $_totalPrice+ $_subtotal;
                    					$_totalQty          = $_totalQty + $_qty;
                    					
                    					echo "<div class='orderTableRow'>";
                    					echo "<div class='orderTableCell'>".$_foodCategory."</div>";
                    					echo "<div class='orderTableCell'>".$_foodName."</div>";
                    					echo "<div class='orderTableCellAmt'>$".$_price."</div>";
                    					echo "<div class='orderTableCell'><input type='hidden' name='selectedFood[]' value='".$_foodID."'><input type='number' name='qtyID".$_foodID."' maxlength='3' value='".$_qty."' min='0' max='5' disabled></div>";
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
                                		<label class="cart_label2"><?php if(isset($_address)){echo $_address;} ?></label> <br>
                                		
                                		<label class="cart_label">Contact Phone No. : </label>
                                		<label class="cart_label2"><?php if(isset($_tel)){echo $_tel;} ?></label><br>
                                		
                                		<label class="cart_label">Delivery Timeslot : </label>
                                    	<select id="deliveryTimeslot" name="deliveryTimeslot" class="disabledList" disabled>
                                    		<option value="DT01" <?php if (isset($_deliveryTimeslot) && $_deliveryTimeslot=="DT01") echo "selected";?>>Immediately</option>
                                     		<option value="DT11" <?php if (isset($_deliveryTimeslot) && $_deliveryTimeslot=="DT11") echo "selected";?>>After 1 hour</option>
                                     		<option value="DT21" <?php if (isset($_deliveryTimeslot) && $_deliveryTimeslot=="DT21") echo "selected";?>>After 2 hours</option>
                                    	</select> 
                                	</div>
                                	
                                	<hr>
                                	<!-- ******** Confirm Payment Method and Payment Information ******** -->
                                    <div>
                                    	<label class="cart_label">Total Payment Amount : </label>
                                    	<label class="cart_label2">$<span id="confirmedTotalPrice"><?php if(isset($_totalPrice)){echo $_totalPrice;} ?></span><input type='hidden' id='totalPayAmt' name='totalPayAmt' value='".$_totalPrice."'></label><br>
                                    	<label class="cart_label">Payment Method : </label>
                                        <div>
                                            <input type="radio" id="paymentMethod1" name="paymentMethod" value="CR" onclick="clickCreditCard()" <?php if (isset($_paymentMethod) && $_paymentMethod=="CR") echo "checked";?> disabled>Credit Card <br>
                                            	<input class="cart_input_card_type" type="radio" id="cardType1" name="cardType" value="VS" onclick="clickVisaCard()" <?php if (isset($_cardType) && $_cardType=="VS") echo "checked";?> disabled>Visa Card
                                            	<input class="cart_input_card_type" type="radio" id="cardType2" name="cardType" value="MA" onclick="clickMasterCard()" <?php if (isset($_cardType) && $_cardType=="MA") echo "checked";?> disabled>Master Card <br>                                            
                                            	<input class="cart_input" type="text" id="creditCardNo" name="creditCardNo" placeholder="Credit Card No." maxlength="19" value="<?php if(isset($_creditCardNo)){echo $_creditCardNo;} ?>" disabled onblur="creditCardFormatting()"><span class="cart_err" id="creditCardNoMsg" ><?php if(isset($creditCardNoMsg_php)){echo $creditCardNoMsg_php;} ?></span><br>                                            
                                            	<input class="cart_input2" type="text" id="creditCardCVV" name="creditCardCVV" placeholder="Credit Card CVV" maxlength="3" value="<?php if(isset($_creditCardCVV)){echo $_creditCardCVV;} ?>" <?php if (isset($_creditCardCVVDisabled)) echo $_creditCardCVVDisabled;?>><span class="cart_err" id="creditCardCVVMsg" ><?php if(isset($creditCardCVVMsg_php)){echo $creditCardCVVMsg_php;} ?></span><br>
                                            	<input class="cart_input" type="text" id="creditCardHolderName" name="creditCardHolderName" placeholder="Credit Card Holder Name" maxlength="50" value="<?php if(isset($_creditCardHolderName)){echo $_creditCardHolderName;} ?>" <?php if (isset($_creditCardHolderNameDisabled)) echo $_creditCardHolderNameDisabled;?>><span class="cart_err" id="creditCardHolderNameMsg" ><?php if(isset($creditCardHolderNameMsg_php)){echo $creditCardHolderNameMsg_php;} ?></span><br>
                                            	<input class="cart_input" type="text" id="creditCardExpiryDate" name="creditCardExpiryDate" placeholder="Credit Card Expiry Date (MM/YY)" maxlength="5" value="<?php if(isset($_creditCardExpiryDate)){echo $_creditCardExpiryDate;} ?>" <?php if (isset($_creditCardExpiryDateDisabled)) echo $_creditCardExpiryDateDisabled;?>><span class="cart_err" id="creditCardExpiryDateMsg" ><?php if(isset($creditCardExpiryDateMsg_php)){echo $creditCardExpiryDateMsg_php;} ?></span><br>                                				
                                            <input type="radio" id="paymentMethod2" name="paymentMethod" value="CA" onclick="clickCash()" <?php if (isset($_paymentMethod) && $_paymentMethod=="CA") echo "checked";?> disabled>Cash <br>
                                            <input type="radio" id="paymentMethod3" name="paymentMethod" value="CH" onclick="clickCheque()" <?php if (isset($_paymentMethod) && $_paymentMethod=="CH") echo "checked";?> disabled>Cheque <input class="cart_input3" type="text" id="chequeNo" name="chequeNo" placeholder="Cheque No." maxlength="10" value="<?php if(isset($_chequeNo)){echo $_chequeNo;} ?>" disabled><span class="cart_err" id="chequeNoMsg" ><?php if(isset($chequeNoMsg_php)){echo $chequeNoMsg_php;} ?></span><br>
                                        </div>
                                    </div>                  
                                  </div>
                                  
								  <div>								  	  
									  <input class="cart_input" type="submit" id="okBtn" name="okBtn" value="OK">
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