<?php

include ("database_e.php");
//include ("database_e3.php");
require_once 'include/validacion.php';
$auditoria = isset($_POST['auditoria']) ? $_POST['auditoria'] : false;; //Operador ternario -> if línea


$audit_arr = array(array(0),);
$it = 0;

$return_arr = array();
$select_arr = array();
$select_arr2 = array();
$select_arr3 = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$DB= new Database();
	$res = $DB->prDetalleAuditoriav1($auditoria);
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
			if ($it == 0){
				$nombrecliente = $row['nombre'];
				$numerocliente = $row['id_xl'];
				$it++;
			}else{
				$audit_arr[$it-1][0] = $row['serie'];
				$audit_arr[$it-1][1] = $row['producto'];
				$audit_arr[$it-1][2] = $row['idproducto'];
				$audit_arr[$it-1][3] = $row['tipoenvase'];
				$audit_arr[$it-1][4] = $row['id_xl'];
				if (is_null($row['fecharemito'])) {
					$audit_arr[$it-1][5] = '&nbsp';
				}else{
					$audit_arr[$it-1][5] = date_format(date_create($row['fecharemito']),"d-m-Y");
				}
				if (is_null($row['remito'])) {
					$audit_arr[$it-1][6] = '&nbsp';
				}else{
					$audit_arr[$it-1][6] = $row['remito'];
				}
				//$audit_arr[$it-1][6] = $row['remito'];
				if (is_null($row['lote'])) {
					$audit_arr[$it-1][7] = '&nbsp';
					$lotehidden = '0';
				}else{
					$audit_arr[$it-1][7] = $row['lote'];
					$lotehidden = $row['lote'];
				}
				$audit_arr[$it-1][8] = $row['auditado'];
				$audit_arr[$it-1][9] = $row['tipo'];
				$it++;	
			}
			
		}
		
		$header4 = "";
		
		//if ($cliente){
		//	$clienteid_xls = explode("|",$_POST['cliente']);
		//	$idcliente_xls = $clienteid_xls[0];
		//}
		$DB0= new Database();
		$res1 = $DB0->clientesGRUPO($numerocliente);
		$iRow = 1;
		
		while ($row=mysqli_fetch_object($res1)){
			$select_arr2[$iRow] = $row->c_id_xl."|".$row->c_nombre."|".$iRow.">".$row->c_id_xl." - ".$row->c_nombre;
			//$select_arr2[$iRow] = $row->c_id_xl."|".$row->c_nombre."|".$iRow.">".$row->c_id_xl." - ".$row->c_nombre;
			//$select_arr2[$iRow] = "'".$row->c_id_xl."|".$row->c_nombre."|".$iRow."'>".$row->c_id_xl." - ".$row->c_nombre;
			//$select_arr2[$iRow] = "<option value='".$row->id_xl."|".$row->nombre."|".$iRow."' selected>".$row->id_xl." - ".$row->nombre."</option>";
			$iRow++;
		}					
		
		$row_cnt_label = $row_cnt - 1;
		
		$header1 = "<table class='table table-bordered' id='tablaUno'><thead><tr><th class='text-left' colspan=7><label name='lbcantidadE' id='lbcantidadE'><pre class='lx-pre'>Registros (Inicial): ".$row_cnt_label." | Insertados: 0 | Eliminados: 0"."</pre></label></th>";
		
		$header1 = $header1."<th class='text-center' colspan=3><label><pre class='lx-pre'>Insertar Registros</pre></label></th><th class='text-center'><pre class='lx-pre'><button class='btn btn-success' onclick='jq.fn.insertaRegistroAuditoria()'>+</button></pre></th>";
		
		$header1 = $header1."</tr>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Fecha</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Remito</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Serie</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Cliente</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Lote</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Producto</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Envase</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>RmpBKP</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Audit</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Tipo</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Acción</pre></label></th>";
		$header1 = $header1."</tr></thead>";		
		$header1 = $header1."<tbody>";
		for($tre=0;$tre<$row_cnt-1;$tre++){
			//$header1 = $header1."<tr class='TRs' id='".$tre."'>";
			if (strlen(strval($tre)) == 1){
				$sTR = 'TR00'.strval($tre);
				$sFEC = "FEC00".strval($tre);
				$sFEH = "FEH00".strval($tre);
				$sREM = "REM00".strval($tre);
				$sREH = "REH00".strval($tre);
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
				$sACT = "ACT00".strval($tre);
				$sACH = "ACH00".strval($tre);
			}else if (strlen(strval($tre)) == 2){
				$sTR = 'TR0'.strval($tre);
				$sFEC = "FEC0".strval($tre);
				$sFEH = "FEH0".strval($tre);
				$sREM = "REM0".strval($tre);
				$sREH = "REH0".strval($tre);
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
				$sACT = "ACT0".strval($tre);
				$sACH = "ACH0".strval($tre);
			}else{
				$sTR = 'TR'.strval($tre);
				$sFEC = "FEC".strval($tre);
				$sFEH = "FEH".strval($tre);
				$sREM = "REM".strval($tre);
				$sREH = "REH".strval($tre);
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
				$sACT = "ACT".strval($tre);
				$sACH = "ACH".strval($tre);
			}
			$header1 = $header1."<tr class='TRs' id='".$sTR."'>";
			
			/*
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sFEC."' class='form-control input-sm datepicker' id='".$sFEC."' maxlength=15  autocomplete='off' value=".$audit_arr[$tre][5]." /></pre><input type='hidden' value=".$audit_arr[$tre][5]." name='".$sFEH."' id='".$sFEH."'/></td>";
			*/
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sFEC."' class='form-control input-sm datepicker' id='".$sFEC."' maxlength=15  autocomplete='off' ";
			
			
			
			if ($audit_arr[$tre][5] == '&nbsp'){
				$header1 = $header1."value='' /></pre><input type='hidden' value='-' name='".$sFEH."' id='".$sFEH."'/></td>";
			}else{
				$header1 = $header1."value=".$audit_arr[$tre][5]." /></pre><input type='hidden' value=".$audit_arr[$tre][5]." name='".$sFEH."' id='".$sFEH."'/></td>";
			}
			
			if ($audit_arr[$tre][6] == '&nbsp'){
				$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sREM."' class='form-control input-sm remito' id='".$sREM."' maxlength=6  autocomplete='off' value='' ></pre><input type='hidden' value='&nbsp' name='".$sREH."' id='".$sREH."'/></td>";
			}else{
				$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sREM."' class='form-control input-sm remito' id='".$sREM."' maxlength=6  autocomplete='off' value=".$audit_arr[$tre][6]." /></pre><input type='hidden' value=".$audit_arr[$tre][6]." name='".$sREH."' id='".$sREH."'/></td>";
			}
			
			/*
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sREM."' class='form-control input-sm remito' id='".$sREM."' maxlength=6  autocomplete='off' value=".$audit_arr[$tre][6]." /></pre><input type='hidden' value=".$audit_arr[$tre][6]." name='".$sREH."' id='".$sREH."'/></td>";
			*/
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sSER."' class='form-control input-sm' id='".$sSER."' maxlength=15  autocomplete='off' value=".$audit_arr[$tre][0]." /></pre><input type='hidden' value=".$audit_arr[$tre][0]." name='".$sSEH."' id='".$sSEH."'/></td>";
			$header4 = $header4.$audit_arr[$tre][0].";";
			
			$iRow2 = 1;
			$select_arr[0] = "<pre class='lx-pre'><input type='hidden' value=".$audit_arr[$tre][4]." name='".$sIXH."' id='".$sIXH."'/><select name='".$sIXL."' id='".$sIXL."' class='form-control input-sm uno'>";
			$select_arr3[0] = "<pre class='lx-pre'><select name='clientesgrupo' id='clientesgrupo' class='form-control input-sm'>";
			
			foreach($select_arr2 as $sel2){
				$id_xl = explode("|",$sel2);
				if ($id_xl[0] == $audit_arr[$tre][4]){
					$select_arr[$iRow2] = "<option value=".$id_xl[0]."|".$id_xl[1]."|".$iRow2." selected>".$id_xl[0]." - ".$id_xl[1]."</option>";
					$header4 = $header4.$id_xl[0].";".$audit_arr[$tre][9].";";
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
			
			if ($audit_arr[$tre][7] == '&nbsp'){
				$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sLOT."' class='form-control input-sm lote' id='".$sLOT."' maxlength=6  autocomplete='off' value=".$audit_arr[$tre][7]." ></pre><input type='hidden' name='".$sLOH."' id='".$sLOH."' value='".$lotehidden."' /></td>";
			}else{
				$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sLOT."' class='form-control input-sm lote' id='".$sLOT."' maxlength=6  autocomplete='off' value=".$audit_arr[$tre][7]." ></pre><input type='hidden' name='".$sLOH."' id='".$sLOH."' value='".$lotehidden."' /></td>";
			}
			
			//$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sLOT."' class='form-control input-sm lote' id='".$sLOT."' maxlength=6  autocomplete='off' value=".$audit_arr[$tre][7]."/></pre><input type='hidden' name='".$sLOH."' id='".$sLOH."' value='".$lotehidden."' /></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sPRO."' class='form-control input-sm' id='".$sPRO."' maxlength=30  autocomplete='off' value='".$audit_arr[$tre][1]."' disabled/></pre><input type='hidden' value=".$audit_arr[$tre][2]." name='".$sPRH."' id='".$sPRH."'/></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='".$sENV."' class='form-control input-sm' id='".$sENV."' maxlength=3  autocomplete='off' value=".$audit_arr[$tre][3]." disabled /></pre><input type='hidden' value=".$audit_arr[$tre][3]." name='".$sENH."' id='".$sENH."'/></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='checkbox' name='".$sCHKRB."' class='chkBox' id='".$sCHKRB."' tabindex='-1' /></pre><input type='hidden' name='".$sCHKRH."' id='".$sCHKRH."' value=0 /></td>";
			$header1 = $header1."<td><pre class='lx-pre'><input type='checkbox' name='".$sCHKAU."' class='chkBox' id='".$sCHKAU."' tabindex='-1' "; 
			if ($audit_arr[$tre][8] == 1){
				$header1 = $header1."checked";
			}
			$header1 = $header1." /></pre><input type='hidden' name='".$sCHKAH."' id='".$sCHKAH."' value='".$audit_arr[$tre][8]."' /></td>";
			$header1 = $header1."<td class='text-center'><label id='".$sTYA."'><pre class='lx-pre'>".$audit_arr[$tre][9]."</pre></label><input type='hidden' name='".$sTYH."' value='".$audit_arr[$tre][9]."' id='".$sTYH."' /></td>";
			$header4 = $header4.$sTYA.";";
			
			
			//$header1 = $header1."<td class='text-center'><label><pre class='lx-pre'></pre></label><input type='hidden' name='".$sACH."' id='".$sACH."' /></td>";
			
			$header1 = $header1."<td class='text-center'><pre class='lx-pre'><button class='btn btn-danger' id='".$sACT."'>-</button></pre><input type='hidden' name='".$sACH."' id='".$sACH."' /></td>";
			
			$header1 = $header1."</tr>";
		}			
		$header1 = $header1."</tbody>";
		$header1 = $header1."<input type='hidden' name='iregistro' id='iregistro' />"."<input type='hidden' name='numerocliente' id='numerocliente' value = ".$numerocliente." />";
		$header2 = $row_cnt - 1;
		$header4 = substr($header4, 0, strlen($header4) - 1);
		

		
			$return_arr[] = array("header1" => $header1,"header2" => $header2,"header3" => $header3,"header4" => $header4);
			//$return_arr[] = array("header1" => $header1,"header2" => $header2,"header3" => $header3,"header4" => $header4,"header5" => $header5);	
			
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
