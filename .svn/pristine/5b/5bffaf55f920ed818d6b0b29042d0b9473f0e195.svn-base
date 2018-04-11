<?php

include_once("../common/functions.php");


//Receive Ajax call with parameter foodData2Add and add the food to selectedFoodMap in user login session.
if(isset($_POST['foodData2Add']))
{
    $foodData2Add = $_POST['foodData2Add'];
    addToSelectedFoodMap($foodData2Add);
	exit();
}

function addToSelectedFoodMap($foodData2Add)
{
    //javascript object {foodID:$foodID, qty:$qty}
	$foodData2Add_array = json_decode(json_encode($foodData2Add), true);	
	$addFoodID = $foodData2Add_array['foodID'];
	$addQty = $foodData2Add_array['qty'];
	$_newSelectedFoodMap = array();
	
	if(!isset($addFoodID) || !isset($addQty)){
		echo false;
		return;
	}
	
	if(isset($addQty) && $addQty <= 0){
		echo false;
		return;
	}
	
    session_start();
    
    if(isset($_SESSION['selected_food_map'])){
        $_selectedFoodMap_in_session = $_SESSION['selected_food_map'];
        unset($_SESSION['selected_food_map']);
        $isExisted = false;

        for ($row = 0; $row < count($_selectedFoodMap_in_session); $row++) {
            $foodID = $_selectedFoodMap_in_session[$row]["foodID"];
            $qty = $_selectedFoodMap_in_session[$row]["qty"];

            if($foodID == $addFoodID){
                $qty = $qty + $addQty;
                $selectedFood = array("foodID" => $foodID, "qty" => $qty);
                array_push($_newSelectedFoodMap, $selectedFood);
                $isExisted = true;
            }else{
                $selectedFood = array("foodID" => $foodID, "qty" => $qty);
                array_push($_newSelectedFoodMap, $selectedFood);
            }
        }
        
        if(!$isExisted){
            $newFood = array("foodID" => $addFoodID, "qty" => $addQty);
            array_push($_newSelectedFoodMap, $newFood);
        }
    }else{
        $selectedFood = array("foodID" => $addFoodID, "qty" => $addQty);
        array_push($_newSelectedFoodMap, $selectedFood);                
    }
    
    $_SESSION['selected_food_map'] = $_newSelectedFoodMap;
    echo true;    
    return;
}

//Receive Ajax call with parameter foodData2Remove and remove the food from selectedFoodMap in user login session.
if(isset($_POST['foodData2Substract']))
{
	$foodData2Substract= $_POST['foodData2Substract'];
	substractFromSelectedFoodMap($foodData2Substract);
    exit();
}

function substractFromSelectedFoodMap($foodData2Substract)
{
	//javascript object {foodID:$foodID, qty:$qty}
	$foodData2Substract_array = json_decode(json_encode($foodData2Substract), true);
	$substractFoodID = $foodData2Substract_array['foodID'];
	$substractQty = $foodData2Substract_array['qty'];
	$_newSelectedFoodMap = array();
	
	if(!isset($substractFoodID) || !isset($substractQty)){
		echo false;
		return;
	}
	
	if(isset($substractQty) && $substractQty<= 0){
		echo false;
		return;
	}
	
	session_start();
	
	if(isset($_SESSION['selected_food_map'])){
		$_selectedFoodMap_in_session = $_SESSION['selected_food_map'];
		unset($_SESSION['selected_food_map']);
		
		for ($row = 0; $row < count($_selectedFoodMap_in_session); $row++) {
			$foodID = $_selectedFoodMap_in_session[$row]["foodID"];
			$qty = $_selectedFoodMap_in_session[$row]["qty"];
			
			if($foodID == $substractFoodID){
				$qty = $qty - $substractQty;
				if($qty > 0){
					$selectedFood = array("foodID" => $foodID, "qty" => $qty);
					array_push($_newSelectedFoodMap, $selectedFood);
				}
			}else{
				$selectedFood = array("foodID" => $foodID, "qty" => $qty);
				array_push($_newSelectedFoodMap, $selectedFood);
			}
		}		
	}else{
		echo false;
		return;
	}
	
	$_SESSION['selected_food_map'] = $_newSelectedFoodMap;
	echo true;
	return;
}

// Receive Ajax call with parameter foodID2Count, if parameter = 'ALL' then count all in selectedFoodMap in user login session.
// Otherwise, count the number of specified food.
if(isset($_POST['foodID2Count']))
{
	$foodID2Count= $_POST['foodID2Count'];
	countFoodFromSelectedFoodMap($foodID2Count);
	exit();
}

function countFoodFromSelectedFoodMap($foodID2Count)
{
	//javascript object {foodID:$foodID}
	$foodID2Count_array = json_decode(json_encode($foodID2Count), true);
	$countFoodID = $foodID2Count_array['foodID'];
	
	if(!isset($countFoodID)){
		echo 0;
		return;
	}
	
	session_start();
	
	if(isset($_SESSION['selected_food_map'])){
		$_selectedFoodMap_in_session = $_SESSION['selected_food_map'];
		$countAll = 0;
		for ($row = 0; $row < count($_selectedFoodMap_in_session); $row++) {
			$foodID = $_selectedFoodMap_in_session[$row]["foodID"];
			$qty = $_selectedFoodMap_in_session[$row]["qty"];
			$countAll = $countAll + $qty;
			
			if($foodID == $countFoodID){
				echo $qty;
				return;
			}
		}
		
		if($countFoodID == "ALL"){
			echo $countAll;
			return;
		}
	}

	echo 0;
	return;
}


?>