<?php

include ("database_e.php");
//include ("database_e3.php");
require_once 'include/validacion.php';
$cliente = isset($_POST['cliente']) ? $_POST['cliente'] : false;; //Operador ternario -> if línea
$fecha = date("Y-m-d", strtotime($_POST['fecha']));
$detallepor = 2;
$propiedad = "NP";
//$tenv = "CIL";
$estado = "E";
$tproc = 1;
$producto = 6;

$audit_arr = array(array(0),);
$it = 0;

$return_arr = array();
$select_arr = array();
$select_arr2 = array();
$select_arr3 = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$DB= new Database();
	//$res = $DB->prinUltimoEnviadov41($fecha,$cliente,$detallepor,$propiedad,$tenv,$estado,$tproc,$producto);
	$res = $DB->prinUltimoEnviadov41($fecha,$cliente,$detallepor,$propiedad,$estado,$tproc,$producto);
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
			$audit_arr[$it][4] = $row['id_xl'];
			$it++;
		}
		
		$header4 = "";
		
		if ($cliente){
			$clienteid_xls = explode("|",$_POST['cliente']);
			$idcliente_xls = $clienteid_xls[0];
		}
		$DB0= new Database();
		$res1 = $DB0->clientesGRUPO($idcliente_xls);
		$iRow = 1;
		
		while ($row=mysqli_fetch_object($res1)){
			$select_arr2[$iRow] = $row->c_id_xl."|".$row->c_nombre."|".$iRow.">".$row->c_id_xl." - ".$row->c_nombre;
			//$select_arr2[$iRow] = $row->c_id_xl."|".$row->c_nombre."|".$iRow.">".$row->c_id_xl." - ".$row->c_nombre;
			//$select_arr2[$iRow] = "'".$row->c_id_xl."|".$row->c_nombre."|".$iRow."'>".$row->c_id_xl." - ".$row->c_nombre;
			//$select_arr2[$iRow] = "<option value='".$row->id_xl."|".$row->nombre."|".$iRow."' selected>".$row->id_xl." - ".$row->nombre."</option>";
			$iRow++;
		}					
		
		$header1 = "<table class='table table-bordered' id='tablaUno'><thead><tr><th class='text-left' colspan=5><label name='lbcantidadE' id='lbcantidadE'><pre class='lx-pre'>Total de Registros: ".$row_cnt." | Registros Insertados Manualmente: 0"."</pre></label></th>";
		
		$header1 = $header1."<th class='text-center' colspan=2><label><pre class='lx-pre'>Insertar Registros</pre></label></th><th class='text-center'><pre class='lx-pre'><button class='btn btn-success' onclick='jq.fn.insertaRegistroAuditoria()'>+</button></pre></th>";
		
		$header1 = $header1."</tr>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Serie</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Cliente</pre></label></th>";
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
				$sIXL = "IXL00".strval($tre);
				$sIXH = "IXH00".strval($tre);
				$sCHKRB = "CHKRB00".strval($tre);
				$sCHKRH = "CHKRH00".strval($tre);
				$sCHKAU = "CHKAU00".strval($tre);
				$sCHKAH = "CHKAH00".strval($tre);
				$sTYA = "TYA00".strval($tre);
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
				$sIXL = "IXL0".strval($tre);
				$sIXH = "IXH0".strval($tre);
				$sCHKRB = "CHKRB0".strval($tre);
				$sCHKRH = "CHKRH0".strval($tre);
				$sCHKAU = "CHKAU0".strval($tre);
				$sCHKAH = "CHKAH0".strval($tre);
				$sTYA = "TYA0".strval($tre);
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
				$sIXL = "IXL".strval($tre);
				$sIXH = "IXH".strval($tre);
				$sCHKRB = "CHKRB".strval($tre);
				$sCHKRH = "CHKRH".strval($tre);
				$sCHKAU = "CHKAU".strval($tre);
				$sCHKAH = "CHKAH".strval($tre);
				$sTYA = "TYA".strval($tre);
				$sTYH = "TYH".strval($tre);
				$sACH = "ACH".strval($tre);
			} 
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sSER."' class='form-control input-sm' id='".$sSER."' maxlength=15  autocomplete='off' value=".$audit_arr[$tre][0]." disabled/></pre><input type='hidden' value=".$audit_arr[$tre][0]." name='".$sSEH."' id='".$sSEH."'/></td>";
			$header4 = $header4.$audit_arr[$tre][0].";";
			
			$iRow2 = 1;
			$select_arr[0] = "<pre class='lx-pre'><input type='hidden' value=".$audit_arr[$tre][4]." name='".$sIXH."' id='".$sIXH."'/><select name='".$sIXL."' id='".$sIXL."' class='form-control input-sm uno'>";
			$select_arr3[0] = "<pre class='lx-pre'><select name='clientesgrupo' id='clientesgrupo' class='form-control input-sm'>";
			
			foreach($select_arr2 as $sel2){
				$id_xl = explode("|",$sel2);
				if ($id_xl[0] == $audit_arr[$tre][4]){
					$select_arr[$iRow2] = "<option value=".$id_xl[0]."|".$id_xl[1]."|".$iRow2." selected>".$id_xl[0]." - ".$id_xl[1]."</option>";
					$header4 = $header4.$id_xl[0].";"."A".";";
					//$select_arr[$iRow2] = "<option value=".$id_xl[0]."|".$id_xl[1]."|".$iRow2." selected>".$id_xl[0]." - ".$id_xl[1]."</option>";
				}else{
					$select_arr[$iRow2] = "<option value=".$sel2."</option>";
				}
				if ($iRow2 == 1){
					$select_arr3[$iRow2] = "<option value=".$id_xl[0]."|".$id_xl[1]."|".$iRow2." selected>".$id_xl[0]." - ".$id_xl[1]."</option>";
					//$select_arr3[$iRow2] = "<option value=".$id_xl[0]."|".$id_xl[1]."|".$iRow2." selected>".$id_xl[0]." - ".$id_xl[1]."</option>";
				}else{
					$select_arr3[$iRow2] = "<option value=".$sel2."</option>";
					//$select_arr3[$iRow2] = '<option value="'.$sel2.'"</option>';
				}
				$iRow2++;
			}
			
			$header3 = '';
			foreach($select_arr3 as $sel3){
				$header3 = $header3.$sel3;
			}
			
			$acliente = '';
			foreach($select_arr as $sel){
				$acliente = $acliente.$sel;
			}
			$acliente = $acliente."</select></pre>";
			$header1 = $header1."<td>".$acliente."</td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sLOT."' class='form-control input-sm lote' id='".$sLOT."' maxlength=15  autocomplete='off' /></pre><input type='hidden' name='".$sLOH."' id='".$sLOH."' value='0' /></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sPRO."' class='form-control input-sm' id='".$sPRO."' maxlength=30  autocomplete='off' value='".$audit_arr[$tre][1]."' disabled/></pre><input type='hidden' value=".$audit_arr[$tre][2]." name='".$sPRH."' id='".$sPRH."'/></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sENV."' class='form-control input-sm' id='".$sENV."' maxlength=3  autocomplete='off' value=".$audit_arr[$tre][3]." disabled /></pre><input type='hidden' value=".$audit_arr[$tre][3]." name='".$sENH."' id='".$sENH."'/></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='checkbox' name='".$sCHKRB."' class='chkBox' id='".$sCHKRB."' tabindex='-1' /></pre><input type='hidden' name='".$sCHKRH."' id='".$sCHKRH."' value=0 /></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='checkbox' name='".$sCHKAU."' class='chkBox' id='".$sCHKAU."' tabindex='-1' /></pre><input type='hidden' name='".$sCHKAH."' id='".$sCHKAH."' value=0 /></td>";
			$header1 = $header1."<td class='text-center'><label id='".$sTYA."'><pre class='lx-pre'>A</pre></label><input type='hidden' name='".$sTYH."' value='A' id='".$sTYH."' /></td>";
			$header4 = $header4.$sTYA.";";
			$header1 = $header1."<td class='text-center'><label><pre class='lx-pre'></pre></label><input type='hidden' name='".$sACH."' id='".$sACH."' /></td>";
			$header1 = $header1."</tr>";
		}			
		$header1 = $header1."</tbody>";
		$header1 = $header1."<input type='hidden' name='iregistro' id='iregistro' />";
		$header2 = $row_cnt;
		$header4 = substr($header4, 0, strlen($header4) - 1);
			
			$return_arr[] = array("header1" => $header1,"header2" => $header2,"header3" => $header3,"header4" => $header4);		
			
			echo json_encode($return_arr);
		}

}else{
	$header1 = "";
	$header2 = "";
	$header3 = "";
	$header4 = "";
	$return_arr[] = array("header1" => $header1,"header2" => $header2,"header3" => $header3,"header4" => $header4);
	echo json_encode($return_arr);
}	
?>
