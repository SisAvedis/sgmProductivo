<?php

include ("database_e.php");
require_once 'include/validacion.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
$nserie = isset($_POST['nserie']) ? $_POST['nserie'] : false;; //Operador ternario -> if línea
$return_arr = array();
$select_arr = array(0);
//echo "<pre>";
//echo $abmOpcion."</br>".$nremito;
//echo "</pre>";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(validaSerie($nserie) && $nserie && $nremito){
		$DB= new Database();
		$nremito = $DB->sanitize($_POST['nremito']);
		$nserie = $DB->sanitize($_POST['nserie']);
		//$abmOpcion = $_POST['abmOpcion'];
		$res = $DB->consultaSerieRemitoSinClienteXLS($nremito, $nserie);
		$row_cnt = mysqli_num_rows($res);
		if($row_cnt > 0){
			while($row = mysqli_fetch_array($res)){
				$fecha = $row['fecha'];
				$cliente = $row['nombre'];
				$estado = $row['estado'];
				$propiedad = $row['propiedad'];
				$tipoenvase = $row['tipoenvase'];
			} 
		}else{
			$estado = 'No Encontrado';
			$propiedad = 'No Encontrada';
			$tipoenvase = 'No Encontrado';
		}
	$label1 = "<label><pre class='lx-pre'>Estado</pre></label>"."</br>"."<label><pre class='lx2-pre'>".$estado."</pre></label>";
	$label2 = "<label><pre class='lx-pre'>Propiedad</pre></label>"."</br>"."<label><pre class='lx2-pre'>".$propiedad."</pre></label>";
	$label3 = "<label><pre class='lx-pre'>Envase</pre></label>"."</br>"."<label><pre class='lx2-pre'>".$tipoenvase."</pre></label>";
	$return_arr[] = array("estado" => $label1, "propiedad" => $label2, "tipoenvase" => $label3);
	echo json_encode($return_arr);
	} 
}

?>