<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="partida-v1.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Partidas - Certificados</h4></div>
                </div>
            </div>
			
			<?php
				$nradio = isset($_POST['abmOpcion']) ? $_POST['abmOpcion'] : false;;
				$iRegistro = isset($_POST['iregistro']) ? $_POST['iregistro'] : false;;
				$iclaves = $iRegistro * 4;
			?>
			
			
			<div class="row">
				<div class="col-md-1">
				<table class="table table-bordered" id="tabla">
					<thead>
						<tr>
							<th class="text-center" colspan=3>Consultar</th>
							<th class="text-center">Completar</th>
						</tr>
						<tr>
							<th>Completos</th>
							<th>Incompletos</th>
							<th>Todos</th>
							<th>Incompletos</th>
						</tr>
						<tr>
							<td class="text-center"><input type="radio" class="abmOpcion" name="abmOpcion" value="C" required <?php //echo ($nradio=='C')?'checked':'' ?> /></td>
							<td class="text-center"><input type="radio" class="abmOpcion" name="abmOpcion" value="I" required <?php //echo ($nradio=='I')?'checked':'' ?> /></td>
							<td class="text-center"><input type="radio" class="abmOpcion" name="abmOpcion" value="T" required <?php //echo ($nradio=='T')?'checked':'' ?> /></td>
							<td class="text-center"><input type="radio" class="abmOpcion" name="abmOpcion" value="K" required <?php //echo ($nradio=='K')?'checked':'' ?> /></td>
							
							
						</tr>
					</thead>
				</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-5">
					<label><pre class="lx-pre" id="lblMsgInformacion">Consulta | Completa Trazabilidad Producto Granel</pre></label></br>
				</div>
			</div>
			
			
			<div class="row">	
				<div class="col-md-8" id="lblPartida1">
				</div>
			</div>
			
			
			<div class="row">	
				<!--<div class="col-md-12 pull-right">-->
				<div class="col-md-12">
					<!--<hr>-->
					<button type="submit" id="consultar" class="btn btn-sm btn-danger">Consultar</button>
					<!--<hr>-->
				</div>
			</div>	
		</div>
			
			
			<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($nradio){
					
					$DB= new Database();
					if($nradio == "K"){
						
						$seriesCSV = '';
						foreach ($_POST as $clave=>$valor){
							if(substr($clave,0,3) == "REH"){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
							}
							if(substr($clave,0,3) == "PAR" ){
								if(trim($valor) <> ''){
									$seriesCSV = $seriesCSV.$valor.$clave.",";
								}
							}
							if(substr($clave,0,3) == "CER"){
								if(trim($valor) <> ''){
									$seriesCSV = $seriesCSV.$valor.$clave.",";
								}
							}
							if(substr($clave,0,3) == "MOH"){
								if(trim($valor) <> ''){
									$seriesCSV = $seriesCSV.$valor.$clave.",";
								}
							}
						}
						
						$seriesCSV = substr($seriesCSV,0,strlen($seriesCSV)-1);
						//echo "<pre>";
						//echo $seriesCSV."</br>";
						//echo "</pre>";
						
						$res = $DB->prActualizaPCTv1($seriesCSV);
						
						switch ($nradio) {
							case "C":
								$sMsg = "Consultar -> Completos";
								break;
							case "I":
								$sMsg = "Consultar -> Incompletos";
								break;
							case "T":
								$sMsg = "Consultar -> Todos";
								break;
							case "K":
								$sMsg = "Completar -> Incompletos";
								break;
						}
								
						
						$row_cnt = mysqli_num_rows($res);
						if(!empty($res)){
						$row_cnt = mysqli_num_rows($res);
						if ($row_cnt == 0){
							$class="alert alert-info";
							$message= "No se obtuvieron movimientos para la opción solicitada. (".$sMsg.")";
						}elseif ($row_cnt == 1){
							$class="alert alert-success";
							$message= "Se obtuvo 1 movimiento para la opción solicitada. (".$sMsg.")";
						}else{
							$class="alert alert-success";
							$message= "Se obtuvieron ".$row_cnt." movimientos para la opción solicitada. (".$sMsg.")";
						}
						?>
			
						<div class="<?php echo $class?>" id="rows">
							<?php echo $message;?>
						</div>
						<?php
						if ($row_cnt == 0){
						}else{
							?>	
						<div class="row">
							<div class="col-md-6">
							<table class="table table-bordered" id="tabla1">
								<thead>
									<tr>
										<th>Remito</th>
										<th>Partida</th>
										<th>Certificado</th>
										<th>Tanque Destino</th>
									</tr>
								</thead>
						<?php 
						while ($row=mysqli_fetch_object($res)){
						?>
							<tbody>
								<tr>
									<td><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
									<?php
										if($row->bpartida == 1){
											$claseTh = "success";
										}else{
											$claseTh = "";
										}
									?>
									<td class="<?php echo $claseTh;?>"><?php if(isset($row->partida) && !is_null($row->partida)){
													echo $row->partida;
												}elseif(!isset($row->partida) && is_null($row->partida)){
													echo "";
												}else{
													echo "Error";
												}
											?>
									</td>
									<?php
										if($row->bcertificado == 1){
											$claseTh = "success";
										}else{
											$claseTh = "";
										}
									?>
									<td class="<?php echo $claseTh;?>"><?php if(isset($row->certificado) && !is_null($row->certificado)){
													echo $row->certificado;
												}elseif(!isset($row->certificado) && is_null($row->certificado)){
													echo "";
												}else{
													echo "Error";
												}
											?>
									</td>
									<?php
										if($row->btdestino	 == 1){
											$claseTh = "success";
										}else{
											$claseTh = "";
										}
									?>
									<td class="<?php echo $claseTh;?>"><?php if(isset($row->tdestino) && !is_null($row->tdestino)){
													echo $row->tdestino;
												}elseif(!isset($row->tdestino) && is_null($row->tdestino)){
													echo "";
												}else{
													echo "Error";
												}
									?>
							</td>
							<!--$myvar = NULL; is_null($myvar); // TRUE-->
							<!--$myvar = NULL; isset($myvar);   // FALSE-->
							<!--$myvar = NULL; empty($myvar);   // TRUE-->
						</tr>
						<?php		
							if(isset($row->message)){
						?>
							<tr>
								<td><?php if(isset($row->message)){echo $row->message;}?></td>
							</tr>
						<?php
							}
						?>
						
						
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
				else{
					$message= "La consulta arrojó un error.";
					$class="alert alert-warning";
				?>
					<div class="<?php echo $class;?>" id="rows">
						<?php echo $message;?>
					</div>
				<?php		
					}
						
					}else{
						$res = $DB->prConsultaPCTv1($nradio);
					//}
					switch ($nradio) {
					case "C":
						$sMsg = "Consultar -> Completos";
						break;
					case "I":
						$sMsg = "Consultar -> Incompletos";
						break;
					case "T":
						$sMsg = "Consultar -> Todos";
						break;
					case "K":
						$sMsg = "Completar -> Incompletos";
						break;
					}
					
					$row_cnt = mysqli_num_rows($res);
					if(!empty($res)){
						$row_cnt = mysqli_num_rows($res);
						if ($row_cnt == 0){
							$class="alert alert-info";
							$message= "No se obtuvieron movimientos para la opción solicitada. (".$sMsg.")";
						}elseif ($row_cnt == 1){
							$class="alert alert-success";
							$message= "Se obtuvo 1 movimiento para la opción solicitada. (".$sMsg.")";
						}else{
							$class="alert alert-success";
							$message= "Se obtuvieron ".$row_cnt." movimientos para la opción solicitada. (".$sMsg.")";
						}
				?>
			
			<div class="<?php echo $class?>" id="rows">
				  <?php echo $message;?>
			</div>
			<?php
			if ($row_cnt == 0){
			}else{
				?>	
			<div class="row">
				<div class="col-md-6">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th>Remito</th>
							<th>Partida</th>
							<th>Certificado</th>
							<th>Tanque Destino</th>
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
				?>
					<tbody>
						<tr>
							<td><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
							<td><?php if(isset($row->partida) && !is_null($row->partida)){
											echo $row->partida;
										}elseif(!isset($row->partida) && is_null($row->partida)){
											echo "";
										}else{
											echo "Error";
										}
									?>
							</td>
							<td><?php if(isset($row->certificado) && !is_null($row->certificado)){
											echo $row->certificado;
										}elseif(!isset($row->certificado) && is_null($row->certificado)){
											echo "";
										}else{
											echo "Error";
										}
									?>
							</td>
							<td><?php if(isset($row->tdestino) && !is_null($row->tdestino)){
											echo $row->tdestino;
										}elseif(!isset($row->tdestino) && is_null($row->tdestino)){
											echo "";
										}else{
											echo "Error";
										}
									?>
							</td>
							<!--$myvar = NULL; is_null($myvar); // TRUE-->
							<!--$myvar = NULL; isset($myvar);   // FALSE-->
							<!--$myvar = NULL; empty($myvar);   // TRUE-->
						</tr>
						<?php		
							if(isset($row->message)){
						?>
							<tr>
								<td><?php if(isset($row->message)){echo $row->message;}?></td>
							</tr>
						<?php
							}
						?>
						
						
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
				
				
				
				
				else{
					$message= "La consulta arrojó un error.";
					$class="alert alert-warning";
				?>
					<div class="<?php echo $class;?>" id="rows">
						<?php echo $message;?>
					</div>
				<?php		
					}
				}
				?>
				
		<?php
						}
					?>
		<?php
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
	
	var jq = jQuery.noConflict();
	jq(document).ready(function(){
		var smessage = '<?php //echo $message; ?>';
		//var stitulo = '';
		//var sdatoremito = '';
		//var sdatoserie = '';
		/*
		if (smessage !== ''){
			bootbox.alert({
				message: smessage,
				size: 'small'
			});
		}
		*/
		
		var ilen = 0;
		var aRemitoFull = [];
		var aDataFull = [];
		var aValoresFull = [];
		var aValoresFullI = [];
		
		
		//setear valor de input hidden
		jq.fn.setHiddenV = function(hId, hValue){
			jq('#'+hId).val(hValue)
                 //.trigger('change');
		}
		
		jq.fn.setOption = function(sOption){
			switch(sOption) {
					case "C":
						var sMessage = "Consulta Trazabilidad Producto Granel (Completos)";
						break;
					case "I":
						var sMessage = "Consulta Trazabilidad Producto Granel (Incompletos)";
						break;
					case "T":
						var sMessage = "Consulta Trazabilidad Producto Granel (Todos)";
						break;
					case "K":
						var sMessage = "Completa Trazabilidad Producto Granel";
						break;
			}
			jq('#lblMsgInformacion').text(sMessage);
		}
		
		//Chequea los valores ingresados de input text
		jq.fn.chkInput = function(value,sTipo){
			switch(sTipo) {
				//Partida
				case "P":
					var regExp = /^([0-9]{5})$/;
					break;
				//Certificado
				case "C":	
					var regExp = /^([0-9]{4,5})$/;
					break;
			}
			if(!value.match(regExp)){
				return false;
			}else{
				return true;
			}
		}
		
		//Modifica CSS según valor ingresado
		jq.fn.setCSS = function(value,sTipo){
			if(jq("#"+sTipo).val() !== ''){
				if(value == true){
				jq("#"+sTipo).css("background-color","#92FF8A");
				jq("#"+sTipo).css("color","#000333");
			}else{
				jq("#"+sTipo).css("background-color","#EE2C25");
				jq("#"+sTipo).css("color","#FFFFFF");
			}
			}else{
				jq("#"+sTipo).css("background-color","transparent");
				jq("#"+sTipo).css("color","#000333");
			}
		}
		
		
		jq('#lblMsgInformacion').css("background-color","#B8D4FE");
		jq('#lblMsgInformacion').css("color","#000333");
		
		
		jq.fn.inputradio = function(nradioVal){
			jq.ajax({
				url:"./ajaxConsultaPartida-v1.php",
				dataType: "json",
				data: {"nradioval": nradioVal},
				type:"POST",
				success:function(data){
					var bres = false;
					var len = data.length;
					for(var i=0; i<len; i++){
						var header1 = data[i].header1;
						ilen = data[i].header2;
						jq("#lblPartida1").append(header1);
						jq("#consultar").prop("value","Actualizar");
						jq("#consultar").text("Actualizar");
						jq.fn.setArray(ilen);
						jq.fn.setHiddenV('iregistro', ilen);
						jq.fn.setDataArray(ilen);
					}
					jq('#pText').css("background-color","#EE2C25");
					jq('#pText').css("color","#FFFFFF");
					jq.fn.chkDataPCT();
				}
			});
		}
		
		
		jq.fn.setArray = function(ival){
			for(k = 0 ;k < 5 ;k++){
				var aRemito = [];
				if(k == 0){
					var sId0 = 'REM0';	//remito
					var sId1 = 'REM';	//remito
				}
				else if(k == 1){
					var sId0 = 'PAR0';	//input text partida
					var sId1 = 'PAR';	//input text partida
				}
				else if(k == 2){
					var sId0 = 'CER0';	//input text certificado
					var sId1 = 'CER';	//input text certificado
				}
				else if(k == 3){
					var sId0 = 'CHK0';	//input checkbox movil
					var sId1 = 'CHK';	//input checkbox movil
				}
				else if(k == 4){
					var sId0 = 'MOV0';	//label movil
					var sId1 = 'MOV';	//label movil
				}
				else if(k == 5){
					var sId0 = 'MOH0';	//input hidden
					var sId1 = 'MOH';	//input hidden
				}
				
				for(j = 0 ;j < ival ;j++){
					if (j < 10){
						var schkID = sId0+j.toString();
						aRemito.push(schkID);
					}
					else {
						var schkID = sId1+j.toString();
						aRemito.push(schkID);
					}	
				}
				aRemitoFull.push(aRemito);
			}
		}
		
		jq.fn.setDataArray = function(ival){
			//Comienzo armado Array aDataFull
			for(k = 0 ;k < 5 ;k++){
				var aData = [];
				for(j = 0 ;j < ival ;j++){
					if(k !== 3 && k !== 4){
						var sId = jq('#'+aRemitoFull[k][j]).val();	//remito - partida - certificado - movil (MOH)
					}else{
						var sId = false;	//checkbox
					}
					aData.push(sId);
				}
				aDataFull.push(aData);
			}
			for(k = 0 ;k < 5 ;k++){
				for(j = 0 ;j < ival ;j++){
					if(k !== 3 && k !== 4){
						if(aDataFull[k][j] == '' || typeof aDataFull[k][j] == 'undefined'){
							aDataFull[k][j] = true;
						}
					}
				}
			}
			//Fin armado Array aDataFull
			//
			//Comienzo armado Array aValoresFull
			for(k = 0 ;k < 5 ;k++){
				var aValores = [];
				for(j = 0 ;j < ival ;j++){
					if(k !== 4){
						var sId = jq('#'+aRemitoFull[k][j]).val();	//remito - partida - certificado - checkbox - movil (MOH)
					}else{
						var sId = jq('#'+aRemitoFull[k][j]).text();	//remito - partida - certificado - checkbox - movil (MOH)
					}
					
					aValores.push(sId);
				}
				aValoresFull.push(aValores);
			}
			
			for(k = 0 ;k < 5 ;k++){
				var aValores = [];
				for(j = 0 ;j < ival ;j++){
					if(k !== 4){
						var sId = jq('#'+aRemitoFull[k][j]).val();	//remito - partida - certificado - checkbox - movil (MOH)
					}else{
						var sId = jq('#'+aRemitoFull[k][j]).text();	//remito - partida - certificado - checkbox - movil (MOH)
					}
					
					aValores.push(sId);
				}
				aValoresFullI.push(aValores);
			}
			//jq.fn.chkDataPCT(bValDos);
		}
		
				
		//Event binding on dynamically created elements | Input text Partida Certificado
		jq("#lblPartida1").on('focusout','.form-control', function(){
			var sParCerVal = jq(this).val();
			var sParCer = jq(this).attr('id').substring(0,1);
			if(ilen < 10){
				var iParCer = jq(this).attr('id').substring(4,5);
			}else{
				var iParCer = jq(this).attr('id').substring(3,5);
			}
			
			switch(sParCer) {
				//Partida
				case "P":
					var retval = jq.fn.chkInput(jq(this).val(),'P');
					if(retval == true){	
						aDataFull[1][iParCer] = true;
					}else if(retval == false && sParCerVal !== ''){
						aDataFull[1][iParCer] = false;
					}else if(retval == false && sParCerVal == ''){
						aDataFull[1][iParCer] = true;
					}
					aValoresFull[1][iParCer] = sParCerVal;
					jq.fn.setCSS(retval,jq(this).attr('id'));
					break;
				//Certificado
				case "C":	
					var retval = jq.fn.chkInput(jq(this).val(),'C');
					if(retval == true){	
						aDataFull[2][iParCer] = true;
					}else if(retval == false && sParCerVal !== ''){
						aDataFull[2][iParCer] = false;
					}else if(retval == false && sParCerVal == ''){
						aDataFull[2][iParCer] = true;
					}
					aValoresFull[2][iParCer] = sParCerVal;
					jq.fn.setCSS(retval,jq(this).attr('id'));
					break;
			}
			jq.fn.chkDataPCT();
		});
		
		jq("#lblPartida1").on('click','.chkBox', function(){
			var sChkId = jq(this).attr('id');
			var sMovId = 'MOV'+sChkId.substring(3,5);
			var sMovHId = 'MOH'+sChkId.substring(3,5);
			if(ilen < 10){
				var iMovId = jq(this).attr('id').substring(4,5);
			}else{
				var iMovId = jq(this).attr('id').substring(3,5);
			}
			if(jq(this).prop('checked') == false){
				jq('#'+sMovId).text('');
				jq.fn.setHiddenV(sMovHId, '')
				aDataFull[3][iMovId] = false;
				aDataFull[4][iMovId] = false;
			}else{
				aDataFull[3][iMovId] = true;
			}
			aValoresFull[3][iMovId] = jq('#'+aRemitoFull[3][iMovId]).val();
			aValoresFull[4][iMovId] = jq('#'+aRemitoFull[4][iMovId]).text();
			console.log("aValoresFull[3][4] -> "+aValoresFull[3][iMovId]+" |-| "+aValoresFull[4][iMovId]);
			console.log("aValoresFullI[3][4] -> "+aValoresFullI[3][iMovId]+" |-| "+aValoresFullI[4][iMovId]);
			jq.fn.chkDataPCT();
		});
		
		
		//Event binding on dynamically created elements | Combo Movil
		jq("#lblPartida1").on('change','#tanque', function(){
			iMovil = jq(this).val();
			sMovil = jq("#tanque option:selected").text() ;
			for(j = 0 ;j < ilen ;j++){
				if(jq('#'+aRemitoFull[3][j]).prop('checked') == true && jq('#'+aRemitoFull[4][j]).text() == ''){
					jq('#'+aRemitoFull[4][j]).text(' Móvil: '+sMovil);
					jq('#'+aRemitoFull[4][j]).css("color","#522AE9");
					var sCapHId = 'MOH'+aRemitoFull[4][j].substring(3,5);
					jq.fn.setHiddenV(sCapHId, iMovil);
					aDataFull[4][j] = true;
					aValoresFull[3][j] = jq('#'+aRemitoFull[3][j]).val();
					aValoresFull[4][j] = jq('#'+aRemitoFull[4][j]).text();
					console.log("aValoresFull[3][4] -> "+aValoresFull[3][j]+" |-| "+aValoresFull[4][j]);
					console.log("aValoresFullI[3][4] -> "+aValoresFullI[3][j]+" |-| "+aValoresFullI[4][j]);
				}
			}
			
			jq('#tanque').val(0);
			jq.fn.chkDataPCT();
		});
		
		
		jq("input[name=abmOpcion]").click(function () {
			nradioVal = jq(this).val();
			jq('#lblPartida1').children().each(function (index) {
				jq(this).remove();
			});
			jq("#rows").remove();
			jq("#tabla1").remove();
			
			if(jq("input:radio[name=abmOpcion][value='K']").prop('checked') == true){
				jq.fn.inputradio(nradioVal);
			}else{
				jq("#consultar").prop("value","Consultar");
				jq("#consultar").text("Consultar");
			};
			jq.fn.setOption(nradioVal);
		});
		
		//Chequea formulario a actualizar
		jq.fn.chkDataPCT = function(){
			var bVal = true;
			var bValUno = true;
			
			for(k = 0 ;k < 5 ;k++){
				if(k == 1 || k == 2){
					for(j = 0 ;j < ilen ;j++){
						switch(aDataFull[k][j]){
							case true:
								bValUno = bValUno && aDataFull[k][j];
							break;
							case false:
								bValUno = bValUno && aDataFull[k][j];
							break;
						}
					}
				}	
			}
			
			for(k = 0 ;k < 5 ;k++){
				if(k == 3 || k == 4){
					for(j = 0 ;j < ilen ;j++){
						if(aDataFull[3][j] == aDataFull[4][j]){
							bValUno = bValUno && true;
						}else{
							bValUno = bValUno && false;
						}
					}
				}	
				
			}
			
			var bValDos = true;
			for(k = 0 ;k < 5 ;k++){
				for(j = 0 ;j < ilen ;j++){
					if(aValoresFull[k][j] == aValoresFullI[k][j]){
						bValDos = bValDos && true;
					}else{
						bValDos = bValDos && false;
					}
				}
			}
			
			console.log("bValUno -> "+bValUno+" bValDos -> "+bValDos);
			//console.log("bValUno -> "+bValUno);
			
			if(bValUno && !bValDos){
				jq('#pText').css("background-color","#92FF8A");
				jq('#pText').css("color","#140CC5");
				jq('#pText').text("Si");
				var retVal = true; 
				}else{
					jq('#pText').css("background-color","#EE2C25");
					jq('#pText').css("color","#FFFFFF");
					jq('#pText').text("No");
					var retVal = false;
				}
			//console.log("Valor de retVal -> "+retVal);	
			return retVal;
		}
		
		
		jq('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
			switch(nradioVal) {
				//Completar
				case 'K':
					var returnValue = jq.fn.chkDataPCT();
					if(returnValue == true){
						currentForm.submit();
					}
				break;
				//Consultar
				default:
					currentForm.submit();
				break;
			}
		});
	});
	
</script>
</form>
	
	</body>
</html>


