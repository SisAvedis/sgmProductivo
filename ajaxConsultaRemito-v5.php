<?php

include ("database_e.php");
require_once 'include/validacion.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
$tipoOpcion = isset($_POST['tipoOpcion']) ? $_POST['tipoOpcion'] : false;; //Operador ternario -> if línea
$return_arr = array();
$select_arr = array(0);
$cap_arr = array(0);
$cant_arr = array(0);
$bremito = validaRemito($nremito);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	//if($nremito && $abmOpcion) {
	if($nremito && $bremito) {
		$DB= new Database();
		$nremito = $DB->sanitize($_POST['nremito']);
		//$abmOpcion = $_POST['abmOpcion'];
		$res = $DB->prRemitoDetallev1($nremito,1);
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
			$header1 = "Atención. El remito ".$nremito." ya fue ingresado";
			$header2 = "<label><pre class='lx-pre'>Fecha: ".$fecha." | Cliente: (".$id_xl.") ".$clie." | Tipo: ".$tipo." | Env: ".$env." | Dev: ".$dev."</pre></label>";
			$header7 = true;
			
			
			$return_arr[] = array("header1" => $header1, "header2" => $header2, "header7" => $header7);
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

					$header3 = "<label><pre class='lx-pre'>Tipo</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='radio' name='env' value='CIL' class='envRadio' required checked/>CIL<input type='radio' name='env' value='TER' class='envRadio' required/>TER</pre></label>";
					
					$header4 = "<label><pre class='lx-pre'>Propiedad</pre></label>"."</br>"."<label><pre class='lx-pre'><input type='radio' name='prop' value='NP' class='envProp' required checked />NP<input type='radio' name='prop' value='SP' class='envProp' required/>SP</pre></label>";
					
					$header5 = "<label><pre class='lx-pre'>Listo</pre></label>"."</br>"."<label><pre class='lx-pre' id='rStatus'>No</pre></label>";
					//$header5 = "<label><pre class='lx-pre'>Listo</pre></label>"."</br>"."<table class='table table-bordered'><thead><tr><th><label><pre class='lx-pre' id='rStatus'>No</pre></label></th></tr></table>";
//Acá comienza tabla Enviados
					$header6 = "<table class='table table-bordered'><thead><tr><th colspan=2><label name='lbcantidadE' id='lbcantidadE'><pre class='lx-pre'>Enviados - Cantidad: 0</pre></label></th>";
					
					//$header6 = $header6."<th colspan=3><label name='lbrepetidoE' id='lbrepetidoE'></label></th>";
					//$header6 = $header6."<th colspan=3><pre class='lx2-pre'><label name='lbrepetidoE' id='lbrepetidoE'></label></pre></th>";
					$header6 = $header6."<th colspan=3><label><pre class='lx2-pre' id='lbrepetidoE'></pre></label></th>"; 
					//$header6 = $header6."<th colspan=3 id='lbrepetidoE'></th>";
					
					$header6 = $header6."<th><label><pre class='lx-pre'><input type='checkbox' name='allE' value='Todos' id='allChkBE' class='allCheckE'/>Todos </pre></label></th>";
					
					$DB1= new Database();
					$res1 = $DB1->getCap($tipoEnv[0]);
					$iRowC = 1;
					$cap_arr[0] = "<th><pre class='lx-pre'><select name='capacidadE' id='capacidadE' class='form-control input-sm'>"."<option value='0'>Capacidad</option>";
					
					while($row = mysqli_fetch_array($res1)){
					//while ($row=mysqli_fetch_object($res1)){ 
						if ($iRowC == $tipoEnva){ 
							//$selectCap_arr[$iRowC] = "<option value='".$row->capacidad."|".$iRowC."' selected>".$row->capacidad."</option>";
							$cap_arr[$iRowC] = "<option value='".$row['capacidad']."|".$iRowC."' selected>".$row['capacidad']."</option>";
							$iRowC++;
						}else{
							$cap_arr[$iRowC] = "<option value='".$row['capacidad']."|".$iRowC."'>".$row['capacidad']."</option>";
							$iRowC++;
							//$selectCap_arr[$iRowC] = "<option value='".$row->capacidad."|".$iRowC."'>".$row->capacidad."</option>";
							//$iRowC++;
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
								$header6 = $header6."<td><input type='text' name='ENV0".strval($tre*8+$tde)."' class='form-control' id='ENV0".strval($tre*8+$tde)."' maxlength=12  autocomplete='off' required/><pre class='lx2-pre'><input type='checkbox' name='ECHK0".strval($tre*8+$tde)."' class='chkBox' id='ECHK0".strval($tre*8+$tde)."' tabindex='-1' required/><label name='ECAP0".strval($tre*8+$tde)."' id='ECAP0".strval($tre*8+$tde)."'>"."</label></pre><input type='hidden' value='0' name='ECAPH0".strval($tre*8+$tde)."' id='ECAPH0".strval($tre*8+$tde)."'/></td>";
							}else{
								$header6 = $header6."<td><input type='text' name='ENV".strval($tre*8+$tde)."' class='form-control' id='ENV".strval($tre*8+$tde)."' maxlength=12  autocomplete='off' required/><pre class='lx2-pre'><input type='checkbox' name='ECHK".strval($tre*8+$tde)."' class='chkBox' id='ECHK".strval($tre*8+$tde)."' tabindex='-1' required/><label name='ECAP".strval($tre*8+$tde)."' id='ECAP".strval($tre*8+$tde)."'>"."</label></pre><input type='hidden' value='0' name='ECAPH".strval($tre*8+$tde)."' id='ECAPH".strval($tre*8+$tde)."'/></td>";	
							}
						}
						$header6 = $header6."</tr>";
					}
					$header6 = $header6."</tbody>";
//Acá termina Enviados	
//Acá empieza Devueltos				
					$header6 = $header6."<table class='table table-bordered'><thead><tr><th colspan=2><label name='lbcantidadD' id='lbcantidadD'><pre class='lx-pre'>Devueltos - Cantidad: 0</pre></label></th>";
					
					//$header6 = $header6."<th colspan=3><label name='lbrepetidoD' id='lbrepetidoD'></label></th>";
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
								$header6 = $header6."<td><input type='text' name='DEV0".strval($trd*8+$tdd)."' class='form-control' id='DEV0".strval($trd*8+$tdd)."' maxlength=12  autocomplete='off' required/><pre class='lx2-pre'><input type='checkbox' name='DCHK0".strval($trd*8+$tdd)."' class='chkBox' id='DCHK0".strval($trd*8+$tdd)."' tabindex='-1' required/><label name='DCAP0".strval($trd*8+$tdd)."' id='DCAP0".strval($trd*8+$tdd)."'>"."</label></pre><input type='hidden' value='0' name='DCAPH0".strval($trd*8+$tdd)."' id='DCAPH0".strval($trd*8+$tdd)."'/></td>";
							}else{
								$header6 = $header6."<td><input type='text' name='DEV".strval($trd*8+$tdd)."' class='form-control' id='DEV".strval($trd*8+$tdd)."' maxlength=12  autocomplete='off' required/><pre class='lx2-pre'><input type='checkbox' name='DCHK".strval($trd*8+$tdd)."' class='chkBox' id='DCHK".strval($trd*8+$tdd)."' tabindex='-1' required/><label name='DCAP".strval($trd*8+$tdd)."' id='DCAP".strval($trd*8+$tdd)."'>"."</label></pre><input type='hidden' value='0' name='DCAPH".strval($trd*8+$tdd)."' id='DCAPH".strval($trd*8+$tdd)."'/></td>";	
							}
						}
						$header6 = $header6."</tr>";
					}
					$header6 = $header6."</tbody>";
	
					$header7 = false;
					
				$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3, "header4" => $header4, "header5" => $header5, "header6" => $header6, "header7" => $header7);		
				
				echo json_encode($return_arr);
			
			}
				
				
			}else{
				$header1 = "Atención. El número ingresado (".$nremito.") no es válido";
				$header2 = "";
				$header7 = true;
				$return_arr[] = array("header1" => $header1, "header2" => $header2, "header7" => $header7);
				echo json_encode($return_arr);
			}
				
			

		}
			
	
	 

?>
