<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="remitoAlta-v7.1.php" id="frm" >
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Alta Remito</h4></div>
                </div>
            </div>
            

			
			<div class="row">
				<div class="col-md-3">
					<label><pre class="lx-pre">Número de Remito</pre></label></br>
					<label><pre class="lx-pre" id="msgTAB">Ingrese Remito y presione TAB</pre></label></br>
					<pre class="lx-pre"><input type="text" name="nremito" id="nremito" class="form-control input-sm" maxlength="6" required value="<?php $nremito; ?>" /></pre>
				</div>
				<div class="col-md-5" id="lblExisteRemito">
				</div>	
				<div class="col-md-4" id="lblExisteRemito2">
				</div>
			</div>
			
			<div class="row">	
				<div class="col-md-2" id="lblRemito">
				</div>
				<div class="col-md-4" id="lblRemito2">
				</div>			
				<div class="col-md-2" id="lblRemito3">
				</div>
				<div class="col-md-2" id="lblRemito4">
				</div>
				<div class="col-md-2" id="lblRemito5">
				</div>
				<div class="col-md-12" id="lblRemito6">
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<hr>
					<button type="submit" class="btn btn-sm btn-danger" tabindex='-1'>Ingresar</button>
					<!--<hr>-->
				</div>
			</div>
			
			<?php
			$otipoProducto = isset($_POST['tipoProducto']) ? $_POST['tipoProducto'] : false;;
			$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;;
			//$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			$idusuario=isset($_SESSION['idusuario'])? $_SESSION['idusuario']:"";
			$tipoRemito = 'RDIST';
			if($otipoProducto && $otipoProducto == 'LG' && validaSerie($nremito)){
				$envS = 0;
				$devS = 0;
				$ecapH = 0;
				$dcapH = 0;
				$tipoenv = isset($_POST['env']) ? $_POST['env'] : null;
				$propiedad = isset($_POST['prop']) ? $_POST['prop'] : null;
				//foreach ($_POST as $clave=>$valor){
				//	}
				$seriesCSV = '';
				foreach ($_POST as $clave=>$valor){
					if(substr($clave,0,3) == "ENV" || substr($clave,0,3) == "DEV"){
						if(substr($clave,0,3) == "ENV" && trim($valor) <> ''){
							$seriesCSV = $seriesCSV.$valor.$clave.",";
							$envS++;
						}
						if(substr($clave,0,3) == "DEV" && trim($valor) <> ''){
							$seriesCSV = $seriesCSV.$valor.$clave.",";
							$devS++;
						}
					}
					if(substr($clave,0,5) == "ECAPH" || substr($clave,0,5) == "DCAPH"){
						if(substr($clave,0,3) == "ECA" && trim($valor) <> '' && $valor <> 0){
							$seriesCSV = $seriesCSV.$valor.$clave.",";
							$ecapH++;
						}
						if(substr($clave,0,3) == "DCA" && trim($valor) <> '' && $valor <> 0){
							$seriesCSV = $seriesCSV.$valor.$clave.",";
							$dcapH++;
						}
					}
				}
				$seriesCSV = substr($seriesCSV,0,strlen($seriesCSV)-1);
				//echo "<pre>";
				//echo $seriesCSV."</br>";
				//echo "</pre>";
				$DB= new Database();
				$nremito = $DB->sanitize($_POST['nremito']);
				$clienteid = explode("|",$_POST['cliente']);
				$fecha = date("Y-m-d", strtotime($_POST['fecha']));
				$prop = isset($_POST['prop']) ? $_POST['prop'] : false;
				$tipoenvase = isset($_POST['env']) ? $_POST['env'] : false;
								
				$res = $DB->prInsertarCSVv6($fecha,$nremito,$clienteid[1],$seriesCSV,$prop,$tipoenvase,$clienteid[0],$tipoRemito,$idusuario);
				$row_cnt = mysqli_num_rows($res);
					if ($row_cnt == 0){
						$message= "No se insertaron movimientos";
						$class="alert alert-info";
					}elseif($row_cnt == 1){
						$message= "Se insertó ".$row_cnt." movimiento con éxito ";
						$class="alert alert-success";
					}else{
						$message= "Se insertaron ".$row_cnt." movimientos con éxito ";
						$class="alert alert-success";
					}
				?>
			    
				<div class="<?php echo $class;?>" id="rows">
					<?php echo $message;?>
				</div>
				<?php
				if ($row_cnt == 0){
				}else{
					?>	
					<div class="row">
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
								<tr>
									<td><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
									<td><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
									<td><?php if(isset($row->id_xl) && isset($row->cliente)){echo '('.$row->id_xl.') '.$row->cliente;}else{echo "Error";}?></td>
									<td><?php if(isset($row->estado)){echo $row->estado;}else{echo "Error";}?></td>
									<td><?php if(isset($row->serie)){echo $row->serie;}else{echo "Error";}?></td>
									<td><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Error";}?></td>
									<td><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
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
					}elseif($otipoProducto && $otipoProducto == 'GR' && validaSerie($nremito)){
						$DB= new Database();
						$nremito = $DB->sanitize($_POST['nremito']);
						$volumen = isset($_POST['vol']) ? $_POST['vol'] : false;
						$partida = isset($_POST['part']) ? $_POST['part'] : false;
						$certificado = isset($_POST['cert']) ? $_POST['cert'] : false;
						$clienteid = explode("|",$_POST['cliente']);
						$fecha = date("Y-m-d", strtotime($_POST['fecha']));
						$serie = "TAV";
						$estado = "E";
						$prop = "NP";
						$tipoenvase = "ZZZ";
						$tdestino = explode("|",$_POST['tanque']);
						
						//$tdestino = "N/D";
						if($tdestino[0] == 0){
							$stdestino = "N/D";
						}else{
							$stdestino = $tdestino[0];
						}
						
						if(!$partida){
							$partida = "N/D";
						}
						if(!$certificado){
							$certificado = "N/D";
						}
						//echo "<pre>";
						//echo $fecha."</br>".$nremito."</br>".$clienteid[1]."</br>".$estado."</br>".$serie."</br>".$volumen."</br>".$prop."</br>".$tipoenvase."</br>".$clienteid[0]."</br>".$partida."</br>".$certificado."</br>".$stdestino;
						//echo "</pre>";
						
						$res = $DB->prInsertarGRv1($fecha,$nremito,$clienteid[1],$estado,$serie,$volumen,$prop,$tipoenvase,$clienteid[0],$partida,$certificado,$tdestino[0],$tipoRemito,$idusuario);
						$row_cnt = mysqli_num_rows($res);
						if ($row_cnt == 0){
							$message= "No se insertaron movimientos";
							$class="alert alert-info";
						}elseif($row_cnt == 1){
							$message= "Se insertó ".$row_cnt." movimiento con éxito ";
							$class="alert alert-success";
						}else{
							$message= "Se insertaron ".$row_cnt." movimientos con éxito ";
							$class="alert alert-success";
						}
					?>
					<div class="<?php echo $class;?>" id="rows">
						<?php echo $message;?>
					</div>
					<?php
					if ($row_cnt == 0){
					}else{
						?>	
						<div class="row">
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
									<tr>
										<td><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
										<td><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
										<td><?php if(isset($row->id_xl) && isset($row->cliente)){echo '('.$row->id_xl.') '.$row->cliente;}else{echo "Error";}?></td>
										<td><?php if(isset($row->tipo_fake)){echo $row->tipo_fake;}else{echo "Error";}?></td>
										<td><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Error";}?></td>
										<td><?php if(isset($row->partida)){echo $row->partida;}else{echo "Error";}?></td>
										<td><?php if(isset($row->certificado)){echo $row->certificado;}else{echo "Error";}?></td>
										<td><?php if(isset($row->tdestino)){echo $row->tdestino;}else{echo "Error";}?></td>
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
	//
	Array.prototype.count_value = function(){
		var count = {};
		for(var i = 0; i < this.length; i++){
			if(!(this[i] in count))count[this[i]] = 0;
				count[this[i]]++;
			}
		return count;
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
	
	//Defino la función llamada setSerie
	function setSerie(sSerie, sClie, sProp, sTipo, callbackFn) {
		jq.ajax({
			url:"./ajaxConsultaSerie-v2.php",
			dataType: "json",
			data: {"sSerie": sSerie, "sClie": sClie, "sProp": sProp, "sTipo": sTipo },
			type:"POST",
			success:function(response){
				callbackFn(response);
			}
		})
	}
	
	//Chequea si ya existe el remito - usuarios concurrentes - al salir del input nremito
	function chkRemitoExiste(sRemito, sTipo, nradioVal, callbackFn){
		//console.log("Valor de nradioVal -> "+nradioVal);
		if(sRemito.trim() !== ''){
			jq.ajax({
				url:"./ajaxConsultaRemito-v7.php",
				dataType: "json",
				data: {"nremito": sRemito, "tipoOpcion": sTipo, "tipoProducto": nradioVal},
				type:"POST",
				success:function(response){
					callbackFn(response);
				}					
			})
		}
	}
	
	//Chequea si ya existe el remito - usuarios concurrentes - al salir del input nremito
	function chkRemitoExisteUno(sRemito, callbackFn){
		if(sRemito.trim() !== ''){
			jq.ajax({
				url:"./ajaxConsultaRemito-v6.php",
				dataType: "json",
				data: {"nremito": sRemito},
				type:"POST",
				success:function(response){
					callbackFn(response);
				}					
			})
		}
	}
	
	//Chequea si ya existe el remito - usuarios concurrentes - al ejecutar acción sobre otro control (menos input nremito)
	function chkRemitoExisteNIR(sRemito, callbackFn){
		jq.ajax({
			url:"./ajaxConsultaExisteRemito-v4.php",
			dataType: "json",
			data: {"nremito": sRemito},
			type:"POST",
			success:function(response){
				callbackFn(response);
			}					
		})
			
	}
	
	//Chequea si ya existe un certificado
	function chkCertificadoExiste(sCertificado, callbackFn){
			
			if(sCertificado.trim() !== ''){
				jq.ajax({
					url:"./ajaxConsultaExisteCertificado-v1.php",
					dataType: "json",
					data: {"scertificado": sCertificado},
					type:"POST",
					success:function(response){
						callbackFn(response);
					}					
				})
			}
	}
	
	
	
	var jq = jQuery.noConflict();
	//jQuery.noConflict();
	jq(document).ready(function(){
		
		var aSerieCap = [];
		var aSerieCapFull = [];
		
		jq("#nremito").focus();
		
		for(k = 0 ;k < 8 ;k++){
			var aSerieCap = [];
			if(k == 0){
				var sId0 = 'ENV0';	//input text
				var sId1 = 'ENV';	//input text
			}
			else if(k == 1){
				var sId0 = 'DEV0';	//input text
				var sId1 = 'DEV';	//input text
			}
			else if(k == 2){
				var sId0 = 'ECHK0';	//input checkbox
				var sId1 = 'ECHK';	//input checkbox
			}
			else if(k == 3){
				var sId0 = 'DCHK0';	//input checkbox
				var sId1 = 'DCHK';	//input checkbox
			}
			else if(k == 4){
				var sId0 = 'ECAP0'; //label
				var sId1 = 'ECAP';	//label
			}
			else if(k == 5){
				var sId0 = 'DCAP0';	//label
				var sId1 = 'DCAP';	//label
			}
			else if(k == 6){
				var sId0 = 'ECAPH0';	//input hidden
				var sId1 = 'ECAPH';	//input hidden
			}
			else if(k == 7){
				var sId0 = 'DCAPH0';	//input hidden
				var sId1 = 'DCAPH';	//input hidden	
			}
			
			for(j = 1 ;j < 25 ;j++){
				if (j < 10){
					var schkID = sId0+j.toString();
					aSerieCap.push(schkID);
				}
				else {
					var schkID = sId1+j.toString();
					aSerieCap.push(schkID);
				}	
			}
			aSerieCapFull.push(aSerieCap);
		}
		
		
		var sRemito = '';
		var bRemitoIngresado = false;
		var stitulo = '';
		var sdatoremito = '';
		
		var bvolVal = false;
		var bpartVal = true;
		var bcertVal = true;
		
		var nradioVal = '';
		
		var sProp = 'NP';
		var sTipo = 'CIL';
		var sCap = '';
		//var sMov = 'E';
		var sDate = '';
		var isDate = 0;
		var isDup = 0;
		var iCliente = 0;
		
		var envBool = false;
		var devBool = false;
		
		var bGranel = false;
		
		jq('#msgTAB').css("background-color","#B8D4FE");
		jq('#msgTAB').css("color","#000333");
		var smsgTAB = "Ingrese Remito y presione TAB";
		
		jq.fn.setOptionCss = function (sValue){
			switch(sValue) {
				//Con Envase
				case 'LG':
					jq('#lblEnvasado').css("background-color","#92FF8A");
					jq('#lblEnvasado').css("color","#000333");
					jq('#lblGranel').css("background-color","#F5F5F5");
					jq('#lblGranel').css("color","#000333");
					bGranel = false;
				break;
				//Granel
				case 'GR':
					jq('#lblEnvasado').css("background-color","#F5F5F5");
					jq('#lblEnvasado').css("color","#000333");
					jq('#lblGranel').css("background-color","#92FF8A");
					jq('#lblGranel').css("color","#000333");
					bGranel = true;
				break;
			}
		}
		
		
		jq.fn.chkSerie = function(value){
			var regExp = /^([0-9]{1,12})$/;
			if(!value.match(regExp)){
				return false;
			}else{
				return true;
			}
		}
		
		jq.fn.chkVolumen = function(value){
			//var regExp = /^[0-9]{1,7}(\.[0-9]{1,2})?$/;
			var regExp = /^-?[0-9]{1,7}(\.[0-9]{1,2})?$/;
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
		
		//Verifica si existe remito - si no existe genera formulario Envasado | Granel
		jq.fn.inputradioProducto = function(){
			var envOpcion = jq(".env:checked").val();
			jq('#lblRemito').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblRemito2').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblRemito3').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblRemito4').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblRemito5').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblRemito6').children().each(function (index) {
				jq(this).remove();
			});
			jq('#tabla1').children().each(function (index) {
				jq(this).remove();
			});
					
			jq('#rows').remove();
			
			chkRemitoExiste(sRemito, envOpcion, nradioVal, function(data) { // data = the JSON retrieved
				var len = data.length;
				//console.log("Valor de sTitulo ->"+stitulo);
				for(var i=0; i<len; i++){
					bRemitoIngresado = data[i].header13;
					if(bRemitoIngresado == true){
						stitulo = data[i].header1;
						sdatoremito = data[i].header2;
					}else{
						var header1 = data[i].header1;
						var header2 = data[i].header2;
						var header3 = data[i].header3;
						var header4 = data[i].header4;
						var header5 = data[i].header5;
						var header6 = data[i].header6;
						var scolmo0 = data[i].header7;
						var scolmo1 = data[i].header8;
						var scolmo2 = data[i].header9;
						//var scolmo3 = data[i].header10;
						var scolmo4 = data[i].header11;
						jq("#lblRemito").html(header1);
						jq('#lblRemito2').removeClass();
						jq('#lblRemito2').addClass(scolmo0);
						jq("#lblRemito2").append(header2);
						//jq('#lblRemito3').removeClass();
						//jq('#lblRemito3').addClass(scolmo3);						
						jq("#lblRemito3").html(header3);
						jq('#lblRemito4').removeClass();
						jq('#lblRemito4').addClass(scolmo1);						
						jq("#lblRemito4").append(header4);
						jq('#lblRemito5').removeClass();
						jq('#lblRemito5').addClass(scolmo4);						
						//jq("#lblRemito5").append(header5);
						jq("#lblRemito5").html(header5);
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
									jq.fn.chkDataGR();
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
									jq.fn.chkDataGR();
								});
							});
						//lx - now	
						jq('#lblRemito6').removeClass();
						jq('#lblRemito6').addClass(scolmo2);						
						jq("#lblRemito6").append(header6);
						jq('#lbrepetidoE').css("background-color","#92FF8A");
						jq('#lbrepetidoD').css("background-color","#92FF8A");
						//jq('#msgTAB').hide();
					}
					for(j = 0 ;j < 25 ;j++){
						jq('#'+aSerieCapFull[0][j]).prop("disabled", true);
						jq('#'+aSerieCapFull[2][j]).attr("disabled", true);
						jq('#'+aSerieCapFull[1][j]).prop("disabled", true);
						jq('#'+aSerieCapFull[3][j]).attr("disabled", true);
					}
					jq.fn.chkData();
				}
				jq.fn.cleanMsg(bRemitoIngresado);
			});
		}
		
			
		
		//Event binding on dynamically created elements | Opcion Tipo Producto
		jq("#lblExisteRemito").on('click','.oTP', function(){
			nradioVal = jq(this).val();
			//console.log("Click en el option -> "+nradioVal);
			jq.fn.setOptionCss(nradioVal);
			jq.fn.inputradioProducto();
		});
		
		
		//Event binding on dynamically created elements
		jq("#lblRemito6").on('focusout','.form-control', function(){
			if (bGranel == false){
				//console.log("lblRemito6 pero de la clase .form-control....");
				var sPropSerie = jq(this).attr('id');
				var sNMSerie = jq(this).attr('name');
				var sCapId = sNMSerie.substring(0,1)+'CAP'+sNMSerie.substring(3,5);
				var sChkId = sNMSerie.substring(0,1)+'CHK'+sNMSerie.substring(3,5);
				var sCapHId = sNMSerie.substring(0,1)+'CAPH'+sNMSerie.substring(3,7);
				
				var retval = jq.fn.chkSerie(jq(this).val());
				jq('#lbrepetidoE').css("background-color","#92FF8A");
				jq('#lbrepetidoD').css("background-color","#92FF8A");
				if(retval == true){
					var sSerie = jq(this).val();
					jq.fn.chkDup();
				}else{
					var sSerie = jq(this).val();
					jq(this).val('');
					jq(this).css("background-color","transparent");
					jq(this).css("color","#000000");
					jq('#'+sChkId).attr("disabled", false);
					jq('#'+sCapId).text("");
					jq.fn.chkDup();
					jq.fn.chkData();
					return false;
				}
				
				if(sPropSerie == 'cantidadE' || sPropSerie == 'capacidadE' || sPropSerie == 'cantidadD' || sPropSerie == 'capacidadD'){
					return false;
				}
				
				if(sSerie !== ''){
					if(sProp == 'NP'){
						var sClie = '999';
					}else if(sProp == 'SP'){
						var sClie = iCliente;
					}
					
					setSerie(sSerie, sClie, sProp, sTipo, function(data){// data = the JSON retrieved
					var len = data.length;
					for(var i=0; i<len; i++){
						var iCantidad = data[i].icantidad;
						var iCapcantidad = data[i].icapcantidad;
						var dCapacidad = data[i].dcapacidad;
						//Ningún registro en tabla movimientos y ninguno en tabla envcap
						//Fondo campo serie color rojo y texto capacidad rojo
						if (iCantidad == 0 && iCapcantidad == 0){
							jq('#'+sPropSerie).css("background-color","#EE2C25");
							jq('#'+sPropSerie).css("font-weight","bold");
							jq('#'+sPropSerie).css("color","#FFFFFF");
							jq('#'+sChkId).removeAttr("disabled");
							jq('#'+sCapId).text(' Cap: 0');
							jq('#'+sCapId).css("color","#EE2C25");
							jq('#'+sChkId).prop("checked", false);
						}
						//Más de un registro en tabla movimientos y ninguno en tabla envcap
						//Fondo campo serie color verde y texto capacidad rojo
						else if (iCantidad > 0 && iCapcantidad == 0) {
							jq('#'+sPropSerie).css("background-color","#AFFFB4");
							jq('#'+sPropSerie).css("font-weight","bold");
							jq('#'+sPropSerie).css("color","#000000");
							jq('#'+sChkId).removeAttr("disabled");
							jq('#'+sCapId).text(' Cap: 0');
							jq('#'+sCapId).css("color","#EE2C25");
							jq('#'+sChkId).prop("checked", false);
						}
						//Más de un registro en tabla movimientos y uno en tabla envcap
						//Fondo campo serie color verde y texto capacidad azul
						else if (iCantidad > 0 && iCapcantidad == 1) {
							jq('#'+sPropSerie).css("background-color","#AFFFB4");
							jq('#'+sPropSerie).css("font-weight","bold");
							jq('#'+sPropSerie).css("color","#000000");
							jq('#'+sCapId).text(' Cap: '+dCapacidad);
							jq('#'+sCapId).css("color","#522AE9");
							//jq('#'+sChkId).attr("disabled", true);
							jq('#'+sChkId).prop("checked", true);
							jq.fn.setHiddenV(sCapHId, dCapacidad);
							if(jq('#'+sCapId).text() == ' Cap: 0.0'){
								jq('#'+sPropSerie).css("background-color","#FAE605");
							}
						}
						//Ningún registro en tabla movimientos y uno en tabla envcap
						//Fondo campo serie color rojo y texto capacidad azul
						else if (iCantidad == 0 && iCapcantidad == 1) {
							jq('#'+sPropSerie).css("background-color","#EE2C25");
							jq('#'+sPropSerie).css("font-weight","bold");
							jq('#'+sPropSerie).css("color","#FFFFFF");
							jq('#'+sCapId).text(' Cap: '+dCapacidad);
							jq('#'+sCapId).css("color","#522AE9");
							//jq('#'+sChkId).attr("disabled", true);
							jq('#'+sChkId).prop("checked", true);
							jq.fn.setHiddenV(sCapHId, dCapacidad); //FAE605
							if(jq('#'+sCapId).text() == ' Cap: 0.0'){
								jq('#'+sPropSerie).css("background-color","#FAE605");
							}
						}
						
						jq('#'+sPropSerie).val(sSerie);
					}
					jq.fn.chkDup();
					jq.fn.chkData();
					});
				}
			}
			});
		
		
		jq("#lblRemito6").on('click','.chkBox', function(){
			var sChkId = jq(this).attr('id');
			var sCapId = sChkId.substring(0,1)+'CAP'+sChkId.substring(4,6);
			var sCapHId = sChkId.substring(0,1)+'CAPH'+sChkId.substring(4,6);
			if(jq(this).prop('checked') == false){
				jq('#'+sCapId).text('');
				jq.fn.setHiddenV(sCapHId, 0)
			}
				jq.fn.chkData();
			});
			
				
			
		//Event binding on dynamically created elements | Tipo de Envase
		jq("#lblRemito3").on('click','.envRadio', function(){
			
			sTipo = jq(this).val();	
			jq.ajax({
				url:"./ajaxConsultaTipoEnvase.php",
				dataType: "json",
				data: {"sTipo": sTipo},
				type:"POST",
				success:function(response){
					var len = response.length;
					for(var i=0; i<len; i++){
						var header7 = response[i].header7;
						jq("#capacidadE").html(header7);
						jq("#capacidadD").html(header7);
						}
					}
				});
				jq.fn.cleanGrid();
		});
		
		//Event binding on dynamically created elements | Propiedad
		jq("#lblRemito4").on('change','.envProp', function(){
			sProp = jq(this).val();	
			jq.fn.cleanGrid();
		});
			
		jq.fn.setHiddenV = function(hId, hValue){
			jq('#'+hId).val(hValue)
                 //.trigger('change');
		}
		
		//Chequea formulario Envasado
		jq.fn.chkData = function(){
			var envEn = 0;
			var envStr = 0;
			var ecapStr = 0;
			var ecapStr0 = 0;
			var devEn = 0;
			var devStr = 0;
			var dcapStr = 0;
			var dcapStr0 = 0;
			var retVal;
			var aData = [];
			//console.log("Entra por chkData...");
			for(j = 0 ;j < 24 ;j++){
				if(jq('#'+aSerieCapFull[0][j]).prop("disabled") == false){
					envEn++;
				}
				if(jq('#'+aSerieCapFull[0][j]).val() !== ''){
					envStr++;
				}
				if(jq('#'+aSerieCapFull[4][j]).text() !== '' && jq('#'+aSerieCapFull[4][j]).text() !== ' Cap: 0'){
					ecapStr++;
				}
				if(jq('#'+aSerieCapFull[4][j]).text() == ' Cap: 0.0'){
					ecapStr0++;
				}
			}
			
			for(j = 0 ;j < 24 ;j++){
				if(jq('#'+aSerieCapFull[1][j]).prop("disabled") == false){
					devEn++;
				}
				if(jq('#'+aSerieCapFull[1][j]).val() !== ''){
					devStr++;
				}
				if(jq('#'+aSerieCapFull[5][j]).text() !== '' && jq('#'+aSerieCapFull[5][j]).text() !== ' Cap: 0'){
					dcapStr++;
				}
				if(jq('#'+aSerieCapFull[5][j]).text() == ' Cap: 0.0'){
					dcapStr0++;
				}
			}
			
			if((envEn !== 0 && envStr !== 0 && ecapStr !== 0) || (devEn !== 0 && devStr !== 0 && dcapStr !== 0)){
				aData.push(true);
			}else{
				aData.push(false);
			}
			
			envBool = envEn !== 0 && envStr !== 0 && ecapStr !== 0;
			devBool = devEn !== 0 && devStr !== 0 && dcapStr !== 0;
			
			if(envEn == envStr && envEn == ecapStr && envStr == ecapStr && ecapStr0 == 0){
				aData.push(true);
			}else{
				aData.push(false);
			}
			if(devEn == devStr && devEn == dcapStr && devStr == dcapStr && dcapStr0 == 0){
				aData.push(true);
			}else{
				aData.push(false);
			}
			
			if(isDate == 1){
				aData.push(true);
			}else{
				aData.push(false);
			}
			
			if(isDup == 0){
				aData.push(true);
			}else{
				aData.push(false);
			}
			
			if(iCliente == '0'){
				aData.push(false);
			}else{
				aData.push(true);
			}
			
			if(bRemitoIngresado == true){
				aData.push(false);
				}else{
					aData.push(true);
				}
			
			var bVal = true;
			for(j = 0 ;j < aData.length ;j++){
				bVal = bVal && aData[j];
				
			}
						
			if(bVal){
				//console.log("Dentro de checkdata por true de bVal...");
				jq('#rStatus').css("background-color","#92FF8A");
				jq('#rStatus').css("color","#140CC5");
				jq('#rStatus').text("Si");
				retVal = true; 
				}else{
					//console.log("Dentro de checkdata por true de bVal...");
					jq('#rStatus').css("background-color","#EE2C25");
					jq('#rStatus').css("color","#FFFFFF");
					jq('#rStatus').text("No");
					retVal = false;
				}
			return retVal;
		}
		
		//Chequea formulario Granel
		jq.fn.chkDataGR = function(){
			var aDataGR = [];
			
			if(jq('#vol').val() !== '' && bvolVal == true ){
				aDataGR.push(true);
			}else{
				aDataGR.push(false);
			}
			
			if(jq('#part').val() !== '' && bpartVal == true){
				aDataGR.push(true);
			}else if(jq('#part').val() == ''){
				aDataGR.push(true);
			}else{
				aDataGR.push(false);
			}
			
			if(jq('#cert').val() !== '' && bcertVal == true){
				aDataGR.push(true);
			}
			else if(jq('#cert').val() == ''){
				aDataGR.push(true);
			}
			else{
				aDataGR.push(false);
			}
			
			if(isDate == 1){
				aDataGR.push(true);
			}else{
				aDataGR.push(false);
			}
			
			if(iCliente == '0'){
				aDataGR.push(false);
			}else{
				aDataGR.push(true);
			}
			
			var bVal = true;
			for(j = 0 ;j < aDataGR.length ;j++){
				bVal = bVal && aDataGR[j];
				
			}
			
			if(bVal){
				jq('#rStatus').css("background-color","#92FF8A");
				jq('#rStatus').css("color","#140CC5");
				jq('#rStatus').text("Si");
				retVal = true; 
				}else{
					jq('#rStatus').css("background-color","#EE2C25");
					jq('#rStatus').css("color","#FFFFFF");
					jq('#rStatus').text("No");
					retVal = false;
				}
			//console.log("Valor de retVal -> "+retVal);	
			return retVal;
			
			
		}
		
		//Chequea N° serie duplicados
		jq.fn.chkDup = function(){
			//alert('Entro a ChkDup');
			var bdupE = false;
			var bdupD = false;
			var bdupED = false;
			var iCantE = 0;
			var iCantD = 0;
			var aSerie = [];
			var aSerieE = [];
			var aSerieD = [];
			for(j = 0 ;j < 24 ;j++){
				if(jq('#'+aSerieCapFull[0][j]).val() !== ''){
					var sSerie = jq('#'+aSerieCapFull[0][j]).val();
					iCantE++;
					aSerie.push(sSerie);
					aSerieE.push(sSerie);
				}
			}
			for(j = 0 ;j < 24 ;j++){
				if(jq('#'+aSerieCapFull[1][j]).val() !== ''){
					var sSerie = jq('#'+aSerieCapFull[1][j]).val();
					iCantD++;
					aSerie.push(sSerie);
					aSerieD.push(sSerie);
				}
			}
			
			if(iCantE > 0 && iCantD > 0){
				for(k = 0 ;k < iCantE ;k++){
					var sSerieE = aSerie[k];
						for(j = 0 ;j < iCantD ;j++){
							var sSerieD = aSerie[iCantE+j];
							if(sSerieE == sSerieD){
								bdupED = true;
							}
						}
				}
			}
			
			obj = aSerieE.count_value();
			for(j = 0 ;j < aSerieE.length ;j++){
				for (var key in obj) {
					if(obj[key] > 1){
						for(k = 0 ;k < iCantE ;k++){
							if(key == jq('#'+aSerieCapFull[0][k]).val()){
								bdupE = true;
							}
						}
					}	
				}		
			}
			obj = aSerieD.count_value();
			for(j = 0 ;j < aSerieD.length ;j++){
				for (var key in obj) {
					if(obj[key] > 1){
						for(k = 0 ;k < iCantD ;k++){
							if(key == jq('#'+aSerieCapFull[1][k]).val()){
								bdupD = true;
							}
						}
					}
				}		
			}
			
			if(bdupE && !bdupED){
				jq('#lbrepetidoE').css("background-color","#FAE605");
				jq('#lbrepetidoE').css("color","#A605FA");
				jq('#lbrepetidoE').text("Envases Repetidos (E)");
			}
			if(bdupE && bdupED){
				jq('#lbrepetidoE').css("background-color","#FAE605");
				jq('#lbrepetidoE').css("color","#A605FA");
				jq('#lbrepetidoE').text("Envases Repetidos (E) (E-D)");
			}
			else if(!bdupE && bdupED){
				jq('#lbrepetidoE').css("background-color","#FAE605");
				jq('#lbrepetidoE').css("color","#A605FA");
				jq('#lbrepetidoE').html("Envases Repetidos (E-D)");
			}
			else if(!bdupE && !bdupED){
				jq('#lbrepetidoE').html("");
			}
			if(bdupD && !bdupED){
				jq('#lbrepetidoD').css("background-color","#FAE605");
				jq('#lbrepetidoD').css("color","#A605FA");
				jq('#lbrepetidoD').html("Envases Repetidos (D)");
			}
			else if(bdupD && bdupED){
				jq('#lbrepetidoD').css("background-color","#FAE605");
				jq('#lbrepetidoD').css("color","#A605FA");
				jq('#lbrepetidoD').html("Envases Repetidos (D) (E-D)");
			}
			else if(!bdupD && bdupED){
				jq('#lbrepetidoD').css("background-color","#FAE605");
				jq('#lbrepetidoD').css("color","#A605FA");
				jq('#lbrepetidoD').html("Envases Repetidos (E-D)");
			}
			else if(!bdupD && !bdupED){
				jq('#lbrepetidoD').html("");
			}
		
			isDup = bdupE || bdupD || bdupED;
		}
		
		
		//Limpia la grilla de entregados y devueltos
		jq.fn.cleanGrid = function(){
			if(jq('#'+aSerieCapFull[0][0]).val() !== ''){
				for(j = 0 ;j < 24 ;j ++){
					jq('#'+aSerieCapFull[0][j]).prop("disabled", true);
					jq('#'+aSerieCapFull[0][j]).css("background-color","#EFEEEE");
					jq('#'+aSerieCapFull[0][j]).css("color","#000000");
					jq('#'+aSerieCapFull[0][j]).val('');
					jq('#'+aSerieCapFull[2][j]).attr("checked", false);
					jq('#'+aSerieCapFull[2][j]).attr("disabled", true);
					jq('#'+aSerieCapFull[4][j]).text('');
					jq('#'+aSerieCapFull[6][j]).val(0);
				}
				var sCantEIni = "<pre class='lx-pre'>Enviados";
				var sCantEFin = "</pre>";
				jq('#lbcantidadE').html(sCantEIni+' - Cantidad: '+0+sCantEFin);
				jq('#cantidadE').val('0');
				jq('#lbrepetidoE').css("background-color","#92FF8A");
				jq.fn.chkDup();
				jq.fn.chkData();
			}
			
			if(jq('#'+aSerieCapFull[1][0]).val() !== ''){
				for(j = 0 ;j < 24 ;j ++){
					jq('#'+aSerieCapFull[1][j]).prop("disabled", true);
					jq('#'+aSerieCapFull[1][j]).css("background-color","#EFEEEE");
					jq('#'+aSerieCapFull[1][j]).css("color","#000000");
					jq('#'+aSerieCapFull[1][j]).val('');
					jq('#'+aSerieCapFull[3][j]).attr("checked", false);
					jq('#'+aSerieCapFull[3][j]).attr("disabled", true);
					jq('#'+aSerieCapFull[5][j]).text('');
					jq('#'+aSerieCapFull[7][j]).val(0);
				}
				var sCantDIni = "<pre class='lx-pre'>Devueltos";
				var sCantDFin = "</pre>";
				jq('#lbcantidadD').html(sCantDIni+' - Cantidad: '+0+sCantDFin);
				jq('#cantidadD').val('0');
				jq('#lbrepetidoD').css("background-color","#92FF8A");
				jq.fn.chkDup();
				jq.fn.chkData();
			}
		}	
		
		
		jq.fn.cleanMsg = function(bValue){
			console.log("Por acá...");
			if(bValue == true){
				jq('#rExiste').css("background-color","#EE2C25");
				jq('#rExiste').css("color","#FFFFFF");
				jq("#rExiste").text(stitulo);
				jq("#lblExisteRemito2").html(sdatoremito);
				jq('#msgTAB').show();
				jq("#nremito").val("");
				sRemito = jq("#nremito").val();
			}else{
				
				jq('#rExiste').css("background-color","#F5F5F5");
				jq('#rExiste').css("color","#000333");
				jq("#rExiste").text(stitulo);
				jq('#lblExisteRemito2').children().each(function (index) {				
					//jq(this).remove();
				});
			}
			switch(nradioVal) {
				//Envasado
				case 'LG':
					jq.fn.chkData();
				break;
				//Granel
				case 'GR':
					jq.fn.chkDataGR();
				break;
			}
		}
		
		
		//Event binding on dynamically created elements | Combo Cantidad Enviados
		jq("#lblRemito6").on('change','#cantidadE', function(){
		var iCantE = jq(this).val() - 1;
		var iCantEDis = 24 - iCantE;
		for(j = 0 ;j < iCantE ;j++){
			if(jq('#'+aSerieCapFull[0][j]).val() == ''){
				var sSerieVal = 'Vacio';
			}else{
				var sSerieVal = jq('#'+aSerieCapFull[0][j]).val();
			}
			if(jq('#'+aSerieCapFull[0][j]).val() == ''){
				jq('#'+aSerieCapFull[0][j]).removeAttr("disabled");
				jq('#'+aSerieCapFull[2][j]).removeAttr("disabled");
			}
				if(jq('#'+aSerieCapFull[4][j]).text() == ''){
					jq('#'+aSerieCapFull[0][j]).css("background-color","transparent");
					jq('#'+aSerieCapFull[4][j]).text(' Cap: 0');
					jq('#'+aSerieCapFull[4][j]).css("color","#EE2C25");
					jq('#'+aSerieCapFull[2][j]).attr("checked", false);
				}
			}
			for(j = iCantEDis ;j > 0 ;j--){
				jq('#'+aSerieCapFull[0][j+iCantE-1]).prop("disabled", true);
				jq('#'+aSerieCapFull[0][j+iCantE-1]).css("background-color","#EFEEEE");
				jq('#'+aSerieCapFull[0][j+iCantE-1]).css("color","#000000");
				jq('#'+aSerieCapFull[0][j+iCantE-1]).val('');
				jq('#'+aSerieCapFull[2][j+iCantE-1]).attr("checked", false);
				jq('#'+aSerieCapFull[2][j+iCantE-1]).attr("disabled", true);
				jq('#'+aSerieCapFull[4][j+iCantE-1]).text('');
				jq('#'+aSerieCapFull[6][j+iCantE-1]).val(0);
			}
			
			var sCantEIni = "<pre class='lx-pre'>Enviados";
			var sCantEFin = "</pre>";
			jq('#lbcantidadE').html(sCantEIni+' - Cantidad: '+iCantE+sCantEFin);
			jq('#cantidadE').val('0');
			jq.fn.chkDup();
			jq.fn.chkData();
		});
		
		//Event binding on dynamically created elements | Combo Cantidad Devueltos
		jq("#lblRemito6").on('change','#cantidadD', function(){
		for(j = 0 ;j < 25 ;j++){
			if(jq('#'+aSerieCapFull[1][j]).val() == ''){
				jq('#'+aSerieCapFull[1][j]).removeAttr("disabled");
				jq('#'+aSerieCapFull[3][j]).removeAttr("disabled");
			}
				if(jq('#'+aSerieCapFull[5][j]).text() == ''){
					jq('#'+aSerieCapFull[1][j]).css("background-color","transparent");
					jq('#'+aSerieCapFull[5][j]).text(' Cap: 0');
					jq('#'+aSerieCapFull[5][j]).css("color","#EE2C25");
					jq('#'+aSerieCapFull[3][j]).attr("checked", false);
				}
			}
			
			var iCantD = jq(this).val() - 1;
			var iCantDDis = 24 - iCantD;
			
			for(j = iCantDDis ;j > 0 ;j--){
				jq('#'+aSerieCapFull[1][j+iCantD-1]).prop("disabled", true);
				jq('#'+aSerieCapFull[1][j+iCantD-1]).css("background-color","#EFEEEE");
				jq('#'+aSerieCapFull[1][j+iCantD-1]).val('');
				jq('#'+aSerieCapFull[3][j+iCantD-1]).attr("checked", false);
				jq('#'+aSerieCapFull[3][j+iCantD-1]).attr("disabled", true);
				jq('#'+aSerieCapFull[5][j+iCantD-1]).text('');
				jq('#'+aSerieCapFull[7][j+iCantD-1]).val(0);
			}
			
			var sCantDIni = "<pre class='lx-pre'>Devueltos";
			var sCantDFin = "</pre>";
			jq('#lbcantidadD').html(sCantDIni+' - Cantidad: '+iCantD+sCantDFin);
			jq('#cantidadD').val('0');		
			jq.fn.chkDup();
			//jq.fn.chkRemitoExiste();
			jq.fn.chkData();
		});
		
		//Event binding on dynamically created elements | Combo Capacidad Enviados
		jq("#lblRemito6").on('change','#capacidadE', function(){
			sCap = jq(this).val();
			sCapArr = sCap.split('|');
				
			
			for(j = 0 ;j < 24 ;j++){
				if(jq('#'+aSerieCapFull[2][j]).prop('checked') == true){
					if(jq('#'+aSerieCapFull[4][j]).text() == '' || jq('#'+aSerieCapFull[4][j]).text() == ' Cap: 0'){
						jq('#'+aSerieCapFull[4][j]).text(' Cap: '+sCapArr[0]);
						jq('#'+aSerieCapFull[4][j]).css("color","#522AE9");
						jq.fn.setHiddenV(aSerieCapFull[6][j], sCapArr[0]);
					}
				}
			}
			//Combo a posición cero
			jq('#capacidadE').val('0');
			//jq.fn.chkRemitoExiste();
			jq.fn.chkData();
		});
		
		//Event binding on dynamically created elements | Combo Capacidad Devueltos
		jq("#lblRemito6").on('change','#capacidadD', function(){
			sCap = jq(this).val();
			sCapArr = sCap.split('|');
				
			for(j = 0 ;j < 24 ;j++){
				if(jq('#'+aSerieCapFull[3][j]).prop('checked') == true){
					if(jq('#'+aSerieCapFull[5][j]).text() == '' || jq('#'+aSerieCapFull[5][j]).text() == ' Cap: 0'){
						jq('#'+aSerieCapFull[5][j]).text(' Cap: '+sCapArr[0]);
						jq('#'+aSerieCapFull[5][j]).css("color","#522AE9");
						jq.fn.setHiddenV(aSerieCapFull[7][j], sCapArr[0]);
					}
				}
			}
			//Combo a posición cero
			jq('#capacidadD').val('0');
			jq.fn.chkData();
		});
		
		//Event binding on dynamically created elements | CheckBox Todos Enviados
		jq("#lblRemito6").on('click','.allCheckE', function(){
			if(jq(".allCheckE").prop("checked") == true){
				for(j = 0 ;j < 24 ;j++){
					if(jq('#'+aSerieCapFull[2][j]).prop('disabled') == false){
						jq('#'+aSerieCapFull[2][j]).prop('checked', true);
					}
				}
			}else{
				for(j = 0 ;j < 24 ;j++){
					if(jq('#'+aSerieCapFull[2][j]).prop('disabled') == false){
						jq('#'+aSerieCapFull[2][j]).prop('checked', false);
						jq('#'+aSerieCapFull[4][j]).text('');
					}
				}
			}
			//jq.fn.chkRemitoExiste();
			jq.fn.chkData();
		});		
		
		//Event binding on dynamically created elements | CheckBox Todos Devueltos
		jq("#lblRemito6").on('click','.allCheckD', function(){
			if(jq(".allCheckD").prop("checked") == true){
				for(j = 0 ;j < 24 ;j++){
					if(jq('#'+aSerieCapFull[3][j]).prop('disabled') == false){
						jq('#'+aSerieCapFull[3][j]).prop('checked', true);
					}
				}
			}else{
				for(j = 0 ;j < 24 ;j++){
					if(jq('#'+aSerieCapFull[3][j]).prop('disabled') == false){
						jq('#'+aSerieCapFull[3][j]).prop('checked', false);
						jq('#'+aSerieCapFull[5][j]).text('');
					}
				}
			}
			//jq.fn.chkRemitoExiste();
			jq.fn.chkData();
		});
		
		
		//Event binding on dynamically created elements | Combo Cliente
		jq("#lblRemito2").on('change','#cliente', function(){
			sCli = jq(this).val();
			sCliArr = sCli.split('|');
			iCliente = sCliArr[0];
			switch(nradioVal) {
				//Envasado
				case 'LG':
					jq.fn.chkData();
					jq.fn.cleanGrid();
				break;
				//Granel
				case 'GR':
					jq.fn.chkDataGR();
				break;
			}
		});
		
		//Event binding on dynamically created elements | Input text volumen
		jq("#lblRemito3").on('focusout','#vol', function(){
			bvolVal = jq.fn.chkVolumen(jq(this).val());
			if(bvolVal == true){
				jq(this).css("background-color","#92FF8A");
				jq(this).css("color","#000333");
			}else{
				jq(this).css("background-color","#EE2C25");
				jq(this).css("color","#FFFFFF");
			}
			jq.fn.chkDataGR();
		});
		
		//Event binding on dynamically created elements | Input text partida
		jq("#lblRemito4").on('focusout','#part', function(){
			bpartVal = jq.fn.chkPartida(jq(this).val());
			if(bpartVal == true){
				jq(this).css("background-color","#92FF8A");
				jq(this).css("color","#000333");
			}else{
				jq(this).css("background-color","#FAE605");
				jq(this).css("color","#000333");
			}
			jq.fn.chkDataGR();
		});
		
		//Event binding on dynamically created elements | Input text certificado
		jq("#lblRemito5").on('focusout','#cert', function(){
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
			jq.fn.chkDataGR();
		});
		
			
		//Event binding on dynamically created elements | Combo Cliente
		jq("#lblRemito6").on('change','#tanque', function(){
			//console.log("Pasa por change del tanque");
			jq.fn.chkDataGR();
			
		});	
		
		
		jq("#nremito").focusout('input', function(){
			
			sRemito = jq(this).val();
			//var envOpcion = jq(".env:checked").val();
			chkRemitoExisteUno(sRemito, function(data) {
				jq('#lblRemito').children().each(function (index) {
				jq(this).remove();
				});
				jq('#lblRemito2').children().each(function (index) {
					jq(this).remove();
				});
				jq('#lblRemito3').children().each(function (index) {
					jq(this).remove();
				});
				jq('#lblRemito4').children().each(function (index) {
					jq(this).remove();
				});
				jq('#lblRemito5').children().each(function (index) {
					jq(this).remove();
				});
				jq('#lblRemito6').children().each(function (index) {
					jq(this).remove();
				});
				jq('#tabla1').children().each(function (index) {
					jq(this).remove();
				});
				jq('#lblExisteRemito').children().each(function (index) {
					jq(this).remove();
				});
				jq('#lblExisteRemito2').children().each(function (index) {
					jq(this).remove();
				});
								
				
				jq('#rows').remove();
				
				var len = data.length;
				for(var i=0; i<len; i++){
					bRemitoIngresado = data[i].header10;
					var scolmod0 = data[i].header7;
					var scolmod1 = data[i].header8;
					jq("#lblExisteRemito").removeClass();
					jq("#lblExisteRemito").addClass(scolmod0);
					jq("#lblExisteRemito2").removeClass();
					jq("#lblExisteRemito2").addClass(scolmod1);
					if(bRemitoIngresado == true){
						var sMsgUno = data[i].header1;
						var sMSGDos = data[i].header2;
						var sLblUno = "<label id='uno'><pre class='lx-pre'></pre></label></br>";
						var sLblDos = "<label id='dos'><pre class='lx-pre'></pre></label></br>";
						jq("#lblExisteRemito").append(sLblUno);
						jq("#uno pre").attr('id', 'msgUNO');
						jq("#lblExisteRemito").append(sLblDos);
						jq("#dos pre").attr('id', 'msgDOS');
						jq('#msgUNO').css("background-color","#EE2C25");
						jq('#msgUNO').css("color","#FFFFFF");
						jq("#msgUNO").text(sMsgUno);
						jq('#msgDOS').css("background-color","#E8F7AC");
						jq('#msgDOS').css("color","#000333");
						jq("#msgDOS").text(sMSGDos);
						jq("#msgTAB").hide();
						jq("#nremito").val("");
					}else{
						stitUno = data[i].header1;
						sMsgUno = data[i].header2;
						oProOpt = data[i].header3;
						stitDos = data[i].header4;
						sMSGDos = data[i].header5;
						sMSGTre = data[i].header6;
						var sLblUno = "<label><pre class='lx-pre'>"+stitUno+"</pre></label></br>";
						var sLblDos = "<label id='uno'><pre class='lx-pre'></pre></label></br>";
						var sLblTre = oProOpt;
						var sLblCua = "<label><pre class='lx-pre'>"+stitDos+"</pre></label></br>";
						var sLblCin = "<label id='dos'><pre class='lx-pre'></pre></label></br>";
						var sLblSei = "<label id='tre'><pre class='lx-pre'></pre></label></br>";
						jq("#lblExisteRemito").append(sLblUno+sLblDos+sLblTre);
						jq("#uno pre").attr('id', 'msgOPT');
						jq("#lblExisteRemito2").append(sLblCua+sLblCin+sLblSei);
						jq("#dos pre").attr('id', 'msgLBL');
						jq("#tre pre").attr('id', 'rStatus');
						jq('#msgOPT').css("background-color","#B8D4FE");
						jq('#msgOPT').css("color","#000333");
						jq("#msgOPT").text(sMsgUno);
						jq('#msgLBL').css("background-color","#B8D4FE");
						jq('#msgLBL').css("color","#000333");
						jq("#msgLBL").text(sMSGDos);
						jq('#rStatus').css("background-color","#EE2C25");
						jq('#rStatus').css("color","#FFFFFF");
						jq("#rStatus").text(sMSGTre);
						jq("#msgTAB").show();
						
					}
				}	
			});
		});	
		
		
					
		
		jq('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
			switch(nradioVal) {
				//Con Envase
				case 'LG':
					var returnValue = jq.fn.chkData();
					jq.fn.chkDup();
					var sconfirmsg = '';
					if(devBool == false){
						sconfirmsg = "Va a dar de alta un remito con entregas solamente. Es correcto?";
					}else if(envBool == false){
						sconfirmsg = "Va a dar de alta un remito con devoluciones solamente. Es correcto?";
					}
					
					if(envBool == false && returnValue == true || devBool == false && returnValue == true){
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
								chkRemitoExisteNIR(sRemito, function(data) { // data = the JSON retrieved
									var len = data.length;
									for(var i=0; i<len; i++){
										bRemitoIngresado = data[i].header3;
										if(bRemitoIngresado == false){
											currentForm.submit();
										}else{
											stitulo = data[i].header1;
											sdatoremito = data[i].header2;
											jq.fn.cleanMsg(bRemitoIngresado);
										}
									}	
								});
							}
						}
						});
					}else if(envBool == true && devBool == true && returnValue == true){
						chkRemitoExisteNIR(sRemito, function(data) { // data = the JSON retrieved
							var len = data.length;
							for(var i=0; i<len; i++){
								bRemitoIngresado = data[i].header3;
								if(bRemitoIngresado == false){
									currentForm.submit();
								}else{
									stitulo = data[i].header1;
									sdatoremito = data[i].header2;
									jq.fn.cleanMsg(bRemitoIngresado);
								}
							}	
						});
					}
				break;
				//Granel
				case 'GR':
					var returnValue = jq.fn.chkDataGR();
					if(returnValue == true){
						chkRemitoExisteNIR(sRemito, function(data) { // data = the JSON retrieved
							var len = data.length;
							for(var i=0; i<len; i++){
								bRemitoIngresado = data[i].header3;
								if(bRemitoIngresado == false){
									currentForm.submit();
								}else{
									stitulo = data[i].header1;
									sdatoremito = data[i].header2;
									jq.fn.cleanMsg(bRemitoIngresado);
								}
							}	
						});
					}
				break;
			}
			
			
			
			
			
		});
		
		
		
});
</script>	



	</form>
</body>


