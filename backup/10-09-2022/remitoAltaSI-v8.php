<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="remitoAltaSI-v8.php" id="frm" >
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e3.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Alta Remito SI</h4></div>
                </div>
            </div>
            

			
			<div class="row">
				<div class="col-md-3">
					<label><pre class="lx-pre">Próximo Número de Remito</pre></label></br>
					<label><pre class="lx-pre" id="msgTAB">Presione TAB</pre></label></br>
					<pre class="lx-pre"><input type="text" name="nremito" id="nremito" class="form-control input-sm" maxlength="6" required value="<?php $nremito; ?>" /></pre>
				</div>
				<div class="col-md-5" id="lblExisteRemito">
				</div>	
				<div class="col-md-4" id="lblExisteRemito2">
				</div>
				<div class="col-md-4" id="lblExisteRemito3">
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
			$productoid = isset($_POST['producto']) ? $_POST['producto'] : false;;
			$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;;
			$tipoenv = isset($_POST['envH']) ? $_POST['envH'] : null;
			$propiedad = isset($_POST['prop']) ? $_POST['prop'] : null;
			
			$message = '';
			$nombreusu = '';
			
			//echo "<pre>";
			//echo print_r($_POST)."</br>";
			//echo "</pre>";
			
			
			//$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			//if($otipoProducto && $otipoProducto == 'LG' && validaSerie($nremito)){
			if($propiedad && $tipoenv && validaSerie($nremito)){
				$envS = 0;
				$devS = 0;
				$ecapH = 0;
				$dcapH = 0;
				
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
				$tipoenvase = isset($_POST['envH']) ? $_POST['envH'] : false;
				$productoid = explode("|",$_POST['producto']);
				$idusuario=isset($_SESSION['idusuario'])? $_SESSION['idusuario']:"";
				$tipoRemito = 'RSUBI';
				$res = $DB->prInsertarCSVv7($fecha,$nremito,$clienteid[1],$productoid[0],$productoid[1],$seriesCSV,$prop,$tipoenvase,$clienteid[0],$tipoRemito,$idusuario);
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
					<div class="col-md-12">
					<table class="table table-bordered" id="tabla1">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Remito</th>
								<th>Cliente</th>
								<th>Producto</th>
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
							if(isset($row->existeremito)){
								$existeremito = $row->existeremito;
							}
							if(isset($row->nombreusu)){
								$nombreusu = $row->nombreusu;
							}
							switch ($existeremito) {
								case 0:
									$claseFondo = "";
									$nombreusu = "";
									break;
								default:
									$claseFondo = "danger";
									break;
							}
							
						?>
							<tbody>
								<tr class="<?php echo $claseFondo;?>">
									<td><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
									<td><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
									<td><?php if(isset($row->id_xl) && isset($row->cliente)){echo '('.$row->id_xl.') '.$row->cliente;}else{echo "Error";}?></td>
									<td><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
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
	function setSerie(sProducto, sSerie, sClie, sProp, sTipo, callbackFn) {
		jq.ajax({
			url:"./ajaxConsultaSerie-v3.php",
			dataType: "json",
			data: {"sProducto": sProducto, "sSerie": sSerie, "sClie": sClie, "sProp": sProp, "sTipo": sTipo },
			type:"POST",
			success:function(response){
				callbackFn(response);
			}
		})
	}
	
	//Defino la función llamada setCapacidad
	function setCapacidad(iProducto, sTipo, callbackFn) {
		jq.ajax({
			url:"./ajaxConsultaTipoEnvase-v2.php",
			dataType: "json",
			data: {"iProducto": iProducto, "sTipo": sTipo},
			type:"POST",
			success:function(response){
				callbackFn(response);
			}
		});
	}
	
	
	//Chequea si ya existe el remito - usuarios concurrentes - al salir del input nremito
	function chkRemitoExiste(sRemito, sTipo, callbackFn){
		if(sRemito.trim() !== ''){
			jq.ajax({
				url:"./ajaxConsultaRemitoSI-v8.php",
				dataType: "json",
				data: {"nremito": sRemito, "tipoOpcion": sTipo},
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
				url:"./ajaxConsultaRemito-v8.php",
				dataType: "json",
				data: {"nremito": sRemito},
				type:"POST",
				success:function(response){
					callbackFn(response);
				}					
			})
		}
	}
	
	//Trae próximo Número de remito
	function getNumeroRemito(callbackFn){
		jq.ajax({
			url:"./ajaxGetNumeroRemito-v2.php",
			dataType: "json",
			type:"POST",
			success:function(response){
				callbackFn(response);
			}					
		})
	}
	
		
	var jq = jQuery.noConflict();
	//jQuery.noConflict();
	jq(document).ready(function(){
		
		var aSerieCap = [];
		var aSerieCapFull = [];
		
		//jq("#nremito").focus();
		
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
		
		getNumeroRemito(function(data){
			var len = data.length;
			for(var i=0; i<len; i++){
				sNumeroRemito = data[i].header1;
			}
			jq('#nremito').css("background-color","#92FF8A");
			jq('#nremito').css("color","#000333");
			jq('#nremito').val(sNumeroRemito);
			//console.log("Valor de sNumeroRemito ->"+sNumeroRemito);
		});
			
		jq("#nremito").focus();
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
		var iProducto = 0;
		
		var envBool = false;
		var devBool = false;
		
		var bGranel = false;
		
		jq('#msgTAB').css("background-color","#B8D4FE");
		jq('#msgTAB').css("color","#000333");
		var smsgTAB = "Ingrese Remito y presione TAB";
		
		
		var message = '<?php echo $message; ?>';
		var nombreusu = '<?php echo $nombreusu; ?>';
		
		if(nombreusu !== ''){
			jq('#rows').html(message+'. (Usuario: '+nombreusu+')');
		}else{
			jq('#rows').html(message);
		}
		
		
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
		
		
		
		//Verifica si existe remito - si no existe genera formulario Envasado
		jq.fn.inputradioProducto = function(){
			//var envOpcion = jq(".env:checked").val();
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
			
			jq('#lblExisteRemito3').children().each(function (index) {
				jq(this).remove();
			});
			
			jq('#rows').remove();
			
			chkRemitoExiste(sRemito, nradioVal, function(data) { // data = the JSON retrieved
				var len = data.length;
				//console.log("Valor de sTitulo ->"+stitulo);
				for(var i=0; i<len; i++){
					bRemitoIngresado = data[i].header13;
					var scolmod0 = data[i].header7;
					var scolmod1 = data[i].headerD;
					var scolmod2 = data[i].headerE;
					jq("#lblExisteRemito").removeClass();
					jq("#lblExisteRemito").addClass(scolmod0);
					jq("#lblExisteRemito2").removeClass();
					jq("#lblExisteRemito2").addClass(scolmod1);
					jq("#lblExisteRemito3").removeClass();
					jq("#lblExisteRemito3").addClass(scolmod2);
					
					
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
						//jq("#nremito").val("");
						getNumeroRemito(function(data){
							var lenU = data.length;
							for(var i=0; i<lenU; i++){
								sNumeroRemito = data[i].header1;
							}
						});
						jq('#nremito').val(sNumeroRemito);
						jq("#nremito").focus();
					}else{
						var stitDos = data[i].header51;
						var sMSGDos = data[i].header52;
						var oProCmb = data[i].header53;
						
						
						
						
						//var stitDos = data[i].headerA;
						//var sMSGDos = data[i].headerB;
						//var sMSGTre = data[i].headerC;
						
						var stitTre = data[i].headerA;
						var sMSGTre = data[i].headerB;
						var sMSGCua = data[i].headerC;
						
						
						
						var sLblDos = "<label id='uno'><pre class='lx-pre'></pre></label></br>";
						//var sLblCua = "<label><pre class='lx-pre'>"+stitDos+"</pre></label></br>";
						//var sLblCin = "<label id='dos'><pre class='lx-pre'></pre></label></br>";
						//var sLblSei = "<label id='tre'><pre class='lx-pre'></pre></label></br>";
						var sLblCua = "<label><pre class='lx-pre'>"+stitDos+"</pre></label></br>";
						var sLblCin = "<label id='dos'><pre class='lx-pre'></pre></label></br>";
						var sLblSei = oProCmb;
						var sLblSie = "<label><pre class='lx-pre'>"+stitTre+"</pre></label></br>";
						var sLblOch = "<label id='cua'><pre class='lx-pre'></pre></label></br>";
						var sLblNue = "<label id='cin'><pre class='lx-pre'></pre></label></br>";
						
						jq("#lblExisteRemito2").append(sLblCua+sLblCin+sLblSei);
						jq("#dos pre").attr('id', 'msgCMB');
						
						//jq("#uno pre").attr('id', 'msgOPT');
						jq("#lblExisteRemito3").append(sLblSie+sLblOch+sLblNue);
						jq("#cua pre").attr('id', 'msgLBL');
						jq("#cin pre").attr('id', 'rStatus');
						jq('#msgOPT').css("background-color","#B8D4FE");
						jq('#msgOPT').css("color","#000333");
						jq('#msgCMB').css("background-color","#B8D4FE");
						jq('#msgCMB').css("color","#000333");
						jq("#msgCMB").text(sMSGDos);
						jq('#msgLBL').css("background-color","#B8D4FE");
						jq('#msgLBL').css("color","#000333");
						jq("#msgLBL").text(sMSGTre);
						jq('#rStatus').css("background-color","#EE2C25");
						jq('#rStatus').css("color","#FFFFFF");
						jq("#rStatus").text(sMSGCua);
						jq("#msgTAB").show();
						
						
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
					
					
					if(iProducto !== 0){
						sProducto = iProducto;
					}else{
						return false;
					}
					
					setSerie(sProducto, sSerie, sClie, sProp, sTipo, function(data){// data = the JSON retrieved
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
			
			var senvH ="envH"; 
			jq.fn.setHiddenV(senvH, sTipo);
			
			setCapacidad(iProducto, sTipo, function(data){// data = the JSON retrieved
				var len = data.length;
				for(var i=0; i<len; i++){
					var header1 = data[i].header1;
					jq("#capacidadE").html(header1);
					jq("#capacidadD").html(header1);
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
			
			if(iProducto == '0'){
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
			if(bValue == true){
				jq('#rExiste').css("background-color","#EE2C25");
				jq('#rExiste').css("color","#FFFFFF");
				jq("#rExiste").text(stitulo);
				jq("#lblExisteRemito2").html(sdatoremito);
				jq('#msgTAB').show();
				//jq("#nremito").val("");
				sRemito = jq("#nremito").val();
			}else{
				
				jq('#rExiste').css("background-color","#F5F5F5");
				jq('#rExiste').css("color","#000333");
				jq("#rExiste").text(stitulo);
				jq('#lblExisteRemito').children().each(function (index) {				
					jq(this).remove();
				});
			}
			jq.fn.chkData();
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
			jq.fn.chkData();
			jq.fn.cleanGrid();
		});
		
		//Event binding on dynamically created elements | Combo Producto
		jq("#lblExisteRemito2").on('change','#producto', function(){
			//console.log("Por acá combo producto...");
			sPro = jq(this).val();
			sProArr = sPro.split('|');
			iProducto = sProArr[0];
			jq.fn.chkData();
			jq.fn.cleanGrid();
				switch(iProducto) {
					//Oxígeno
					case '1':
						var senvH ="envH"; 
						jq.fn.setHiddenV(senvH, sTipo);
						jq("input:radio[name=env]").attr("disabled",false);
					break;
					
					default:
						var senvH ="envH"; 
						jq.fn.setHiddenV(senvH, "CIL");
						jq("input:radio[name=env]").attr("disabled",true);
					break;
				}
				
			setCapacidad(iProducto, sTipo, function(data){// data = the JSON retrieved
				var len = data.length;
				for(var i=0; i<len; i++){
					var header1 = data[i].header1;
					jq("#capacidadE").html(header1);
					jq("#capacidadD").html(header1);
				}
			});
		});
		
		jq("#nremito").focusout('input', function(){
			
			sRemito = jq(this).val();
			jq.fn.inputradioProducto();
			
		});	
		
					
		
		jq('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
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
								currentForm.submit();
							}
						}
						});
					}else if(envBool == true && devBool == true && returnValue == true){
						currentForm.submit();
					}
			
			
		});
		
		
		
});
</script>	



	</form>
</body>


