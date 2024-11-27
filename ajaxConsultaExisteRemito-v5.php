<?php

include ("database_e.php");
//include ("database_e3.php");
require_once 'include/validacion.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($nremito) {
		$DB= new Database();
		$nremito = $DB->sanitize($_POST['nremito']);
		$res = $DB->prRemitoDetallev5($nremito,1);
		$row_cnt = mysqli_num_rows($res);
		if($row_cnt > 0){
			while($row = mysqli_fetch_array($res)){
				$fecha = $row['c_fecha'];
				$fecha = date_format(date_create($fecha),"d-m-Y");
				$id_xl = $row['c_id_xl'];
				$clie = $row['c_cliente'];
				$tipo = $row['c_tipo'];
				$env = $row['c_CE'];
				$dev = $row['c_CD'];
			}
			//$header1 = "<label><pre class='lx-pre' id='rExiste'>Atención. El remito ".$nremito." ya fue ingresado</pre></label></br>";
			$header1 = "Atención. El remito ".$nremito." ya fue ingresado";
			//$header2 = "</br>"."<label><pre class='lx-pre'>Fecha: ".$fecha." | Cliente: (".$id_xl.") ".$clie." | Tipo: ".$tipo." | Env: ".$env." | Dev: ".$dev."</pre></label>";
			$header2 = "<label><pre class='lx-pre'>Fecha: ".$fecha." | Cliente: (".$id_xl.") ".$clie." | Tipo: ".$tipo." | Env: ".$env." | Dev: ".$dev."</pre></label>";
			//$header2 = "Fecha: ".$fecha." | Cliente: (".$id_xl.") ".$clie." | Tipo: ".$tipo." | Env: ".$env." | Dev: ".$dev;
			//$header2 = true;
			$header3 = true;
			
			}else{
				$header1 = "";
				$header2 = "";
				//$header2 = false;
				$header3 = false;
			}
			
			//$return_arr[] = array("header1" => $header1, "header2" => $header2);
			//	echo json_encode($return_arr);
			$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3);
				echo json_encode($return_arr);
			
	}
}		

?>
