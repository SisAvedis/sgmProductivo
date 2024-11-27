<?php

include ("database_e3.php");
require_once 'include/validacion.php';
$tipoProducto = isset($_POST['tipoProducto']) ? $_POST['tipoProducto'] : false;; //Operador ternario -> if línea
$mov_arr = array(0);
$return_arr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($tipoProducto){
		//Todos los productos
		$tLP = 0;
		$DB0= new Database();
		$res = $DB0->prProductov1($tipoProducto,$tLP);
		$iRowC = 1;
		//$mov_arr[0] = "<label><pre class='lx-pre'>Producto</pre></label>"."</br>"."<label><pre class='lx-pre'><select name='producto' id='producto' class='form-control input-sm'>"."<option value='0'>Producto</option>";
		$mov_arr[0] = "<label><pre class='lx-pre'><select name='producto' id='producto' class='form-control input-sm'>"."<option value='0'>Producto</option>";
		while($row = mysqli_fetch_array($res)){
			if ($iRowC == 0){ 
				$mov_arr[$iRowC] = "<option value='".$row['id']."|".$row['nombre']."' selected>".$row['nombre']."</option>";
				$iRowC++;
			}else{
				$mov_arr[$iRowC] = "<option value='".$row['id']."|".$row['nombre']."'>".$row['nombre']."</option>";
				$iRowC++;
			}
		}
		$header1 = '';
		foreach($mov_arr as $sel){
			$header1 = $header1.$sel;
		}
		$header1 = $header1."</select></pre></label>";
			
		$return_arr[] = array("header1" => $header1);
			echo json_encode($return_arr);
			
	}else{
		$header1 = 'Shit';
		$return_arr[] = array("header1" => $header1);
			echo json_encode($return_arr);
	}
}
?>
