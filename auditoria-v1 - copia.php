<?php include ("inicio.php"); ?>
<style>

.overlay {
	display: grid;
	place-items: center;
	display: none;
	background: #5C4BF9;
	color: #666666;
	position: fixed;
	height: 10%;
	width: 12%;
	z-index: 5000;
	top: 50%;
	left: 50%;
	text-align: center;
	padding-top: 5%;
	opacity: 0.8;
	border-color: #F8E205;
}
.spinner {
    margin: 0 auto;
    height: 36px;
    width: 36px;
	position: fixed;
	top: 52%;
	left: 55%;
    border: 4px solid rgba(248, 226, 5, 0.4);
	border-left-color: #40F805;
    border-radius: 50%;
	
	animation: rotate 1s infinite linear;
}
@keyframes rotate  {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
/* Turn off scrollbar when body element has the loading class */
body.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
body.loading .overlay{
    display: block;
}
</style>


<?php try{ ?>
<body>
	<form method="post" action="auditoria-v1.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Auditoría</h4></div>
                </div>
            </div>
			
			<?php
				$DB= new Database();
				$idCL = 'XLS';
				$res = $DB->clientesTodos($idCL);
				//$res = $DB->clientesTodos();
				$iRow = 1;
				$clienteid_xl = array(0,0);
				$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
				if ($clienteOption){
					$clienteid_xls = explode("|",$_POST['cliente']);
					$idcliente_xls = $clienteid_xls[2];
					$idcliente_xl0 = $clienteid_xls[0];
				}else{
					$idcliente_xls = 0;
					$idcliente_xl0 = 0;
				}
			?>
			
			
			<div class="row">
				<div class="col-md-6 table-responsive">
				<table class="table table-bordered" id="tabla">
					<thead>
						<tr>
							<th class="text-center" colspan=2>Consultar</th>
						</tr>
						<tr>
							<th class="text-center">Fecha</th>
							<th class="text-center">Cliente</th>
						</tr>
						<tr>
							<th class="text-center"><input type="text" name="fecha" id="datepicker" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
							<th>
								<select name="cliente" id="cliente" class="form-control input-sm">
								<option value="0">Clientes</option>
								<?php while ($row=mysqli_fetch_object($res)){ 
									if ($iRow == $idcliente_xls){?>
										<option value="<?php echo $row->id_xl.'|'.$row->nombre.'|'.$iRow ; $iRow++;?>" selected><?php echo $row->id_xl?> - <?php echo $row->nombre;?></option>
									<?php
									}else {
									?>
										<option value="<?php echo $row->id_xl.'|'.$row->nombre.'|'.$iRow; $iRow++;?>"><?php echo $row->id_xl?> - <?php echo $row->nombre;?></option>
									<?php } ?>
									
								<?php } ?>
								</select>
							</th>
						</tr>
						
					</thead>
				</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-5">
					<label><pre class="lx-pre" id="lblMsgInformacion">Consulta Envases en Cliente | Alta Auditoría</pre></label></br>
				</div>
			</div>
			
			<div class="overlay">
				<div class="spinner"></div>
				<span style="color:#0517F8;font-size:1.0em;"><b>Aguarde por favor...</b></span>
			</div>	
			
			
			<div class="col-md-1" id="divNumeroAuditoria">
			</div>
			<div class="col-md-2" id="divFechaAuditoria">
			</div>	
			<div class="col-md-2" id="divClienteAuditoria">
			</div>
			<div class="col-md-12" id="divDetalleAuditoria">
			</div>
			
			<div class="row">	
				<!--<div class="col-md-12 pull-right">-->
				<div class="col-md-12">
					<!--<hr>-->
					<button type="submit" id="btnsubmit" class="btn btn-sm btn-danger">Consultar</button>
					<!--<hr>-->
				</div>
			</div>	
		<!--</div>-->
	<!--</div>-->	

	<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$envS = 0;
				$envL = 0;
				$envP = 0;
				if(1 == 1){
					$seriesCSV = '';
					foreach ($_POST as $clave=>$valor){
						if(substr($clave,0,3) == "SEH"){
							if(substr($clave,0,3) == "SEH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envS++;
							}
						}
						if(substr($clave,0,3) == "LOH"){
							if(substr($clave,0,3) == "LOH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envL++;
							}
						}
						if(substr($clave,0,3) == "PRH"){
							if(substr($clave,0,3) == "PRH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envP++;
							}
						}
						if(substr($clave,0,3) == "ENH"){
							if(substr($clave,0,3) == "ENH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envP++;
							}
						}
						if(substr($clave,0,5) == "CHKRH"){
							if(substr($clave,0,5) == "CHKRH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envP++;
							}
						}
						if(substr($clave,0,5) == "CHKAH"){
							if(substr($clave,0,5) == "CHKAH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envP++;
							}
						}
						if(substr($clave,0,3) == "TYH"){
							if(substr($clave,0,3) == "TYH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envP++;
							}
						}
					}
				$seriesCSV = substr($seriesCSV,0,strlen($seriesCSV)-1);
				//echo "<pre>";
				//echo $seriesCSV."</br>";
				//echo "</pre>";
				
				$DB= new Database();
				
				$clienteid = explode("|",$_POST['cliente']);
				$fecha = date("Y-m-d", strtotime($_POST['fecha']));
				$idusuario=isset($_SESSION['idusuario'])? $_SESSION['idusuario']:"";
				
				$res = $DB->prInsertarAUCSVv1($fecha,$clienteid[1],$seriesCSV,$clienteid[0],$idusuario);
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
					
				}
				?>
			    
				<div class="<?php echo $class;?>" id="rowmessage">
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
								<th>Comprobante</th>
								<th>Cliente</th>
								<th>Producto</th>
								<th>Serie</th>
								<th>Lote</th>
								<th class="text-center">Tipo Envase</th>
								<th class="text-center">Rampa BKP</th>
								<th class="text-center">Auditado</th>
								<th class="text-center">Tipo</th>
							</tr>
						</thead>
					<?php 
						while ($row=mysqli_fetch_object($res)){
							
							
						?>
							<tbody>
								<tr class="<?php echo $claseFondo;?>">
									<td><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
									<td><?php if(isset($row->numerocomprobante)){echo $row->numerocomprobante;}else{echo "Error";}?></td>
									<td><?php if(isset($row->id_xl) && isset($row->cliente)){echo '('.$row->id_xl.') '.$row->cliente;}else{echo "Error";}?></td>
									<td><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
									<td><?php if(isset($row->serie)){echo $row->serie;}else{echo "Error";}?></td>
									<td><?php if(isset($row->lote)){echo $row->lote;}else{echo "Error";}?></td>
									<td class="text-center"><?php if(isset($row->tipoenvase)){echo $row->tipoenvase;}else{echo "Error";}?></td>
									<td class="text-center">
										<?php if(isset($row->rampabackup))
											{if($row->rampabackup == 0){
												echo "No";
											}else{
												echo "Si";
											}
											//echo $row->rampabackup;
										}else{echo "Error";}?>
									
									</td>
									<td class="text-center">
										<?php if(isset($row->auditado))
											{if($row->auditado == 0){
												echo "No";
											}else{
												echo "Si";
											}
											//echo $row->auditado;
										}else{echo "Error";}?>
									
									</td>
									<td class="text-center"><?php if(isset($row->tipo)){echo $row->tipo;}else{echo "Error";}?></td>
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
	
<script type="text/javascript">
	
	//Consulta Envase en Cliente
	function getEnvaseCliente(sDate, sCliente, callbackFn){
		jq.ajax({
			url:"./ajaxEnvaseAuditoria-v1.php",
			dataType: "json",
			data: {"fecha": sDate, "cliente": sCliente},
			type:"POST",
			success:function(response){
				callbackFn(response);
			}					
		})
		//}
	}
	
	//Defino la función llamada chkDate  
	function chkDate(value, callbackFn) {
		var sValue = value;
		jq.ajax({
			url:"include/chkDate.php",
			dataType: "json",
			data: {"value": sValue},
			type:"POST",
			global: false,
			success:function(response){
				callbackFn(response);
			}
		})
	}
	
	var jq = jQuery.noConflict();
	//jQuery.noConflict();
	jq(document).ready(function(){
		
		var bRes = false;
		var sRemito = '';
		var bkeyPressed = false;
		
		var sCliente = '<?php echo $idcliente_xl0; ?>';
		var iInsReg = 0;
		
		
		jq.fn.chkPattern = function(sRemito){
			var pattern = new RegExp('^[0-9]{4}$|^[0-9]{6}$');
			if (pattern.test(sRemito)) {
				jq('#nremito').css("background-color","#92FF8A");
				jq('#nremito').css("color","#A605FA");
				bRes = true;
			}else{
				if(jq('#nremito').val() !== ''){
					jq('#nremito').css("background-color","#FAE605");
					jq('#nremito').css("color","#A605FA");
					jq("#nremito").focus();
				}
				bRes = false;
			}
		}
		
		jq('#lblMsgInformacion').css("background-color","#B8D4FE");
		jq('#lblMsgInformacion').css("color","#000333");
		
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
					//console.log("Valor de sDate -> "+sDate);
					//jq.fn.chkData();
					//jq.fn.chkDataGR();
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
					//console.log("Valor de sDate -> "+sDate);
					//jq.fn.chkData();
					//jq.fn.chkDataGR();
				});
			});
		
		//jq("#nremito").focus();
		
		jq.fn.setHiddenV = function(hId, hValue){
			jq('#'+hId).val(hValue)
                 //.trigger('change');
		}
		
		//Limpia la grilla de entregados y devueltos
		jq.fn.procesaAuditoria = function(){
			jq('#divNumeroAuditoria').children().each(function (index) {
				jq(this).remove();
			});
			jq('#divFechaAuditoria').children().each(function (index) {
				jq(this).remove();
			});
			jq('#divClienteAuditoria').children().each(function (index) {
				jq(this).remove();
			});
			jq('#divDetalleAuditoria').children().each(function (index) {
				jq(this).remove();
			});
			
			jq('#tabla1').children().each(function (index) {
				jq(this).remove();
			});
			
			jq('#rowmessage').each(function (index) {
				jq(this).remove();
			});
			
			//console.log('Dentro de función procesaAuditoria -> '+sDate+ ' - ' +sCliente);
			getEnvaseCliente(sDate, sCliente, function(data) {
				var len = data.length;
				//console.log("Valor de len -> "+len);
				for(var i=0; i<len; i++){
					var header1 = data[i].header1;
					iInsReg = data[i].header2;
					if (iInsReg !== 0){
						jq("#divDetalleAuditoria").append(header1);
						jq("#btnsubmit").prop("value","Actualizar");
						jq("#btnsubmit").text("Actualizar");
					}else{
						bootbox.alert({
                              size: 'small',
                              title: "<span style='color:#FF9803;font-size:1.6em;'>"+"<b>"+"Información"+"</b>"+"</span>"+"</br>",
                              message: "<span style='color:#5ABCF7;'>"+"<b>"+"No existen datos"+"</b>"+"</span>"+"</br>",
                              callback: function() {
									jq("#btnsubmit").prop("value","Consultar");
									jq("#btnsubmit").text("Consultar");
							  //jq.fn.insertaRegistroAuditoria(); 
							  }
                        });
					}
				}
			});
		}
		
		
		//BootStrap Modal Alta Registro Auditoría
		jq.fn.insertaRegistroAuditoria = function(){
			//console.log("Adentro de la función traída V2...");
			bRes = false;
			bootbox.confirm(
				"<div class='table-wrapper'>"+
				"<form id='mdform' action=''>"+
				"<div class='row'>"+
				"<table class='table'>"+
				"<thead><tr><th>"+
				"<span style='color:green;font-size:1.6em;'>"+"<b>"+"Insertar Registro"+"</b>"+"</span>"+"</br>"+
				"</th></tr></thead>"+
				"<tbody><tr><td>"+
				"Serie:<pre class='lx-pre'><input type='text' class='form-control input-sm' id='serie' name='serie' required /></pre><br/>"+
				"</td><td>"+
				"Producto:<pre class='lx-pre'><select name='producto' id='producto' class='form-control input-sm'>"+
				"<option value='1'>Oxigeno</option>"+
				"<option value='2'>Dióxido"+"&nbsp"+"de"+"&nbsp"+"Carbono</option>"+
				"<option value='3'>Óxido"+"&nbsp"+"Nitroso</option>"+
				"<option value='4'>Nitrógeno</option>"+
				"<option value='5'>Aire</option>"+
				"</select></pre><br/>"+
				"</td></tr><tr><td>"+
				"Lote:<pre class='lx-pre'><input type='text' class='form-control input-sm' id='lote' name='lote' />"+
				//"</td></tr><tr><td>"+
				"</td><td>"+
				//"Lote:<pre class='lx-pre'><input type='text' class='form-control input-sm' id='lote' name='lote' /></pre><br/>"+
				"<label><pre class='lx-pre' id='lblEnvasado'>Cilindro <input type='radio' class='oTP' name='tipoProducto' value='CIL' checked required  /></pre></label><label><pre class='lx-pre' id='lblGranel'>Termo  <input type='radio' class='oTP' name='tipoProducto' value='TER' required  /></pre></label>"+
				//"</td><td>"+
				"</td></tr><tr><td>"+
				"Rampa BKP:<pre class='lx-pre'><input type='checkbox' name='BKP' class='chkBox' id='BKP' tabindex='-1' /></pre><br/>"+
				"</td></tr>"+
				"</tbody>"+
				"</table>"+
				"</div>"+
				"</form>"+
				"</div>"
				, function(result) {
				if(result){
					//console.log(String(iInsReg).length);
					if (String(iInsReg).length == 1){
						sTR = 'TR00'+String(iInsReg);
						sSER = 'SER00'+String(iInsReg);
						sSEH = 'SEH00'+String(iInsReg);
						sLOT = 'LOT00'+String(iInsReg);
						sLOH = 'LOH00'+String(iInsReg);
						sPRO = 'PRO00'+String(iInsReg);
						sPRH = 'PRH00'+String(iInsReg);
						sENV = 'ENV00'+String(iInsReg);
						sENH = 'ENH00'+String(iInsReg);
						sCHKRB = 'CHKRB00'+String(iInsReg);
						sCHKRH = 'CHKRH00'+String(iInsReg);
						sCHKAU = 'CHKAU00'+String(iInsReg);
						sCHKAH = 'CHKAH00'+String(iInsReg);
						sTYH = 'TYH00'+String(iInsReg);
						sACT = 'ACT00'+String(iInsReg);
						sACH = 'ACH00'+String(iInsReg);
					}else if (String(iInsReg).length == 2) {
						sTR = 'TR0'+String(iInsReg);
						sSER = 'SER0'+String(iInsReg);
						sSEH = 'SEH0'+String(iInsReg);
						sLOT = 'LOT0'+String(iInsReg);
						sLOH = 'LOH0'+String(iInsReg);
						sPRO = 'PRO0'+String(iInsReg);
						sPRH = 'PRH0'+String(iInsReg);
						sENV = 'ENV0'+String(iInsReg);
						sENH = 'ENH0'+String(iInsReg);
						sCHKRB = 'CHKRB0'+String(iInsReg);
						sCHKRH = 'CHKRH0'+String(iInsReg);
						sCHKAU = 'CHKAU0'+String(iInsReg);
						sCHKAH = 'CHKAH0'+String(iInsReg);
						sTYH = 'TYH0'+String(iInsReg);
						sACT = 'ACT0'+String(iInsReg);
						sACH = 'ACH0'+String(iInsReg);
					}else{
						sTR = 'TR'+String(iInsReg);
						sSER = 'SER'+String(iInsReg);
						sSEH = 'SEH'+String(iInsReg);
						sLOT = 'LOT'+String(iInsReg);
						sLOH = 'LOH'+String(iInsReg);
						sPRO = 'PRO'+String(iInsReg);
						sPRH = 'PRH'+String(iInsReg);
						sENV = 'ENV'+String(iInsReg);
						sENH = 'ENH'+String(iInsReg);
						sCHKRB = 'CHKRB'+String(iInsReg);
						sCHKRH = 'CHKRH'+String(iInsReg);
						sCHKAU = 'CHKAU'+String(iInsReg);
						sCHKAH = 'CHKAH'+String(iInsReg);
						sTYH = 'TYH'+String(iInsReg);
						sACT = 'ACT'+String(iInsReg);
						sACH = 'ACH'+String(iInsReg);
					}
					//iInsReg++;
					var sSerie = jq('#serie').val();
					if (sSerie !== ''){
						var sLote = jq('#lote').val();
						var sProd = jq('select[name=producto] option').filter(':selected').text();
						var sPrid = jq('select[name=producto] option').filter(':selected').val();
						//var sProd = jq('select[name=producto]').find("option:selected").html();
						var sEnv = jq('input:radio[name=tipoProducto]:checked').val()
						//var sEnv = jq('oTP').val();
						var bRBkp = jq('#BKP').prop("checked");
						//console.log("Valor de bRBKP -> "+bRBkp);
						var bAudi = true;
						var sTipo = "M";
						//serie
						var newRow = "<tr class='TRs' id='"+sTR+"'><td><pre class='lx-pre'><input type='text' name='"+sSER+"' class='form-control input-sm' id='"+sSER+"' maxlength=15  autocomplete='off' value='"+sSerie+"' /></pre><input type='hidden' value='"+ sSerie +"' name='"+sSEH+"' id='"+sSEH+"'/></td>";
						//lote
						var newRow = newRow+"<td><pre class='lx-pre'><input type='text' name='"+sLOT+"' class='form-control input-sm' id='"+sLOT+"' maxlength=15  autocomplete='off' value='"+ sLote +"' /></pre><input type='hidden' value='"+ sLote +"' name='"+sLOH+"' id='"+sLOH+"'/></td>";
						//producto
						var newRow = newRow+"<td><pre class='lx-pre'><input type='text' name='"+sPRO+"' class='form-control input-sm' id='"+sPRO+"' maxlength=15  autocomplete='off' value="+ sProd +" disabled /></pre><input type='hidden' value="+ sPrid +" name='"+sPRH+"' id='"+sPRH+"' /></td>";
						//tipo de envase
						var newRow = newRow+"<td><pre class='lx-pre'><input type='text' name='"+sENV+"' class='form-control input-sm' id='"+sENV+"' maxlength=15  autocomplete='off' value="+ sEnv +" /></pre><input type='hidden' value="+ sEnv +" name='"+sENH+"' id='"+sENH+"' /></td>";
						//rampa backup
						var newRow = newRow+"<td><pre class='lx-pre'><input type='checkbox' name='"+sCHKRB+"' class='chkBox' id='"+sCHKRB+"' tabindex='-1' /></pre><input type='hidden' name='"+sCHKRH+"' id='"+sCHKRH+"'/></td>";
						//auditado
						var newRow = newRow+"<td><pre class='lx-pre'><input type='checkbox' name='"+sCHKAU+"' class='chkBox' id='"+sCHKAU+"' checked ="+ bAudi + " disabled tabindex='-1' /></pre><input type='hidden' name='"+sCHKAH+"' id='"+sCHKAH+"' checked /></td>";
						//tipo
						var newRow = newRow+"<td class='text-center'><label><pre class='lx-pre'>"+ sTipo +"</pre></label><input type='hidden' value="+ sTipo +" name='"+sTYH+"' id='"+sTYH+"' /></td>";
						//acción
						var newRow = newRow+"<td class='text-center'><label><pre class='lx-pre'><button class='btn btn-danger' id='"+sACT+"' >-</button></pre></label><input type='hidden' name='"+sACH+"' id='"+sACH+"' /></td></tr>";
						
											
						jq("#tablaUno").append(newRow);
						
						jq('#'+sCHKRB).prop('checked', bRBkp);
						if (bRBkp == true){
							bRBkp = 1;
						}else{
							bRBkp = 0;
						}
						
						jq.fn.setHiddenV(sCHKRH, bRBkp);
						if (sLote == ''){
							sLote = 0;
						}
						jq.fn.setHiddenV(sLOH, sLote);
						
						jq.fn.setHiddenV(sCHKAH, 1);
						
						jq('#'+sSER).prop('disabled', true);
						jq('#'+sLOT).prop('disabled', true);
						jq('#'+sENV).prop('disabled', true);
						
						iInsReg++;
					}else{
						bootbox.alert({
                              size: 'small',
                              title: "<span style='color:#FF9803;font-size:1.6em;'>"+"<b>"+"Atención"+"</b>"+"</span>"+"</br>",
                              message: "<span style='color:#5ABCF7;'>"+"<b>"+"Debe ingresar un número de envase"+"</b>"+"</span>"+"</br>",
                              callback: function() { 
							  jq.fn.insertaRegistroAuditoria(); 
							  }
                        });
					}
				}else{
					
				}
				
				
				
				});
		}
		
		
		
		
		
		jq("#divDetalleAuditoria").on('click','.btn', function(){
			
			const attr = jq(this).attr('id');
			
			// attribute exists?
			if (typeof attr !== 'undefined' && attr !== false) {
				//console.log("Adentro de adentro...");
				//console.log("Valor -> "+attr);
				//console.log("Valor después -> "+jq(this).closest('tr').attr('id'));
				jq(this).closest('tr').remove();
			}
    		
		});
		
		
		
		jq.fn.recorreform = function(){
			jq("#tablaUno").children().each( function( index, element ){
			//jq("#tablaUno").each( function( index, element ){
				//console.log(index + ': ' +jq(element).text()+'\n');
				//console.log(index + ': ' +jq(element).text()+ ' -> ' +jq(element).attr('id')+'\n');
				console.log(index + ': ' +jq(element).text()+ ' -> ' +jq(element).val()+'\n');
			});
		}
		
		
		jq.fn.recorreform2 = function(){
			var formData = new FormData(jq("#frm")[0]);
			for (var pair of formData.entries()) {
				
				/*
				var regExp = /^((CHKRB)[0-9]{2})$/;
				//var regExp = '/^[0-9][a-z][A-Z]{1,}$/';
				if(!pair[0].match(regExp)){
					//console.log('Substring False');
					//console.log('pair[0] -> '+pair[0]);
				}else{
					console.log('Entrando a la validación...');
					if(jq('#'+pair[0]).prop('checked') == true){
						pair[1] = 2;
						//console.log('pair[0] -> '+pair[0]);
					}else{
						pair[1] = 0;
						console.log('Por False...');
					}
					//console.log('Substring True');
					console.log(pair[0]+ ', ' + pair[1]);
				}
				*/
				
				/*
				if(pair[0].substring(1,5) == "CHKRH"){
					console.log('Substring True');
					console.log(pair[0]+ ', ' + pair[1]);
				}else{
					console.log('Substring False');
					console.log(pair[0]+ ', ' + pair[1]);
				}
				*/
				
				
				console.log(pair[0]+ ', ' + pair[1]);
			}
		}
			
		//Event binding on dynamically created elements | CheckBoxes
		jq("#divDetalleAuditoria").on('click','.chkBox', function(){
			var sIDF = '';
			var sIDI = jq(this).attr('id');
			for (var k = 0; k<jq(this).attr('id').length;k++){
				if (k == 4){
					sIDF = sIDF + 'H';
				}else{
					sIDF = sIDF + sIDI.substring(k, k+1);
				}
			}
			//console.log("Valor de sIDF -> "+sIDF);
			if(jq(this).prop('checked') == true){
				//console.log('Ahora salimos por True -> '+jq(this).attr('id'));
				jq(this).prop('value', 1)
				jq.fn.setHiddenV(sIDF, jq(this).val());
			}else{
				//console.log('Ahora salimos por False -> '+jq(this).attr('id'));
				jq(this).prop('value', 0)
				jq.fn.setHiddenV(sIDF, jq(this).val());
			}
		});	
			
		
		//Event binding on dynamically created elements | TextBox
		jq("#divDetalleAuditoria").on('focusout','.form-control', function(){
			var sIDF = '';
			var sIDI = jq(this).attr('id');
			for (var k = 0; k<jq(this).attr('id').length;k++){
				if (k == 2){
					sIDF = sIDF + 'H';
				}else{
					sIDF = sIDF + sIDI.substring(k, k+1);
				}
			}
			jq.fn.setHiddenV(sIDF, jq(this).val());
		});
			
			
		//}
				
		//Event binding on statically created elements | Combo Cliente
		jq('#cliente').change(function() {
			sCli = jq(this).val();
			sCliArr = sCli.split('|');
			sCliente = sCliArr[0];
			if (jq("#btnsubmit").prop("value") == "Actualizar"){
				jq.fn.procesaAuditoria();
			}
			
			//console.log("Valor de sCliente -> "+sCliente);
		});
		
		//Event binding on statically created elements | Combo Cliente
		jq('#cliente').click(function() {
			sCli = jq(this).val();
			sCliArr = sCli.split('|');
			sCliente = sCliArr[0];
			//console.log("Valor de sCliente -> "+sCliente);
		});
		
		jq('#btnsubmit').on('click', function(e) {
			bRes = true;
		});
		
		jq('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
			sClick = jq(this).val();
			//sSubmit = jq("#btnsubmit").prop("value");
			sSubmit = jq("#btnsubmit").text();
			//console.log("Valor de sSubmit -> "+sSubmit);
			//jq.fn.chkPattern(sRemito);
			if(bRes == true && bkeyPressed == false && sSubmit == 'Consultar'){
				jq.fn.procesaAuditoria();
			}else if(bRes == true && bkeyPressed == false && sSubmit == 'Actualizar'){
				jq.fn.recorreform2();
				currentForm.submit();
			}
			bkeyPressed = false;
		
		
		});

	});
	
	jq(document).on({
    ajaxStart: function(){
		console.log("Dentro de ajaxStart...");
        jq("body").addClass("loading"); 
    },
    ajaxStop: function(){
		console.log("Dentro de ajaxStop...");
        jq("body").removeClass("loading"); 
    }    
});
</script>				
	



	</form>
	</body>
</html>
			
			
			