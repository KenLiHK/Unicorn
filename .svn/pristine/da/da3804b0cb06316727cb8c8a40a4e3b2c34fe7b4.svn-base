/******** [START] Login JavaScript ********/
function formSubmit(){
	resetErrMsg();

	if(!loginFormValidate()){
		return false;
	}
}

function resetErrMsg(){
	document.getElementById("userIDEmailMsg").innerHTML = "";
	document.getElementById("passMsg").innerHTML = "";	
}

/* 
Automatic HTML form validation does not work in Internet Explorer 9 or earlier.
We have to implement javaScript client side validation in loginFormValidation() function.
*/
function loginFormValidate(){
	var isValid = true;
	var _userIDEmail = document.forms["loginForm"]["userIDEmail"].value;
	var _pass = document.forms["loginForm"]["pass"].value;
	
	// ******** [START] User ID/Email validation ********	
    if (_userIDEmail == "") {
		document.getElementById("userIDEmailMsg").innerHTML = "[E601] User ID / Email must be input!";				

		if(isValid){
			document.forms["loginForm"]["userIDEmail"].focus();
		}
        isValid = false;
    }	
	// ******** [END] User ID/Email validation ********
		
	// ******** [START] Password validation ********
    if (_pass == "") {
		document.getElementById("passMsg").innerHTML = "[E602] Password must be input!";				
		
		if(isValid){
			document.forms["loginForm"]["pass"].focus();   
		}
        isValid = false;
    }
	
	/*
		Check password format and character combination
		rule 1 : Password length must be 8 - 20 characters
		rule 2 : Password must contain at least 2 upper case characters
		rule 3 : Password must contain at least 2 lower case characters
		rule 4 : Password must contain at least 2 numeric characters
		rule 5 : Password must contain at least 2 special characters
	*/
	if(_pass != ""){
		var anUpperCase = /[A-Z]/;
		var aLowerCase = /[a-z]/; 
		var aNumber = /[0-9]/;
		var aSpecial = /[!|@|#|$|%|^|&|*|(|)|-|_]/;
		var passValid = true;
		
		if(_pass.length < 8 || _pass.length > 20){
			document.getElementById("passMsg").innerHTML = "[E603] Password length must be 8 - 20 characters!";	
			document.forms["loginForm"]["pass"].value="";
			
			if(isValid){
				document.forms["loginForm"]["pass"].focus();   
			}
			isValid = false;
			passValid = false;
		}

		var numUpper = 0;
		var numLower = 0;
		var numNums = 0;
		var numSpecials = 0;
		for(var i=0; i<_pass.length; i++){
			if(anUpperCase.test(_pass[i])){
				numUpper++;
			}else if(aLowerCase.test(_pass[i])){
				numLower++;
			}else if(aNumber.test(_pass[i])){
				numNums++;
			}else if(aSpecial.test(_pass[i])){
				numSpecials++;
			}
		}

		if(numUpper < 2 && passValid){
			document.getElementById("passMsg").innerHTML = "[E604] Password must contain at least 2 upper case characters!";
			document.forms["loginForm"]["pass"].value="";
			
			if(isValid){
				document.forms["loginForm"]["pass"].focus();   
			}
			isValid = false;
			passValid = false;
		}
		
		if(numLower < 2 && passValid){
			document.getElementById("passMsg").innerHTML = "[E605] Password must contain at least 2 lower case characters!";
			document.forms["loginForm"]["pass"].value="";
			
			if(isValid){
				document.forms["loginForm"]["pass"].focus();   
			}
			isValid = false;
			passValid = false;
		}
		
		if(numNums < 2 && passValid){
			document.getElementById("passMsg").innerHTML = "[E606] Password must contain at least 2 numeric characters!";
			document.forms["loginForm"]["pass"].value="";
				
			if(isValid){
				document.forms["loginForm"]["pass"].focus();   
			}
			isValid = false;
			passValid = false;
		}
		
		if(numSpecials <2 && passValid){
			document.getElementById("passMsg").innerHTML = "[E607] Password must contain at least 2 special characters!";	
			document.forms["loginForm"]["pass"].value="";
			
			if(isValid){
				document.forms["loginForm"]["pass"].focus();   
			}
			isValid = false;
			passValid = false;
		}	
	}	
	// ******** [END] Password validation ********			
	return isValid;
}
/******** [END] Login JavaScript ********/

