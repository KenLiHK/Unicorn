<?php

include_once("../common/functions.php");

checkLogon();

//Receive Ajax call with parameter email2Check and check if the received Email exist in Database USER table.
if(isset($_POST['emailUserID2Check']))
{
	$emailUserID2Check= $_POST['emailUserID2Check'];
	//echo $emailUserID2Check;
	checkEmail($emailUserID2Check);
	exit();
}

function checkEmail($emailUserID2Check)
{
	//javascript object {email:_email, userID:_userID}
	$data_array = json_decode(json_encode($emailUserID2Check), true);
	$email= $data_array['email'];
	$userID= $data_array['userID'];
	
	$_email = db_select_user_by_Email_UserID($email, $userID);
	if(isset($_email))
	{
		echo "Y"; //Found Email in DB
	}
	else
	{
		echo "N"; //NOT found Email in DB
	}
}

?>