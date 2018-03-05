<?php

include_once("../common/database.php");
include_once("../common/functions.php");

if( isset($_GET["reg_token"]) && !empty($_GET["reg_token"]) && isset($_GET["email"]) && !empty($_GET["email"]) ){
    //Receive reg_token from GET request
    $_reg_token = mysql_escape_string($_GET['reg_token']); //Escape special character to prevent SQL injection
	$_email = mysql_escape_string($_GET['email']); //Escape special character to prevent SQL injection	
	
	//Check if this email and regToken existed in database USER table
	$_user_in_db = array();
	$_user_in_db = db_select_user_by_Email_RegToken($_email, $_reg_token);
		
	if(isset($_user_in_db)){
		//Update LAST_LOGIN_TIME in database USER table
		$_isLogin = login_after_activation($_email, $_reg_token);
		
		if(isset($_isLogin) && $_isLogin){
			$_updated_row_count = db_update_user_remove_RegToken($_email, $_reg_token);
			if(isset($_updated_row_count) && $_updated_row_count == 1){
				prepare_login_session($_user_in_db[0], $_user_in_db[1]);
			
				//When login success, go to home page with login session
				header('Location: ../home.php');
				exit;
			}else{				
				header('Location: ./activateFailure.php');
				exit;				
			}
		}else{			
			header('Location: ./activateFailure.php');
			exit;			
		}
	}else{		
		header('Location: ./activateFailure.php');
		exit;
	}
}

?>