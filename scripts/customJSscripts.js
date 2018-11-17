function dateEvaluation(checkInID,checkOutID){
	var cid= document.getElementById(checkInID).value;
	var cod= document.getElementById(checkOutID).value;
	var date1 = new Date(cid).getTime();
	var date2 = new Date(cod).getTime();
	if (date2 <= date1){
		alert("please make sure check out date is after check in date");
		return false;
	} else {
		return true;
	}
}

function isFieldEmpty(id){
	var field = document.getElementById(id);
	return (field.value === "");
}

function evaluateInputFields(){
	if (isFieldEmpty('city_name')){
		alert("please fill out city name field");
		return false;
	} else if (isFieldEmpty('room_type')){
		alert("please fill out room type field");
		return false;
	} else if (isFieldEmpty('datepicker1')){
		alert("please fill out check in date field");
		return false;
	} else if (isFieldEmpty('datepicker2')){
		alert("please fill out check out date field");
		return false;
	} else {
		return dateEvaluation('datepicker1','datepicker2');
	}
	
}