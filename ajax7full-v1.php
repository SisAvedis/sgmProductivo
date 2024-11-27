<?php

include ("database_e.php");
//include ("database_e3.php");
require_once 'include/validacion.php';
$nserie = isset($_POST['nserie']) ? $_POST['nserie'] : false;; //Operador ternario -> if línea
$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : false;; //Operador ternario -> if línea
//$abmOpcion = isset($_POST['abmOpcion']) ? $_POST['abmOpcion'] : false;; //Operador ternario -> if línea
$return_arr = array();
$select_arr = array(0);


$DB= new Database();

if ($nserie && $tipoenv){
	$res = $DB->productoSeriev1($nserie,$tipoenv);

$iRow = 1;
//$clienteid_xls = array(0,0);

$idproductoOption = isset($_POST['idproducto']) ? $_POST['idproducto'] : false;;
if ($idproductoOption){
	$productoOption = explode("|",$_POST['idproducto']);
	$productoNom = $productoOption[2];
}else{
	$productoNom = 0;
}

$spacesCount = 45;
$spaces = '';
for($z = 0 ; $z < $spacesCount; $z++){
	$spaces = $spaces.'&nbsp';
}

$select_arr[0] = "<option value='0'>Producto".$spaces."</option>";

while ($row=mysqli_fetch_object($res)){ 
	$select_arr[$iRow] = "<option value='".$row->id."|".$row->codigo."|".$row->nombre."|".$iRow."'>".$row->nombre."</option>";
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
}			
			
?>
