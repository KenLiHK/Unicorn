<?php

include_once("../common/functions.php");

check_session_timeout();

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

function results_jsonEncode($oriResArray){
    $api_output = array(
        'data'=>array(),
        'message'=>'',
        'code'=>2
    );
    if(!is_array($oriResArray)){
        $api_output['message'] = '<span style="color:red;">[E801] The result from sql is not an array!</span>';
        $api_output['code'] = 1;
    }
    else if(count($oriResArray) == 0){
        $api_output['message'] = '<span>No new notification!</span>';
        $api_output['code'] = 2;
    }
    else{
        $api_output['data'] = $oriResArray;
        $api_output['message'] = '';
        $api_output['code'] = 0;
    }
    $json_print = json_encode($api_output, JSON_PRETTY_PRINT);
    return $json_print;

}

if(isset($_POST['prepareNotification'])){	
	$userID= $_SESSION['login_user_id'];
	load_All_Notification_by_UserID($userID);
	exit();
}

function load_All_Notification_by_UserID($userID){
	$_notificationArray = get_notification_list_by_userID($userID);
	echo results_jsonEncode($_notificationArray);
}

if(isset($_POST['updateNotification'])){
	$notiID = $_POST['updateNotification'];
	update_noti($notiID);
	exit();
}

function update_noti($notiID){
	$data_array 	= json_decode(json_encode($notiID), true);
	$notiIDTmp      = $data_array['notiID'];
	$userID 		= isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : "";
	$now            = date("Y-m-d h:i:sa");
	
	$notiObj = new UserNotification($notiIDTmp, $userID, "NS11", NULL, $now);
	$notiIDResult = update_notification($notiObj);
	echo $notiIDResult;
}

if(isset($_POST['notification2Count'])){
    $userID = isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : "";
    $count = 0;
    if($userID != ""){
        $count = count_Notification_by_UserID($userID);
    }
    
    if($count > 0){
        echo $count;
    }else{
        echo 0;
    }
    exit();
}

function count_Notification_by_UserID($userID){
    return get_notification_count_by_userID($userID);        
}

?>