/******** [START] Place order JavaScript ********/
function addFoodToCart($foodID, $qty)
{
	var _foodData = {"foodID":$foodID, "qty":$qty}; 
	if(_foodData)
	{
		$.ajax(
			{
				type: 'post',
				url: './cartAjaxService.php',
				
				data: {
					foodData2Add:_foodData
				},
				
				success: function (SUCCESSorFAIL) 
				{
					return SUCCESSorFAIL;
				}
			}
		);
	}
}

function substractFoodFromCart($foodID, $qty)
{
	var _foodData = {"foodID":$foodID, "qty":$qty}; 
	if(_foodData)
	{
		$.ajax(
			{
				type: 'post',
				url: './cartAjaxService.php',
				
				data: {
					foodData2Substract:_foodData
				},
				
				success: function (SUCCESSorFAIL) 
				{
					return SUCCESSorFAIL;
				}
			}
		);
	}
}

function countFoodFromCart($foodID)
{
	var _foodData = {"foodID":$foodID}; //if foodID == "ALL", then sum all food's quantity
	if(_foodData)
	{
		$.ajax(
			{
				type: 'post',
				url: './cartAjaxService.php',
				
				data: {
					foodID2Count:_foodData
				},
				
				success: function (qty) 
				{
					return qty;
				}
			}
		);
	}
}
/******** [END] Place order JavaScript ********/