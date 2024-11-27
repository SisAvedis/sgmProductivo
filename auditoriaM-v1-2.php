<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="auditoriaM-v1-2.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>M Auditoría</h4></div>
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
				
				$nauditoria = '';
				$numerocliente = '';
			?>
			
			
			
			<div class="row">
				<div class="col-md-2">
					<label><pre class="lx-pre">Número de Auditoría</pre></label></br>
					<pre class="lx-pre"><input type="text" name="nauditoria" id="nauditoria" class="form-control input-sm" maxlength="8" required value="<?php $nauditoria; ?>" /></pre>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-5">
					<label><pre class="lx-pre" id="lblMsgInformacion">Modifica Auditoría</pre></label></br>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-md-12" id="divDetalleAuditoria">
				</div>
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
				
				//echo "<pre>";
				//echo print_r($_POST)."</br>";
				//echo "</pre>";
				
				
				$envS = 0;
				$envC = 0;
				$envL = 0;
				$envP = 0;
				if(1 == 1){
					$seriesCSV = '';
					foreach ($_POST as $clave=>$valor){
						if(substr($clave,0,3) == "FEH"){
							if(substr($clave,0,3) == "FEH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envS++;
							}
						}
						if(substr($clave,0,3) == "REH"){
							if(substr($clave,0,3) == "REH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envS++;
							}
						}
						if(substr($clave,0,3) == "SEH"){
							if(substr($clave,0,3) == "SEH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envS++;
							}
						}
						if(substr($clave,0,3) == "IXH"){
							if(substr($clave,0,3) == "IXH" && trim($valor) <> ''){
								$seriesCSV = $seriesCSV.$valor.$clave.",";
								$envC++;
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
				$nauditoria=isset($_POST['nauditoria'])? $_POST['nauditoria']:"";
				$numerocliente=isset($_POST['numerocliente'])? $_POST['numerocliente']:"";
				//echo "<pre>";
				//echo $seriesCSV."</br>";
				//echo "</pre>";
				
				//echo "<pre>";
				//echo $nauditoria."</br>";
				//echo $numerocliente."</br>";
				//echo "</pre>";
				
				$DB= new Database();
				
				//$clienteid = explode("|",$_POST['cliente']);
				//$fecha = date("Y-m-d", strtotime($_POST['fecha']));
				
				$idusuario=isset($_SESSION['idusuario'])? $_SESSION['idusuario']:"";
				
				$res = $DB->prModificarAUCSVv1($nauditoria,$seriesCSV,$numerocliente,$idusuario);
				$row_cnt = mysqli_num_rows($res);
					if ($row_cnt == 0){
						$message= "No se actualizaron registros.";
						$class="alert alert-info";
					}elseif($row_cnt == 1){
						$message= "Se actualizó ".$row_cnt." registro.";
						$class="alert alert-success";
					}else{
						$message= "Se actualizaron ".$row_cnt." registros.";
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
					<div class="col-md-12">
					<table class="table table-bordered" id="tabla1">
						<thead>
							<tr>
								<th>Fecha C</th>
								<th>Comprobante</th>
								<th>Fecha R</th>
								<th>Remito</th>
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
									<td>
										<?php if(isset($row->fecharemito))
										{
											if($row->fecharemito == ""){
												echo "";
											}else{
												{echo date_format(date_create($row->fecharemito),"d-m-Y");}
											}
										}else{echo "Error";}?>
										
									</td>
									
									
									<td><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
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
	
	//Consulta Auditoría
	function getAuditoria(sAuditoria, callbackFn){
		//console.log('Dentro de Función Externa -> '+sAuditoria);
		jq.ajax({
			url:"./ajaxAuditoria-v1-2.php",
			dataType: "json",
			data: {"auditoria": sAuditoria},
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
	
	//Función que inserta string en una posición especificada
	function insertAtIndex(str, substring, index) {
		return str.slice(0, index) + substring + str.slice(index);
	}
	
	
	var jq = jQuery.noConflict();
	//jQuery.noConflict();
	jq(document).ready(function(){
		
		var bRes = false;
		var sRemito = '';
		var bkeyPressed = false;
		
		var sCliente = '<?php echo $idcliente_xl0; ?>';
		var iInsReg = 0;
		var iTotReg = 0;
		var iInsRegManual = 0;
		var iDelRegManual = 0;
		var aClientes;
		var aAuditInicial;
		var sAuditoria = '';
		var aDimension = [];
		var aDimension2 = [];
		var nauditoria = '<?php echo $nauditoria; ?>';
		
		
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
		
		
		
		jq.fn.setHiddenV = function(hId, hValue){
			jq('#'+hId).val(hValue)
                 //.trigger('change');
		}
		
		jq("#nauditoria").focusout('input', function(){
			sAuditoria = jq(this).val();
			//console.log('Dentro de focusout...');
			jq.fn.procesaAuditoria();
			/*
			jq.fn.procesaAuditoria(sRemito, nradioVal);
			jq("#rows").remove();
			jq('#rows').children().each(function (index) {
				jq(this).remove();
			});
			jq('#rowsT').children().each(function (index) {
				jq(this).remove();
			});
			*/
		});
		
		//Limpia la grilla de entregados y devueltos
		jq.fn.procesaAuditoria = function(){
			jq('#divDetalleAuditoria').children().each(function (index) {
				jq(this).remove();
			});
			
			jq('#tabla1').children().each(function (index) {
				jq(this).remove();
			});
			
			jq('#rowmessage').each(function (index) {
				jq(this).remove();
			});
			
			//console.log('Dentro de función procesaAuditoria -> '+sAuditoria);
			getAuditoria(sAuditoria, function(data) {
				var len = data.length;
				//console.log("Valor de len -> "+len);
				for(var i=0; i<len; i++){
					var header1 = data[i].header1;
					iInsReg = data[i].header2;
					iTotReg = iInsReg;
					aClientes = data[i].header3;
					aAuditInicial = data[i].header4;
					//console.log('iInsReg -> '+iInsReg);
					if (iInsReg !== 0){
						jq("#divDetalleAuditoria").append(header1);
						jq("#btnsubmit").prop("value","Actualizar");
						jq("#btnsubmit").text("Actualizar");
						
						var kk = (jq.fn.occurrences(aAuditInicial,";",1) + 1);
						for(z = 0 ;z < kk ;z++){
							sArrDIM = aAuditInicial.split(';');
							sArDMVA = sArrDIM[z];
							aDimension.push(sArDMVA);
						}
						
						var kk2 = (jq.fn.occurrences(aAuditInicial,";",1) + 1)/4;
						for(y = 0 ;y < kk2 ;y++){
							aDimension2.push([aDimension[0+(y*4)],aDimension[1+(y*4)],aDimension[2+(y*4)],aDimension[3+(y*4)]]);
						}
						//console.log(aDimension2);
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
		
		
		jq.fn.occurrences = function(string, subString, allowOverlapping){
			string+=""; subString+="";
			if(subString.length<=0) return string.length+1;
		
			var n=0, pos=0;
			var step=(allowOverlapping)?(1):(subString.length);
		
			while(true){
				pos=string.indexOf(subString,pos);
				if(pos>=0){ n++; pos+=step; } else break;
			}
			return(n);
		}
		
		
		
		//Datepicker
		jq("#divDetalleAuditoria").on('focus','.form-control.input-sm.datepicker',function(){
			var sDPI = jq(this).attr('id');
			
			var sDPF = '';
			for (var k = 0; k<sDPI.length;k++){
				if (k == 2){
					sDPF = sDPF + 'H';
				}else{
					sDPF = sDPF + sDPI.substring(k, k+1);
				}
			}
			//console.log('sDPI -> '+sDPI);
			//console.log('sDPF -> '+sDPF);
			
			jq(this).datepicker({
				onSelect: function(date) {
					sDate = date;
					chkDate(sDate, function(data) { // data = the JSON retrieved
						var len = data.length;
						for(var i=0; i<len; i++){
							isDate = data[i].header7;
							if(isDate == 1){
								jq('#'+sDPI).css("background-color","#92FF8A");
								jq('#'+sDPI).css("color","#000000");
								jq.fn.setHiddenV(sDPF, sDate);
							}else if(isDate == 0){
								jq('#'+sDPI).css("background-color","#EE2C25");
								jq('#'+sDPI).css("color","#FFFFFF");
							}
						}
					});
				},
				dateFormat: "dd-mm-yy"
				//showButtonPanel: true // Show the button panel
				//changeMonth: true, // Enable month dropdown
				//changeYear: true // Enable year dropdown
				
				}).on("change", function() {
					sDate = jq(this).val();
					chkDate(sDate, function(data) { // data = the JSON retrieved
						var len = data.length;
						for(var i=0; i<len; i++){
							isDate = data[i].header7;
							if(isDate == 1){
								jq('#'+sDPI).css("background-color","#92FF8A");
								jq('#'+sDPI).css("color","#000000");
								jq.fn.setHiddenV(sDPF, sDate);
							}else if(isDate == 0){
								jq('#'+sDPI).css("background-color","#EE2C25");
								jq('#'+sDPI).css("color","#FFFFFF");
							}
						}
					});
				});
		});
				
		
		
		
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
				"Cliente:"+aClientes+
				"</td></tr><tr><td>"+
				//"Lote:<pre class='lx-pre'><input type='text' class='form-control input-sm' id='lote' name='lote' /></pre><br/>"+
				"<label><pre class='lx-pre' id='lblEnvasado'>Cilindro <input type='radio' class='oTP' name='tipoProducto' value='CIL' checked required  /></pre></label><label><pre class='lx-pre' id='lblGranel'>Termo  <input type='radio' class='oTP' name='tipoProducto' value='TER' required  /></pre></label>"+
				"</td><td>"+
				//"</td></tr><tr><td>"+
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
						sFEC = 'FEC00'+String(iInsReg);
						sFEH = 'FEH00'+String(iInsReg);
						sREM = 'REM00'+String(iInsReg);
						sREH = 'REH00'+String(iInsReg);
						sSER = 'SER00'+String(iInsReg);
						sSEH = 'SEH00'+String(iInsReg);
						sIXL = 'IXL00'+String(iInsReg);
						sIXH = 'IXH00'+String(iInsReg);
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
						sFEC = 'FEC0'+String(iInsReg);
						sFEH = 'FEH0'+String(iInsReg);
						sREM = 'REM0'+String(iInsReg);
						sREH = 'REH0'+String(iInsReg);
						sSER = 'SER0'+String(iInsReg);
						sSEH = 'SEH0'+String(iInsReg);
						sIXL = 'IXL0'+String(iInsReg);
						sIXH = 'IXH0'+String(iInsReg);
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
						sFEC = 'FEC'+String(iInsReg);
						sFEH = 'FEH'+String(iInsReg);
						sREM = 'REM'+String(iInsReg);
						sREH = 'REH'+String(iInsReg);
						sSER = 'SER'+String(iInsReg);
						sSEH = 'SEH'+String(iInsReg);
						sIXL = 'IXL'+String(iInsReg);
						sIXH = 'IXH'+String(iInsReg);
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
						var sClie = jq('select[name=clientesgrupo] option').filter(':selected').text();
						var sClid = jq('select[name=clientesgrupo] option').filter(':selected').val();
						
						//console.log("Valor de sClie -> "+sClie);
						//console.log("Valor de sClid -> "+sClid);
						//var sProd = jq('select[name=producto]').find("option:selected").html();
						var sEnv = jq('input:radio[name=tipoProducto]:checked').val()
						//var sEnv = jq('oTP').val();
						var bRBkp = jq('#BKP').prop("checked");
						//console.log("Valor de bRBKP -> "+bRBkp);
						var bAudi = true;
						var sTipo = "M";
						//fecha
						var newRow = "<tr class='TRs' id='"+sTR+"'><td><pre class='lx-pre'><input type='text' name='"+sFEC+"' class='form-control input-sm' id='"+sFEC+"' maxlength=10  autocomplete='off' value=''disabled /></pre><input type='hidden' value='-' name='"+sFEH+"' id='"+sFEH+"'/></td>";
						//remito
						var newRow = newRow+"<td><pre class='lx-pre'><input type='text' name='"+sREM+"' class='form-control input-sm' id='"+sREM+"' maxlength=6  autocomplete='off' value='' disabled /></pre><input type='hidden' value='-' name='"+sREH+"' id='"+sREH+"'/></td>";
						//serie
						var newRow = newRow+"<td><pre class='lx-pre'><input type='text' name='"+sSER+"' class='form-control input-sm' id='"+sSER+"' maxlength=15  autocomplete='off' value='"+sSerie+"' /></pre><input type='hidden' value='"+ sSerie +"' name='"+sSEH+"' id='"+sSEH+"'/></td>";
						//clientesgrupo
						var newRow = newRow+"<td><pre class='lx-pre'><input type='text' name='"+sIXL+"' class='form-control input-sm' id='"+sIXL+"' maxlength=15  autocomplete='off' value='"+ sClie +"' disabled /></pre><input type='hidden' value="+ sClid +" name='"+sIXH+"' id='"+sIXH+"' /></td>";
						//lote
						var newRow = newRow+"<td><pre class='lx-pre'><input type='text' name='"+sLOT+"' class='form-control input-sm' id='"+sLOT+"' maxlength=5  autocomplete='off' value='"+ sLote +"' /></pre><input type='hidden' value='"+ sLote +"' name='"+sLOH+"' id='"+sLOH+"'/></td>";
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
						
						sCliArrMO = sClid.split('|');
						sClienteMO = sCliArrMO[0];
						
						var sIDF = '';
						var sIDI = sIXH;
						
						for (var k = 0; k<sClid.length;k++){
							if (k == 2){
								sIDF = sIDF + 'H';
							}else{
								sIDF = sIDF + sIDI.substring(k, k+1);
							}
						}
						jq.fn.setHiddenV(sIDF, sClienteMO);
						console.log("Valor de sIDF -> "+sIDF);
						console.log("Valor de sClienteMO -> "+sClienteMO);
						
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
						iInsRegManual++;
						jq.fn.actualizacantidadregistros(iInsRegManual);
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
				}
				
				
				
				});
		}
		
		
		
		
		//Eliminar registro agregado con botón "Agregar"
		jq("#divDetalleAuditoria").on('click','.btn', function(){
			const attr = jq(this).attr('id');
			
			// attribute exists?
			if (typeof attr !== 'undefined' && attr !== false) {
				var oTr = jq(this);	
				//jq(this).closest('tr').remove();
				//iInsReg--;
				//iDelRegManual++;
				//jq.fn.actualizacantidadregistros();
				
				//console.log("Valor -> "+attr);
				//console.log("Valor después -> "+jq(this).closest('tr').attr('id'));
				/*
				bootbox.alert({
					size: 'small',
                    title: "<span style='color:#FF9803;font-size:1.6em;'>"+"<b>"+"Atención"+"</b>"+"</span>"+"</br>",
                    message: "<span style='color:#5ABCF7;'>"+"<b>"+"Debe ingresar un número de envase"+"</b>"+"</span>"+"</br>",
                    callback: function() { 
						jq(this).closest('tr').remove();
						iInsReg--;
						iDelRegManual++;
						jq.fn.actualizacantidadregistros(); 
					}
                });
				*/
				
				bootbox.confirm({
					title: "<span style='color:#FF9803;font-size:1.6em;'>"+"<b>"+"Atención"+"</b>"+"</span>"+"</br>",
                    message: "<span style='color:#5ABCF7;'>"+"<b>"+"Desea eliminar el registro?"+"</b>"+"</span>"+"</br>",
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
							//console.log("Por True...");
							oTr.closest('tr').remove();
							//iInsReg--;
							iDelRegManual++;
							jq.fn.actualizacantidadregistros();
						}
					}
				});
				
				
				
				
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
		
		//Actualizar cantidad de registros agregados
		jq.fn.actualizacantidadregistros = function(){
			var iTotalRegistros = iTotReg + iInsRegManual - iDelRegManual;
			iTotalRegistros = parseFloat(iTotalRegistros).toFixed(0)
			jq("#lbcantidadE").html("<pre class='lx-pre'>Registros (Inicial): "+iTotReg+" | Insertados: "+iInsRegManual+" | Eliminados: "+iDelRegManual+" | Registros (Final): "+iTotalRegistros+"</pre>");
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
			
		
		//Event binding on dynamically created elements | InputBox Lote
		jq("#divDetalleAuditoria").on('focusout','.form-control.input-sm.lote', function(){
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
			console.log("No sé...");
		});
		
		//Event binding on dynamically created elements | InputBox Remito
		jq("#divDetalleAuditoria").on('focusout','.form-control.input-sm.remito', function(){
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
			
		
		//Event binding on dynamically created elements | ComboBox Clientes Grupo Formulario Principal
		jq("#divDetalleAuditoria").on('change','.form-control.input-sm.uno', function(){
			
			sCliGR = jq(this).val();
			console.log("Pasando por la función change... "+sCliGR);
			sCliArrGR = sCliGR.split('|');
			sClienteGR = sCliArrGR[0];
			
			var sIDF = '';
			var sIDI = jq(this).attr('id');
			for (var k = 0; k<jq(this).attr('id').length;k++){
				if (k == 2){
					sIDF = sIDF + 'H';
				}else{
					sIDF = sIDF + sIDI.substring(k, k+1);
				}
			}
			jq.fn.setHiddenV(sIDF, sClienteGR);
			
			
			
			var sTYH = 'TYH'+sIDF.slice(-3);
			var sTYA = 'TYA'+sIDF.slice(-3);
			var sSER = 'SER'+sIDF.slice(-3);
			
			var sSerie = jq("#"+sSER).val();
			
			
			for (var x = 0; x < aDimension2.length; x++){
				//console.log("Antes del if sSerie");
				//console.log("sSerie -> "+sSerie+" sClienteGR -> "+sClienteGR+" aDimension2[x][1] -> "+aDimension2[x][1]);
				if (aDimension2[x][0] == sSerie && aDimension2[x][1] == sClienteGR){
					jq("#"+sTYA).html("<pre class='lx-pre'>A</pre>");
					jq.fn.setHiddenV(sTYH, 'A');	
				}else if (aDimension2[x][0] == sSerie && aDimension2[x][1] !== sClienteGR){
					jq("#"+sTYA).html("<pre class='lx-pre'>P</pre>");
					jq.fn.setHiddenV(sTYH, 'P');
				}
			}
			
		});
		
		jq.fn.procesaCliente = function(sCliGR){
			
			sCliArrGR = sCliGR.split('|');
			sClienteGR = sCliArrGR[0];
			
			var sIDF = '';
			var sIDI = jq(this).attr('id');
			for (var k = 0; k<jq(this).attr('id').length;k++){
				if (k == 2){
					sIDF = sIDF + 'H';
				}else{
					sIDF = sIDF + sIDI.substring(k, k+1);
				}
			}
			jq.fn.setHiddenV(sIDF, sClienteGR);
			
			
			
		}
		
		
		//Event binding on dynamically created elements | ComboBox Clientes Grupo
		jq("#mdform").on('click','#clientesgrupo', function(){
			
			
		});
		
		
		//Event binding on statically created elements | Combo Cliente
		jq('#cliente').change(function() {
			sCli = jq(this).val();
			sCliArr = sCli.split('|');
			sCliente = sCliArr[0];
			if (jq("#btnsubmit").prop("value") == "Actualizar"){
				jq.fn.procesaAuditoria();
			}
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
		
		jq.fn.chkData = function(){
			//jq('#divDetalleAuditoria #tablaUno tbody tr td .form-control.input-sm.remito').children().each(function (index) {
			var bRemitos = false;
			jq('#divDetalleAuditoria #tablaUno tbody tr td pre .form-control.input-sm.remito').each(function (index) {
				//const attr = jq(this).attr('id');
				console.log('Id -> '+jq(this).attr('id')+' || Value -> '+jq(this).prop('value').length);
				var sRemito = jq(this).prop('value');
				if (sRemito.length == 6){
					var bRe = jq.fn.chkPattern(sRemito);
					if (bRe){
						bRemitos = true;
					}else{
						bRemitos = false;
					}	
				}
					
				
			
				
			
			
			
			});
			
			
			
		}
		
		jq('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
			sClick = jq(this).val();
			//sSubmit = jq("#btnsubmit").prop("value");
			sSubmit = jq("#btnsubmit").text();
			//console.log("Valor de sSubmit -> "+sSubmit);
			//jq.fn.chkPattern(sRemito);
			if(bRes == true && bkeyPressed == false && sSubmit == 'Consultar'){
				//jq.fn.procesaAuditoria();
			}else if(bRes == true && bkeyPressed == false && sSubmit == 'Actualizar'){
				//jq.fn.recorreform2();
				jq.fn.chkData();
				currentForm.submit();
			}
			bkeyPressed = false;
		
		
		});

	});
	
	
</script>				
	



	</form>
	</body>
</html>
			
			
			