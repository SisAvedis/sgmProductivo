<?php

//include ("database_e.php");
include ("database_e4.php");
//require_once 'include/validacion.php';
require_once 'include/validacion4.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
$tipoOpcion = isset($_POST['tipoOpcion']) ? $_POST['tipoOpcion'] : false;; //Operador ternario -> if línea
$tipoProducto = isset($_POST['tipoProducto']) ? $_POST['tipoProducto'] : false;; //Operador ternario -> if línea
$iProducto = isset($_POST['iProducto']) ? $_POST['iProducto'] : false;; //Operador ternario -> if línea
$return_arr = array();
$select_arr = array(0);
$cap_arr = array(0);
$mov_arr = array(0);
$cant_arr = array(0);
$bremito = validaRemito($nremito);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	//if($nremito && $abmOpcion) {
	if($nremito && $bremito) {
		$DB= new Database();
		$nremito = $DB->sanitize($_POST['nremito']);
		//$abmOpcion = $_POST['abmOpcion'];
		$res = $DB->prRemitoDetallev7($nremito);
		$row_cnt = mysqli_num_rows($res);
		if($row_cnt == 0){
				// LG -> Líquido - Gaseoso || GR -> Granel
				if($tipoProducto == 'LG'){
					$header1 = "<label><pre class='lx-pre'>Fecha</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='text' name='fecha' id='datepicker' class='form-control input-sm' maxlength='10' autocomplete='off' required/></pre></label>";
					
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
					
					if ($tipoOpcion){
						$tipoEnv = explode("|", $_POST['tipoOpcion']);
						$tipoEnva= $tipoEnv[1];
					}else{
						$tipoEnv[0] = "CIL";
						$tipoEnva = 0;
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
							
						$header2 = '';
						foreach($select_arr as $sel){
							$header2 = $header2.$sel;
						}
						$header2 = $header2."</select></pre></label>";
	
						$header3 = "<label><pre class='lx-pre'>Tipo</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='radio' name='env' value='CIL' class='envRadio' required checked/>CIL<input type='radio' name='env' value='TER' class='envRadio' required/>TER</pre></label><input type='hidden' name='envH' id='envH'/><input type='hidden' name='mot' id='mot'/>";
						
						$header4 = "<label><pre class='lx-pre'>Propiedad</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='radio' name='prop' value='NP' class='envProp' required checked />NP<input type='radio' name='prop' value='SP' class='envProp' required/>SP</pre></label>";
						
						$header5 = "";
						
						//Acá comienza tabla Enviados
						
						$header6 = "<table class='table table-bordered'><thead><tr><th colspan=2><label name='lbcantidadE' id='lbcantidadE'><pre class='lx-pre'>Enviados - Cantidad: 0</pre></label></th>";
						
						$header6 = $header6."<th colspan=3><label><pre class='lx2-pre' id='lbrepetidoE'></pre></label></th>"; 
						
						$header6 = $header6."<th><label><pre class='lx-pre'><input type='checkbox' name='allE' value='Todos' id='allChkBE' class='allCheckE'/>Todos </pre></label></th>";
						
						$DB1= new Database();
						$res1 = $DB1->getCapProd($iProducto,$tipoEnv[0]);
						$iRowC = 1;
						$cap_arr[0] = "<th><pre class='lx-pre'><select name='capacidadE' id='capacidadE' class='form-control input-sm'>"."<option value='0'>Capacidad</option>";
						
						while($row = mysqli_fetch_array($res1)){
							if ($iRowC == $tipoEnva){ 
								$cap_arr[$iRowC] = "<option value='".$row['capacidad']."|".$iRowC."' selected>".$row['capacidad']."</option>";
								$iRowC++;
							}else{
								$cap_arr[$iRowC] = "<option value='".$row['capacidad']."|".$iRowC."'>".$row['capacidad']."</option>";
								$iRowC++;
							}
						}
						
						foreach($cap_arr as $sel){
							$header6 = $header6.$sel;
						}
						
						$header6 = $header6."</select></pre></th>";
						
						$cant_arr[0] = "<th><pre class='lx-pre'><select name='cantidadE' id='cantidadE' class='form-control input-sm'>"."<option value='0'>Cantidad</option>";
						
						for($cantE=1;$cantE<26;$cantE++){
							if ($cantE == 0){ 
								$cant_arr[$cantE] = "<option value='".$cantE."' selected>".$cantE."</option>";
							}else{
								$cant_arr[$cantE] = "<option value='".$cantE."'>".($cantE-1)."</option>";
							}	
						}
						
						foreach($cant_arr as $sel){
							$header6 = $header6.$sel;
						}
						
						$header6 = $header6."</select></pre>";
						$header6 = $header6."</th></tr></thead>";
						
						$header6 = $header6."<tbody>";
						for($tre=0;$tre<3;$tre++){
							$header6 = $header6."<tr>";
							for($tde=1;$tde<9;$tde++){
								if($tre*8+$tde<10){
									$header6 = $header6."<td><input type='text' name='ENV0".strval($tre*8+$tde)."' class='form-control input-sm' id='ENV0".strval($tre*8+$tde)."' maxlength=12  autocomplete='off' required/><pre class='lx2-pre'><input type='checkbox' name='ECHK0".strval($tre*8+$tde)."' class='chkBox' id='ECHK0".strval($tre*8+$tde)."' tabindex='-1' required/><label name='ECAP0".strval($tre*8+$tde)."' id='ECAP0".strval($tre*8+$tde)."'>"."</label></pre><input type='hidden' value='0' name='ECAPH0".strval($tre*8+$tde)."' id='ECAPH0".strval($tre*8+$tde)."'/></td>";
								}else{
									$header6 = $header6."<td><input type='text' name='ENV".strval($tre*8+$tde)."' class='form-control input-sm' id='ENV".strval($tre*8+$tde)."' maxlength=12  autocomplete='off' required/><pre class='lx2-pre'><input type='checkbox' name='ECHK".strval($tre*8+$tde)."' class='chkBox' id='ECHK".strval($tre*8+$tde)."' tabindex='-1' required/><label name='ECAP".strval($tre*8+$tde)."' id='ECAP".strval($tre*8+$tde)."'>"."</label></pre><input type='hidden' value='0' name='ECAPH".strval($tre*8+$tde)."' id='ECAPH".strval($tre*8+$tde)."'/></td>";	
								}
							}
							$header6 = $header6."</tr>";
						}
						$header6 = $header6."</tbody>";
						
						//Acá termina Enviados	
						//Acá comienza Devueltos				
						
						$header6 = $header6."<table class='table table-bordered'><thead><tr><th colspan=2><label name='lbcantidadD' id='lbcantidadD'><pre class='lx-pre'>Devueltos - Cantidad: 0</pre></label></th>";
						
						$header6 = $header6."<th colspan=3><label><pre class='lx2-pre' id='lbrepetidoD'></pre></label></th>";
						
						$header6 = $header6."<th><label><pre class='lx-pre'><input type='checkbox' name='allD' value='Todos' id='allChkBD' class='allCheckD'/>Todos </pre></label></th>";
						
						$cap_arr[0] = "<th><pre class='lx-pre'><select name='capacidadD' id='capacidadD' class='form-control input-sm'>"."<option value='0'>Capacidad</option>";
						
						foreach($cap_arr as $sel){
							$header6 = $header6.$sel;
						}
						
						$header6 = $header6."</select></pre></th>";
						
						$cant_arr[0] = "<th><pre class='lx-pre'><select name='cantidadD' id='cantidadD' class='form-control input-sm'>"."<option value='0'>Cantidad</option>";
						
						for($cantD=1;$cantD<26;$cantD++){
							if ($cantD == 0){ 
								$cant_arr[$cantD] = "<option value='".$cantD."' selected>".$cantD."</option>";
							}else{
								$cant_arr[$cantD] = "<option value='".$cantD."'>".($cantD-1)."</option>";
							}	
						}
						
						foreach($cant_arr as $sel){
							$header6 = $header6.$sel;
						}
						
						$header6 = $header6."</select></pre>";
						$header6 = $header6."</th></tr></thead>";
						
						$header6 = $header6."<tbody>";
						for($trd=0;$trd<3;$trd++){
							$header6 = $header6."<tr>";
							for($tdd=1;$tdd<9;$tdd++){
								if($trd*8+$tdd<10){
									$header6 = $header6."<td><input type='text' name='DEV0".strval($trd*8+$tdd)."' class='form-control input-sm' id='DEV0".strval($trd*8+$tdd)."' maxlength=12  autocomplete='off' required/><pre class='lx2-pre'><input type='checkbox' name='DCHK0".strval($trd*8+$tdd)."' class='chkBox' id='DCHK0".strval($trd*8+$tdd)."' tabindex='-1' required/><label name='DCAP0".strval($trd*8+$tdd)."' id='DCAP0".strval($trd*8+$tdd)."'>"."</label></pre><input type='hidden' value='0' name='DCAPH0".strval($trd*8+$tdd)."' id='DCAPH0".strval($trd*8+$tdd)."'/></td>";
								}else{
									$header6 = $header6."<td><input type='text' name='DEV".strval($trd*8+$tdd)."' class='form-control input-sm' id='DEV".strval($trd*8+$tdd)."' maxlength=12  autocomplete='off' required/><pre class='lx2-pre'><input type='checkbox' name='DCHK".strval($trd*8+$tdd)."' class='chkBox' id='DCHK".strval($trd*8+$tdd)."' tabindex='-1' required/><label name='DCAP".strval($trd*8+$tdd)."' id='DCAP".strval($trd*8+$tdd)."'>"."</label></pre><input type='hidden' value='0' name='DCAPH".strval($trd*8+$tdd)."' id='DCAPH".strval($trd*8+$tdd)."'/></td>";	
								}
							}
							$header6 = $header6."</tr>";
						}
						$header6 = $header6."</tbody>";
						$header7 = "col-md-4";	//combo cliente
						$header8 = "col-md-2";	//vacío ex label Tipo (SI/NO) 
						$header9 = "col-md-12";	//grilla envases
						$header10 = "col-md-2";	//option Tipo (CIL/TER)
						$header11 = "col-md-2";	//option Propiedad (NP/SP)
						$header12 = "";
						$header13 = false;
						
					$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3, "header4" => $header4, "header5" => $header5, "header6" => $header6, "header7" => $header7, "header8" => $header8, "header9" => $header9, "header10" => $header10, "header11" => $header11, "header12" => $header12, "header13" => $header13);		
					
					echo json_encode($return_arr);
				}else{
					$header1 = "<label><pre class='lx-pre'>Fecha</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='text' name='fecha' id='datepicker' class='form-control input-sm' maxlength='10' autocomplete='off' required/></pre></label>";
					
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
					
					if ($tipoOpcion){
						$tipoEnv = explode("|", $_POST['tipoOpcion']);
						$tipoEnva= $tipoEnv[1];
					}else{
						$tipoEnv[0] = "CIL";
						$tipoEnva = 0;
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
							
						$header2 = '';
						foreach($select_arr as $sel){
							$header2 = $header2.$sel;
						}
					$header2 = $header2."</select></pre></label>";
					$header3 = "<label><pre class='lx-pre'>Volumen</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='text' name='vol' id='vol' class='form-control input-sm' maxlength=8  autocomplete='off' required /></pre></label>";
					
					$header4 = "<label><pre class='lx-pre'>Partida</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='text' name='part' id='part' class='form-control input-sm' maxlength=12  autocomplete='off' /></pre></label>";
					$header5 = "<label><pre class='lx-pre'>Cert</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='text' name='cert' id='cert' class='form-control input-sm' maxlength=5  autocomplete='off' /></pre></label>";
					
					$DB1= new Database();
					$res1 = $DB1->getTanque();
					$iRowC = 1;
					$mov_arr[0] = "<label><pre class='lx-pre'>Móvil</pre></label>"."</br>"."<label><pre class='lx-pre'><select name='tanque' id='tanque' class='form-control input-sm'>"."<option value='0'>Móvil</option>";
					while($row = mysqli_fetch_array($res1)){
						if ($iRowC == $tipoEnva){ 
							$mov_arr[$iRowC] = "<option value='".$row['id']."' selected>".$row['nombre']."</option>";
							$iRowC++;
						}else{
							$mov_arr[$iRowC] = "<option value='".$row['id']."'>".$row['nombre']."</option>";
							$iRowC++;
						}
					}
					$header6 = '';
					foreach($mov_arr as $sel){
						$header6 = $header6.$sel;
					}
					$header6 = $header6."</select></pre></label>";
						
					$header7 = "col-md-3";	//combo cliente
					$header8 = "col-md-2";	//input Partida
					$header9 = "col-md-2";	//combo Móvil
					$header10 = "col-md-2";	//input Volumen
					$header11 = "col-md-1";	//input Certificado
					$header12 = "";
					$header13 = false;
					
					
					$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3, "header4" => $header4, "header5" => $header5, "header6" => $header6, "header7" => $header7, "header8" => $header8, "header9" => $header9, "header10" => $header10, "header11" => $header11, "header12" => $header12, "header13" => $header13);		
					
					echo json_encode($return_arr);
				}
			}	
				}
		}
?>
