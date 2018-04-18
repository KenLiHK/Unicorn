<?php
/**
 * Created by PhpStorm.
 * User: pcc
 * Date: 04/02/2018
 * Time: 17:50
 */

include_once("../common/functions.php");
include_once("db_recom.php");


define('MAX_RECOM_FOOD', 4);


function results_jsonEncode($oriResArray){
    $api_output = array(
        'data'=>array(),
        'message'=>'',
        'code'=>2
    );
    if(!is_array($oriResArray)){
        $api_output['message'] = '<span style="color:red;">[E301] The result from sql is not an array!</span>';
        $api_output['code'] = 1;
    }
    else if(count($oriResArray) == 0){
        $api_output['message'] = '<span style="color:red;">[E302] No results!</span>';
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

if(isset($_POST['prepareCate'])){
	load_All_Food_Category_Name();
	exit();
}

function load_All_Food_Category_Name(){
	$res = db_select_all_food_category_name();
	echo results_jsonEncode($res);
}

if(isset($_POST['prepareLiveSearch'])){
	load_All_Food_Name_Tag();
	exit();
}

function load_All_Food_Name_Tag(){
	$res = db_select_all_food_name_tag();
	echo results_jsonEncode($res);
}

if(isset($_POST['prepareLiveSearchByCat'])){
	$cat = $_POST['prepareLiveSearchByCat'];
	load_All_Food_Cat($cat);
	exit();
}

function load_All_Food_Cat($cat){
	$res = db_select_all_food_cat($cat);
	echo results_jsonEncode($res);
}

if(isset($_POST['searchFoodCatName'])){
	$FoodCatName= $_POST['searchFoodCatName'];
	Search_Food_By_Food_Cat_Name($FoodCatName);
	exit();
}

function Search_Food_By_Food_Cat_Name($FoodCatName){
	$data_array = json_decode(json_encode($FoodCatName), true);
	$foodCate = isset($data_array['foodCate']) ? $data_array['foodCate'] : "";
	$foodName = isset($data_array['foodName']) ? $data_array['foodName'] : "";
	
	$res= db_select_food_by_food_category_name($foodCate, $foodName);
	echo results_jsonEncode($res);
}

if(isset($_POST['cate2Load'])){
    $cate2Load = $_POST['cate2Load'];
    load_CateName($cate2Load);
    exit();
}

function load_CateName($cate2Load){
    $res = db_select_food_list_byCateName($cate2Load);
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

if(isset($_POST['logonCheck'])){	
    if(checkUserLogon()){
        $userId = $_SESSION['login_user_id'];
        $result = get_RecomFood_byUserId($userId);
    }
    else{
        $result = get_randFood_from_tagSearchResult('Hot');
    }

    echo results_jsonEncode($result);
}

function get_RecomFood_byUserId($userId){

    $res = db_select_latestOrderId_byUserId($userId);
//    $res = results_jsonEncode($res);
//    echo $res;
    if(count($res)==0){
        //This user doesn't have any history order, recommend as unlogin user or check the outstanding order?
        return $recomFoodList = get_randFood_from_tagSearchResult('Hot');
    }
    else{
        $orderId = $res[0]['order_id'];
        $cateList = db_select_orderFoodCateList_byOrderId($orderId);
        $recomFoodList = array();
        $_selectedFoodIds = array();
        $sizeOfCateList = count($cateList);
        $_allSelectedCate = array();

        do{
            do{
                $_randIndex = mt_rand(0, $sizeOfCateList-1);
            }while(in_array($_randIndex, $_allSelectedCate));
            $_selectedCate = $cateList[$_randIndex];
            $res = get_randFood_from_cate($_selectedCate['food_category'],$_selectedFoodIds);
            if($res['food'] != null){
                $_genFood = $res['food'];
                $_selectedFoodIds = $res['selectedId_array'];
                array_push($recomFoodList, $_genFood);
            }
            elseif(is_string($res['food'])){
                echo $res['food'];
            }
            else{
//                print_r('All food in the cate have been selected!'.'<br>');
                array_push($_allSelectedCate, $_randIndex);
//                print_r($_allSelectedCate);
            }

//            print_r('RecomlistLength='.count($recomFoodList). '<br>');
        }while(count($recomFoodList) < MAX_RECOM_FOOD);
    }
    return $recomFoodList;

}


function get_randFood_from_cate($cateName, $selectedIdArray){
    $res = db_select_food_list_byCateName($cateName);
    if(is_string($res)){
        return array('food'=>$res, 'selectedId_array'=>$selectedIdArray);
    }

    $max = count($res);
    $inCount = 0;

    //Check if all foods in the category have been selected
    for($i=0; $i<$max; $i++){
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
            $_tmp = mt_rand(0, $max-1);
            $foodId = $res[$_tmp]['food_id'];
        }while(in_array($foodId, $selectedIdArray));

        $food = $res[$_tmp];
        array_push($selectedIdArray,$res[$_tmp]['food_id']);
        return array('food'=>$food, 'selectedId_array'=>$selectedIdArray);
    }
}

//Function created but not used yet
function convertFoodObj2Array($Food){
    $foodArray = array(
        'food_id'=> $Food->getFoodID(),
        'food_name'=>$Food->getFoodName(),
        'img_path'=>$Food->getImgPath(),
        'price'=>$Food->getPrice(),
        'discount'=>$Food->getDiscount(),
        'food_category'=>$Food->getFoodCategory(),
        'available'=>$Food->getAvailable(),
        'discountEffectDate'=>$Food->getDiscountEffectDate(),
        'discountExpiryDate'=>$Food->getDiscountExpiryDate(),
        'remark'=>$Food->getRemark(),
        'createDate'=>$Food->getCreateDate(),
        'updateDate'=>$Food->getUpdateDate(),
    );
    return $foodArray;

}

//Function created but not used yet
function jsonEncode_foodObjArray($FoodObjArray2Encode){
    $jsonArray = array();
    for($i=0; $i<count($FoodObjArray2Encode); $i++){
        $arrayItem = convertFoodObj2Array($FoodObjArray2Encode[$i]);
        array_push($jsonArray, $arrayItem);
    }
    return $jsonArray;
}

function get_RecomFood_byHotTag($tagName){

}

function get_randFood_from_tagSearchResult($tagName){
    $foodArray2Return = array();
    $foodArray2Return = db_select_food_list_byTagName($tagName);

    $inCount= count($foodArray2Return);
    $moreRecomFood = array();
    $tmpFoodArray = array();
    
    if($inCount < MAX_RECOM_FOOD){
    	$limitNo = MAX_RECOM_FOOD - $inCount;
    	$moreRecomFood = db_select_lowest_Price_food_list();
    	
    	if(isset($moreRecomFood)){
    		for($i = 0; $i < count($moreRecomFood); $i++){
    			if($limitNo > 0){
    				$isFound = false;
	    			for($j = 0; $j < count($foodArray2Return); $j++){
	    				$iFoodId = $moreRecomFood[$i]['food_id'];
	    				$jFoodId = $foodArray2Return[$j]['food_id'];
						
	    				if($iFoodId == $jFoodId){
	    					$isFound = true;
	    				}	    				
	    			}
	    			
	    			if(!$isFound){
	    				array_push($tmpFoodArray,$moreRecomFood[$i]);
	    				$limitNo--;
	    			}
    			}
    		}
    		
    		for($k = 0; $k < count($tmpFoodArray); $k++){
    			array_push($foodArray2Return, $tmpFoodArray[$k]);
    		}
    	}
    }
    return $foodArray2Return;
}

//$result = get_randFood_from_tagSearchResult('Hot');
//$result = jsonEncode_FoodObjArray($result);
//echo results_jsonEncode($result);

//$res = db_query_food_list_byCateName('LU');




?>