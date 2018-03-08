<?php
/**
 * Created by PhpStorm.
 * User: pcc
 * Date: 04/02/2018
 * Time: 17:50
 */

include_once("../common/database.php");
include_once("../common/functions.php");
include_once("../common/entity.php");
include_once("db_recom.php");


define('MAX_RECOM_FOOD', 4);


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
    load_CateName($cate2Load);
    exit();
}

function load_CateName($cate2Load){
    $res = db_query_food_list_byCateName($cate2Load);
    echo results_jsonEncode($res);
}

if(isset($_POST['displayCate'])){
   load_FoodInCate();
    exit();
}

function load_FoodInCate(){
    $res = db_select_allAvailCategories();
    echo results_jsonEncode($res);
}

//$res = db_select_allFoodCateIsAval();
//echo results_jsonEncode($res);


function get_RecomFood_byUserId($userId){

    $res = db_select_latestOrderId_byUserId($userId);
//    $res = results_jsonEncode($res);
//    echo $res;
    if(count($res)==0){
        //This user doesn't have any history order, recommend as unlogin user or check the outstanding order?
    }
    else{
        $orderId = $res[0]['order_id'];
//        print_r($orderId);
        $cateList = db_select_orderFoodCateList_byOrderId($orderId);
        $recomFoodList = array();
        $_selectedFoodIds = array();
        $sizeOfCateList = count($cateList);
        $_allSelectedCate = array();

//        if($sizeOfCateList < MAX_RECOM_FOOD){
//            $i = 0;
//            do{
//                $res = getRandFoodFromCate($cateList[$i]['food_category'],$_selectedFoodIds);
//                if($res['food'] != null){
//                    $_genFood = $res['food'];
//                    $_selectedFoodIds = $res['selectedId_array'];
//                    array_push($recomFoodList, $_genFood);
//                }
//                if($i==$sizeOfCateList){
//                    $i = 0;
//                }
//                else{
//                    $i++;
//                }
//            }while(count($recomFoodList) < MAX_RECOM_FOOD);
//        }
        do{
            do{
                $_randIndex = mt_rand(0, $sizeOfCateList);
            }while(in_array($_randIndex, $_allSelectedCate));
            $res = getRandFoodFromCate($cateList[$_randIndex]['food_category'],$_selectedFoodIds);
            if($res['food'] != null){
                $_genFood = $res['food'];
                $_selectedFoodIds = $res['selectedId_array'];
                array_push($recomFoodList, $_genFood);
            }
            else{
                array_push($_allSelectedCate, $_randIndex);
            }

        }while(count($recomFoodList) < MAX_RECOM_FOOD);
    }

    return $recomFoodList;

}



function getRandFoodFromCate($cateName, $selectedIdArray){
    $res = db_query_food_list_byCateName($cateName);
    $max = count($res);
    $inCount = 0;

    //Check if all foods in the category have been selected
    for($i=0; $i<=$max; $i++){
        if(in_array($res[$i]['food_id'], $selectedIdArray)){
            $inCount++;
        }
    }

    if($inCount == $max){
        return array('food'=>null, 'selectedId_array'=>$selectedIdArray);
    }
    //If not all selected, randomly select one and update selectedIdArray
    else{
        do{
            $_tmp = mt_rand(0, $max);
            $foodId = $res[$_tmp]['food_id'];
        }while(in_array($foodId, $selectedIdArray));

        $food = new Food($foodId);  //需要新的构造方法!!
        $food->setImgPath($res[$_tmp]['img_path']);
        $food->setFoodName($res[$_tmp]['food_name']);
        $food->setPrice($res[$_tmp]['price']);
        $food->setDiscount($res[$_tmp]['discount']);

        array_push($selectedIdArray,$food->getFoodID());
        return array('food'=>$food, 'selectedId_array'=>$selectedIdArray);
    }
}

$result = get_RecomFood_byUserId('kenli');
print_r($result)
//$res = db_query_food_list_byCateName('LU');
//print_r($res);



?>