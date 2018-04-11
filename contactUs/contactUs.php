<?php

include_once("../common/functions.php");

healthCheckDB();
healthCheckDBTables();

check_session_timeout();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_SESSION['login_user_id'])){
	$userID_In_Session = $_SESSION['login_user_id'];
}

?>
<html>

	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant - Contact Us</title>
		
		<?php include_once("../import.php");?>
		
		<link rel="stylesheet" href="../unicorn.css" type="text/css">
	</head>


	<body>
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
							<div class="alert mt-4 alert-success">
								<span class="badge badge-pill badge-success">Welcome Ken!!</span> We promise to deliver the freshest foods to you as soon as possible. 							
							</div>
							<!-- ******** [END] Alert Message Display ******** -->
							
							
							
							<!-- ******** [START] Food Navigation Division ******** -->
							<h3>Unicorn Restaurant Address</h3>
							<hr>
							<div>
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1845.2142512517173!2d114.17161262136285!3d22.337443559179594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3404073400f3ef35%3A0xb6954fc2f7f6aa44!2sLi+Dak+Sum+Yip+Yio+Chin+Academic+Building%2C+City+University+of+Hong+Kong!5e0!3m2!1sen!2shk!4v1518196898716" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
							</div>
							<!-- ******** [END] Food Navigation Division ******** -->
							
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
	
	</body>
</html>