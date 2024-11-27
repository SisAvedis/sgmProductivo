<?PHP
if($_POST) {
  $value = trim($_POST['value']);
  //$value = date("d-m-Y", strtotime($value));
} else {
  die("Error: missing POST values");
}

$date_is_valid = false;
$preg = "/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-([2][0][0-9]{2})$/";

if(preg_match($preg, $value, $dateA)) {
	//var_export ($dateA);
	$day = (int)$dateA[1];
	$month = (int)$dateA[2];
	$year = (int)$dateA[3];
	$date_is_valid = checkdate($month, $day, $year);
	if($date_is_valid){
		$date = date('Y-m-d');
		if(strtotime($value)<=strtotime($date)){
			$retval = 1;
		}else{
			$retval = 0;
		}
		
	}else{
		$retval = 0;
	}
}else{
		$retval = 0;
}

$header7 = (int)$retval;
	
$return_arr[] = array("header7" => $header7);
			echo json_encode($return_arr);	
	
	
  
?>