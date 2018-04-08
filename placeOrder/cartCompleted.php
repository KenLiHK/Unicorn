<?php
include_once("../common/functions.php");

checkLogon();

check_session_timeout();

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
$_placedOrderID = "";

if (!empty($_POST["okBtn"]) && $_SERVER["REQUEST_METHOD"] == "POST") {    
    header('Location: ../recommend/recom_home.php');
    exit;  
}else if (!empty($_POST["printBtn"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST["placedOrderID"])){
		$_placedOrderIDTmp = htmlspecialchars($_POST["placedOrderID"]);
	}
	header('Location: ../placeOrder/cartCompletedPrint.php?placedOrderID='.$_placedOrderIDTmp);
	exit;
}else{	
	if(isset($_GET["placedOrderID"])){
    	$_placedOrderID = htmlspecialchars($_GET["placedOrderID"]);
	}
	
    if($_placedOrderID == ""){
        //go back to cart.php
        header('Location: ./cart.php');
        exit;
    }else{
    	$cartInfoMsg_php = "[I201] Placed order successfully! The order number is " . $_placedOrderID . " !";
    }
    
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
		
		<?php include_once("../import.php");?>

		<link rel="stylesheet" href="../unicorn.css" type="text/css">
		<link rel="stylesheet" href="./placeOrder.css" type="text/css">
		<script type="text/javascript" src="../unicorn.js"></script>
		<script type="text/javascript" src="./placeOrder.js"></script>    			
	</head>

	<body>	
		<form name="cartForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return confirmFormSubmit()">
			<div id="loading"></div>
			<div id="app"  style="display:none;" >						
				<div>
				
					<?php include_once("../leftPanel.php");?>
					
					
					
					<!-- ******** [START] Right panel ******** -->
					<div id="right-panel" class="right-panel">
						
						<?php include_once("../header.php");?>	
						
						<!-- ******** [START] Navigation Body ******** -->
						<div>
							<div>
							
								<!-- ******** [START] Alert Message Display ******** -->
								<div id="alertMsg" class="alert mt-4 alert-success">
								<?php if(isset($cartInfoMsg_php) && !empty($cartInfoMsg_php)){ ?>
												<span class="cart_info" id="cartInfoMsg" ><?php if(isset($cartInfoMsg_php)){echo $cartInfoMsg_php;} ?></span>
								<?php }else if(isset($cartMsg_php) && !empty($cartMsg_php)){ ?>
												<span class="cart_err" id="cartMsg" ><?php if(isset($cartMsg_php)){echo $cartMsg_php;} ?></span>";
								<?php }else{
											if(isset($userID)){ ?>
												<span class='badge badge-pill badge-success'>Welcome <?php if(isset($userID)){echo $userID;} ?></span> We promise to deliver the freshest foods to you as soon as possible.
								<?php 		}else{ ?>
												<span class="cart_info" id="cartInfoMsg" >We promise to deliver the freshest foods to you as soon as possible.</span>
								<?php }
				 				}
								?>
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
                                  
								  <div id="actionBtn">								  	  
									  <input class="placeOrder_button" type="submit" id="okBtn" name="okBtn" value="OK">
									  <input class="placeOrder_button" type="button" id="printBtn" name="printBtn" value="Print" onclick="gotoPrintVersion(<?php echo $_placedOrderID;?>)">
									  <input type="hidden" id="placedOrderID" name="placedOrderID" value="<?php echo $_placedOrderID;?>">
								   </div>				
								</div>
								<!-- ******** [END] Shopping Cart Division ******** -->
								
								<?php include_once("../footer.php");?>			
								
								
								
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