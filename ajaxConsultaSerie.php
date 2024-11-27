<?php

include ("database_e.php");
require_once 'include/validacion.php';
$sSerie = isset($_POST['sSerie']) ? $_POST['sSerie'] : false;; //Operador ternario -> if línea
$sProp = isset($_POST['sProp']) ? $_POST['sProp'] : false;; //Operador ternario -> if línea
$sTipo = isset($_POST['sTipo']) ? $_POST['sTipo'] : false;; //Operador ternario -> if línea

//echo "<pre>";
//echo $sSerie."</br>".$sProp."</br>".$sTipo."</br>"."</br>"."</br>";
//echo "</pre>";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($sSerie) {
		$DB= new Database();
		$sSerie = $DB->sanitize($_POST['sSerie']);
		//$abmOpcion = $_POST['abmOpcion'];
		$res = $DB->prSerieExistev1($sSerie, $sProp, $sTipo, 1);
		$row_cnt = mysqli_num_rows($res);
		//echo $row_cnt;
		if($row_cnt > 0){
			while ($row=mysqli_fetch_object($res)){
				$icantidad = $row->iCantidad;
				$cPropiedad = $row->c_prop;
				$icapcantidad = $row->iCapCantidad;
				if($icapcantidad > 0){
					$dcapacidad = $row->dCapacidad;
				
				$return_arr[] = array("icantidad" => $icantidad, "icapcantidad" => $icapcantidad, "dcapacidad" => $dcapacidad);
				}else{
					$return_arr[] = array("icantidad" => $icantidad, "icapcantidad" => $icapcantidad);
				}
				
			}
			
			//echo "<pre>";
			//echo $icantidad."</br>".$cPropiedad."</br>";
			//echo "</pre>";
			
			
				
				echo json_encode($return_arr);
			}
	}
	}
?>