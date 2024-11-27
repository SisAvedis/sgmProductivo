<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="remitoBM-v1.3.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-4"><h4>BM Remito</h4></div>
                </div>
            </div>
			
			<?php
			
			$message = "";
			$bmOpcion = isset($_POST['bmOpcion']) ? $_POST['bmOpcion'] : false;;
			
			if ($bmOpcion){
				$bmOpcion = $_POST['bmOpcion'];
			}else{
				$bmOpcion = "M";
			}
			
			$class = "";
			$scolmod = "col-md-4";
			
			//echo "<pre>";
			//echo var_dump($_POST);
			//echo "</pre>";
					
			?>
			
			<div class="row">
				<div class="col-md-1">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center" colspan=3>Remito</th>
						</tr>
						<tr>
							<th>Modificar</th>
							<th>Eliminar</th>
						</tr>
						<tr>
							<td class="text-center"><input type="radio" class="bmOpcion" name="bmOpcion" value="M" required <?php echo ($bmOpcion=='M')?'checked':'' ?>/></td>
							<td class="text-center"><input type="radio" class="bmOpcion" name="bmOpcion" value="B" required <?php echo ($bmOpcion=='B')?'checked':'' ?>/></td>
						</tr>
					</thead>
				</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-4">
					<label><pre class="lx-pre" id="lblMsgInformacion"></pre></label></br>
				</div>
				<div class="col-md-2" id="lblExisteListo">
					<!--<label><pre class="lx-pre" id="lblListo">Listo</pre></label></br>-->
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-md-2">
					<label><pre class="lx-pre" id="lblRemito"></pre></label></br>
					<label><pre class="lx-pre"><input type="text" name="nremito" id="nremito" class="form-control input-sm" maxlength="6" autocomplete="on" required value="<?php $nremito; ?>" /></pre></label>
					
					<!--<hr>-->
				</div>
				<div class="col-md-2" id="lblExisteRemito">
				</div>	
				<div class="col-md-1" id="lblExisteRemito2">
				</div>
				<div class="col-md-1" id="lblExisteRemito3">
				</div>
				<div class="col-md-1" id="lblExisteRemito4">
				</div>
				<div>
					<input type="hidden" name="fechaH" id="fechaH" />
					<input type="hidden" name="id_xlH" id="id_xlH" />
					<input type="hidden" name="prH" id="prH" />
					<input type="hidden" name="tipoH" id="tipoH" />
					<input type="hidden" name="volH" id="volH" />
					<input type="hidden" name="partH" id="partH" />
					<input type="hidden" name="certH" id="certH" />
					<input type="hidden" name="idtanqueH" id="idtanqueH" />	
				</div>
			</div>	
				
			<div class="row">	
				<div class="col-md-1" id="lblExisteRemito5">
				</div>
				<div class="col-md-1" id="lblExisteRemito6">
				</div>
				<div class="col-md-1" id="lblExisteRemito7">
				</div>
				<div class="col-md-1" id="lblExisteRemito8">
				</div>
				<div class="col-md-1" id="lblExisteRemito9">
				</div>
				<div class="col-md-1" id="lblExisteRemito10">
				</div>
				<div class="col-md-1" id="lblExisteRemito11">
				</div>
			</div>	
			
			
			<div class="row">	
				<!--<div class="col-md-12 pull-right">-->
				<div class="col-md-12">
					<!--<hr>-->
					<button type="submit" class="btn btn-sm btn-danger">Actualizar</button>
					<hr>
				</div>
			</div>
			
		</div>
			
			
		<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;;
			$nid_xl = isset($_POST['id_xlH']) ? $_POST['id_xlH'] : false;;
			$tipo = isset($_POST['tipoH']) ? $_POST['tipoH'] : false;;
			$idusuario=isset($_SESSION['idusuario'])? $_SESSION['idusuario']:"";
			if($tipo <> "Granel"){
				$pr = isset($_POST['prH']) ? $_POST['prH'] : false;;
				if ($bmOpcion == "B"){
					$DB= new Database();
					$nremito = $DB->sanitize($_POST['nremito']);
					$fecha = date("Y-m-d", strtotime($_POST['fechaH']));
					$res = $DB->prBMRemitoLGv13($fecha,$fecha,$nremito,$nremito,$nid_xl,$nid_xl,$pr,$pr,$tipo,$bmOpcion,$idusuario);
					$row_cnt = mysqli_num_rows($res);
				}elseif ($bmOpcion == "M"){
					$DB= new Database();
					$nremito = $DB->sanitize($_POST['nremito']);
					$nremitomodi = isset($_POST['nremitomodiH']) ? $_POST['nremitomodiH'] : false;;
					$nremitomodi = $DB->sanitize($_POST['nremitomodi']);
					$fecha = date("Y-m-d", strtotime($_POST['fechaH']));
					$fechaM = date("Y-m-d", strtotime($_POST['fecha']));
					$nid_xl = isset($_POST['id_xlH']) ? $_POST['id_xlH'] : false;;
					$clienteid = explode("|",$_POST['cliente']);
					$pr = isset($_POST['prH']) ? $_POST['prH'] : false;;
					$prM = isset($_POST['prop']) ? $_POST['prop'] : false;;
					$res = $DB->prBMRemitoLGv13($fecha,$fechaM,$nremito,$nremitomodi,$nid_xl,$clienteid[0],$pr,$prM,$tipo,$bmOpcion,$idusuario);
					$row_cnt = mysqli_num_rows($res);
				}
				?>
				<div class="<?php echo $class;?>" id="rows">
					<?php echo $message;?>
				</div>
				<?php
				if ($row_cnt == 0){
				}else{
					?>	
					<div class="row" id="rowsT">
					<div class="col-md-10">
					<table class="table table-bordered" id="tabla1">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Remito</th>
								<th>Cliente</th>
								<th>Movimiento</th>
								<th>Serie</th>
								<th>Capacidad</th>
								<th>Propiedad</th>
								<th>Tipo Envase</th>
								<th>Tipo Remito</th>
							</tr>
						</thead>
					<?php 
						while ($row=mysqli_fetch_object($res)){
						?>
							<tbody>
								<?php
									$flagsM = 0;
									if(isset($row->feM)){
										$ffeM = $row->feM;
										switch ($ffeM) {
												case 0:
													$claseFondoffeM = "";
												break;
												case 1:
													$claseFondoffeM = "success";
													break;
										}
										$flagsM = $flagsM + $ffeM;
									}
									if(isset($row->reM)){
										$freM = $row->reM;
										switch ($freM) {
												case 0:
													$claseFondofreM = "";
												break;
												case 1:
													$claseFondofreM = "success";
													break;
										}
										$flagsM = $flagsM + $freM;
									}		
									if(isset($row->prM)){
										$fprM = $row->prM;
										switch ($fprM) {
												case 0:
													$claseFondofprM = "";
												break;
												case 1:
													$claseFondofprM = "success";
													break;
										}
										$flagsM = $flagsM + $fprM;
									}	
									if(isset($row->idM)){
										$fidM = $row->idM;
										switch ($fidM) {
												case 0:
													$claseFondofidM = "";
												break;
												case 1:
													$claseFondofidM = "success";
													break;
										}
										$flagsM = $flagsM + $fidM;
									}
									if($flagsM == 0 && $bmOpcion == "M"){
										$message= "No se modificó el remito.";
										$class="alert alert-info";
									}elseif($flagsM >= 1 && $bmOpcion == "M") {
										$message= "Se modificó el remito con éxito.";
										$class="alert alert-success";
									}elseif($flagsM == 0 && $bmOpcion == "B"){
										$message= "Se eliminó el remito con éxito.";
										$class="alert alert-success";
									}elseif($flagsM == 1 && $bmOpcion == "B"){
										$message= "No se eliminó el remito.";
										$class="alert alert-info";
									}
								?>
								
								<tr>
									<td class="text-center <?php echo $claseFondoffeM;?>" ><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
									<td class="text-center <?php echo $claseFondofreM;?>"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
									<td class="text-center <?php echo $claseFondofidM;?>"><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
									<td><?php if(isset($row->estado)){echo $row->estado;}else{echo "Error";}?></td>
									<td><?php if(isset($row->serie)){echo $row->serie;}else{echo "Error";}?></td>
									<td class="text-right"><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Error";}?></td>
									<td class="text-center <?php echo $claseFondofprM;?>"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
									<td><?php if(isset($row->tipo)){echo $row->tipo;}else{echo "Error";}?></td>
									<td><?php if(isset($row->tiporemito)){echo $row->tiporemito;}else{echo "Error";}?></td>
								</tr>				
							</tbody>	
						<?php
							}
						?>
						</table>
					</div>
					</div>
			
				<?php
					}
					?>
			<?php		
			}else{//Comienzo Granel
				
				if ($bmOpcion == "B"){
					$DB= new Database();
					$nremito = $DB->sanitize($_POST['nremito']);
					$fecha = date("Y-m-d", strtotime($_POST['fechaH']));
					//volumen - partida - certificado - tanque
					$vopacetaid = explode(" || ",$_POST['prH']);
					$idtanque = isset($_POST['idtanqueH']) ? $_POST['idtanqueH'] : false;;
					$res = $DB->prBMRemitoGRv13($fecha,$fecha,$nremito,$nremito,$nid_xl,$nid_xl,$vopacetaid[0],$vopacetaid[0],
												$vopacetaid[1],$vopacetaid[1],$vopacetaid[2], $vopacetaid[2], $idtanque,
												$idtanque, $bmOpcion,$idusuario);
					$row_cnt = mysqli_num_rows($res);
				}elseif ($bmOpcion == "M"){
					$DB= new Database();
					$nremito = $DB->sanitize($_POST['nremito']);
					$nremitomodi = isset($_POST['nremitomodiH']) ? $_POST['nremitomodiH'] : false;;
					$nremitomodi = $DB->sanitize($_POST['nremitomodi']);
					$fecha = date("Y-m-d", strtotime($_POST['fechaH']));
					$fechaM = date("Y-m-d", strtotime($_POST['fecha']));
					$nid_xl = isset($_POST['id_xlH']) ? $_POST['id_xlH'] : false;;
					$clienteid = explode("|",$_POST['cliente']);
					$vopacetaid = explode(" || ",$_POST['prH']);
					$idtanque = isset($_POST['idtanqueH']) ? $_POST['idtanqueH'] : false;;
					$vol = isset($_POST['vol']) ? $_POST['vol'] : false;;
					$part = isset($_POST['part']) ? $_POST['part'] : false;;
					$cert = isset($_POST['cert']) ? $_POST['cert'] : false;;
					$tanque = explode("|",$_POST['tanque']);
					$res = $DB->prBMRemitoGRv13($fecha,$fechaM,$nremito,$nremitomodi,$nid_xl,$clienteid[0],$vopacetaid[0],$vol,
												$vopacetaid[1],$part,$vopacetaid[2], $cert, $idtanque,
												$tanque[0], $bmOpcion,$idusuario);
					$row_cnt = mysqli_num_rows($res);
				}
				?>
				<div class="<?php echo $class;?>" id="rows">
					<?php echo $message;?>
				</div>
				<?php
				if ($row_cnt == 0){
				}else{
					?>	
					<div class="row" id="rowsT">
					<div class="col-md-10">
					<table class="table table-bordered" id="tabla1">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Remito</th>
								<th>Cliente</th>
								<th>Tipo Envase</th>
								<th>Volumen</th>
								<th>Partida</th>
								<th>Certificado</th>
								<th>Móvil</th>
								<th>Tipo Remito</th>
							</tr>
						</thead>
					<?php 
						while ($row=mysqli_fetch_object($res)){
						?>
							<tbody>
								<?php
									$flagsM = 0;
									if(isset($row->feM)){
										$ffeM = $row->feM;
										switch ($ffeM) {
												case 0:
													$claseFondoffeM = "";
												break;
												case 1:
													$claseFondoffeM = "success";
													break;
										}
										$flagsM = $flagsM + $ffeM;
									}
									if(isset($row->reM)){
										$freM = $row->reM;
										switch ($freM) {
												case 0:
													$claseFondofreM = "";
												break;
												case 1:
													$claseFondofreM = "success";
													break;
										}
										$flagsM = $flagsM + $freM;
									}		
									if(isset($row->idM)){
										$fidM = $row->idM;
										switch ($fidM) {
												case 0:
													$claseFondofidM = "";
												break;
												case 1:
													$claseFondofidM = "success";
													break;
										}
										$flagsM = $flagsM + $fidM;
									}
									if(isset($row->voM)){
										$fvoM = $row->voM;
										switch ($fvoM) {
												case 0:
													$claseFondofvoM = "";
												break;
												case 1:
													$claseFondofvoM = "success";
													break;
										}
										$flagsM = $flagsM + $fvoM;
									}
									if(isset($row->paM)){
										$fpaM = $row->paM;
										switch ($fpaM) {
												case 0:
													$claseFondofpaM = "";
												break;
												case 1:
													$claseFondofpaM = "success";
													break;
										}
										$flagsM = $flagsM + $fpaM;
									}
									if(isset($row->ceM)){
										$fceM = $row->ceM;
										switch ($fceM) {
												case 0:
													$claseFondofceM = "";
												break;
												case 1:
													$claseFondofceM = "success";
													break;
										}
										$flagsM = $flagsM + $fceM;
									}
									if(isset($row->tdM)){
										$ftdM = $row->tdM;
										switch ($ftdM) {
												case 0:
													$claseFondoftdM = "";
												break;
												case 1:
													$claseFondoftdM = "success";
													break;
										}
										$flagsM = $flagsM + $ftdM;
									}
									if($flagsM == 0 && $bmOpcion == "M"){
										$message= "No se modificó el remito.";
										$class="alert alert-info";
									}elseif($flagsM >= 1 && $bmOpcion == "M") {
										$message= "Se modificó el remito con éxito.";
										$class="alert alert-success";
									}elseif($flagsM == 0 && $bmOpcion == "B"){
										$message= "Se eliminó el remito con éxito.";
										$class="alert alert-success";
									}elseif($flagsM == 1 && $bmOpcion == "B"){
										$message= "No se eliminó el remito.";
										$class="alert alert-info";
									}
								?>
								
								<tr>
									<td class="text-center <?php echo $claseFondoffeM;?>" ><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
									<td class="text-center <?php echo $claseFondofreM;?>"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
									<td class="text-center <?php echo $claseFondofidM;?>"><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
									<td class="text-center">GRANEL</td>
									<td class="text-right <?php echo $claseFondofvoM;?>" ><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Error";}?></td>
									<td class="text-center <?php echo $claseFondofpaM;?>"><?php if(isset($row->partida)){echo $row->partida;}else{echo "Error";}?></td>
									<td class="text-center <?php echo $claseFondofceM;?>"><?php if(isset($row->certificado)){echo $row->certificado;}else{echo "Error";}?></td>
									<td class="text-center <?php echo $claseFondoftdM;?>"><?php if(isset($row->tdestino)){echo $row->tdestino;}else{echo "Error";}?></td>
									<td class="text-center"><?php if(isset($row->tiporemito)){echo $row->tiporemito;}else{echo "Error";}?></td>
								</tr>				
							</tbody>	
						<?php
							}
						?>
						</table>
					</div>
					</div>
			
				<?php
					}
					?>
			<?php
			}
		}	
		?>
			
<?php
}catch (Error $e) {
	$message= "Error: ". $e->getMessage();
	$class="alert alert-danger";
?>
	<div class="<?php echo $class;?>" id="rows">
		<?php echo $message;?>
	</div>
<?php
}
?>		

<script type="text/javascript">
	
	//Chequea si ya existe el remito - usuarios concurrentes - al salir del input nremito
	function getRemito(sRemito, nradioVal, callbackFn){
		//console.log("Valor de nradioVal -> "+nradioVal);
		if(sRemito.trim() !== ''){
			jq.ajax({
				url:"./ajax2RemitoDetalle-v3.php",
				dataType: "json",
				data: {"nremito": sRemito, "nradioval": nradioVal},
				type:"POST",
				success:function(response){
					callbackFn(response);
				}					
			})
		}
	}
	
	//Defino la función llamada chkDate  
	function chkDate(value, callbackFn) {
		var sValue = value;
		jq.ajax({
			url:"include/chkDate.php",
			dataType: "json",
			data: {"value": sValue},
			type:"POST",
			success:function(response){
				callbackFn(response);
			}
		})
	}
	
	//Defino la función llamada ExisteRemito  
	function chkExisteRemito(value, valueModi, callbackFn) {
		var sValue = value;
		var sValueModi = valueModi;
		jq.ajax({
			url:"ajaxRemitoBM-v1.php",
			dataType: "json",
			data: {"nremito": sValue, "nremitomodi": sValueModi},
			type:"POST",
			success:function(response){
				callbackFn(response);
			}
		})
	}
	
	var jq = jQuery.noConflict();
	jq(document).ready(function(){
		var smessage = '<?php echo $message; ?>';
		var stitulo = '';
		var sdatoremito = '';
		var sdatoserie = '';
		
		if (smessage !== ''){
			bootbox.alert({
				message: smessage,
				size: 'small'
			});
		}
		
		var isDate = 0;
		var iCliente = 0;
		var bRemito = false;
		var iTan = 0;
		
		var sRemito = '';
		var sRemitoModi = '';
		
		var sTipoEnv = '';
		var bvolVal = true;
		var bpartVal = true;
		var bcertVal = true;
		
		var nradioVal = '<?php echo $bmOpcion; ?>';
		
		var message = '<?php echo $message; ?>';
		var sclass = '<?php echo $class; ?>';
		jq("#rows").removeClass();
		jq("#rows").addClass(sclass);
		jq('#rows').html(message);
		
		jq('#lblMsgInformacion').css("background-color","#B8D4FE");
		jq('#lblMsgInformacion').css("color","#000333");
		
		jq.fn.setHiddenV = function(hId, hValue){
			jq('#'+hId).val(hValue)
                 //.trigger('change');
		}
		
		jq.fn.setlblListo = function(sRadio){
			var sRadio = sRadio;
			if(sRadio == 'M'){
				var sLblListo = "<label><pre class='lx-pre' id='lblListo'></pre></label></br>";
				jq("#lblExisteListo").append(sLblListo);
				jq("#lblListo").attr('id', 'msglblUNO');
				jq('#msglblUNO').css("background-color","#EE2C25");
				jq('#msglblUNO').css("color","#FFFFFF");
				jq("#msglblUNO").text('Listo');
			}else{
				jq('#lblExisteListo').children().each(function (index) {
					jq(this).remove();
				});
			}
		}
		
		jq.fn.setlblListo(nradioVal);
		
		jq.fn.chkPattern = function(sRemito){
			var pattern = new RegExp('^[0-9]{4}$|^[0-9]{6}$');
			if (pattern.test(sRemito)) {
				jq('#nremitomodi').css("background-color","#92FF8A");
				jq('#nremitomodi').css("color","#A605FA");
				return true;
			}else{
				if(jq('#nremitomodi').val() !== ''){
					jq('#nremitomodi').css("background-color","#FAE605");
					jq('#nremitomodi').css("color","#A605FA");
					jq("#nremitomodi").focus();
				}
				return false;
			}
		}
		
		jq.fn.existeRemito = function(sRemito,sRemitoModi){
			chkExisteRemito(sRemito, sRemitoModi, function(data) {
				var len = data.length;
				for(var i=0; i<len; i++){
					bRemitoExiste = data[i].header1;
				}
				if(bRemitoExiste == true){
					jq('#nremitomodi').css("background-color","#92FF8A");
					jq('#nremitomodi').css("color","#A605FA");
				}else{
					jq('#nremitomodi').css("background-color","#EE2C25");
					jq('#nremitomodi').css("color","#FFFFFF");
				}
			
			});	
		}
		
		//Limpia div Edición
		jq.fn.cleandivEDI = function(){
			jq('#lblExisteRemito').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito2').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito3').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito4').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito5').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito6').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito7').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito8').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito9').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito10').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito11').children().each(function (index) {
				jq(this).remove();
			});
			
		}
		
		jq.fn.chkVolumen = function(value){
			var regExp = /^[0-9]{1,7}(\.[0-9]{1,2})?$/;
			if(!value.match(regExp)){
				return false;
			}else{
				if(value < 17000){
					return true;
				}else{
					return false;
				}
			}
		}
		
		jq.fn.chkPartida = function(value){
			var regExp = /^([0-9]{5,6})$/;
			//var regExp = /^([0-9]{5})$|^([0-9]{9})$/;
			if(!value.match(regExp)){
				return false;
			}else{
				return true;
			}
		}
		
		jq.fn.chkCertificado = function(value){
			var regExp = /^([0-9]{4,5})$/;
			if(!value.match(regExp)){
				return false;
			}else{
				return true;
			}
		}
		
		// Decrease Font Size       
        jq.fn.achicaFont = function(sObj){
			var currentFontSize = jq('#'+sObj).css('font-size');        			
			var currentSize = parseFloat(currentFontSize)*0.8;
			currentSize = currentSize.toFixed(0)	
			//console.log(currentSize);
			jq("#"+sObj).css({
				'font-size': currentSize+'px' 
			});
        }
		
		
		//Trae datos de cabecera de remito si existe
		jq.fn.procesaRemito = function(sRemito, nradioVal){
			jq.fn.cleandivEDI();
			//var sRemito = jq(this).val();
			//jq.fn.chkPattern(sRemito);
			getRemito(sRemito, nradioVal, function(data) {
				var len = data.length;
			//console.log("Valor de len -> "+len);
				for(var i=0; i<len; i++){
					bRemitoExiste = data[i].header1;
					bModificaRto = data[i].header11;
					var scolmod0 = data[i].header20;
					var scolmod1 = data[i].header21;
					var scolmod2 = data[i].header22;
					var scolmod3 = data[i].header23;
					var scolmod4 = data[i].header24;
					var scolmod5 = data[i].header25;
					var scolmod6 = data[i].header26;
					var scolmod7 = data[i].header27;
					var scolmod8 = data[i].header28;
					jq("#lblExisteRemito").removeClass();
					jq("#lblExisteRemito").addClass(scolmod0);
					jq("#lblExisteRemito2").removeClass();
					jq("#lblExisteRemito2").addClass(scolmod1);
					jq("#lblExisteRemito3").removeClass();
					jq("#lblExisteRemito3").addClass(scolmod2);
					jq("#lblExisteRemito4").removeClass();
					jq("#lblExisteRemito4").addClass(scolmod3);
					jq("#lblExisteRemito5").removeClass();
					jq("#lblExisteRemito5").addClass(scolmod4);
					jq("#lblExisteRemito6").removeClass();
					jq("#lblExisteRemito6").addClass(scolmod5);
					jq("#lblExisteRemito7").removeClass();
					jq("#lblExisteRemito7").addClass(scolmod6);
					jq("#lblExisteRemito8").removeClass();
					jq("#lblExisteRemito8").addClass(scolmod7);
					jq("#lblExisteRemito9").removeClass();
					jq("#lblExisteRemito9").addClass(scolmod8);
					jq("#lblExisteRemito9").removeClass();
					jq("#lblExisteRemito9").addClass(scolmod8);
					jq("#lblExisteRemito10").removeClass();
					jq("#lblExisteRemito10").addClass(scolmod8);
					jq("#lblExisteRemito11").removeClass();
					jq("#lblExisteRemito11").addClass(scolmod7);
					
					if(bRemitoExiste == true){
						var sMsgUno = data[i].header2;
						var sMSGDos = data[i].header3;
						var sMSGTre = data[i].header4;
						var sMSGCua = data[i].header5;
						var sMSGCin = data[i].header6;
						var sMSGSei = data[i].header7;
						sTipoEnv = sMSGSei;
						var sMSGSie = data[i].header8;
						var sMSGOch = data[i].header9;
						var sMSGOcha = data[i].header9a;
						iTan = sMSGOcha;
						var sTipoRe = data[i].header10;
						switch(sTipoRe){
							//RDIST
							case 'RDIST':
								var sBGColor = "#E8F7AC";
							break;
							//RSUBI
							case 'RSUBI':
								var sBGColor = "#F7CA14";
							break;
						}
						
						
						var header19 = data[i].header19;
						var sCliVarH = header19.split('|');
						jq.fn.setHiddenV('id_xlH', sCliVarH[0]);
							
						var sLblUno = "<label id='uno'><pre class='lx-pre'></pre></label></br>";
						var sLblDos = "<label id='dos'><pre class='lx-pre'></pre></label></br>";
						var sLblTre = "<label id='tre'><pre class='lx-pre'></pre></label></br>";
						var sLblCua = "<label id='cua'><pre class='lx-pre'></pre></label></br>";
						var sLblCin = "<label id='cin'><pre class='lx-pre'></pre></label></br>";
						var sLblSei = "<label id='sei'><pre class='lx-pre'></pre></label></br>";
						var sLblSie = "<label id='sie'><pre class='lx-pre'></pre></label></br>";
						var sLblOch = "<label id='och'><pre class='lx-pre'></pre></label></br>";
						jq("#lblExisteRemito").append(sLblUno);
						jq("#uno pre").attr('id', 'msgUNO');
						jq("#lblExisteRemito").append(sLblDos);
						jq("#dos pre").attr('id', 'msgDOS');
						jq("#lblExisteRemito2").append(sLblTre);
						jq("#tre pre").attr('id', 'msgTRE');
						jq("#lblExisteRemito2").append(sLblCua);
						jq("#cua pre").attr('id', 'msgCUA');
						jq("#lblExisteRemito3").append(sLblCin);
						jq("#cin pre").attr('id', 'msgCIN');
						jq("#lblExisteRemito3").append(sLblSei);
						jq("#sei pre").attr('id', 'msgSEI');
						jq("#lblExisteRemito4").append(sLblSie);
						jq("#sie pre").attr('id', 'msgSIE');
						jq("#lblExisteRemito4").append(sLblOch);
						jq("#och pre").attr('id', 'msgOCH');
						jq('#msgUNO').css("background-color","#F5F5F5");
						jq('#msgUNO').css("color","#000333");
						jq("#msgUNO").text(sMsgUno);
						jq('#msgDOS').css("background-color",sBGColor);
						jq('#msgDOS').css("color","#000333");
						jq("#msgDOS").text(sMSGDos);
						jq.fn.setHiddenV('fechaH', sMSGDos);
						jq('#msgTRE').css("background-color","#F5F5F5");
						jq('#msgTRE').css("color","#000333");
						jq("#msgTRE").text(sMSGTre);
						jq('#msgCUA').css("background-color",sBGColor);
						jq('#msgCUA').css("color","#000333");
						jq("#msgCUA").text(sMSGCua);
						jq('#msgCIN').css("background-color","#F5F5F5");
						jq('#msgCIN').css("color","#000333");
						jq("#msgCIN").text(sMSGCin);
						jq('#msgSEI').css("background-color",sBGColor);
						jq('#msgSEI').css("color","#000333");
						jq("#msgSEI").text(sMSGSei);
						jq.fn.setHiddenV('tipoH', sMSGSei);
						jq('#msgSIE').css("background-color","#F5F5F5");
						jq('#msgSIE').css("color","#000333");
						jq("#msgSIE").text(sMSGSie);
						jq('#msgOCH').css("background-color",sBGColor);
						jq('#msgOCH').css("color","#000333");
						jq("#msgOCH").text(sMSGOch);
						jq.fn.setHiddenV('prH', sMSGOch);
						jq.fn.setHiddenV('idtanqueH', sMSGOcha);
						
						
						if(bModificaRto == true){
							var header12 = data[i].header12;
							var header13 = data[i].header13;
							var header14 = data[i].header14;
							var header15 = data[i].header15;
							var header16 = data[i].header16;
							var header17 = data[i].header17;
							var header18 = data[i].header18;
							//var header19 = data[i].header19;
							
							
							jq("#lblExisteRemito5").html(header12);
							jq("#nremitomodi").val(sRemito);
							sRemitoModi = jq("#nremitomodi").val();
							bRemito = jq.fn.chkPattern(sRemitoModi);
							jq.fn.setHiddenV('nremitomodiH', sRemitoModi);
							jq("#lblExisteRemito6").html(header13);
							//Inicializar el objeto datepicker
							jq("#datepicker").datepicker({ 
								dateFormat: "dd-mm-yy" 
							});
							jq("#datepicker").datepicker("setDate",sMSGDos);
							chkDate(sMSGDos, function(data) { // data = the JSON retrieved
								var len = data.length;
									for(var i=0; i<len; i++){
										isDate = data[i].header7;
										if(isDate == 1){
											jq('#datepicker').css("background-color","#92FF8A");
											jq('#datepicker').css("color","#000000");
										}else if(isDate == 0){
											jq('#datepicker').css("background-color","#EE2C25");
											jq('#datepicker').css("color","#FFFFFF");
										}
									}
								jq.fn.chkData();
							});
							jq("#lblExisteRemito7").html(header14);
							var aCliente = [];
							jq("#cliente option").each(function(){
								aCliente.push(jq(this).val());
							});
							//console.log(aCliente[4]);
							//console.log(sMSGCua);
							for(var i=1; i<aCliente.length; i++){
								var optCli = aCliente[i];
								var sCliArr = optCli.split('|');
								var sCliVar = header19.split('|');
								iCliente = sCliVar[0];
								//if(icap == sCliArr[0]){
								if(sCliVar[0] == sCliArr[0]){
									jq("#cliente option[value='"+optCli+"']").attr("selected", true);
									
									//jq("#cliente option:selected").css("background-color",'#FAE605');
									//jq("#cliente").css("background-color",'#FFFFFF');
									if(sMSGSei == "Granel"){
										jq.fn.achicaFont("cliente");
									}
								}
							}
							
							if(sMSGSei == "Granel"){
								var sVPCVar = sMSGOch.split(' || ');
								jq("#lblExisteRemito8").html(header15);
								
								jq("#vol").val(sVPCVar[0]);
								//jq.fn.achicaFont("vol");
								//var size = jq("#vol").css('font-size');
								//console.log(size);
								//jq("#vol").css({
								//	'font-size': '10px' 
								//});
								jq("#lblExisteRemito9").html(header16);
								jq("#part").val(sVPCVar[1]);
								jq("#lblExisteRemito10").html(header17);
								jq("#cert").val(sVPCVar[2]);
								jq("#lblExisteRemito11").html(header18);
								var aTanque = [];
								jq("#tanque option").each(function(){
									aTanque.push(jq(this).val());
								});
								//console.log(aTanque[2]);
								for(var i=1; i<aTanque.length; i++){
									var optTan = aTanque[i];
									var sTanArr = optTan.split('|');
									var sTanVar = sMSGOch.split(' || ');
									//console.log(sTanVar[3]);
									//console.log(sTanArr[1]);
									if(sTanVar[3] == sTanArr[1]){
										jq("#tanque option[value='"+optTan+"']").attr("selected", true);
									}
								}
							}else{
								jq("#lblExisteRemito8").html(header15);
								jq("#lblExisteRemito9").html(header16);
								jq("input[name=prop][value=" + sMSGOch + "]").prop('checked', true);
										
								
								
								
								jq("#nremitomodi").val(sRemito);
								sRemitoModi = jq("#nremitomodi").val();
								jq.fn.setHiddenV('nremitomodi', sRemitoModi);
							}
							
							jq("#datepicker").datepicker({
							onSelect: function(date) {
								sDate = date;
								chkDate(sDate, function(data) { // data = the JSON retrieved
									var len = data.length;
									for(var i=0; i<len; i++){
										isDate = data[i].header7;
										if(isDate == 1){
											jq('#datepicker').css("background-color","#92FF8A");
											jq('#datepicker').css("color","#000000");
										}else if(isDate == 0){
											jq('#datepicker').css("background-color","#EE2C25");
											jq('#datepicker').css("color","#FFFFFF");
										}
									}
									jq.fn.chkData();
								});
							},
								dateFormat:'dd-mm-yy'
							}).on("change", function() {
								sDate = jq(this).val();
								chkDate(sDate, function(data) { // data = the JSON retrieved
									var len = data.length;
									for(var i=0; i<len; i++){
										isDate = data[i].header7;
										if(isDate == 1){
											jq('#datepicker').css("background-color","#92FF8A");
											jq('#datepicker').css("color","#000000");
										}else if(isDate == 0){
											jq('#datepicker').css("background-color","#EE2C25");
											jq('#datepicker').css("color","#FFFFFF");
										}
									}
									jq.fn.chkData();
								});
							});
							
							
							
							
							
						}
					
					
					}else{
						var sMsgUno = data[i].header2;
						var sMSGDos = data[i].header3;
						var sLblUno = "<label id='uno'><pre class='lx-pre'></pre></label></br>";
						var sLblDos = "<label id='dos'><pre class='lx-pre'></pre></label></br>";
						jq("#lblExisteRemito").append(sLblUno);
						jq("#uno pre").attr('id', 'msgUNO');
						jq("#lblExisteRemito").append(sLblDos);
						jq("#dos pre").attr('id', 'msgDOS');
						jq('#msgUNO').css("background-color","#F5F5F5");
						jq('#msgUNO').css("color","#000333");
						jq("#msgUNO").text(sMsgUno);
						jq('#msgDOS').css("background-color","#E8F7AC");
						jq('#msgDOS').css("color","#000333");
						jq("#msgDOS").text(sMSGDos);
					}
				}
				
			});
		
		}
		
		
		var scolmod = '<?php echo $scolmod; ?>';
		
		//Procesa los OptionButton Modificar - Eliminar
		jq.fn.inputradio = function(nradioVal){ 
			var preI = '<pre class="lx-pre">';
			var preF = '</pre>';
			
			if (nradioVal == 'B') {
					jq('#lblMsgInformacion').css("background-color","#D1E3FD");
					jq('#lblMsgInformacion').css("color","#000333");
					jq('#lblMsgInformacion').text("Elimina el remito ingresado");
					jq('#lblRemito').text("Remito a Eliminar");
			}
			else if (nradioVal == 'M') {
					jq('#lblMsgInformacion').css("background-color","#D1E3FD");
					jq('#lblMsgInformacion').css("color","#000333");
					jq('#lblMsgInformacion').text("Modifica datos del remito ingresado");
					jq('#lblRemito').text("Remito a Modificar");
			}
		}
		
		jq.fn.inputradio(nradioVal);
		
		
		jq("#nremito").focusout('input', function(){
			sRemito = jq(this).val();
			jq.fn.procesaRemito(sRemito, nradioVal);
			jq("#rows").remove();
			jq('#rows').children().each(function (index) {
				jq(this).remove();
			});
			jq('#rowsT').children().each(function (index) {
				jq(this).remove();
			});
		});
		
		
		//Event binding on dynamically created elements | Input Remito (Nuevo)
		jq("#lblExisteRemito5").on('focusout', '#nremitomodi', function(){
			sRemitoModi = jq(this).val();
			bRemito = jq.fn.chkPattern(sRemitoModi);
			jq.fn.existeRemito(sRemito,sRemitoModi);
			jq.fn.chkData();
		});
		
		//Event binding on dynamically created elements | Input text volumen
		jq("#lblExisteRemito8").on('focusout','#vol', function(){
			bvolVal = jq.fn.chkVolumen(jq(this).val());
			if(bvolVal == true){
				jq(this).css("background-color","#92FF8A");
				jq(this).css("color","#000333");
			}else{
				jq(this).css("background-color","#EE2C25");
				jq(this).css("color","#FFFFFF");
			}
			jq.fn.chkData();
		});
		
		//Event binding on dynamically created elements | Input text partida
		jq("#lblExisteRemito9").on('focusout','#part', function(){
			bpartVal = jq.fn.chkPartida(jq(this).val());
			if(bpartVal == true){
				jq(this).css("background-color","#92FF8A");
				jq(this).css("color","#000333");
			}else{
				jq(this).css("background-color","#FAE605");
				jq(this).css("color","#000333");
			}
			jq.fn.chkData();
		});
		
		//Event binding on dynamically created elements | Input text certificado
		jq("#lblExisteRemito10").on('focusout','#cert', function(){
			bcertVal = jq.fn.chkCertificado(jq(this).val());
			if(jq(this).val() !== ""){
				if(bcertVal == true){
					jq(this).css("background-color","#92FF8A");
					jq(this).css("color","#000333");
				}else{
					jq(this).css("background-color","#FAE605");
					jq(this).css("color","#000333");
				}
			}else{
				jq(this).css("background-color","#FAE605");
				jq(this).css("color","#000333");
			}
			jq.fn.chkData();
		});
		
		
		//OptionButton Modificar - Eliminar
		jq("input[name=bmOpcion]").click(function () {
			//jq.fn.setOptionCss(0);
			nradioVal = jq(this).val();
			jq.fn.inputradio(nradioVal);
			jq("#nremito").val("");
			jq.fn.cleandivEDI();
			jq("#rows").remove();
			jq.fn.setlblListo(nradioVal);
			jq('#rowsT').children().each(function (index) {
				jq(this).remove();
			});
		});
			 
		
		
		//Event binding on dynamically created elements | Combo Móvil
		jq("#lblExisteRemito11").on('change','#tanque', function(){
			sTanArr = jq(this).val().split('|');
			iTan = sTanArr[0];
			jq.fn.chkData();
		});
		
		//Event binding on dynamically created elements | Combo Cliente
		jq("#lblExisteRemito7").on('change','#cliente', function(){
			sCli = jq(this).val();
			sCliArr = sCli.split('|');
			iCliente = sCliArr[0];
			jq.fn.chkData();
		});
		
		//Chequea formulario
		jq.fn.chkData = function(){
			var aData = [];
			//console.log("isDate -> "+isDate+" |-| iCliente -> "+iCliente+" |-| bRemito -> "+bRemito);
			switch(nradioVal) {
				case 'M':
					if(isDate == 1){
						aData.push(true);
					}else{
						aData.push(false);
					}
					
					if(iCliente == '0'){
						aData.push(false);
					}else{
						aData.push(true);
					}
					
					if(bRemito == true ){
						aData.push(true);
					}else{
						aData.push(false);
					}
					
					if(sTipoEnv == "Granel"){
						//console.log("vol -> "+jq('#vol').val()+" |-| part -> "+jq('#part').val()+" |-| cert -> "+jq('#cert').val());
						//console.log("bpartVal -> "+bpartVal+" |-| bcertVal -> "+bcertVal+" |-| iTan -> "+iTan);
							if(jq('#vol').val() !== '' && bvolVal == true ){
								aData.push(true);
							}else{
								aData.push(false);
							}
							
							if(jq('#part').val() !== '' && bpartVal == true){
								aData.push(true);
							}else if(jq('#part').val() == ''){
								aData.push(true);
							}else{
								aData.push(false);
							}
							
							if(jq('#cert').val() !== '' && bcertVal == true){
								aData.push(true);
							}
							else if(jq('#cert').val() == ''){
								aData.push(true);
							}
							else{
								aData.push(false);
							}
							
							if(iTan == 0){
								aData.push(false);
							}else{
								aData.push(true);
							}
														
						}
					}
			
			var bVal = true;
			for(j = 0 ;j < aData.length ;j++){
				bVal = bVal && aData[j];
				
			}
			console.log("Valor de bVal -> "+bVal );
			if(bVal){
				//console.log("Adentro de bVal por true -> "+bVal );
				jq('#msglblUNO').css("background-color","#92FF8A");
				jq('#msglblUNO').css("color","#140CC5");
				//jq('#msglblUNO').text("Si");
				retVal = true; 
				}else{
					//console.log("Adentro de bVal por false -> "+bVal );
					jq('#msglblUNO').css("background-color","#EE2C25");
					jq('#msglblUNO').css("color","#FFFFFF");
					//jq('#msglblUNO').text("No");
					retVal = false;
				}
			return retVal;
		}
		
		
		
		jq('#frm').on('submit', function(e){	
			var currentForm = this;
			
			//console.log("Adentro...");
			e.preventDefault();
			var returnValue = jq.fn.chkData();
			switch(nradioVal) {
				//Eliminar Remito
				case 'B':
					sconfirmsg = "Desea eliminar el remito N° "+ sRemito +"?";
					bootbox.confirm({
						message: sconfirmsg,
						size: 'small',
						buttons: {
							confirm: {
								label: 'Si',
								className: 'btn-success'
							},
							cancel: {
								label: 'No',
								className: 'btn-warning'
							}
						},
						callback: function (result) {
							if(result == true){
								currentForm.submit();
							}
						}
					});
				break;
				case 'M':
					sconfirmsg = "Desea modificar el remito N° "+ sRemito +"?";
					bootbox.confirm({
						message: sconfirmsg,
						size: 'small',
						buttons: {
							confirm: {
								label: 'Si',
								className: 'btn-success'
							},
							cancel: {
								label: 'No',
								className: 'btn-warning'
							}
						},
						callback: function (result) {
							if(result == true && returnValue == true){
								currentForm.submit();
							}
						}
					});
				break;
			}
			//}
		});
			//}
		});
		
		
		
		
		
	//});
	
</script>
	</form>
	
	</body>
</html>


