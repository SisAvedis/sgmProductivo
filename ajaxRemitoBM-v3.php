<?php

//include ("database_e.php");
include ("database_e4.php");
//require_once 'include/validacion.php';
require_once 'include/validacion4.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
$nremitomodi = isset($_POST['nremitomodi']) ? $_POST['nremitomodi'] : false;; //Operador ternario -> if línea
$return_arr = array();
$bremito = validaRemito($nremitomodi);

//if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($nremitomodi && $bremito) {
		$DB= new Database();
		$nremitomodi = $DB->sanitize($_POST['nremitomodi']);
		$res = $DB->prRemitoDetallev9($nremitomodi);
		$row_cnt = mysqli_num_rows($res);
		if($row_cnt == 0){
			$header1 = true;
		}else{
			if($nremito == $nremitomodi){
				$header1 = true;
			}else{
				$header1 = false;
			}
			
		}
		$return_arr[] = array("header1" => $header1);
		echo json_encode($return_arr);
	}
//}
?>
