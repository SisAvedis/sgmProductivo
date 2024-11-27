<?php

include ("database_e.php");
//include ("database_e3.php");
require_once 'include/validacion.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
$return_arr = array();
$bremito = validaRemito($nremito);
$icnt = 0;
$itr = 0;
$icnte = 0;
$icntd = 0;
$dvole = 0;
$icntvol = 0;
$sCodTitle = "Producto";


$env_arr = array();
$dev_arr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($nremito && $bremito) {
		
		$DB1 = new Database();
		$nremito = $DB1->sanitize($_POST['nremito']);
		$res1 = $DB1->prRemitoProductov1($nremito);
		$row_cnt1 = mysqli_num_rows($res1);
		while($row1 = mysqli_fetch_array($res1)){
			$header51 = "<td class='text-center' rowspan=5>"."<img id='imagenE' src = 'data:image/png;base64,".base64_encode($row1['c_imagen'])."' width = '72px' height = '347px'/>"."</td>";
			$header52 = "<td class='text-center' rowspan=5>"."<img id='imagenD' src = 'data:image/png;base64,".base64_encode($row1['c_imagen'])."' width = '72px' height = '347px'/>"."</td>";
			$codigo = $row1['c_cod_producto'];
			if($codigo == "O2"){
				$header53 = "<td class='text-center' rowspan=5>"."<img id='imagenE' src = 'data:image/png;base64,".base64_encode($row1['c_imagenT'])."' width = '48px' height = '138px'/>"."</td>";
				$header54 = "<td class='text-center' rowspan=5>"."<img id='imagenD' src = 'data:image/png;base64,".base64_encode($row1['c_imagenT'])."' width = '48px' height = '138px'/>"."</td>";
				$header55 = "<td class='text-center' rowspan=2>"."<img id='imagenF' src = 'data:image/png;base64,".base64_encode($row1['c_imagenG'])."' width = '400px' height = '202px'/>"."</td>";
				$codigo = $row1['c_cod_producto'];
			
			}
			
			
				
		}
		
		
		$DB= new Database();
		$nremito = $DB->sanitize($_POST['nremito']);
		$res = $DB->prRemitoDetalleDUv43($nremito);
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
					$remitodup = $row['remitodup'];
					$tiporemito = $row['c_tiporemito'];
					//$codigo = $row['c_cod_producto'];
					$idestado = $row['iddescripcion'];
					$estado = $row['estadodescripcion'];
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
							$sProp = "";
							$sPropTitle = "";
							$bEnvasado = false;
							$tdheader = "<td class='text-center'>Partida</td>"."<td class='text-center'>Certificado</td>"."<td class='text-center'>Movil</td>".$header55;
							$header11 = "<table class='table table-bordered'><thead><tr><th colspan=4><label name='lbvolumenE' id='lbvolumenE'><pre class='lx-pre'>Volumen Despachado: 0</pre></label></th>";
							$header11 = $header11."</th></tr></thead>";
							$header11 = $header11."<tbody>"."<tr>".$tdheader;
							$header11 = $header11."</tr>";
							$header11 = $header11."<tr><td class='text-center'>".$row['c_partida']."</td>"."<td class='text-center'>".$row['c_certificado']."</td>"."<td class='text-center'>".$row['c_movil']."</td></tr></tbody></table>";
							$dvole = $row['c_volumen'];
							$header12 = "";
							$header13 = "";
							$header14 = "";
							$motivo = "";
							break;
						case "CIL":
							$sTipo = "CIL";
							$sPropTitle = "Pr";
							$bEnvasado = true;
							$tdheaderE = "";
							for($i=1;$i<7;$i++){
								$tdheaderE = $tdheaderE."<td>"."N° Serie"."</td><td>"."Capacidad"."</td>";
							}
							$tdheaderE = $tdheaderE.$header51;
							$header11 = "<table class='table table-bordered'><thead><tr><th colspan=13><label name='lbcantidadE' id='lbcantidadE'><pre class='lx-pre'>Enviados - Cantidad: 0</pre></label></th>";
							$header11 = $header11."</th></tr></thead>";
							$header11 = $header11."<tbody>"."<tr>".$tdheaderE;
							$header13 = "<table class='table table-bordered'><thead><tr><th colspan=13><label name='lbcantidadD' id='lbcantidadD'><pre class='lx-pre'>Devueltos - Cantidad: 0</pre></label></th>";
							$tdheaderD = "";
							for($i=1;$i<7;$i++){
								$tdheaderD = $tdheaderD."<td>"."N° Serie"."</td><td>"."Capacidad"."</td>";
							}
							$tdheaderD = $tdheaderD.$header52;
							$header13 = $header13."</th></tr></thead>";
							$header13 = $header13."<tbody>"."<tr>".$tdheaderD;
							$motivo = $row['motivodescripcion'];
							break;
						case "TER":
							$sTipo = "TER";
							$sPropTitle = "Pr";
							$bEnvasado = true;
							$tdheaderE = "";
							for($i=1;$i<7;$i++){
								$tdheaderE = $tdheaderE."<td>"."N° Serie"."</td><td>"."Capacidad"."</td>";
							}
							$tdheaderE = $tdheaderE.$header53;
							$header11 = "<table class='table table-bordered'><thead><tr><th colspan=13><label name='lbcantidadE' id='lbcantidadE'><pre class='lx-pre'>Enviados - Cantidad: 0</pre></label></th>";
							$header11 = $header11."</th></tr></thead>";
							$header11 = $header11."<tbody>"."<tr>".$tdheaderE;
							$header13 = "<table class='table table-bordered'><thead><tr><th colspan=13><label name='lbcantidadD' id='lbcantidadD'><pre class='lx-pre'>Devueltos - Cantidad: 0</pre></label></th>";
							$tdheaderD = "";
							for($i=1;$i<7;$i++){
								$tdheaderD = $tdheaderD."<td>"."N° Serie"."</td><td>"."Capacidad"."</td>";
							}
							$tdheaderD = $tdheaderD.$header54;
							$header13 = $header13."</th></tr></thead>";
							$header13 = $header13."<tbody>"."<tr>".$tdheaderD;
							$motivo = $row['motivodescripcion'];
							break;
					}
					if($bEnvasado == true){
						switch($row['c_estado']) {
							case "E":
								//20-08-2022
								//$dvole = $row['c_volumen'];
								//$dvole = number_format($dvole+$row['c_volumen'],2);
								$dvole = $row['c_volumen']+0;
								$icnte++;
								$env_arr[0][$icnte] = $row['c_serie'];
								$env_arr[1][$icnte] = $row['c_volumen'];
								
							break;
							case "D":
								$icntd++;
								$dev_arr[0][$icntd] = $row['c_serie'];
								$dev_arr[1][$icntd] = $row['c_volumen'];
							break;
						}
						if($row['c_volumen'] <> 0.00){
							$icntvol++;
						}
					}
					
				//Hasta acá es la primera pasada	
				}else{
					if($bEnvasado == true){
						switch($row['c_estado']) {
							case "E":
								//20-08-2022
								//$dvole = number_format($dvole+$row['c_volumen'],2);
								$dvole = $dvole+$row['c_volumen'];
								$icnte++;
								$env_arr[0][$icnte] = $row['c_serie'];
								$env_arr[1][$icnte] = $row['c_volumen'];
							break;
							case "D":
								$icntd++;
								$dev_arr[0][$icntd] = $row['c_serie'];
								$dev_arr[1][$icntd] = $row['c_volumen'];
							break;
						}
						if($row['c_volumen'] <> 0.00){
							$icntvol++;
						}
					}
				}
			
				if($bEnvasado == true){
					$icnt++;
				}
			
			
			
			
			
			
			
			
			
			
			
			}
			//fin del recordset
			
		if($bEnvasado == true){
			$header11 = procesaTabla($icnte,"E");
			$header13 = procesaTabla($icntd,"D");
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
		$header10 = $bEnvasado;
		$header12 = $icnte;
		$header14 = $icntd;
		//20-08-2022
		//$header15 = $dvole;
		//Cuando pasa las unidades de mil, el string tiene una coma entonces modifica el número.
		$header15 = number_format($dvole,2);
		$header16 = $icntvol;
		$header17 = $tiporemito;
		
		$header18 = $sCodTitle;
		$header19 = $codigo;
		
		$header192 = $estado;
		$header191 = $idestado;
		
		$header193 = $icnt;
		
		$header194 = $remitodup;
		
		$header98 = $motivo;
		
		$header20 = "col-md-2";	//Div Fecha
		$header21 = "col-md-4";	//Div Cliente
		$header22 = "col-md-1";	//Div Tipo Envase
		$header23 = "col-md-1";	//Div Propiedad
		$header25 = "col-md-2";	//Div Producto
		$header24 = "col-md-11";//Div Detalle
		
		$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3, "header4" => $header4, "header5" => $header5, "header6" => $header6, "header7" => $header7, "header8" => $header8, "header9" => $header9, "header10" => $header10, "header11" => $header11, "header12" => $header12, "header13" => $header13, "header14" => $header14, "header15" => $header15, "header16" => $header16, "header17" => $header17, "header18" => $header18, "header19" => $header19, "header191" => $header191, "header192" => $header192, "header193" => $header193, "header194" => $header194, "header98" => $header98, "header20" => $header20, "header21" => $header21, "header22" => $header22, "header23" => $header23, "header24" => $header24, "header25" => $header25);
		echo json_encode($return_arr);
		}
	}
}

function procesaTabla($icnt, $movimiento)
{
	
	//$seccion = $seccion."<tr>";
	switch($movimiento) {
		case "E":
			global $env_arr;
			global $header11;
			$seccion = $header11."<tr>";
			for($j = 1 ;$j <= $icnt ;$j++){
				$seccion = $seccion."<td>".$env_arr[0][$j]."</td><td>".$env_arr[1][$j]."</td>";
				if(($j)%6 == 0){
					$seccion = $seccion."</tr><tr>";
				}
			}
		break;
		case "D":
			global $dev_arr;
			global $header13;
			$seccion = $header13."<tr>";
			for($j = 1 ;$j <= $icnt ;$j++){
				$seccion = $seccion."<td>".$dev_arr[0][$j]."</td><td>".$dev_arr[1][$j]."</td>";
				if(($j)%6 == 0){
					$seccion = $seccion."</tr><tr>";
				}
			}
		break;
	}
	
	for($j = $icnt+1 ;$j <= 24 ;$j++){
		$seccion = $seccion."<td></td><td></td>";
		if(($j)%6 == 0){
			$seccion = $seccion."</tr><tr>";
		}
	}
	$seccion = $seccion."</tr></tbody></table>";
	return ($seccion);
}


?>
