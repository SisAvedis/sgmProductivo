<?php

include ("database_e.php");
//include ("database_e3.php");
require_once 'include/validacion.php';
$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : false;; //Operador ternario -> if línea
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
$nserie = isset($_POST['nserie']) ? $_POST['nserie'] : false;; //Operador ternario -> if línea
$id_xl = isset($_POST['id_xl']) ? $_POST['id_xl'] : false;; //Operador ternario -> if línea
$prop = isset($_POST['prop']) ? $_POST['prop'] : false;; //Operador ternario -> if línea
$tenv = isset($_POST['tenv']) ? $_POST['tenv'] : false;; //Operador ternario -> if línea
$qr = isset($_POST['qr']) ? $_POST['qr'] : false;; //Operador ternario -> if línea
$return_arr = array();
$selectCap_arr = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($fecha && $nserie && $nremito){
		$DB= new Database();
		$nremito = $DB->sanitize($_POST['nremito']);
		$nserie = $DB->sanitize($_POST['nserie']);
		//$abmOpcion = $_POST['abmOpcion'];
		$res = $DB->prABMv2($fecha,$nremito,$nserie,$id_xl,$prop,$tenv,$qr);
		$row_cnt = mysqli_num_rows($res);
		if($row_cnt > 0){
			while($row = mysqli_fetch_array($res)){
				$var1 = $row['c_mov'];
				$var2 = $row['c_env'];
				$var3 = $row['c_cap'];
				$var4 = $row['c_estado'];
				$prod = $row['c_id_producto'];
			} 
		}
	}else{
		$var1 = "";
		$var2 = "";
		$var3 = "";
		$var4 = "";
	}
	
	if($tenv){
		$DB0= new Database();
			$res = $DB0->getCapProd($prod,$tenv);
			$iRowC = 1;
			$selectCap_arr[0] = "<label><pre class='lx-pre'>Capacidad</pre></label>"."</br>"."<label><pre class='lx-pre'><select name='capacidad' id='capacidad' class='form-control input-sm'>"."<option value='0'>Capacidad</option>";
			
			while ($row=mysqli_fetch_object($res)){
				if ($iRowC == 0){
					$selectCap_arr[$iRowC] = "<option value='".$row->capacidad."|".$iRowC."' selected>".$row->capacidad."</option>";
					$iRowC++;
				}else{
					$selectCap_arr[$iRowC] = "<option value='".$row->capacidad."|".$iRowC."'>".$row->capacidad."</option>";
					$iRowC++;
				}			
			}
			$var5 = '';
			foreach($selectCap_arr as $sel){
				$var5 = $var5.$sel;
			}
			$var5 = $var5."</select></pre></label>";
		}else{
			$var5 = "";
		}
		
			
		
	$return_arr[] = array("var1" => $var1, "var2" => $var2, "var3" => $var3, "var4" => $var4, "var5" => $var5);
			echo json_encode($return_arr);
}

?>