<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['login_user_id'])){
	$userID_In_Session = $_SESSION['login_user_id'];
}

$_exceptionMsg = isset($_SESSION['exception_msg']) ? $_SESSION['exception_msg'] : "";
unset($_SESSION['exception_msg']);

?>
<html>

	<head>
		<meta charset="utf-8">
		
		<title>Unicorn Restaurant - Exception</title>
		
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
							<div class="alert mt-4 alert-danger">
								<span class="Exception page" id="cartMsg" ><?php if(isset($_exceptionMsg)){echo $_exceptionMsg;} ?></span> 							
							</div>
							<!-- ******** [END] Alert Message Display ******** -->
							
							
							
							<!-- ******** [START] Exception Page Division ******** -->
						
							<!-- ******** [END] Exception Page Division ******** -->
							
							<?php include_once("../footer.php");?>
							
							
							
						</div>
					</div>
					<!-- ******** [END] Navigation Body ******** -->
					
					
					
				</div>
				<!-- ******** [END] Right panel ******** -->
				
				
			</div>
		</div>
	
	</body>
</html>