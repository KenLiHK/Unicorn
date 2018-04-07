<?php

include_once("../common/functions.php");

checkLogon();

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
        $api_output['message'] = '<span>No previous comment!</span>';
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

if(isset($_POST['prepareComment'])){	
	$userID= $_SESSION['login_user_id'];
	load_All_Comment_by_UserID($userID);
	exit();
}

function load_All_Comment_by_UserID($userID){
	$_commentArray = db_select_comment_by_UserID($userID);
	echo results_jsonEncode($_commentArray);
}

if(isset($_POST['addComment'])){
	$commentDetail = $_POST['addComment'];
	add_comment($commentDetail);
	exit();
}

function add_comment($commentDetail){
	$data_array 	= json_decode(json_encode($commentDetail), true);
	$orderID		= $data_array['orderID'];
	$rating			= $data_array['rating'];
	$comment		= $data_array['comment'];
	$userID 		= isset($_SESSION['login_user_id']) ? $_SESSION['login_user_id'] : "";
	$now            = date("Y-m-d h:i:sa");
	
	$commentObj = new Comment(NULL, $userID, $orderID, $rating, $comment, $now, $now);
	$commentID = save_comment($commentObj);
	echo $commentID;
}

?>



