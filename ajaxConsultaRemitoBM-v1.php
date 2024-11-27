<?php

include ("database_e.php");
require_once 'include/validacion.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
$tipoOpcion = isset($_POST['tipoOpcion']) ? $_POST['tipoOpcion'] : false;; //Operador ternario -> if línea
$tipoProducto = isset($_POST['tipoProducto']) ? $_POST['tipoProducto'] : false;; //Operador ternario -> if línea
$return_arr = array();
$select_arr = array(0);
$cap_arr = array(0);
$cant_arr = array(0);
$bremito = validaRemito($nremito);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	//if($nremito && $abmOpcion) {
	if($nremito && $bremito) {
		$DB= new Database();
		$nremito = $DB->sanitize($_POST['nremito']);
		//$abmOpcion = $_POST['abmOpcion'];
		$res = $DB->prRemitoDetallev2($nremito);
		$row_cnt = mysqli_num_rows($res);
		if($row_cnt > 0){
			$header1 = "Atención. El remito ".$nremito." ya fue ingresado";
			$header2 = $row_cnt;
			$header7 = "col-md-8";	//Etiqueta Atención
			$header8 = "";	//Etiqueta Listo (Oculta)
			$header10 = false;
			
			
			$return_arr[] = array("header1" => $header1, "header2" => $header2, "header7" => $header7, "header8" => $header8, "header10" => $header10);
				echo json_encode($return_arr);	
			
			}else{
				$header1 = "Atención. El remito ".$nremito." no fue ingresado";
				$header2 = 	$row_cnt;
				$header7 = "col-md-8";	//Etiqueta Atención
				$header8 = "";	//Etiqueta Listo (Oculta)
				$header10 = true;
			
			
				$return_arr[] = array("header1" => $header1, "header2" => $header2, "header7" => $header7, "header8" => $header8, "header10" => $header10);
					echo json_encode($return_arr);
			}	
		}
	}
?>
