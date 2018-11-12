<?php
//function that takes 2 strings ($start_date,$end_date) in a "yyyy-mm-dd" type and produces the total sum of days inbetween these two dates
function days_of_stay($start_date,$end_date){
	$start_date_array = explode("-",$start_date);
	$start_days = intval($start_date_array[0])*365 + intval($start_date_array[1])*30 + intval($start_date_array[2]);

	$end_date_array = explode("-",$end_date);
	$end_days = intval($end_date_array[0])*365 + intval($end_date_array[1])*30 + intval($end_date_array[2]);
	return ($end_days-$start_days);
}
?>