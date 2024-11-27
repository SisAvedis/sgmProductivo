<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="envasesLote-v2.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Envases por Lote - Lotes por Fecha</h4></div>
                </div>
            </div>
            
			<div class="row">
				<div class="col-md-4 table-responsive">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center info" id="exl">Envases x Lote<pre class="lx-pre" id="lblexl"></pre></label></th>
							<th class="text-center info" colspan=2 id="lxf">Lotes x Fecha<pre class="lx-pre" id="lbllxf"></pre></label></th>
						</tr>
						<tr>
							<th class="text-center" rowspan=3>Número Lote</th>
							<th class="text-center" colspan=2>Tipo Envase</th>
							<input type="hidden" name="tipoinf"/>
						</tr>
						<tr>
							<th class="text-center">CIL</th><th class="text-center">TER</th>
						</tr>
						<tr id="tipoenvase">
							<th class="text-center"><input type="radio" class="tipoenvase" checked="checked" name="tipoenv" value=1 required /></th> 
							<th class="text-center"><input type="radio" class="tipoenvase" name="tipoenv" value=2 required /></th>							
						</tr>
						<tr>
							<th><input type="text" name="nlote" id="nlote" class="form-control input-sm" maxlength="6" autocomplete="off" required value="<?php $nlote; ?>" /></th>
							<th class="text-center" colspan=2><input type="text" name="fecha" id="datepicker" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
						</tr>
						
					</thead>
				</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<label><pre class="lx-pre" id="lblMsgInformacion">Seleccione el informe haciendo click en la celda deseada (color celeste)</pre></label></br>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<label><pre class="lx-pre" id="lblMsgTipoInforme">Informe Seleccionado: Envases x Lotes</pre></label></br>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12 pull-right">
					<hr>
					<button type="submit" id="consultar" class="btn btn-sm btn-danger">Consultar</button>
					<hr>
				</div>
			</div>
			
			
			<?php
			
			$tipoInf = isset($_POST['tipoinf']) ? $_POST['tipoinf'] : null;
			
			if($tipoInf){
				$tipoInf = $_POST['tipoinf'];
			}else{
				$tipoInf = 0;
			}
			
			//echo "<pre>";
			//echo $tipoInf."</br>";
			//echo "</pre>";
			
			$tipoenv = 0;

			$FechaLote = '';
			$message = '';
			if($tipoInf == 0){
				$nlote = isset($_POST['nlote']) ? $_POST['nlote'] : false;
				if ($_SERVER['REQUEST_METHOD'] == 'POST'){
					if(validaLote($nlote)){
						$DB= new Database();
						$nlote = $DB->sanitize($_POST['nlote']);
						$res = $DB->prEnvasesLotev1($nlote);
						$row_cnt = mysqli_num_rows($res);
						
						if ($row_cnt == 0){
							$message= "No se obtuvieron movimientos para el Número de Lote ".$nlote;
							$class="alert alert-info";
						}elseif ($row_cnt == 1){
							$message= "Se obtuvo ".$row_cnt." movimiento para el Número de Lote ".$nlote;
							$class="alert alert-success";
						}else{
							$message= "Se obtuvieron ".$row_cnt." movimientos para el Número de Lote ".$nlote;
							$class="alert alert-success";
						}
				?>
				<div class="<?php echo $class?>" id="rows">
					<?php echo $message;?>
				</div>
				<?php
				if ($row_cnt == 0){
				}else{
					$iCantRows = 1;
					?>	
				<div class="row">
					<div class="col-md-9">
					<table class="table table-bordered" id="tabla1">
						<thead>
							<tr>
								<th>N° Serie</th>
								<th class="text-right">Volumen</th>
								<th class="text-center">Propiedad</th>
								<th>Cliente</th>
								<th class="text-center">Fecha Rto Clie</th>
								<th class="text-center">Rto Avedis</th>
								<th class="text-center">Rto Cliente</th>
								<th class="text-center">Fecha Rto Avedis</th>
							</tr>
						</thead>
			<?php 
					while ($row=mysqli_fetch_object($res)){
						if ($iCantRows == 1){
							if(isset($row->ExLSerie)){
								$FechaLote = $row->LoteFechaInicio;
								$FechaLote = date_format(date_create($FechaLote),"d-m-Y");
							}else{
								$FechaLote = "Error";
							}
						}
					?>
						<tbody>
							<tr>
								<td><?php if(isset($row->ExLSerie)){echo $row->ExLSerie;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->ExLCapacidad)){echo $row->ExLCapacidad;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->ExLPropiedad)){echo $row->ExLPropiedad;}else{echo "Error";}?></td>
								<td><?php if(isset($row->ExLCliente)){echo $row->ExLCliente;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->ExLFecha)){echo $row->ExLFecha;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->ExLRemito)){echo $row->ExLRemito;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->ExLRemitoSH)){echo $row->ExLRemitoSH;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->ExLFechaSH)){if($row->ExLFechaSH !== ''){echo date_format(date_create($row->ExLFechaSH),"d-m-Y");}}else{echo "Error";}?></td>
							</tr>				
						</tbody>	
						<?php
							}
							$res = $DB->closePR();
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
						}
			//Lotes x Fecha		
			}else if($tipoInf == 1){
				$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
				$fecha = date("Y-m-d", strtotime($_POST['fecha']));
				if ($_SERVER['REQUEST_METHOD'] == 'POST'){
					if($tipoenv){
						//include ("database_e.php");
						$DB= new Database();
						if ($tipoenv == 1){ 
							$tenv = 'GOX';
						}elseif ($tipoenv == 2){
							$tenv = 'LOX';
						}
						
						$res = $DB->prLotesFechav1($fecha,$tenv);
						$fecha = date_format(date_create($fecha),"d-m-Y");
						$row_cnt = mysqli_num_rows($res);
						
						if ($row_cnt == 0){
							$message= "No se obtuvieron movimientos para la fecha ".$fecha;
							$class="alert alert-info";
						}elseif ($row_cnt == 1){
							$message= "Se obtuvo ".$row_cnt." movimiento para la fecha ".$fecha;
							$class="alert alert-success";
						}else{
							$message= "Se obtuvieron ".$row_cnt." movimientos para la fecha ".$fecha;
							$class="alert alert-success";
						}
				?>
				<div class="<?php echo $class?>" id="rows">
					<?php echo $message;?>
				</div>
				<?php
				if ($row_cnt == 0){
				}else{
					$iCantRows = 1;
					?>	
				<div class="row">
					<div class="col-md-5">
					<table class="table table-bordered" id="tabla1">
						<thead>
							<tr>
								<th class="text-center">Fecha</th>
								<th class="text-center">Partida</th>
								<th class="text-center">Envase</th>
								<th class="text-center">Lote</th>
							</tr>
						</thead>
			<?php 
					while ($row=mysqli_fetch_object($res)){
					?>
						<tbody>
							<tr>
								<td class="text-center"><?php if(isset($row->LoteFechaInicio)){if($row->LoteFechaInicio !== ''){echo date_format(date_create($row->LoteFechaInicio),"d-m-Y");}}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->LotePartida)){echo $row->LotePartida;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->LoteGas)){echo $row->LoteGas;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->Loteid)){echo $row->Loteid;}else{echo "Error";}?></td>
							</tr>				
						</tbody>	
						<?php
							}
							$res = $DB->closePR();
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
						}
			}
					?>
		   
		   <?php
		   } catch (Error $e) {
				$message= "Error: ". $e->getMessage();
				$class="alert alert-danger";
			?>
			<div class="<?php echo $class;?>" id="rows">
				  <?php echo $message;?>
			</div>
			<?php
		   }
		   ?>
			
        </div>
    </div>     

<script type="text/javascript">

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
		
	var jq = jQuery.noConflict();
	jq(document).ready(function(){
		
		var lblMsgInfoCIL = "Informe Seleccionado: Lotes x Fecha (CIL)";
		var lblMsgInfoTER = "Informe Seleccionado: Lotes x Fecha (TER)";
		var lblMsgInfoLxF = "Informe Seleccionado: Envases x Lote";
		var isDate = 0;
		var sLote = '';
		var itipoinf =  '<?php echo $tipoInf; ?>';
		var itipoenv =  '<?php echo $tipoenv; ?>';
		var bResnLote;
		
		var bkeyPressednLote = false;
		var bkeyPressedsDate = false;
		
		jq('#nlote').focus();
		
		
		jq.fn.chkPattern = function(sLote){
			var pattern = new RegExp('^[0-9]{4}$|^[0-9]{5}$');
			if (pattern.test(sLote)) {
				jq('#nlote').css("background-color","#92FF8A");
				jq('#nlote').css("color","#A605FA");
				bResnLote = true;
			}else{
				if(jq('#nlote').val() !== ''){
					jq('#nlote').css("background-color","#FAE605");
					jq('#nlote').css("color","#A605FA");
					jq("#nlote").focus();
				}
				bResnLote = false;
			}
		}
		
		
		//Prepara Opción Envases x Lote
		jq.fn.setExL = function(){
			jq('#nlote').removeAttr("disabled");
			jq('#lblexl').css("background-color","#92FF8A");
			jq('#datepicker').val('');
			jq('#datepicker').prop("disabled", true);
			jq('#datepicker').css("background-color","#F5F5F5");
			jq('.tipoenvase').prop("disabled", true);	
			jq('#lbllxf').css("background-color","#FAE605");
			jq('#lblMsgTipoInforme').css("background-color","#92FF8A");
			jq('#lblMsgTipoInforme').css("color","#140CC5");
			jq('#lblMsgTipoInforme').text(lblMsgInfoLxF);
			jq('input[name="tipoinf"]').val(0);
			itipoinf = jq('input[name="tipoinf"]').val();
			var iRes = jq.fn.chkData(itipoinf);
			jq('#nlote').focus();
		}
		
		//Prepara Opción Lotes x Fecha
		jq.fn.setLxF = function(){
			jq('#nlote').css("background-color","#FFFFFF");
			jq('#nlote').css("color","#000000");
			jq('#nlote').prop("disabled", true);
			jq('#lblexl').css("background-color","#FAE605");
			jq('#nlote').val('');
			jq('#datepicker').removeAttr("disabled");
			jq('.tipoenvase').removeAttr("disabled");
			jq('#lbllxf').css("background-color","#92FF8A");
			jq('#lblMsgTipoInforme').css("background-color","#92FF8A");
			jq('#lblMsgTipoInforme').css("color","#140CC5");
			if(jq("input:radio[name=tipoenv][value=1]").prop('checked') == true){
				jq('#lblMsgTipoInforme').text(lblMsgInfoCIL);
			}else if(jq("input:radio[name=tipoenv][value=2]").prop('checked') == true){
				jq('#lblMsgTipoInforme').text(lblMsgInfoTER);
			}
			jq('input[name="tipoinf"]').val(1);
			itipoinf = jq('input[name="tipoinf"]').val();
			var iRes = jq.fn.chkData(itipoinf);
		}
		
		//Chequea formulario
		jq.fn.chkData = function(iValue){
			var retVal;
			var aData = [];
			switch(iValue) {
				case '0':
					if(bResnLote == true){
						aData.push(true);
					}else{
						aData.push(false);
					}
					break;
				case '1':
					if(isDate == 1){
						aData.push(true);
					}else{
						aData.push(false);
					}
					break;
			}
			var bVal = true;
			for(j = 0 ;j < aData.length ;j++){
				bVal = bVal && aData[j];
			}
			
			if(bVal){
				retVal = true; 
				}else{
					retVal = false;
				}
			
			return retVal;
		}

		
		if(itipoinf == 0){
			var fechalote = '<?php echo $FechaLote; ?>';
			var message = '<?php echo $message; ?>';
			if (fechalote !== ''){
				jq('#rows').html(message+'. ('+fechalote+')');
			}else{
				jq('#rows').html(message);
			}
			jq.fn.setExL();
		}else{
			if(itipoenv == 1){
				jq("input:radio[name=tipoenv][value=1]").prop('checked', true);
			}else{
				jq("input:radio[name=tipoenv][value=2]").prop('checked', true);
			}
			jq.fn.setLxF();
			
		}
		
		
		jq('#lblMsgInformacion').css("background-color","#B8D4FE");
		jq('#lblMsgInformacion').css("color","#000333");
	
		jq("#exl").click(function () {
			jq.fn.setExL();
		});
		
		jq("#lxf").click(function () {
			jq.fn.setLxF();
		});

		jq("#tipoenvase").on('click','.tipoenvase', function(){
			jq('#lblMsgTipoInforme').css("background-color","#92FF8A");
			jq('#lblMsgTipoInforme').css("color","#140CC5");
			if(jq("input:radio[name=tipoenv][value=1]").prop('checked') == true){
				jq('#lblMsgTipoInforme').text(lblMsgInfoCIL);
			}else if(jq("input:radio[name=tipoenv][value=2]").prop('checked') == true){
				jq('#lblMsgTipoInforme').text(lblMsgInfoTER);
			}
		});


		jq("#datepicker").focusout('input', function(){
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
								jq('#datepicker').css("color","#000333");
							}
						}
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
								jq('#datepicker').css("color","#000333");
							}
						}
					});
				});
			jq('#consultar').focus();
		});
		
		jq("#nlote").focusout('input', function(){
			sLote = jq(this).val();
			jq.fn.chkPattern(sLote);
		});
		
		jq("#datepicker").datepicker({
			dateFormat: "dd-mm-yy"
		});
		
		jq('#nlote').keypress(function(e) {
			sLote = jq(this).val();
			//console.log("Valor de bResnLote -> 	"+bResnLote);
			if(e.which == 13) {
				jq.fn.chkPattern(sLote);
				var returnValue = jq.fn.chkData(itipoinf);
				bkeyPressednLote = true;
				if(bResnLote == true && returnValue == true){
					jq('#frm').submit();
				}
			}
		});
		
		jq('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
			//console.log("Valor de bResnLote -> 	"+bResnLote+" | - | Valor de bkeyPressednLote -> "+bkeyPressednLote+" | - | Valor de bkeyPressedsDate -> "+bkeyPressedsDate);
			if(bResnLote == true && bkeyPressednLote == false || bkeyPressednLote == false && isDate == 1){
				currentForm.submit();
			}
			bkeyPressednLote = false;
		});
		
		jq('#datepicker').keypress(function(e) {
			//sDP = jq(this).val();
			
			sLote = '';
			bkeyPressednLote = false;
			if(e.which == 13) {
				bkeyPressedsDate = true;
				//jq.fn.chkPattern(sDP);
				//var returnValue = jq.fn.chkData(itipoinf);
				//if(bResnLote == true){
					//jq('#frm').submit();
				//}
			}
		});

		
});
</script>
		
		
	



	</form>
	</body>
</html>