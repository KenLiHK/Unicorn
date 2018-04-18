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
		<meta http-equiv="refresh" content="10; URL=../recommend/recom_home.php">
		
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
									<span>We promise to deliver the freshest foods to you as soon as possible.</span>
								</div>
								<!-- ******** [END] Alert Message Display ******** -->
								
								
								
								<!-- ******** [START] User Registration Division ******** -->
								<div class="container">
									<h5 class="reg_failure">Problem in user account registration. Please try again!</h5>
									<hr>
									
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