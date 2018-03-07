<?php
/**
 * Created by PhpStorm.
 * User: pcc
 * Date: 04/02/2018
 * Time: 17:50
 */

include_once("../common/database.php");
include_once("../common/functions.php");
include_once("db_recom.php");


function results_jsonEncode($oriResArray){
    $api_output = array(
        'data'=>array(),
        'message'=>'',
        'code'=>2
    );
    if(!is_array($oriResArray)){
        $api_output['message'] = '[E301]the result from sql is not an array!';
        $api_output['code'] = 1;
    }
    else if(count($oriResArray) == 0){
        $api_output['message'] = '[E302]no results!';
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


if(isset($_POST['cate2Load'])){
    $cate2Load = $_POST['cate2Load'];
    $res = db_query_food_list_byCateName($cate2Load);
    echo results_jsonEncode($res);
    exit();
}

if(isset($_POST['displayCate'])){
    $res = db_select_allFoodCateIsAval();
    echo results_jsonEncode($res);
    exit();
}

//$res = db_select_allFoodCateIsAval();
//echo results_jsonEncode($res);

function console_log($data)
{
    if (is_array($data) || is_object($data))
    {
        echo("<script>console.log('".json_encode($data)."');</script>");
    }
    else
    {
        echo("<script>console.log('".$data."');</script>");
    }
}

//console_log($_POST[$cate2Load]);




?>