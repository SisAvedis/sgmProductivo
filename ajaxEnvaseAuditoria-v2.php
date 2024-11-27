<?php

//include ("database_e.php");
include ("database_e4.php");
//require_once 'include/validacion.php';
require_once 'include/validacion4.php';
$cliente = isset($_POST['cliente']) ? $_POST['cliente'] : false;; //Operador ternario -> if línea
$fecha = date("Y-m-d", strtotime($_POST['fecha']));
$detallepor = 2;
$propiedad = "NP";
$tenv = "CIL";
$estado = "E";
$tproc = 1;
$producto = 6;

$audit_arr = array(array(0),);
$it = 0;

$return_arr = array();


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$DB= new Database();
	$res = $DB->prinUltimoEnviadov5($fecha,$cliente,$detallepor,$propiedad,$tenv,$estado,$tproc,$producto);
	$row_cnt = mysqli_num_rows($res);
	if($row_cnt == 0){
		$header1 = false;
		$header2 = 0;
		$header3 = "La consulta no arrojó datos";
		$header15 = "col-md-5";	//Etiqueta Valor Mensaje
		$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3, "header15" => $header15);
		echo json_encode($return_arr);
	}else{
		while($row = mysqli_fetch_array($res)){
			$audit_arr[$it][0] = $row['serie'];
			$audit_arr[$it][1] = $row['producto'];
			$audit_arr[$it][2] = $row['idproducto'];
			$audit_arr[$it][3] = $row['tipo'];
			$it++;
		}
			
		$header1 = "<table class='table table-bordered' id='tablaUno'><thead><tr><th class='text-left' colspan=2><label name='lbcantidadE' id='lbcantidadE'><pre class='lx-pre'>Registros Obtenidos: ".$row_cnt."</pre></label></th>";
		
		$header1 = $header1."<th class='text-center' colspan=5><label><pre class='lx-pre'>Insertar Registro</pre></label></th><th class='text-center'><pre class='lx-pre'><button class='btn btn-success' onclick='jq.fn.insertaRegistroAuditoria()'>+</button></pre></th>";
		
		$header1 = $header1."</tr>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Serie</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Lote</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Producto</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Envase</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>RampaBKP</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Auditado</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Tipo</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Acción</pre></label></th>";
		$header1 = $header1."</tr></thead>";		
		$header1 = $header1."<tbody>";
		for($tre=0;$tre<$row_cnt;$tre++){
			$header1 = $header1."<tr>";
			if (strlen(strval($tre)) == 1){
				$sSER = "SER00".strval($tre);
				$sSEH = "SEH00".strval($tre);
				$sLOT = "LOT00".strval($tre);
				$sLOH = "LOH00".strval($tre);
				$sPRO = "PRO00".strval($tre);
				$sPRH = "PRH00".strval($tre);
				$sENV = "ENV00".strval($tre);
				$sENH = "ENH00".strval($tre);
				$sCHKRB = "CHKRB00".strval($tre);
				$sCHKRH = "CHKRH00".strval($tre);
				$sCHKAU = "CHKAU00".strval($tre);
				$sCHKAH = "CHKAH00".strval($tre);
				$sTYH = "TYH00".strval($tre);
				$sACH = "ACH00".strval($tre);
			}else if (strlen(strval($tre)) == 2){
				$sSER = "SER0".strval($tre);
				$sSEH = "SEH0".strval($tre);
				$sLOT = "LOT0".strval($tre);
				$sLOH = "LOH0".strval($tre);
				$sPRO = "PRO0".strval($tre);
				$sPRH = "PRH0".strval($tre);
				$sENV = "ENV0".strval($tre);
				$sENH = "ENH0".strval($tre);
				$sCHKRB = "CHKRB0".strval($tre);
				$sCHKRH = "CHKRH0".strval($tre);
				$sCHKAU = "CHKAU0".strval($tre);
				$sCHKAH = "CHKAH0".strval($tre);
				$sTYH = "TYH0".strval($tre);
				$sACH = "ACH0".strval($tre);
			}else{
				$sSER = "SER".strval($tre);
				$sSEH = "SEH".strval($tre);
				$sLOT = "LOT".strval($tre);
				$sLOH = "LOH".strval($tre);
				$sPRO = "PRO".strval($tre);
				$sPRH = "PRH".strval($tre);
				$sENV = "ENV".strval($tre);
				$sENH = "ENH".strval($tre);
				$sCHKRB = "CHKRB".strval($tre);
				$sCHKRH = "CHKRH".strval($tre);
				$sCHKAU = "CHKAU".strval($tre);
				$sCHKAH = "CHKAH".strval($tre);
				$sTYH = "TYH".strval($tre);
				$sACH = "ACH".strval($tre);
			} 
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sSER."' class='form-control input-sm' id='".$sSER."' maxlength=15  autocomplete='off' value=".$audit_arr[$tre][0]." disabled/></pre><input type='hidden' value=".$audit_arr[$tre][0]." name='".$sSEH."' id='".$sSEH."'/></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sLOT."' class='form-control input-sm' id='".$sLOT."' maxlength=15  autocomplete='off' /></pre><input type='hidden' name='".$sLOH."' id='".$sLOH."' value='0' /></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sPRO."' class='form-control input-sm' id='".$sPRO."' maxlength=30  autocomplete='off' value='".$audit_arr[$tre][1]."' disabled/></pre><input type='hidden' value=".$audit_arr[$tre][2]." name='".$sPRH."' id='".$sPRH."'/></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sENV."' class='form-control input-sm' id='".$sENV."' maxlength=3  autocomplete='off' value=".$audit_arr[$tre][3]." disabled /></pre><input type='hidden' value=".$audit_arr[$tre][3]." name='".$sENH."' id='".$sENH."'/></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='checkbox' name='".$sCHKRB."' class='chkBox' id='".$sCHKRB."' tabindex='-1' /></pre><input type='hidden' name='".$sCHKRH."' id='".$sCHKRH."' value=0 /></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='checkbox' name='".$sCHKAU."' class='chkBox' id='".$sCHKAU."' tabindex='-1' /></pre><input type='hidden' name='".$sCHKAH."' id='".$sCHKAH."' value=0 /></td>";
			$header1 = $header1."<td class='text-center'><label><pre class='lx-pre'>A</pre></label><input type='hidden' name='".$sTYH."' value='A' id='".$sTYH."' /></td>";
			$header1 = $header1."<td class='text-center'><label><pre class='lx-pre'></pre></label><input type='hidden' name='".$sACH."' id='".$sACH."' /></td>";
			//$header1 = $header1."<td class='text-center'><label><pre class='lx-pre'><button class='btn btn-danger'>-</button></pre></label><input type='hidden' name=".$sTYH."' id='".$sTYH."'/></td>";
			
			
			$header1 = $header1."</tr>";
		}			
		//$header1 = $header1."</tbody>";	
		$header1 = $header1."</tbody>";
		$header1 = $header1."<input type='hidden' name='iregistro' id='iregistro' />";
		$header2 = $row_cnt;
			
			$return_arr[] = array("header1" => $header1,"header2" => $header2);		
			
			echo json_encode($return_arr);
		}

}else{
	$header1 = "";
	$header2 = "";
	
	$return_arr[] = array("header1" => $header1,"header2" => $header2);
	echo json_encode($return_arr);
}	
?>
