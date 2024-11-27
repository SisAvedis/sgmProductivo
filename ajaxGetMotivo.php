<?php

include ("database_e.php");
$icntm = 0;
$mtv_arr = array();
$return_arr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$DB= new Database();
	$res = $DB->getMotivo();
	$row_cnt = mysqli_num_rows($res);
	$header1 = '';
	if($row_cnt > 0){
		while($row = mysqli_fetch_array($res)){
			$mtv_arr[0][$icntm] = $row['id'];
			$mtv_arr[1][$icntm] = $row['descripcion'];
			
			$icntm++;
		}
	}
	$return_arr[] = array("header1" => $mtv_arr,"header2" => $icntm);
	echo json_encode($return_arr);
}
?>
