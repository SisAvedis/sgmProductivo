<?php
//include ("database_e.php");
include ("database_e4.php");
//require_once 'include/validacion.php';
require_once 'include/validacion4.php';
$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;; //Operador ternario -> if línea
//$abmOpcion = isset($_POST['abmOpcion']) ? $_POST['abmOpcion'] : false;; //Operador ternario -> if línea
$bremito = validaRemito($nremito);


$return_arr = array();
$select_arr = array(0);
$var1 = 0;
$var2 = 0;
$var3 = 0;
$var4 = 0;
$var5 = "";
$var7 = "";
$var8 = "";
$var9 = "";
$var10 = "";
$var11 = "";
$var6 = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	//if($nremito && $abmOpcion) {
	if($nremito && $bremito) {
		$DB= new Database();
		$nremito = $DB->sanitize($_POST['nremito']);
		//$abmOpcion = $_POST['abmOpcion'];
		$res = $DB->prRemitoSeriev2($nremito);
		$row_cnt = mysqli_num_rows($res);
		if($row_cnt > 0){
			while($row = mysqli_fetch_array($res)){
				$cantFecha = $row['cantFecha'];
				$cantId_xl = $row['cantId_xl'];
				$codigo = $row['codigo'];
				$cantPropiedad = $row['cantPropiedad'];
				$cantTipoenvase = $row['cantTipoenvase'];
				if(!is_null($row['fecha']) && !is_null($row['id_xl']) && !is_null($row['nombre'])){
					$var8 = $row['tipoenvase'];
					$var21 = "<label><pre class='lx-pre' id='lblproducto'>".$codigo."</pre></label>";
					$var22 = $codigo;
					if($var8 <> "ZZZ"){
						$var7 = $row['propiedad'];
						$var9 = $row['fecha'];
						$var91 = date_format(date_create($row['fecha']),"d-m-Y");
						$var10 = $row['id_xl'];
						$var11 = $row['nombre'];
						$var1 = $cantFecha;
						$var2 = $cantId_xl;
						//$var21 = "<label><pre class='lx-pre' id='lblproducto'>".$codigo."</pre></label>";
						//$var22 = $codigo;
						$var23 = "<label><pre class='lx-pre' id='preimagen'>"."<img id='imagenP' src = 'data:image/png;base64,".base64_encode($row['imagen'])."' width = '72px' height = '347px'/>"."</pre></label>";
						$var3 = $cantPropiedad;
						$var4 = $cantTipoenvase;
						$var5 = "<label><pre class='lx-pre' id='lbldivRemito'>Fecha: ".$var91."</br>"."Cliente: (".$var10.") ".$var11."</pre></label>";
						$var6 = true;
					}else{
						$var1 = 0;
						$var2 = 0;
						$var3 = 0;
						$var4 = 0;
						$var5 = "<label><pre class='lx-pre' id='lbldivRemito'>Remito"."</br>"."Producto Granel</pre></label>";
						$var7 = "";
						//$var8 = "";
						$var9 = "";
						$var10 = "";
						$var11 = "";
						//$var21 = "";
						//$var22 = "";
						$var23 = "<label><pre class='lx-pre' id='preimagen'>"."<img id='imagenP' src = 'data:image/png;base64,".base64_encode($row['imagen'])."' width = '400px' height = '200px'/>"."</pre></label>";
						//$var23 = "";
						$var6 = true;
					}
				}elseif(is_null($row['fecha']) || is_null($row['id_xl']) || is_null($row['nombre'])){
					$var1 = 0;
					$var2 = 0;
					$var3 = 0;
					$var4 = 0;
					$var5 = "<label><pre class='lx-pre' id='lbldivRemito'>Remito"."</br>"."No encontrado</pre></label>";
					$var7 = "";
					$var8 = "";
					$var9 = "";
					$var10 = "";
					$var11 = "";
					$var21 = "";
					$var22 = "";
					$var23 = "";
					$var6 = true;
				}
			} 
		}
	//}
	$return_arr[] = array("var1" => $var1, "var2" => $var2, "var21" => $var21, "var22" => $var22, "var23" => $var23, "var3" => $var3, "var4" => $var4, "var5" => $var5, "var7" => $var7, "var8" => $var8, "var9" => $var9, "var10" => $var10, "var11" => $var11, "var6" => $var6);
					echo json_encode($return_arr);

	}else{
		$var1 = 0;
		$var2 = 0;
		$var3 = 0;
		$var4 = 0;
		$var6 = false;
		$return_arr[] = array("var1" => $var1, "var2" => $var2, "var3" => $var3, "var4" => $var4,"var6" => $var6);
		echo json_encode($return_arr);
		}				
					
					
}	
?>
