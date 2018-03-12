<?php
/**
 * Created by PhpStorm.
 * User: pcc
 * Date: 04/02/2018
 * Time: 15:20
 */

include_once("../common/database.php");
include_once("../common/functions.php");
include_once("db_recom.php");
include_once ("recommendService.php");

//$sql = "SELECT `food_id`,`img_path`, `food_name`, `price`, `discount` FROM `food` WHERE `food_category` = 'LX' AND `available` = 'Y'";
//$sql = "SELECT DISTINCT `food_category` FROM `food` WHERE `available` = 'Y'";
//$res = db_query($sql);
//print_r(count($res));
//exit(json_encode($res, JSON_PRETTY_PRINT));

function food_list_jsonEncode($oriArray){
    $api_output = array(
        'data'=>array(),
        'message'=>'',
        'code'=>2
    );
    if(!is_array($oriArray)){
        $api_output['message'] = '[E201]the result from sql is not an array!';
        $api_output['code'] = 1;
    }
    else if(count($oriArray) == 0){
        $api_output['message'] = '[E202]no results!';
        $api_output['code'] = 2;
    }
    else{
        $api_output['data'] = $oriArray;
        $api_output['message'] = '';
        $api_output['code'] = 0;
    }
    $json_print = json_encode($api_output, JSON_PRETTY_PRINT);
    return $json_print;

}

$result = get_RecomFood_byUserId('kenli');
$result = json_encode($result);
echo $result;
//$res = db_query_food_list_byCate('min');
//$res = db_select_allAvailCategories();
//print_r(food_list_jsonEncode($res));



?>