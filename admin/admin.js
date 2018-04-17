/******** [START] Admin functions JavaScript ********/

$(document).ready(function(){	
	tagging();
	prepareFoodCat();
	checkFoodCat_Name();
    showItemCount();
});

function tagging(){
	$('#tagBox').tagging();
}

function prepareFoodCat(){
    var availableFoodCat = [];
    var $foodCatSection = "";
	$.ajax(
	        {
	            type:'post',
	            url:'adminAjaxService.php',
	            data:{
	                getExistingFoodCat:true
	            },
	            dataType:'json',
	            success:function(result){
	            	$foodCatSection += '<select class="admin_select" id="id_foodCatSel" name="foodCatSel">	            			 ';
	            	$foodCatSection += '       <option value=""></option>                                        ';

	                if(result["code"] == 0){	                    
	                    $.each(result["data"],function(i,n){
	                        var $foodCat 	= n["food_category"];	                        
	                        $foodCatSection += '<option value="' + $foodCat + '">' + $foodCat + '</option>       ';	                        
	                        availableFoodCat.push($foodCat);
	                    }); 
	                }
	                
	                $foodCatSection += '</select>											                     ';
	                $('#foodCat-section').append($foodCatSection);
	                
	            }
	        }
	    )
	    
	  $( function() {
		    $( "#id_foodCat" ).autocomplete({
		      source: availableFoodCat
		    });
		  } );
}

function checkFoodCat_Name(){
	$("#id_foodName").blur(
		function(){
			document.getElementById("foodCatMsg").innerHTML = "";
			document.getElementById("foodNameInfoMsg").innerHTML = "";
			document.getElementById("foodNameMsg").innerHTML = "";
			checkFoodCatNameExist();
		}
	);
}

function checkFoodCatNameExist(){
	var _cat 			= "";
	var _catType		= document.getElementById("id_type1").checked;
	var _foodName	 	= document.forms["addFoodForm"]["foodName"].value.trim();
		
	if(_catType){
		_cat = document.forms["addFoodForm"]["foodCatSel"].value.trim();
	}else{
		_cat = document.forms["addFoodForm"]["foodCat"].value.trim();
	}

	if(_cat != "" && _foodName != "")
	{
		var _foodCatName = {"foodCate":_cat, "foodName":_foodName}; 
		
		$.ajax(
			{
				type: 'post',
				url: './adminAjaxService.php',
				
				data: {
					foodCatName2Check:_foodCatName
				},
				
				success: function (response) 
				{
					if(response == 0)
					{
						document.getElementById("foodNameInfoMsg").innerHTML = 		"[I901] This new food name is acceptable!";
					} else if(response == -1)
					{
						document.getElementById("foodNameInfoMsg").innerHTML = 		"[E913] System error, please try again later!";
					} else
					{
						document.getElementById("foodCatMsg").innerHTML =			"[E907] The food name is existing in the food category!";
					}
				}
			}
		);
	}
}

function clickExistedCat(){	
	document.getElementById("id_foodCat").value = "";
    document.getElementById('id_foodCat').disabled = true;
    document.getElementById('id_foodCatSel').disabled = false;
}

function clickNewCat(){	
	document.getElementById("id_foodCat").value = "";
    document.getElementById('id_foodCat').disabled = false;
    document.getElementById('id_foodCatSel').selectedIndex = 0;
    document.getElementById('id_foodCatSel').disabled = true;
}

function resetErrMsg(){
	document.getElementById("foodImgInfoMsg").innerHTML = "";
	document.getElementById("foodImgMsg").innerHTML = "";
	document.getElementById("foodCatMsg").innerHTML = "";
	document.getElementById("foodNameInfoMsg").innerHTML = "";
	document.getElementById("foodNameMsg").innerHTML = "";	
	document.getElementById("priceMsg").innerHTML = "";
	//document.getElementById("discountMsg").innerHTML = "";
	//document.getElementById("effectDateMsg").innerHTML = "";	
}

function formSubmit(){	
	resetErrMsg();
	var isValid = addFoodFormValidate();
	if(!isValid){
		return false;
	}
}

function addFoodFormValidate(){	
	var isValid = true;
	
	var _cateType 				= document.forms["addFoodForm"]["cateType"].value.trim();
	var _foodCatSel 			= document.forms["addFoodForm"]["foodCatSel"].value.trim();	
	var _foodCat				= document.forms["addFoodForm"]["foodCat"].value.trim();
	var _foodName	 			= document.forms["addFoodForm"]["foodName"].value.trim();
	var _available	 			= document.forms["addFoodForm"]["available"].value.trim();
	var _price		 			= document.forms["addFoodForm"]["price"].value.trim();
	//var _discount 				= document.forms["addFoodForm"]["discount"].value.trim();
	//var _fromDate				= document.forms["addFoodForm"]["fromDate"].value.trim();
	//var _toDate 				= document.forms["addFoodForm"]["toDate"].value.trim();
	var _remarks 				= document.forms["addFoodForm"]["remarks"].value.trim();

	
	// ******** [START] Food category validation ********	
    if (_cateType == "ex" && _foodCatSel == "") {
		document.getElementById("foodCatMsg").innerHTML = 								"[E901] Food category must be selected!";
		isValid = false;
    }
    
    if (_cateType == "nw" && _foodCat == "") {
		document.getElementById("foodCatMsg").innerHTML = 								"[E902] Food category must be input!";
		if(isValid){
			document.forms["addFoodForm"]["foodCat"].focus();
		}
		isValid = false;
    }
    // ******** [END] Food category validation ********
    
    // ******** [START] Food name validation ********
    if (_foodName == ""){
		document.getElementById("foodNameMsg").innerHTML = 								"[E903] Food name must be input!";
		if(isValid){
			document.forms["addFoodForm"]["foodName"].focus();
		}
		isValid = false;
    }
    
    // ******** [END] Food name validation ********
    
    // ******** [START] Price validation ********
    if (_price == "") {
		document.getElementById("priceMsg").innerHTML = 								"[E904] Price must be input!";				
		
		if(isValid){
			document.forms["addFoodForm"]["price"].focus();   
		}
        isValid = false;
    } else {
		var _priceDigitOnly = _price.trim().replace(/\D/g, "");
		var regularExpress4Price = /^\d+$/;		
		var isValidPrice = regularExpress4Price.test(_priceDigitOnly);
  
		if(!isValidPrice){
			document.getElementById("priceMsg").innerHTML = 							"[E905] Price must be numeric!";				
			
			if(isValid){
				document.forms["addFoodForm"]["price"].focus();   
			}
			isValid = false;
		}		
		else{
			if(_price < 1 || _price > 5000){
				document.getElementById("priceMsg").innerHTML = 						"[E906] Price must be greater than 0 and less than 5000!";				
				
				if(isValid){
					document.forms["addFoodForm"]["price"].focus();   
				}
				isValid = false;
			}
		}		
    }    
    // ******** [END] Price validation ********
        
    return isValid;
}
/******** [END] Admin functions JavaScript ********/

