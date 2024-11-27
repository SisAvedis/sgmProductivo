<?php

include ("database_e.php");
//include ("database_e3.php");
require_once 'include/validacion.php';
$nserie = isset($_POST['nserie']) ? $_POST['nserie'] : false;; //Operador ternario -> if línea
$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : false;; //Operador ternario -> if línea
//$abmOpcion = isset($_POST['abmOpcion']) ? $_POST['abmOpcion'] : false;; //Operador ternario -> if línea
$idproductoOption = isset($_POST['idproducto']) ? $_POST['idproducto'] : false;;
if ($idproductoOption){
	$productoOption = explode("|",$_POST['idproducto']);
	$producto = explode("|",$_POST['idproducto']);
}



$return_arr = array();
$select_arr = array(0);


$DB= new Database();
$idCL = 'XLS';
if ($nserie){
	/*
	if ($tipoenv == 1){ 
		$tenv = 'CIL';
	}elseif ($tipoenv == 2){
		$tenv = 'TER';
	}
	*/
	$res = $DB->clientesSPv2($nserie,$tipoenv,$producto[0]);
}else{
	$res = $DB->clientesTodosSG($idCL);
}
$iRow = 1;
//$clienteid_xls = array(0,0);

$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
if ($clienteOption){
	$clienteid_xls = explode("|",$_POST['cliente']);
	$idcliente_xls = $clienteid_xls[2];
}else{
	$idcliente_xls = 1;
}
$spacesCount = 45;
$spaces = '';
for($z = 0 ; $z < $spacesCount; $z++){
	$spaces = $spaces.'&nbsp';
}

$select_arr[0] = "<option value='0'>Clientes".$spaces."</option>";
//$select_arr[0] = "<select name='cliente' id='cliente' class='form-control input-sm'>"."<option value='0' selected>Clientes".$spaces."</option>";
while ($row=mysqli_fetch_object($res)){ 
	/*
	if ($iRow == $idcliente_xls){ 
		$select_arr[$iRow] = "<option value='".$row->id_xl."|".$row->nombre."|".$iRow."'>".$row->id_xl." - ".$row->nombre."</option>";
		$iRow++;
	}else{
		$select_arr[$iRow] = "<option value='".$row->id_xl."|".$row->nombre."|".$iRow."'>".$row->id_xl." - ".$row->nombre."</option>";
							$iRow++;
						}
	*/
	$idcliente_xls = 0;
	$select_arr[$iRow] = "<option value='".$row->id_xl."|".$row->nombre."|".$iRow."'>".$row->id_xl." - ".$row->nombre."</option>";
							$iRow++;
					}					
						$label22 = "</select>";	
						
						$label21 = '';
						foreach($select_arr as $sel){
							$label21 = $label21.$sel;
						}
						$label21 = $label21.'</th>';		
				$return_arr[] = array("nombre" => $label21);
				echo json_encode($return_arr);
			
			
?>

