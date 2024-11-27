
<?php include ("inicio.php"); ?>			

<body>
	<form method="post" action="serieLoteABM-v1.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>ABM Serie</h4></div>
                </div>
            </div>
			
			<?php
			
			$message = "";
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
			
			$nradio = isset($_POST['abmOpcion']) ? $_POST['abmOpcion'] : false;;
			
			if ($nradio){
				$nradio = $_POST['abmOpcion'];
			}else{
				$nradio = "A";
			}
			

			switch ($nradio) {
				case "A":
					$scolmod = "col-md-4";
					break;
				default:
					$scolmod = "col-md-2";
			}
			//echo "<pre>";
			//echo $scolmod."</br>".$nradio."</br>";
			//echo "</pre>";
					
			?>
			
			<div class="row">
				<div class="col-md-1">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th>Insertar</th>
							<th>Modificar</th>
							<th>Eliminar</th>
						</tr>
						<tr>
							<td class="text-center"><input type="radio" class="abmOpcion" name="abmOpcion" value="A" required <?php echo ($nradio=='A')?'checked':'' ?> /></td>
							<td class="text-center"><input type="radio" class="abmOpcion" name="abmOpcion" value="M" required <?php echo ($nradio=='M')?'checked':'' ?> /></td>
							<td class="text-center"><input type="radio" class="abmOpcion" name="abmOpcion" value="B" required <?php echo ($nradio=='B')?'checked':'' ?> /></td>
						</tr>
					</thead>
				</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-2">
					<label><pre class="lx-pre">Remito</pre></label>
					<input type="text" name="nremito" id="nremito" class="form-control input-sm" maxlength="6" autocomplete="off" required value="<?php $nremito ?>" />
					<!--<hr>-->
				</div>
				
				<div class="col-md-2" id="lblRemito">
					
				</div>
				
				<div class="col-md-2" id="lblRemito2">
					
				</div>			
			</div>
			
			<div class="row">
				<div class="col-md-2">
					<label id="lblABMSerie"><pre class="lx-pre">Serie</pre></label>
					<input type="text" name="nserie" id="nserie" class="form-control input-sm" maxlength="12" autocomplete="off" required value="<?php $nserie ?>"/>
					<!--<hr>-->
				</div>
				
				<div class="col-md-2" id="lblSerie">
					
				</div>
				
				<div class="col-md-2" id="lblSerie2">
					
				</div>
				
				<div class="col-md-2" id="lblSerie3">
					
				</div>
			</div>
			
			<div class="row" id="divOptionButton">
				<div class="<?php echo $scolmod;?>" id="NNSerieR">
					<label><pre class="lx-pre">E <input type="radio" name="EnvDev" value="E" required /></pre></label><label><pre class="lx-pre">D <input type="radio" name="EnvDev" value="D" required  /></pre></label><label><pre class="lx-pre">NP <input type="radio" name="prop" value="NP" required /></pre></label><label><pre class="lx-pre"">SP <input type="radio" name="prop" value="SP" required  /></pre></label><label><pre class="lx-pre">CIL <input type="radio" name="env" value="CIL" required /></pre></label><label><pre class="lx-pre">TER <input type="radio" name="env" value="TER" required  /></pre></label>
				</div>
			
				<div class="col-md-2" id="lblSerieN">
					
				</div>
				
				<div class="col-md-2" id="lblSerieN2">
					
				</div>
				
				<div class="col-md-2" id="lblSerieN3">
					
				</div>
			</div>
			
			<div class="row">	
				<!--<div class="col-md-12 pull-right">-->
				<div class="col-md-12">
					<!--<hr>-->
					<button type="submit" class="btn btn-sm btn-danger">Actualizar</button>
					<!--<hr>-->
				</div>
			</div>
		</div>
			
			
			<?php
			$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;;
			$nserie = isset($_POST['nserie']) ? $_POST['nserie'] : false;;
			$nserieN = isset($_POST['nserieN']) ? $_POST['nserieN'] : false;;
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				if ($nradio == "A"){
					if(validaSerie($nremito) && $clienteOption && $nserie){
						$DB= new Database();
						$nremito = $DB->sanitize($_POST['nremito']);
						$nserie = $DB->sanitize($_POST['nserie']);
						$clienteid_xls = explode("|",$_POST['cliente']);
						$fecha = date("Y-m-d", strtotime($_POST['fecha']));
						$envdev = isset($_POST['EnvDev']) ? $_POST['EnvDev'] : false;
						$prop = isset($_POST['prop']) ? $_POST['prop'] : false;
						$tipoenvase = isset($_POST['env']) ? $_POST['env'] : false;
						
						$res = $DB->insertaSerieRemitoConClienteXLS($nremito,$clienteid_xls[0],$fecha,$nserie,$envdev,$prop,$tipoenvase);
						$row_cnt = mysqli_num_rows($res);
						
						if($row_cnt > 0){
							while ($row=mysqli_fetch_object($res)){
								$reg_cnt = $row->b_registros_insertados;
							}
							if($reg_cnt > 0){
								$lblNuevo = consultaNSerieXLS($nremito,$nserie);
								$message= "El remito N° ".$nremito." ha sido ingresado"."</br>"."Cantidad de registros insertados: ".$reg_cnt."</br>".$lblNuevo;
								$class="alert alert-success";
							}else{
								$message= "El remito N° ".$nremito." no ha sido ingresado"."</br>"."Cantidad de registros afectados: ".$reg_cnt;
								$class="alert alert-success";
							}
						}else{
						$message= "Error al intentar actualizar el remito ".$nremito;
						$class="alert alert-danger";
						}
						
				?>
			
			<div class="<?php //echo $class;?>" id="rows">
				  <?php //echo $message;?>
			</div>
			<?php
				}elseif(validaSerie($nremito) && $nserie){
						$DB= new Database();
						$nremito = $DB->sanitize($_POST['nremito']);
						$nserie = $DB->sanitize($_POST['nserie']);
						$envdev = isset($_POST['EnvDev']) ? $_POST['EnvDev'] : false;
						$prop = isset($_POST['prop']) ? $_POST['prop'] : false;
						$tipoenvase = isset($_POST['env']) ? $_POST['env'] : false;
						
						$res = $DB->insertaSerieRemitoSinClienteXLS($nremito,$nserie,$envdev,$prop,$tipoenvase);
						$row_cnt = mysqli_num_rows($res);
						
						if($row_cnt > 0){
							while ($row=mysqli_fetch_object($res)){
								$reg_cnt = $row->b_registros_insertados;
							}
							if($reg_cnt > 0){
								$lblNuevo = consultaNSerieXLS($nremito,$nserie);
								$message= "El remito N° ".$nremito." ha sido actualizado"."</br>"."Cantidad de registros afectados: ".$reg_cnt."</br>"."Valores: ".$lblNuevo;
								$class="alert alert-success";
							}else{
								$message= "El remito N° ".$nremito." no ha sido actualizado"."</br>"."Cantidad de registros afectados: ".$reg_cnt;
								$class="alert alert-success";
							}
						}else{
						$message= "Error al intentar actualizar el remito ".$nremito;
						$class="alert alert-danger";
						}
						
				?>
			
			<div class="<?php //echo $class;?>" id="rows">
				  <?php //echo $message;?>
			</div>
			<?php
				}
				}
				
				if ($nradio == "M"){
					if(validaSerie($nremito) && $nserie && $nserieN){
						$DB= new Database();
						$nremito = $DB->sanitize($_POST['nremito']);
						$nserie = $DB->sanitize($_POST['nserie']);
						$nserieN = $DB->sanitize($_POST['nserieN']);
						$res = $DB->actualizaSerieRemitoSinClienteXLS($nremito,$nserie, $nserieN);
						$row_cnt = mysqli_num_rows($res);
						
						if($row_cnt > 0){
							while ($row=mysqli_fetch_object($res)){
								$reg_cnt = $row->b_registros_modificados;
							}
							if($reg_cnt > 0){
								$lblNuevo = consultaNSerieXLS($nremito,$nserieN);
								$message= "El remito N° ".$nremito." ha sido actualizado"."</br>"."Cantidad de registros afectados: ".$reg_cnt."</br>"."Valores: ".$lblNuevo;;
								$class="alert alert-success";
							}else{
								$message= "El remito N° ".$nremito." no ha sido actualizado"."</br>"."Cantidad de registros afectados: ".$reg_cnt;
								$class="alert alert-success";
							}
						}else{
						$message= "Error al intentar actualizar el remito ".$nremito;
						$class="alert alert-danger";
						}
				?>
			
			<div class="<?php// echo $class;?>" id="rows">
				  <?php //echo $message;?>
			</div>
			<?php
				}
				}
			
			if ($nradio == "B"){
					if(validaSerie($nremito) && $nserie){
						$DB= new Database();
						$nremito = $DB->sanitize($_POST['nremito']);
						$nserie = $DB->sanitize($_POST['nserie']);
						
						$res = $DB->eliminaSerieRemitoSinClienteXLS($nremito,$nserie);
						$row_cnt = mysqli_num_rows($res);
						
						if($row_cnt > 0){
							while ($row=mysqli_fetch_object($res)){
								$reg_cnt = $row->b_registros_eliminados;
							}
							if($reg_cnt > 0){
								$lblNuevo = consultaNSerieXLS($nremito,$nserie);
								$message= "El remito N° ".$nremito." ha sido actualizado"."</br>"."Cantidad de registros afectados: ".$reg_cnt;
								$class="alert alert-success";
							}else{
								$message= "El remito N° ".$nremito." no ha sido actualizado"."</br>"."Cantidad de registros afectados: ".$reg_cnt;
								$class="alert alert-success";
							}
						}else{
						$message= "Error al intentar actualizar el remito ".$nremito;
						$class="alert alert-danger";
						}
						
						
				?>
			
			<div class="<?php //echo $class;?>" id="rows">
				  <?php //echo $message;?>
			</div>
			<?php
				}
			}
			}
			?>
			
<?php 
/*Existen dos formas de pasar parámetros: por valor o por referencia. 
En este caso se hizo por referencia, esto significa 
que las funciones no podrán alterar el código externo*/

function consultaNSerieXLS($nremito,$nserieN){
	
	$DB= new Database();
	$res = $DB->consultaSerieRemitoSinClienteXLS($nremito,$nserieN);
	$row_cnt = mysqli_num_rows($res);
		if($row_cnt > 0){
			while ($row=mysqli_fetch_object($res)){
				$cliente = $row->nombre;
				$fecha = $row->fecha;
				$remito = $row->remito;
				$estado = $row->estado;
				$propiedad = $row->propiedad;
				$tipoenvase = $row->tipoenvase;
			}
	//$fecha = date_format(date_create($row->fecha),"d-m-Y");
			
	//$resultado = $fecha." | ".$remito." | ".$estado." | ".$nserieN." | ".$propiedad." | ".$tipoenvase;
	$resultado = "Fecha: ".$fecha."</br>";
	$resultado = $resultado."Serie: ".$nserieN." (".$estado." - ".$propiedad." - ".$tipoenvase.")</br>";
	$resultado = $resultado."Cliente: ".$cliente;
	}else{
		$resultado = 'No encontrado';
	}
	return($resultado);
	}
?>

			

<script type="text/javascript">
	$(document).ready(function(){
		
		var smessage = '<?php echo $message; ?>';
		
		if (smessage !== ''){
			bootbox.alert({
				message: smessage,
				size: 'small'
			});
		}
		
		var nradioVal = '<?php echo $nradio; ?>';
		
		var scolmod = '<?php echo $scolmod; ?>';
		
		var preI = '<pre class="lx-pre">';
		var preF = '</pre>';
		
		$.fn.inputradio = function(nradioVal){ 
			//var preI = '<pre class="lx-pre">';
			//var preIAdd = '<pre style ="background-color:#f5f5f5;">';
			//var preF = '</pre>';
			
			$('#lblRemito').children().each(function (index) {
						$(this).remove();
					});
			$('#lblRemito2').children().each(function (index) {
						$(this).remove();
					});
			
			$('#lblSerie').children().each(function (index) {
						$(this).remove();
					});
			$('#lblSerie2').children().each(function (index) {
						$(this).remove();
					});
			$('#lblSerie3').children().each(function (index) {
						$(this).remove();
					});
			
			$('#lblSerieN').children().each(function (index) {
						$(this).remove();
					});
			$('#lblSerieN2').children().each(function (index) {
						$(this).remove();
					});
			$('#lblSerieN3').children().each(function (index) {
						$(this).remove();
					});
			
			
			if (nradioVal == 'A') {
					
					scolmod = 'col-md-4';
					$('#lblABMSerie').html(preI+"Serie"+preF);
					
					$('#NNSerieR').removeClass();
					$('#NNSerieR').addClass(scolmod);
					$('#NNSerieR').children().each(function (index) {
						$(this).remove();
					});
					
					var lblrad = '<label><pre class="lx-pre">E <input type="radio" name="EnvDev" value="E" required  /></pre></label><label><pre class="lx-pre">D <input type="radio" name="EnvDev" value="D" required  /></pre></label><label><pre class="lx-pre">NP <input type="radio" name="prop" value="NP" required /></pre></label><label><pre class="lx-pre">SP <input type="radio" name="prop" value="SP" required  /></pre></label><label><pre class="lx-pre">CIL <input type="radio" name="env" value="CIL" required /></pre></label><label><pre class="lx-pre">TER <input type="radio" name="env" value="TER" required  /></pre></label>';
					
					$('#NNSerieR').append(lblrad);
					$("#nremito").val('');
					$("#nserie").val('');
					$("#NNSerieR").val('');
										
			}
			else if (nradioVal == 'B') {
					$('#lblABMSerie').html(preI+"Serie"+preF);
					
					$('#lblRemito').children().each(function (index) {
						$(this).remove();
					});
					$('#lblRemito2').children().each(function (index) {
						$(this).remove();
					});
					
					$('#NNSerieR').children().each(function (index) {
						$(this).remove();
					});
					$("#nremito").val('');
					$("#nserie").val('');
					$("#NNSerieR").val('');
					//$("#rows").remove();
					
			}
			else if (nradioVal == 'M') {
					
					scolmod = 'col-md-2';
					
					$('#lblABMSerie').html(preI+"Serie (Actual)"+preF);
					
					$('#lblRemito').children().each(function (index) {
						$(this).remove();
					});
					$('#lblRemito2').children().each(function (index) {
						$(this).remove();
					});
					
					$('#divOptionButton').children().each(function (index) {
						//$(this).remove();
					});
					
					$('#NNSerieR').removeClass();
					$('#NNSerieR').addClass(scolmod);
					
					$('#NNSerieR').children().each(function (index) {
						$(this).remove();
					});
					
					var divHTML = "<div class='row' id='divOptionButton'>";
					var lblHTML = preI+"Serie (Nuevo)"+preF;
					//var lblHTML = divHTML+preI+"Serie (Nuevo)"+preF;
					var lblHeader = "<label>"+lblHTML+"</label>";
					var inpHeader =	"<input type='text' name='nserieN' id='nserieN' class='form-control input-sm' maxlength='12' autocomplete='off' required />";
					var divHTMLF = "</div>";
					
					$('#NNSerieR').append(lblHeader);
					$('#NNSerieR').append(inpHeader);
					//$('#divOptionButton').append(divHTMLF);
					
					$("#nremito").val('');
					$("#nserie").val('');
					$("#NNSerieR").val('');
					//$("#rows").remove();
			}
		}
		
		$.fn.inputradio(nradioVal);
		
		
		$("#nremito").focusout('input', function(){
			
			$('#lblRemito').children().each(function (index) {
						$(this).remove();
					});
			$('#lblRemito2').children().each(function (index) {
						$(this).remove();
					});
			
			$("#rows").remove();
			
			var sRemito = $(this).val();
			var abmOpcion = $(".abmOpcion:checked").val();
			
			$.ajax({
				url:"./ajax4full.php",
				dataType: "json",
				data: {"nremito": sRemito, "abmOpcion":abmOpcion},
				//data: {"nremito": sRemito},
				type:"POST",
				success:function(response){
					var len = response.length;
					for(var i=0; i<len; i++){
						var fecha = response[i].fecha;
						var nombre = response[i].nombre;
						$("#lblRemito").html(fecha);	
						$("#lblRemito2").html(nombre);	
						$("#datepicker").datepicker({dateFormat:'dd-mm-yy'});
					}
				}
			});
		});
		
		$("#datepicker").datepicker({
				dateFormat: "dd-mm-yy"
				//dateFormat: "yy-mm-dd"
		});
		
		
		$("#nserie").focusout('input', function(){
			
			$('#lblSerie').children().each(function (index) {
						$(this).remove();
					});
			$('#lblSerie2').children().each(function (index) {
						$(this).remove();
					});
			$('#lblSerie3').children().each(function (index) {
						$(this).remove();
					});
			
			var sSerie = $(this).val();
			var sRemito = $("#nremito").val();
			
			$.ajax({
				url:"./ajax1full.php",
				dataType: "json",
				data: {"nremito": sRemito, "nserie": sSerie},
				type:"POST",
				success:function(response){
					var len = response.length;
					for(var i=0; i<len; i++){
						var estado = response[i].estado;
						var propiedad = response[i].propiedad;
						var tipoenvase = response[i].tipoenvase;
						$("#lblSerie").html(estado);
						$("#lblSerie2").html(propiedad);
						$("#lblSerie3").html(tipoenvase);
					}
				//alert(preI+"Serie - "+estado+" - "+preF);
				//$('#lblABMSerie').html(preI+"Serie - "+estado+" - "+preF);
				}
			})
		});
		
		$('#NNSerieR').on('focusout', '#nserieN', function(){
			
			$('#lblSerieN').children().each(function (index) {
						//$(this).remove();
					});
			$('#lblSerieN2').children().each(function (index) {
						//$(this).remove();
					});
			$('#lblSerieN3').children().each(function (index) {
						//$(this).remove();
					});
			
			var sSerie = $(this).val();
			var sRemito = $("#nremito").val();
			
			$.ajax({
				url:"./ajax1full.php",
				dataType: "json",
				data: {"nremito": sRemito, "nserie": sSerie},
				type:"POST",
				success:function(response){
					var len = response.length;
					for(var i=0; i<len; i++){
						var estado = response[i].estado;
						var propiedad = response[i].propiedad;
						var tipoenvase = response[i].tipoenvase;
						$("#lblSerieN").html(estado);
						$("#lblSerieN2").html(propiedad);
						$("#lblSerieN3").html(tipoenvase);
					}
				}
			})
			
		
		});
		
		$("input[name=abmOpcion]").click(function () {
			
			var nradioVal = $(this).val();
			$.fn.inputradio(nradioVal);
			$("#rows").remove();
			
		});
		
	});
	
</script>
	</form>
	
	</body>
</html>


