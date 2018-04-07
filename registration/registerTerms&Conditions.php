<?php

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
		
		<title>Unicorn Restaurant - Registration</title>
		
		<?php include_once("../import.php");?>
		
		<link rel="stylesheet" href="../unicorn.css" type="text/css">
		<link rel="stylesheet" href="./registration.css" type="text/css">		
		<script type="text/javascript" src="../unicorn.js"></script>
		<script type="text/javascript" src="./registration.js"></script>
	</head>


	<body>
		<form name="regForm" method="post" action="" onsubmit="">
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
									<span></span>
								</div>
								<!-- ******** [END] Alert Message Display ******** -->
								
								
								
								<!-- ******** [START] User Registration Division ******** -->
								<div class="container">
									<h3>Registration Terms and Conditions</h3>
									<hr>
									<ul>
										<li>
											Your registration is personal to you. Each registration is for a single user only. 
											  You will be asked to choose your user name and password which in combination ('Your ID') will be unique to you. 
											  You must not permit any other person to share use of Your ID or permit multiple users to access this website using Your ID.
										</li>
										<br><br>
										<li>
											You are responsible for all use of this website using Your ID and for preventing unauthorized use of Your ID. 
											  If you believe that there has been or will be a potential breach of Your ID security please notify us immediately by emailing 
											  <a href="mailto:cs5281unicorn@unicorn.com?Subject=Account%20Enquiry" target="_top">cs5281unicorn@unicorn.com</a>											  .
										</li>
										<br><br>
										<li>
											You will be required to provide Your ID to gain access to this website.
										</li>
										<br><br>
									</ul>
									
								</div>	
								<!-- ******** [END] User Registration Division ******** -->
								
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