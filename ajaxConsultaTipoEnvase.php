<?php

include ("database_e.php");
require_once 'include/validacion.php';
$sTipo = isset($_POST['sTipo']) ? $_POST['sTipo'] : false;; //Operador ternario -> if línea

//echo "<pre>";
//echo $sSerie."</br>".$sProp."</br>".$sTipo."</br>"."</br>"."</br>";
//echo "</pre>";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($sTipo){
		$DB0= new Database();
			$res = $DB0->getCap($sTipo);
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
			$header7 = '';
			foreach($selectCap_arr as $sel){
				$header7 = $header7.$sel;
			}
			
			$header7 = $header7."</select><input type='checkbox' name='all' value='Todos' class='allCheck' required />Todos</pre></label>";
			
			$return_arr[] = array("header7" => $header7);
			echo json_encode($return_arr);
			
		}
	}
?>
