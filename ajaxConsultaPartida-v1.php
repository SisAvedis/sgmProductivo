<?php

include ("database_e.php");
require_once 'include/validacion.php';
$nradioval = isset($_POST['nradioval']) ? $_POST['nradioval'] : false;; //Operador ternario -> if línea

$return_arr = array();
$select_arr = array(0);
$cap_arr = array(0);
$cant_arr = array(0);
$t_arr = array(
							array(0),
			);
$it = 0;
$spacesCount = 4;
$spaces = '';
for($z = 0 ; $z < $spacesCount; $z++){
	$spaces = $spaces.'&nbsp';
}

//$bremito = validaRemito($nremito);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$DB= new Database();
	$res = $DB->prConsultaPCTv1($nradioval);
	$row_cnt = mysqli_num_rows($res);
	if($row_cnt > 0){
		while($row = mysqli_fetch_array($res)){
			$t_arr[$it][0] = $row['remito'];
			$t_arr[$it][1] = $row['partida'];
			$t_arr[$it][2] = $row['certificado'];
			$t_arr[$it][3] = $row['tdestino'];
			$it++;
		}
		// LG -> Líquido - Gaseoso || GR -> Granel
		//Acá comienza tabla Enviados
		
		$header1 = "<table class='table table-bordered'><thead><tr><th class='text-center'><label name='lbcantidadE' id='lbcantidadE'><pre class='lx-pre'>Registros: ".$row_cnt."</pre></label></th>";
		$header1 = $header1."<th class='text-center' colspan=2><label><pre class='lx-pre'>Listo: </pre></label>".$spaces."<label id='pStatus'><pre class='lx-pre' id='pText'>No</pre></label></th>";
		
		$DB1= new Database();
		$res1 = $DB1->getTanque();
		$iRowC = 1;
		$cap_arr[0] = "<th><pre class='lx-pre'><select name='tanque' id='tanque' class='form-control input-sm'>"."<option value='0'>Movil</option>";
		
		while($row = mysqli_fetch_array($res1)){
			if ($iRowC == 0){ 
				$cap_arr[$iRowC] = "<option value='".$row['id']."' selected>".$row['nombre']."</option>";
				$iRowC++;
			}else{
				$cap_arr[$iRowC] = "<option value='".$row['id']."'>".$row['nombre']."</option>";
				$iRowC++;
			}
		}
		
		foreach($cap_arr as $sel){
			$header1 = $header1.$sel;
		}
		
		$header1 = $header1."</select></pre></th></tr>";
		$header1 = $header1."<tr>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Remito</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Partida</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Certificado</pre></label></th>";
		$header1 = $header1."<th class='text-center'><label><pre class='lx-pre'>Tanque Destino</pre></label></th>";
		$header1 = $header1."</tr></thead>";
		
		
		$header1 = $header1."<tbody>";
		for($tre=0;$tre<$row_cnt;$tre++){
			$header1 = $header1."<tr>";
			if($tre<10){
				$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='REM0".strval($tre)."' class='form-control input-sm' id='REM0".strval($tre)."' maxlength=5  autocomplete='off' value=".$t_arr[$tre][0]." disabled/></pre><input type='hidden' value=".$t_arr[$tre][0]." name='REH0".strval($tre)."' id='REH0".strval($tre)."'/></td>";
				if($t_arr[$tre][1] !== "N/D"){
					$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='PAR0".strval($tre)."' class='form-control input-sm' id='PAR0".strval($tre)."' maxlength=12  autocomplete='off' value=".$t_arr[$tre][1]." disabled/></pre></td>";
				}else{
					$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='PAR0".strval($tre)."' class='form-control input-sm' id='PAR0".strval($tre)."' maxlength=12  autocomplete='off' /></pre></td>";
				}
				if($t_arr[$tre][2] !== "N/D"){
					$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='CER0".strval($tre)."' class='form-control input-sm' id='CER0".strval($tre)."' maxlength=5  autocomplete='off' value=".$t_arr[$tre][2]." disabled/></pre></td>";
				}else{
					$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='CER0".strval($tre)."' class='form-control input-sm' id='CER0".strval($tre)."' maxlength=5  autocomplete='off' /></pre></td>";
				}
				if($t_arr[$tre][3] !== "N/D"){
					$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='MOV0".strval($tre)."' class='form-control input-sm' id='MOV0".strval($tre)."' maxlength=5  autocomplete='off' value=".$t_arr[$tre][3]." disabled/></pre></td>";
				}else{
					$header1 = $header1."<td><pre class='lx2-pre'><input type='checkbox' name='CHK0".strval($tre)."' class='chkBox' id='CHK0".strval($tre)."' tabindex='-1' /><label name='MOV0".strval($tre)."' id='MOV0".strval($tre)."'>"."</label><input type='hidden' name='MOH0".strval($tre)."' id='MOH0".strval($tre)."'/></td>";
				}
			}else{
				$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='REM".strval($tre)."' class='form-control input-sm' id='REM".strval($tre)."' maxlength=5  autocomplete='off' value=".$t_arr[$tre][0]." disabled/></pre><input type='hidden' value=".$t_arr[$tre][0]." name='REH".strval($tre)."' id='REH".strval($tre)."'/></td>";
				if($t_arr[$tre][1] !== "N/D"){
					$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='PAR".strval($tre)."' class='form-control input-sm' id='PAR".strval($tre)."' maxlength=12  autocomplete='off' value=".$t_arr[$tre][1]." disabled/></pre></td>";
				}else{
					$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='PAR".strval($tre)."' class='form-control input-sm' id='PAR".strval($tre)."' maxlength=12  autocomplete='off' /></pre></td>";
				}
				if($t_arr[$tre][2] !== "N/D"){
					$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='CER".strval($tre)."' class='form-control input-sm' id='CER".strval($tre)."' maxlength=5  autocomplete='off' value=".$t_arr[$tre][2]." disabled/></pre></td>";
				}else{
					$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='CER".strval($tre)."' class='form-control input-sm' id='CER".strval($tre)."' maxlength=5  autocomplete='off' /></pre></td>";
				}
				if($t_arr[$tre][3] !== "N/D"){
					$header1 = $header1."<td><pre class='lx-pre'><input type='text' name='MOV".strval($tre)."' class='form-control input-sm' id='MOV".strval($tre)."' maxlength=5  autocomplete='off' value=".$t_arr[$tre][3]." disabled/></pre></td>";
				}else{
					$header1 = $header1."<td><pre class='lx2-pre'><input type='checkbox' name='CHK".strval($tre)."' class='chkBox' id='CHK".strval($tre)."' tabindex='-1' /><label name='MOV".strval($tre)."' id='MOV".strval($tre)."'>"."</label><input type='hidden' name='MOH".strval($tre)."' id='MOH".strval($tre)."'/></td>";
				}
			}
			$header1 = $header1."</tr>";
		}
		$header1 = $header1."</tbody>";
		$header1 = $header1."<input type='hidden' name='iregistro' id='iregistro' />";
		$header2 = $row_cnt;
			
			$return_arr[] = array("header1" => $header1,"header2" => $header2);		
			
			echo json_encode($return_arr);
		}

}else{
	$header1 = "";
	$header2 = "";
	
	$return_arr[] = array("header1" => $header1,"header2" => $header2);
	echo json_encode($return_arr);
}
		
?>
