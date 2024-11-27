<?php

include ("database_e.php");
require_once 'include/validacion.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
$abmOpcion = isset($_POST['abmOpcion']) ? $_POST['abmOpcion'] : false;; //Operador ternario -> if línea
$return_arr = array();
$select_arr = array(0);
//echo "<pre>";
//echo $abmOpcion."</br>".$nremito;
//echo "</pre>";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($nremito && $abmOpcion) {
		$DB= new Database();
		$nremito = $DB->sanitize($_POST['nremito']);
		//$abmOpcion = $_POST['abmOpcion'];
		$res = $DB->consultaRemitoXLSArray($nremito);
		$row_cnt = mysqli_num_rows($res);
		if($row_cnt > 0){
			while($row = mysqli_fetch_array($res)){

				$cliente = $row['nombre'];
				//$fecha = $row['fecha'];
				$fecha = date_format(date_create($row['fecha']),"d-m-Y");
				$label1 = "<label><pre class='lx-pre'>Fecha</pre></label>"."</br>"."<label><pre class='lx2-pre'>".$fecha."</pre></label>";
				$label2 = "<label><pre class='lx-pre'>Cliente</pre></label>"."</br>"."<label><pre class='lx2-pre'>".$cliente."</pre></label>";
				$return_arr[] = array("fecha" => $label1, "nombre" => $label2);
			} 
			echo json_encode($return_arr);

		}else{
			if($abmOpcion == "A"){ 
				
				$label1 = "<label><pre class='lx-pre'>Fecha</pre></label>"."</br>"."<input type='text' name='fecha' id='datepicker' class='form-control input-sm' maxlength='10' autocomplete='off' required/>";
				
				$DB0= new Database();
				$idCL = 'XLS';
				$res = $DB0->clientesTodos($idCL);
				$iRow = 1;
				$clienteid_xls = array(0,0);
				$lblNuevo = "";
				$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
				
				if ($clienteOption){
					$clienteid_xls = explode("|",$_POST['cliente']);
					$idcliente_xls = $clienteid_xls[2];
				}else{
					$idcliente_xls = 1;
				}
							
				$select_arr[0] = "<label><pre class='lx-pre'>Cliente</pre></label>"."</br>"."<label><pre class='lx-pre'><select name='cliente' id='cliente' class='form-control input-sm' required>"."<option value='0'>Clientes</option>";
					
					while ($row=mysqli_fetch_object($res)){ 
						if ($iRow == $idcliente_xls){ 
							$select_arr[$iRow] = "<option value='".$row->id_xl."|".$row->nombre."|".$iRow."' selected>".$row->id_xl." - ".$row->nombre."</option>";
							$iRow++;
						}else{
							$select_arr[$iRow] = "<option value='".$row->id_xl."|".$row->nombre."|".$iRow."'>".$row->id_xl." - ".$row->nombre."</option>";
							$iRow++;
						}
					}					
						$label22 = "</select></pre></label>";	
						
						$label21 = '';
						foreach($select_arr as $sel){
							$label21 = $label21.$sel;
						}
								
				$return_arr[] = array("fecha" => $label1, "nombre" => $label21);
				echo json_encode($return_arr);
			
			}else{
				$cliente = 'No encontrado';
				$fecha = 'No encontrado';
				$label1 = "<label><pre class='lx-pre'>Fecha</pre></label>"."</br>"."<label><pre class='lx2-pre'>".$fecha."</pre></label>";
				$label2 = "<label><pre class='lx-pre'>Cliente</pre></label>"."</br>"."<label><pre class='lx2-pre'>".$cliente."</pre></label>";
				$return_arr[] = array("fecha" => $label1, "nombre" => $label2);
				echo json_encode($return_arr);
			} 
			
				
			}
			
	
	} 
}

?>
