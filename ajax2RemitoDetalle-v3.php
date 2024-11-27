<?php

include ("database_e.php");
require_once 'include/validacion.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
$nradioval = isset($_POST['nradioval']) ? $_POST['nradioval'] : false;; //Operador ternario -> if línea
$select_arr = array(0);
$return_arr = array();
$bremito = validaRemito($nremito);
$icnt = 0;
$iGranel = 0;
$idtanque = 0;

if($nremito && $bremito) {
	$DB= new Database();
	$nremito = $DB->sanitize($_POST['nremito']);
	$res = $DB->prRemitoDetallev3($nremito);
	$row_cnt = mysqli_num_rows($res);
	if($row_cnt == 0){
		$header1 = false;
		$header2 = "Información";
		$header3 = "El remito ".$nremito." no se encuentra en el sistema";
		$header15 = "col-md-5";	//Etiqueta Valor Mensaje
		$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3, "header15" => $header15);
		echo json_encode($return_arr);
	}else{

		while($row = mysqli_fetch_array($res)){
			if($icnt == 0){
				$fecha = $row['c_fecha'];
				$fecha = date_format(date_create($fecha),"d-m-Y");
				$id_xl = $row['c_id_xl'];
				$clie = $row['c_cliente'];
				$tiporemito = $row['c_tiporemito'];
				switch($row['c_propiedad']) {
					case "NP":
						$sProp = "NP";
						break;
					case "SP":
						$sProp = "SP";
						break;
				}
				switch($row['c_tipo']) {
					case "ZZZ":
						$sTipo = "Granel";
						$sProp = $row['c_volumen']." || ".$row['c_partida']." || ".$row['c_certificado']." || ".$row['c_movil'];
						$sPropTitle = "Volumen - Partida - Cert - Movil";
						$iGranel = 1;
						$sMovil = $row['c_movil'];
						break;
					case "CIL":
							$sTipo = "CIL";
							$sPropTitle = "Pr";
							break;
					case "TER":
							$sTipo = "TER";
							$sPropTitle = "Pr";
							break;
				}
			}
		}
		if($iGranel == 1){
			$DB1= new Database();
			$res1 = $DB1->getidTanque($sMovil);
			$row_cnt1 = mysqli_num_rows($res1);
			if($row_cnt == 1){
				while($row = mysqli_fetch_array($res1)){
					$idtanque = $row['id'];
				}
			}
		}
		
		
		
		if($nradioval == "M"){
			$header11 = true;
			$header12 = "<label><pre class='lx-pre'>Remito (Nuevo Número)</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='text' name='nremitomodi' id='nremitomodi' class='form-control input-sm' maxlength='6' autocomplete='off' required/></pre></label>";
			$header13 = "<label><pre class='lx-pre'>Fecha</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='text' name='fecha' id='datepicker' class='form-control input-sm' maxlength='10' autocomplete='off' required/></pre></label>";
			
			$DB0= new Database();
			$idCL = 'XLS';
			$res = $DB0->clientesSG($idCL);
			$iRow = 1;
			$clienteid_xls = array(0,0);
			$lblNuevo = "";
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			
			if ($clienteOption){
				$clienteid_xls = explode("|",$_POST['cliente']);
				$idcliente_xls = $clienteid_xls[2];
			}else{
				$idcliente_xls = 0;
			}
			
			$select_arr[0] = "<label><pre class='lx-pre'>Cliente</pre></label>"."</br>"."<label><pre class='lx-pre'><select name='cliente' id='cliente' class='form-control input-sm'>"."<option value='0'>Clientes</option>";
			while ($row=mysqli_fetch_object($res)){ 
				if ($iRow == $idcliente_xls){ 
					$select_arr[$iRow] = "<option value='".$row->id_xl."|".$row->nombre."|".$iRow."' selected>".$row->id_xl." - ".$row->nombre."</option>";
					$iRow++;
				}else{
					$select_arr[$iRow] = "<option value='".$row->id_xl."|".$row->nombre."|".$iRow."'>".$row->id_xl." - ".$row->nombre."</option>";
					$iRow++;
				}
			}					
			$header14 = '';
			foreach($select_arr as $sel){
				$header14 = $header14.$sel;
			}
			$header14 = $header14."</select></pre></label>";
		
			if($sTipo == "Granel"){
				$header15 = "<label><pre class='lx-pre'>Volumen</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='text' name='vol' id='vol' class='form-control input-sm' maxlength=8  autocomplete='off' required /></pre></label>";
				$header16 = "<label><pre class='lx-pre'>Partida</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='text' name='part' id='part' class='form-control input-sm' maxlength=6  autocomplete='off' /></pre></label>";
				$header17 = "<label><pre class='lx-pre'>Cert</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='text' name='cert' id='cert' class='form-control input-sm' maxlength=5  autocomplete='off' /></pre></label>";			
				
				$DB1= new Database();
				$res1 = $DB1->getTanque();
				$iRowC = 1;
				$mov_arr[0] = "<label><pre class='lx-pre'>Móvil</pre></label>"."</br>"."<label><pre class='lx-pre'><select name='tanque' id='tanque' class='form-control input-sm'>"."<option value='0'>Móvil</option>";
				while($row = mysqli_fetch_array($res1)){
					if ($iRowC == 1){ 
						$mov_arr[$iRowC] = "<option value='".$row['id']."|".$row['nombre']."' selected>".$row['nombre']."</option>";
						$iRowC++;
					}else{
						$mov_arr[$iRowC] = "<option value='".$row['id']."|".$row['nombre']."'>".$row['nombre']."</option>";
						$iRowC++;
					}
				}
				$header18 = '';
				foreach($mov_arr as $sel){
					$header18 = $header18.$sel;
				}
				$header18 = $header18."</select></pre></label>";
				
				$sHeader27 = "col-md-2";
			}else{
				$header15 = "<label><pre class='lx-pre'>Tipo</pre></label>"."</br>"."<label><pre class='lx-pre'>".$sTipo."</pre></label>";
				$header16 = "<label><pre class='lx-pre'>Pr</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='radio' name='prop' value='NP' class='envProp' required checked />NP<input type='radio' name='prop' value='SP' class='envProp' required/>SP</pre></label>";
				$header17 = "";
				$header18 = "";
				$sHeader27= "col-md-1";
			}	
				
			
		
		}else{
			$header11 = false;
			$header12 = "";
			$header13 = "";
			$header14 = "";
			$header15 = "";
			$header16 = "";
			$header17 = "";
			$header18 = "";
			$sHeader27 = ""; 
			$header28 = "";
		}
	
		$header1 = true;
		$header2 = "Fecha";
		$header3 = $fecha;
		$header4 = "Cliente";
		$header5 = "(".$id_xl.") ".$clie;
		$header6 = "Tipo";
		$header7 = $sTipo;
		$header8 = $sPropTitle;
		$header9 = $sProp;
		$header9a = $idtanque;
		$header10 = $tiporemito;
		
		$header19 = $id_xl."|".$clie;
		
		$header20 = "col-md-2";	//Div Fecha
		if($sTipo == "Granel"){
			$header21 = "col-md-4";	//Div Cliente
		}else{
			$header21 = "col-md-4";	//Div Cliente
		}
		$header22 = "col-md-1";	//Div Tipo Envase
		$header23 = "col-md-3";	//Div Propiedad
		$header24 = "col-md-2"; //Div Edición Remito
		$header25 = "col-md-2"; //Div Edición Fecha
		if($sTipo == "Granel"){
			$header26 = "col-md-2"; //Div Edición Cliente
		}else{
			$header26 = "col-md-4"; //Div Edición Cliente
		}
		$header27 = $sHeader27; //Div Propiedad (Envasado) - Div Datos Granel
		$header28 = "col-md-1"; //Div Datos Granel
		
		
		
		
		$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3, "header4" => $header4, "header5" => $header5, "header6" => $header6, "header7" => $header7, "header8" => $header8, "header9" => $header9, "header9a" => $header9a, "header10" => $header10, "header11" => $header11, "header12" => $header12, "header13" => $header13, "header14" => $header14, "header15" => $header15, "header16" => $header16, "header17" => $header17, "header18" => $header18, "header19" => $header19, "header20" => $header20, "header21" => $header21, "header22" => $header22, "header23" => $header23, "header24" => $header24, "header25" => $header25, "header26" => $header26, "header27" => $header27, "header28" => $header28);
		echo json_encode($return_arr);
	
	}
}else{
	$header1 = false;
	$header2 = "Atención. El dato ingresado no es válido";
	$header3 = "Remito N° ".$nremito;
	$header15 = "col-md-5";	//Etiqueta Valor Mensaje
	$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3, "header15" => $header15);
	echo json_encode($return_arr);
}

?>
