<?php

include ("database_e.php");
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


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
							$sProp = "";
							$sPropTitle = "";
							$bEnvasado = false;
							$tdheader = "<td class='text-center'>Partida</td>"."<td class='text-center'>Certificado</td>"."<td class='text-center'>Movil</td>";
							$header11 = "<table class='table table-bordered'><thead><tr><th colspan=3><label name='lbvolumenE' id='lbvolumenE'><pre class='lx-pre'>Volumen Despachado: 0</pre></label></th>";
							$header11 = $header11."</th></tr></thead>";
							$header11 = $header11."<tbody>"."<tr>".$tdheader;
							$header11 = $header11."</tr>";
							$header11 = $header11."<tr><td class='text-center'>".$row['c_partida']."</td>"."<td class='text-center'>".$row['c_certificado']."</td>"."<td class='text-center'>".$row['c_movil']."</td></tr></tbody></table>";
							$dvole = $row['c_volumen'];
							$header12 = "";
							$header13 = "";
							$header14 = "";
							break;
						case "CIL":
							$sTipo = "CIL";
							$sPropTitle = "Pr";
							$bEnvasado = true;
							$tdheader = "";
							for($i=1;$i<7;$i++){
								$tdheader = $tdheader."<td>"."N° Serie"."</td><td>"."Capacidad"."</td>";
							}
							$header11 = "<table class='table table-bordered'><thead><tr><th colspan=12><label name='lbcantidadE' id='lbcantidadE'><pre class='lx-pre'>Enviados - Cantidad: 0</pre></label></th>";
							$header11 = $header11."</th></tr></thead>";
							$header11 = $header11."<tbody>"."<tr>".$tdheader;
							$header13 = "<table class='table table-bordered'><thead><tr><th colspan=12><label name='lbcantidadD' id='lbcantidadD'><pre class='lx-pre'>Devueltos - Cantidad: 0</pre></label></th>";
							$header13 = $header13."</th></tr></thead>";
							$header13 = $header13."<tbody>"."<tr>".$tdheader;
							break;
						case "TER":
							$sTipo = "TER";
							$sPropTitle = "Pr";
							$bEnvasado = true;
							$tdheader = "";
							for($i=1;$i<7;$i++){
								$tdheader = $tdheader."<td>"."N° Serie"."</td><td>"."Capacidad"."</td>";
							}
							$header11 = "<table class='table table-bordered'><thead><tr><th colspan=12><label name='lbcantidadE' id='lbcantidadE'><pre class='lx-pre'>Enviados - Cantidad: 0</pre></label></th>";
							$header11 = $header11."</th></tr></thead>";
							$header11 = $header11."<tbody>"."<tr>".$tdheader;
							$header13 = "<table class='table table-bordered'><thead><tr><th colspan=12><label name='lbcantidadD' id='lbcantidadD'><pre class='lx-pre'>Devueltos - Cantidad: 0</pre></label></th>";
							$header13 = $header13."</th></tr></thead>";
							$header13 = $header13."<tbody>"."<tr>".$tdheader;
							break;
					}
					if($bEnvasado == true){
						switch($row['c_estado']) {
							case "E":
								$header11 = $header11."<tr><td class='text-center'>".$row['c_serie']."</td>"."<td class='text-center'>".$row['c_volumen']."</td>";
								//20-08-2022
								//$dvole = $row['c_volumen'];
								$dvole = $row['c_volumen']+0;
								$icnte++;
							break;
							case "D":
								$header13 = $header13."<tr><td class='text-center'>".$row['c_serie']."</td>"."<td class='text-center'>".$row['c_volumen']."</td>";
								$icntd++;
							break;
						}
						if($row['c_volumen'] <> 0.00){
							$icntvol++;
						}
					}
				}else{
					if($bEnvasado == true){
						switch($row['c_estado']) {
							case "E":
								$header11 = $header11."<td class='text-center'>".$row['c_serie']."</td>"."<td class='text-center'>".$row['c_volumen']."</td>";
								//20-08-2022
								//$dvole = number_format($dvole+$row['c_volumen'],2);
								$dvole = $dvole+$row['c_volumen'];
								$icnte++;
							break;
							case "D":
								$header13 = $header13."<td class='text-center'>".$row['c_serie']."</td>"."<td class='text-center'>".$row['c_volumen']."</td>";
								$icntd++;
							break;
						}
						if($row['c_volumen'] <> 0.00){
							$icntvol++;
						}
					}
				}
				if($bEnvasado == true){
					if($icnte%6 == 0){
						$header11 = $header11."</tr><tr>";
					}
					if($icntd%6 == 0){
						$header13 = $header13."</tr><tr>";
					}
					$icnt++;
				}
			}
		
		if($bEnvasado == true){
			if($icnte < 25){
				for($j = 1 ;$j < 25-$icnte ;$j++){
					$header11 = $header11."<td></td><td></td>";
					if(($j+$icnte)%6 == 0){
						$header11 = $header11."</tr><tr>";
					}
				}
			}
			$header11 = $header11."</tr></tbody></table>";
			
			if($icntd < 25){
				for($j = 1 ;$j < 25-$icntd ;$j++){
					$header13 = $header13."<td></td><td></td>";
					if(($j+$icntd)%6 == 0){
						$header13 = $header13."</tr><tr>";
					}
				}
			}
			$header13 = $header13."</tr></tbody></table>";
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
		
		$header20 = "col-md-2";	//Div Fecha
		$header21 = "col-md-4";	//Div Cliente
		$header22 = "col-md-1";	//Div Tipo Envase
		$header23 = "col-md-1";	//Div Propiedad
		$header24 = "col-md-11";//Div Detalle

		
		$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3, "header4" => $header4, "header5" => $header5, "header6" => $header6, "header7" => $header7, "header8" => $header8, "header9" => $header9, "header10" => $header10, "header11" => $header11, "header12" => $header12, "header13" => $header13, "header14" => $header14, "header15" => $header15, "header16" => $header16, "header17" => $header17, "header20" => $header20, "header21" => $header21, "header22" => $header22, "header23" => $header23, "header24" => $header24);
		echo json_encode($return_arr);
		}
	}
}
?>

