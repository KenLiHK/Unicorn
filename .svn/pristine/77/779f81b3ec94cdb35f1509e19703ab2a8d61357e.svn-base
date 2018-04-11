
$(document).ready(function(){	
	prepareNotificationSection();
	showItemCount();
});



function loadNotification(){
	$("#accordion").accordion({heightStyle: "content", active: false, collapsible: true });
	$("#accordion").accordion({
		activate: function(event, ui) 
	    { 
			var notiID = $('.ui-accordion-header-active').attr('id');
        	if(notiID != undefined && notiID != null && notiID != ""){
	            var n = notiID.indexOf("_");
	            var s = notiID.substr(n+1);
	        	updateNotification(s);
	        	$('.ui-accordion-header-active').css({ 'color': 'black'});
        	}
	    }
	});
}

function prepareNotificationSection(){
	var $notificationSection = "";
	$('#notification-section').empty();

	$.ajax(
        {
            type:'post',
            url:'notificationService.php',
            data:{
                prepareNotification:true
            },
            dataType:'json',
            success:function(result){
            	$notificationSection += '<div id="accordion">';
                if(result["code"]!=0){
                    //If the results of query is abnormal, display error msg given by backend.
                	$notificationSection = result["message"];
                }
                else{
                    $.each(result["data"],function(i,n){
                    	var $_notificationID 	= n["notification_id"];
                    	var $_type 				= n["type"];
                    	var $_status 			= n["status"];
                        var $_subject 			= n["subject"];
                        var $_content 			= n["content"];
                        var $_createDate 		= n["create_date"];                        
                        $notificationSection += prepareNotification($_notificationID, $_type, $_status, $_subject, $_content, $_createDate);
                    }); 
                }
                $notificationSection += '</div>';
                $('#notification-section').append($notificationSection);
                loadNotification();
            }
        }
    )
}

function prepareNotification($_notificationID, $_type, $_status, $_subject, $_content, $_createDate){	
	var notificationSec = "";
	var color = "black";
	if($_status == "NS01"){
		color = "red";
	}
	
	var detailBtn = "";	 
	if($_type == 'NT11'){		
		var n = $_subject.indexOf("Placed order successfully!");	    
	    var s = $_subject.substr(0, n-1);
	    var orderID = s.substr(9);
	    detailBtn = '<input class="noti_button" type="button" value="Check order details" onclick="viewOrderDetail(' + orderID + ')">';
	}
	
	
	notificationSec +=
	'	  <h3 id="h3_' + $_notificationID + '" style="color:' + color + ';">' + $_createDate + ' ' + $_subject + '</h3>				' +
	'	  <div><p>' + $_content + '</p>' + detailBtn + '</div>																		' ;
	
    return notificationSec;
}

function viewOrderDetail($_orderID){
	window.open('../placeOrder/cartCompletedPrint.php?placedOrderID=' + $_orderID, '_blank');
}

function updateNotification(_notiID){
	var _notiObj = {"notiID":_notiID}; 
	$.ajax(
	        {
	            type:'post',
	            url:'notificationService.php',
	            data:{
	            	updateNotification:_notiObj
	            },
	            dataType:'json',
	            success:function(result){
	            	showItemCount();
	            }
	        }
	    )
}


