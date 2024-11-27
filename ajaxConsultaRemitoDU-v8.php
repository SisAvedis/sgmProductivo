<?php

include ("database_e.php");
//include ("database_e3.php");
require_once 'include/validacion.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
$tipoOpcion = isset($_POST['tipoOpcion']) ? $_POST['tipoOpcion'] : false;; //Operador ternario -> if línea
$tipoProducto = isset($_POST['tipoProducto']) ? $_POST['tipoProducto'] : false;; //Operador ternario -> if línea
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
		$res = $DB->prRemitoDetallev5($nremito);
		$row_cnt = mysqli_num_rows($res);
		if($row_cnt > 0){
			while($row = mysqli_fetch_array($res)){
				$fecha = $row['c_fecha'];
				$fecha = date_format(date_create($fecha),"d-m-Y");
				$id_xl = $row['c_id_xl'];
				$clie = $row['c_cliente'];
				$prod = $row['c_cod_producto'];
				$tipo = $row['c_tipo'];
				if($tipo == 'CIL' || $tipo == 'TER'){
					$env = $row['c_CE'];
					$dev = $row['c_CD'];
				}else{
					$tipof = $row['c_tipo_fake'];
					$env = $row['c_CZ'];
				}
			}
			if($tipo == 'CIL' || $tipo == 'TER'){
				$header1 = "Atención. El remito número ".$nremito." ya fue ingresado";
				$header2 = "Fecha: ".$fecha." | Cliente: (".$id_xl.") ".$clie." | Producto: ".$prod." | Tipo: ".$tipo." | Env: ".$env." | Dev: ".$dev;
			}else{
				$header1 = "Atención. El remito número ".$nremito." ya fue ingresado";
				$header2 = "Fecha: ".$fecha." | Cliente: (".$id_xl.") ".$clie." | Producto: ".$prod." | Tipo: ".$tipof." | Volumen: ".$env;
			}
			
			
			$header7 = "col-md-8";	//Etiqueta Atención
			$header8 = "";	//Etiqueta Listo (Oculta)
			$header20 = true;
			
			
			$return_arr[] = array("header1" => $header1, "header2" => $header2, "header7" => $header7, "header8" => $header8, "header20" => $header20);
				echo json_encode($return_arr);	
			
			}else{
				$header1 = "Tipo de Producto";
				$header2 = "Seleccione tipo de producto";
				$header3 = "<label><pre class='lx-pre' id='lblEnvasado'>Envasado <input type='radio' class='oTP' name='tipoProducto' value='LG' required /></pre></label><label><pre class='lx-pre' id='lblGranel'>Granel  <input type='radio' class='oTP' name='tipoProducto' value='GR' required  /></pre></label>";
				$header4 = "Producto";
				$header5 = "Seleccione producto";
				//Todos los productos
				$tLP = 0;
				$DB1= new Database();
				$res1 = $DB1->prProductov1($tipoProducto,$tLP);
				$iRowC = 1;
				//$mov_arr[0] = "<label><pre class='lx-pre'>Producto</pre></label>"."</br>"."<label><pre class='lx-pre'><select name='producto' id='producto' class='form-control input-sm'>"."<option value='0'>Producto</option>";
				$mov_arr[0] = "<label><pre class='lx-pre'><select name='producto' id='producto' class='form-control input-sm'>"."<option value='0'>Producto</option>";
				while($row = mysqli_fetch_array($res1)){
					if ($iRowC == 0){ 
						$mov_arr[$iRowC] = "<option value='".$row['id']."|".$row['nombre']."' selected>".$row['nombre']."</option>";
						$iRowC++;
					}else{
						$mov_arr[$iRowC] = "<option value='".$row['id']."|".$row['nombre']."'>".$row['nombre']."</option>";
						$iRowC++;
					}
				}
				$header6 = '';
				foreach($mov_arr as $sel){
					$header6 = $header6.$sel;
				}
				$header6 = $header6."</select></pre></label>";
				
				
				
				
				
				
				
				
				$header7 = "Listo";
				$header8 = "Si/No";
				$header9 = "No";
				$header10 = "col-md-3";	//Tipo de Producto (Etiquetas + Botones Opción)
				$header11 = "col-md-3";	//Producto (Etiqueta + Combo)
				$header12 = "col-md-1";	//Etiqueta Listo (Si/No)
				
				$header20 = false;
			
				$return_arr[] = array("header1" => $header1, "header2" => $header2, "header3" => $header3, "header4" => $header4, "header5" => $header5, "header6" => $header6, "header7" => $header7, "header8" => $header8, "header9" => $header9, "header10" => $header10, "header11" => $header11, "header12" => $header12, "header20" => $header20);
					echo json_encode($return_arr);
			}	
		}else{
			$header1 = "Atención. El dato ingresado no es válido";
			$header2 = "Remito N° ".$nremito;
			$header20 = false;
			$return_arr[] = array("header1" => $header1, "header2" => $header2, "header20" => $header20);
			echo json_encode($return_arr);
			}
	}
?>
