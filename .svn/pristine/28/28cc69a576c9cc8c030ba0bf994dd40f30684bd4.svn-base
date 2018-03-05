<?php

include_once("../common/database.php");
include_once("../common/functions.php");



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
	</head>

	<body>	
		<form name="regForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return formSubmit()">
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
									<span></span>
								</div>
								<!-- ******** [END] Alert Message Display ******** -->
								
								
								
								<!-- ******** [START] Shopping Cart Division ******** -->
								<!-- ******** Confirm Order Details ******** -->
								<h5>Order Details</h5>
                				<div class="orderTable">
                    				<div class="orderTableHeading">
                        				<div class="orderTableHead"><strong>Food Name</strong></div>
                        				<div class="orderTableCellAmt">Price</div>
                        				<div class="orderTableHead">Quantity</div>
                        				<div class="orderTableCellAmt">Sub-total</div>
                    				</div>
                    				<div class="orderTableRow">
                        				<div class="orderTableCell">Food name 1</div>
                        				<div class="orderTableCellAmt">$108.00</div>
                        				<div class="orderTableCell"><input type="number" id="qty1" name="qty1" maxlength="50" value="1" ></div>
                        				<div class="orderTableCellAmt">$108.00</div>
                    				</div>
                    				<div class="orderTableRow">
                        				<div class="orderTableCell">Food name 2</div>
                        				<div class="orderTableCellAmt">$98.00</div>
                        				<div class="orderTableCell"><input type="number" id="qty2" name="qty2" maxlength="50" value="1" ></div>
                        				<div class="orderTableCellAmt">$98.00</div>
                    				</div>
                    				<div class="orderTableRow">
                        				<div class="orderTableCell">Food name 3</div>
                        				<div class="orderTableCellAmt">$188.00</div>
                        				<div class="orderTableCell"><input type="number" id="qty3" name="qty3" maxlength="50" value="1" ></div>
                        				<div class="orderTableCellAmt">$188.00</div>
                    				</div>                				
                    				<div class="orderTableFoot">
                        				<div class="orderTableCell"></div>
                        				<div class="orderTableCellAmt">Total:</div>
                        				<div class="orderTableCell">3</div>
                        				<div class="orderTableCellAmt">$394.00</div>
                    				</div>                     				                    				
                				  </div>
				
								  <hr>
								  <!-- ******** Confirm Delivery Address, Contact Phone No. and Delivery Timeslot ******** -->
                                  <div class="info">
                                  	<div>
                                  		<label class="cart_label">Delivery Address : </label>
                                		<label class="cart_label2">Festival Walk, 80 Tat Chee Ave, Kowloon Tong</label> <a href="#"><label class="cart_label3"> Go to update contact information.</label></a><br>
                                		
                                		<label class="cart_label">Contact Phone No. : </label>
                                		<label class="cart_label2">2626-2626</label><br>
                                		
                                		<label class="cart_label">Delivery Timeslot : </label>
                                    	<select name="cars">
                                    		<option value="0">Immediately</option>
                                     		<option value="1">After 1 hour</option>
                                     		<option value="2">After 2 hours</option>
                                    	</select> 
                                	</div>
                                	
                                	<hr>
                                	<!-- ******** Confirm Payment Method and Payment Information ******** -->
                                    <div>
                                    	<label class="cart_label">Total Payment Amount : </label>
                                    	<label class="cart_label2">$394.00</label><br>
                                    	<label class="cart_label">Payment Method : </label>
                                        <div>
                                            <input type="radio" name="paymentMethod" value="CR" checked>Credit Card</a>                                				
                                            <input type="radio" name="paymentMethod" value="CA">Cash</a>
                                            <input type="radio" name="paymentMethod" value="CH">Cheque</a>
                                        </div>
                                        <input class="cart_input" type="text" id="creditCardNo" name="creditCardNo" placeholder="Credit Card No." maxlength="30">
                                    </div>                  
                                  </div>
                                  
								  <div>
									  <input class="cart_input" type="submit" name="confirmOrder" value="Confirm Payment">
								   </div>				
								</div>
								<!-- ******** [END] User Registration Division ******** -->
								
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