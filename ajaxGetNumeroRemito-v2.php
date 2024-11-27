<?php

include ("database_e.php");
//include ("database_e3.php");
$return_arr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$DB= new Database();
	$res = $DB->prGetNumeroRemitov2();
	$row_cnt = mysqli_num_rows($res);
	if($row_cnt > 0){
		while($row = mysqli_fetch_array($res)){
			$nRemito = $row['remito'];
			
			$return_arr[] = array("header1" => $nRemito);
			echo json_encode($return_arr);	
		}
		
	}
}	
?>
