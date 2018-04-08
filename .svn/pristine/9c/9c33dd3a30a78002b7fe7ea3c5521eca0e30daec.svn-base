
$(document).ready(function(){
	prepareCommentSection();
});

function prepareCommentSection(){
	var $commentSection = "";
	$('#commentDetail-section').empty();
	
	$.ajax(
        {
            type:'post',
            url:'commentService.php',
            data:{
                prepareComment:true
            },
            dataType:'json',
            success:function(result){
                if(result["code"]!=0){
                    //If the results of query is abnormal, display error msg given by backend.
                	$commentSection = result["message"];
                }
                else{
                    $.each(result["data"],function(i,n){
                    	var $_commentID 	= n["COMMENT_ID"];
                        var $_orderID 		= n["ORDER_ID"];
                        var $_rating 		= n["RATING"];
                        var $_comment 		= n["CONTENT"];
                        var $_createDate 	= n["CREATE_DATE"];

                        $commentSection += prepareComment($_commentID, $_orderID, $_rating, $_comment, $_createDate);
                    }); 
                }

                $('#commentDetail-section').append($commentSection);                
            }
        }
    )
}

function prepareComment($_commentID, $_orderID, $_rating, $_comment, $_createDate){
	var check1 = "";
	var check2 = "";
	var check3 = "";
	var check4 = "";
	var check5 = "";
	
	if($_rating == 1){
		check1 = "checked";
	}else if($_rating == 2){
		check2 = "checked";
	}else if($_rating == 3){
		check3 = "checked";
	}else if($_rating == 4){
		check4 = "checked";
	}else if($_rating == 5){
		check5 = "checked";
	}
	
	var commentSec = "";
	
	commentSec +=
	'<div class="comment-container">																											' +
	'    <div class="comment-init">																												' +
	'	    <div class="comment-order">																											' +
	'		    <p id="text-order">Previous Order</p>																							' +
	'	    </div>																																' +
	'	    <div class="comment-name">																											' +
	'		    <p id="text-name">Your comment</p>																						        ' +
	'	    </div>																																' +
	'       <div class="comment-star">																											' +
	'           <div class="star-rating">																										' +
	'	            <input id="' + $_commentID + 'star-5" type="radio" name="rating' + $_commentID + '" value="5" ' + check5 + ' disabled>		' +
	'	            <label for="' + $_commentID + 'star-5" title="5 stars' + $_commentID + '">													' +
	'			        <i class="active fa fa-star" aria-hidden="true"></i>																	' +
	'	            </label>																													' +
	'	            <input id="' + $_commentID + 'star-4" type="radio" name="rating' + $_commentID + '" value="4" ' + check4 + ' disabled>		' +
	'	            <label for="' + $_commentID + 'star-4" title="4 stars' + $_commentID + '">													' +
	'			        <i class="active fa fa-star" aria-hidden="true"></i>																	' +
	'	            </label>																													' +
	'	            <input id="' + $_commentID + 'star-3" type="radio" name="rating' + $_commentID + '" value="3" ' + check3 + ' disabled>		' +
	'	            <label for="' + $_commentID + 'star-3" title="3 stars' + $_commentID + '">													' +
	'			        <i class="active fa fa-star" aria-hidden="true"></i>																	' +
	'	            </label>																													' +
	'	            <input id="' + $_commentID + 'star-2" type="radio" name="rating' + $_commentID + '" value="2" ' + check2 + ' disabled>		' +
	'	            <label for="' + $_commentID + 'star-2" title="2 stars' + $_commentID + '">													' +
	'			        <i class="active fa fa-star" aria-hidden="true"></i>																	' +
	'	            </label>																													' +
	'	            <input id="' + $_commentID + 'star-1" type="radio" name="rating' + $_commentID + '" value="1" ' + check1 + ' disabled>		' +
	'	            <label for="' + $_commentID + 'star-1" title="1 star' + $_commentID + '">													' +
	'			        <i class="active fa fa-star" aria-hidden="true"></i>																	' +
	'	            </label>																													' +
	'           </div>																															' +
	'       </div>																																' +
	'    </div>																																	' +
	'    <div class="comment-body">																												' +
	'        <div class="comment-order-list">																									' +
	'            Order ID: <span style="text-align:center;">' + $_orderID + '</span>															' +
	'            <br><input class="comment_button" type="button" value="Check order details" onclick="viewOrderDetail(' + $_orderID + ')">		' +
	'        </div>																																' +
	'	     <div class="comment-input">' + $_comment + '																						' + 
	'        </div>                                                                 															' +
	'    </div>																																	' +
	'    <div class="comment-footer">																											' +
	'        <div class="time">																													' +
	'            <p id="text-time">' + $_createDate + '</p>																					    ' +
	'        </div>																																' +
	'    </div>																																	' +
	'</div>																																		' ;			
	
    return commentSec;
}

function viewOrderDetail($_orderID){
	window.open('../placeOrder/cartCompletedPrint.php?placedOrderID=' + $_orderID, '_blank');
}

function formSubmit(){
	resetErrMsg();

	if(!comFormValidate()){
		return false;
	}else{
		return true;
	}
}

function resetErrMsg(){
	document.getElementById("commentInfoMsg").innerHTML = "";
	document.getElementById("commentMsg").innerHTML = "";
}

function comFormValidate(){
	var isValid = true;
	var _comment = document.forms["commentForm"]["commentDetail"].value;
	
    if (_comment == "") {
		document.getElementById("commentMsg").innerHTML = "[E801] Comment must be input!";				
		document.forms["commentForm"]["commentDetail"].focus();
        isValid = false;
    }
    
	return isValid;
}

function addComment(){	
	if(formSubmit()){
		var _orderID 		= document.forms["commentForm"]["selectedOrder"].value;
		var _rating  		= document.forms["commentForm"]["rating"].value;
		var _comment 		= document.forms["commentForm"]["commentDetail"].value;
		var _commentDetail 	= {"orderID":_orderID, "rating":_rating, "comment":_comment}; 
		
		$.ajax(
		        {
		            type:'post',
		            url:'commentService.php',
		            data:{
		                addComment:_commentDetail
		            },
		            dataType:'json',
		            success:function(result){
		            	document.getElementById("commentInfoMsg").innerHTML = "[I801] Submit comment successfully!";
		            	document.forms["commentForm"]["commentDetail"].value="";
		            	document.forms["commentForm"]["selectedOrder"].selectedIndex = 0;
		            	document.forms["commentForm"]["rating"][2].checked = true;
		            	prepareCommentSection();               
		            }
		        }
		    )
	}
}


