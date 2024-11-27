<?php include ("inicio.php"); ?>

<body>
	<form method="post" action="serieCABM-v1.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>ABM Envase</h4></div>
                </div>
            </div>
			
			<?php
			
			$message = "";
			$iRow = 1;
			//$clienteid_xls = array(0,0);
			$lblNuevo = "";
			//$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			/*
			if ($clienteOption){
				$clienteid_xls = explode("|",$_POST['cliente']);
				$idcliente_xls = $clienteid_xls[2];
			}else{
				$idcliente_xls = 1;
			}
			*/
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
					$scolmod = "col-md-4";
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
							<th class="text-center" colspan=3>Envase</th>
						</tr>
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
				<div class="col-md-6">
					<label><pre class="lx-pre" id="lblMsgInformacion">Agrega un envase al remito ingresado</pre></label></br>
				</div>
			
				<div class="col-md-5" id="divMensaje">
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-md-3">
					<label><pre class="lx-pre">Remito</pre></label></br>
					<label><pre class="lx-pre"><input type="text" name="nremito" id="nremito" class="form-control input-sm" maxlength="6" autocomplete="on" required value="<?php $nremito; ?>" /></pre></label>
					<!--<hr>-->
				</div>
				<div class="col-md-2" id="inpSerie">
					<label id="lblABMSerie"><pre class="lx-pre">N° Envase</pre></label></br>
					<label><pre class="lx-pre"><input type="text" name="nserie" id="nserie" class="form-control input-sm" maxlength="12" autocomplete="on" required value="<?php $nserie; ?>"/></pre></label>
					<!--<hr>-->
				</div>
				
				<div class="col-md-0" id="inpSerieModi">
				</div>
				
				<div class="col-md-2" id="cmbCapacidad">
					<label id="lblABMCapacidad"><pre class="lx-pre">Capacidad</pre></label></br>
					<label><pre class='lx-pre' id="selABMCapacidad"><select name='capacidad' id='capacidad' class='form-control input-sm'>"."<option value='0'>Capacidad</option></select></pre></label>
				</div>
				<div class="col-md-2">
					<label><pre class="lx-pre">Listo</pre></label></br>
					<label><pre class='lx-pre' id="lbllisto">No</pre></label>
				</div>
			</div>	
				
				
			
			<div class="row">	
				<div class="col-md-3" id="divRemito">
				</div>		
				<div class="col-md-2" id="divSerie">
				</div>
				<div class="col-md-0" id="divSerieModi">
				</div>
				<div class="col-md-2" id="divCapacidad">
				</div>
				
				
			</div>
			
			<div class="row" id="divOptionButton">
				<!--<div class="<?php //echo $scolmod;?>" id="optMPT">-->
				<div class="col-md-4" id="optMPT">
					<label><pre class="lx-pre" id="lblTipoMovE">ENV <input type="radio" name="EnvDev" value="E" class="envdevRadio" required /></pre></label><label><pre class="lx-pre" id="lblTipoMovD">DEV <input type="radio" name="EnvDev" value="D" class="envdevRadio" required  /></pre></label><label><pre class="lx-pre" id="lblPropNP">NP  <input type="radio" name="prop" value="NP" required /></pre></label><label><pre class="lx-pre" id="lblPropSP">SP  <input type="radio" name="prop" value="SP" required  /></pre></label><label><pre class="lx-pre" id="lblTipoEnvC">CIL <input type="radio" name="env" value="CIL" class="envRadio" required /></pre></label><label><pre class="lx-pre" id="lblTipoEnvT">TER <input type="radio" name="env" value="TER" class="envRadio" required  /></pre></label><input type="hidden" name="envdevH" id="envdevH" /> 
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
			//$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;;
			//$nserie = isset($_POST['nserie']) ? $_POST['nserie'] : false;;
			//$nserieN = isset($_POST['nserieN']) ? $_POST['nserieN'] : false;;
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if ($nradio == "A"){
					$DB= new Database();
					$nremito = $DB->sanitize($_POST['nremito']);
					$envdev = isset($_POST['EnvDev']) ? $_POST['EnvDev'] : false;
					$nserie = $DB->sanitize($_POST['nserie']);
					$capacidad = explode("|",$_POST['capacidad']);
					
					//echo "<pre>";
					//echo $nremito."</br>".$envdev."</br>".$nserie."</br>".$capacidad[0]."</br>".$nradio."</br>";
					//echo "</pre>";
					
					$res = $DB->prABMSeriev1($nremito,$envdev,$nserie,$capacidad[0],$nradio);
					$row_cnt = mysqli_num_rows($res);
					if ($row_cnt == 0){
						$message= "No se insertaron movimientos."."</br>";
						//$class="alert alert-info";
					}elseif($row_cnt == 1){
						$message= "Se insertó ".$row_cnt." movimiento con éxito."."</br>"."</br>";
						while ($row=mysqli_fetch_object($res)){
							$cliente = $row->nombre;
							//date("Y-m-d", strtotime($_POST['fecha']));
							$fecha = date("d-m-Y", strtotime($row->fecha));
							$remito = $row->remito;
							$estado = $row->estado;
							$serie = $row->serie;
							$capacidad = $row->volumen;
							$propiedad = $row->propiedad;
							$tipoenvase = $row->tipo;
						}
						$message = $message."Fecha: ".$fecha."</br>";
						$message = $message."Remito: ".$remito."</br>";
						$message = $message."N° Envase: ".$serie." (".$capacidad." - ".$estado." - ".$propiedad." - ".$tipoenvase.")</br>";
						$message = $message."Cliente: ".$cliente;
						//$class="alert alert-success";
					}
				}elseif ($nradio == "B"){
					$DB= new Database();
					$nremito = $DB->sanitize($_POST['nremito']);
					$envdev = isset($_POST['envdevH']) ? $_POST['envdevH'] : false;
					$nserie = $DB->sanitize($_POST['nserie']);
					$capacidad = explode("|",$_POST['capacidad']);
					
					
					if($capacidad[0] <> 0.0){
						$scapacidad = $capacidad[0];
					}else{
						$scapacidad = 0.0;
					}
					//echo "<pre>";
					//echo $nremito."</br>".$envdev."</br>".$nserie."</br>".$scapacidad."</br>".$nradio."</br>";
					//echo "</pre>";
					$res = $DB->prABMSeriev1($nremito,$envdev,$nserie,$scapacidad,$nradio);
					//$res = $DB->prABMSeriev1($nremito,$envdev,$nserie,$capacidad[0],$nradio);
					$row_cnt = mysqli_num_rows($res);
					if ($row_cnt == 0){
						$message= "No se eliminaron movimientos."."</br>";
						//$class="alert alert-info";
					}elseif($row_cnt == 1){
						$message= "Se eliminó ".$row_cnt." movimiento con éxito."."</br>"."</br>";
						while ($row=mysqli_fetch_object($res)){
							$cliente = $row->nombre;
							//date("Y-m-d", strtotime($_POST['fecha']));
							$fecha = date("d-m-Y", strtotime($row->fecha));
							$remito = $row->remito;
							$estado = $row->estado;
							$serie = $row->serie;
							$capacidad = $row->volumen;
							$propiedad = $row->propiedad;
							$tipoenvase = $row->tipo;
						}
						$message = $message."Fecha: ".$fecha."</br>";
						$message = $message."Remito: ".$remito."</br>";
						$message = $message."N° Envase: ".$serie." (".$capacidad." - ".$estado." - ".$propiedad." - ".$tipoenvase.")</br>";
						$message = $message."Cliente: ".$cliente;
					//$class="alert alert-success";
					}elseif($row_cnt > 1){
						
						$message= "Se eliminaron ".$row_cnt." movimientos con éxito "."</br>"."</br>";
						
						while ($row=mysqli_fetch_object($res)){
							$cliente = $row->nombre;
							//date("Y-m-d", strtotime($_POST['fecha']));
							$fecha = date("d-m-Y", strtotime($row->fecha));
							$remito = $row->remito;
							$estado = $row->estado;
							$serie = $row->serie;
							$capacidad = $row->volumen;
							$propiedad = $row->propiedad;
							$tipoenvase = $row->tipo;
						
						$message = $message."Fecha: ".$fecha."</br>";
						$message = $message."Remito: ".$remito."</br>";
						$message = $message."N° Envase: ".$serie." (".$capacidad." - ".$estado." - ".$propiedad." - ".$tipoenvase.")</br>";
						$message = $message."Cliente: ".$cliente."</br>";
						$message = $message."</br>";
						}
					//$class="alert alert-success";
					}
				}elseif ($nradio == "M"){
					$DB= new Database();
					$nremito = $DB->sanitize($_POST['nremito']);
					$envdev = isset($_POST['EnvDev']) ? $_POST['EnvDev'] : false;
					$nserie = $DB->sanitize($_POST['nserie']);
					$nserieModi = $DB->sanitize($_POST['nserieModi']);
					$capacidad = explode("|",$_POST['capacidad']);
					
					$nserieTotal = $nserie."\-/".$nserieModi;
					
					//echo "<pre>";
					//echo $nremito."</br>".$envdev."</br>".$nserie."</br>".$nserieModi."</br>".$nserieTotal."</br>".$capacidad[0]."</br>".$nradio."</br>";
					//echo "</pre>";
					
					$res = $DB->prABMSeriev1($nremito,$envdev,$nserieTotal,$capacidad[0],$nradio);
					$row_cnt = mysqli_num_rows($res);
					if ($row_cnt == 0){
						$message= "No se modificaron movimientos."."</br>";
						//$class="alert alert-info";
					}elseif($row_cnt == 1){
						$message= "Se modificó ".$row_cnt." movimiento con éxito."."</br>"."</br>";
						while ($row=mysqli_fetch_object($res)){
					
							$cliente = $row->nombre;
							$fecha = date("d-m-Y", strtotime($row->fecha));
							$remito = $row->remito;
							$estado = $row->estado;
							$estadoModi = $row->estadoModi;
							$serie = $row->serie;
							$serieModi = $row->serieModi;
							//$serie = explode("\-/",$row->serie);
							$capacidad = $row->volumen;
							$capacidadModi = $row->volumenModi;
							$propiedad = $row->propiedad;
							$tipoenvase = $row->tipo;
							$message = $message."Fecha: ".$fecha."</br>";
							$message = $message."Remito: ".$remito."</br>";
							$message = $message."N° Envase (Ant): ".$serie." (".$capacidad." - ".$estado." - ".$propiedad." - ".$tipoenvase.")</br>";
							$message = $message."N° Envase (Act): ".$serieModi." (".$capacidadModi." - ".$estadoModi." - ".$propiedad." - ".$tipoenvase.")</br>";
							$message = $message."Cliente: ".$cliente."</br>";
							
						}
						
					}
					
				}
					
			}
			?>
			
		

<script type="text/javascript">
	
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
		
		var sprop = "";
		var stenv = "";
		var sfecha = "";
		var sid_xl = "";
		var sclie = "";
		
		
		var bCapVal = false;
		var bEnvDevVal = false;
		var bSerieVal = true;
		var bSerieModiVal = true;
		var nradioVal = '<?php echo $nradio; ?>';
		//console.log("Valor de nradioVal al ingresar en document ready -> "+nradioVal);
		
		jq('#lbllisto').css("background-color","#EE2C25");
		jq('#lbllisto').css("color","#FFFFFF");
		
		jq('#lblMsgInformacion').css("background-color","#B8D4FE");
		jq('#lblMsgInformacion').css("color","#000333");
		
		jq('#capExiste').css("background-color","#F5F5F5");
		jq('#capExiste').css("color","#000333");
		
		jq.fn.setHiddenV = function(hId, hValue){
			jq('#'+hId).val(hValue)
                 //.trigger('change');
		}
		
		//Limpia div Mensajes
		jq.fn.cleandivMSG = function(bOne,bTwo,bThr,bFou,bFiv){
			if(bOne == true){
				jq('#divRemito').children().each(function (index) {
					jq(this).remove();
				});
			}
			if(bTwo == true){
				jq('#divSerie').children().each(function (index) {
					jq(this).remove();
				});
			}
			if(bThr == true){
				jq('#divSerieModi').children().each(function (index) {
					jq(this).remove();
				});
			}
			if(bFou == true){
				jq('#divCapacidad').children().each(function (index) {
					jq(this).remove();
				});
			}
			if(bFiv == true){
				jq('#divMensaje').children().each(function (index) {
					jq(this).remove();
				});
			}
		}	
		
		//Limpia div Objetos
		jq.fn.cleandivOBJ = function(bOne){
			if(bOne == true){
				jq('#inpSerieModi').children().each(function (index) {
					jq(this).remove();
				});
			}
			
		}
		
		//Setea botonera (OptionButton) ENV | DEV - NP | SP - CIL | TER
		jq.fn.setOptionCss = function(sValue,sprop,stenv,sest){
			//console.log("sValue -> "+sValue+" |-| sprop -> "+sprop+" |-| stenv -> "+stenv);
			switch(sValue) {
				//Campo remito vacío - Se resetea Estado, Propiedad y Tipo de Envase
				case 0:
					jq('#lblTipoMovE').css("background-color","#F5F5F5");
					jq('#lblTipoMovE').css("color","#000333");
					jq('#lblTipoMovD').css("background-color","#F5F5F5");
					jq('#lblTipoMovD').css("color","#000333");
					jq('#lblPropNP').css("background-color","#F5F5F5");
					jq('#lblPropNP').css("color","#000333");
					jq('#lblPropSP').css("background-color","#F5F5F5");
					jq('#lblPropSP').css("color","#000333");
					jq('#lblTipoEnvC').css("background-color","#F5F5F5");
					jq('#lblTipoEnvC').css("color","#000333");
					jq('#lblTipoEnvT').css("background-color","#F5F5F5");
					jq('#lblTipoEnvT').css("color","#000333");
					jq("input:radio[name=prop][value=NP]").removeAttr("checked");
					jq("input:radio[name=prop][value=SP]").removeAttr("checked");
					jq("input:radio[name=env][value=CIL]").removeAttr("checked");
					jq("input:radio[name=env][value=TER]").removeAttr("checked");
					jq("input:radio[name=EnvDev]").removeAttr("disabled");
					jq("input:radio[name=prop]").removeAttr("disabled");
					jq("input:radio[name=env]").removeAttr("disabled");
					jq('#nserie').val("");
					jq("#capacidad option:selected").css("background-color",'#FFFFFF');
					jq("#capacidad option[value='0']").attr("selected", true);
					jq("#selABMCapacidad").css("background-color",'#FFFFFF');
					break;
				case 1:
					jq('#lblPropNP').css("background-color","#F5F5F5");
					jq('#lblPropNP').css("color","#000333");
					jq('#lblPropSP').css("background-color","#F5F5F5");
					jq('#lblPropSP').css("color","#000333");
					jq('#lblTipoEnvC').css("background-color","#F5F5F5");
					jq('#lblTipoEnvC').css("color","#000333");
					jq('#lblTipoEnvT').css("background-color","#F5F5F5");
					jq('#lblTipoEnvT').css("color","#000333");
					jq("input:radio[name=prop][value=NP]").removeAttr("checked");
					jq("input:radio[name=prop][value=SP]").removeAttr("checked");
					jq("input:radio[name=env][value=CIL]").removeAttr("checked");
					jq("input:radio[name=env][value=TER]").removeAttr("checked");
					jq('#nserie').val("");
					jq("#capacidad option:selected").css("background-color",'#FFFFFF');
					jq("#capacidad option[value='0']").attr("selected", true);
					jq("#selABMCapacidad").css("background-color",'#FFFFFF');
					break;
				case 2:
					jq('#lblPropNP').css("background-color","#FAE605");
					jq('#lblPropNP').css("color","#140CC5");
					jq('#lblPropSP').css("background-color","#FAE605");
					jq('#lblPropSP').css("color","#140CC5");
					if(stenv == 'CIL'){
						jq('#lblTipoEnvC').css("background-color","#92FF8A");
						jq('#lblTipoEnvC').css("color","#000333");
						jq('#lblTipoEnvT').css("background-color","#F5F5F5");
						jq('#lblTipoEnvT').css("color","#000333");
					}else{
						jq('#lblTipoEnvT').css("background-color","#92FF8A");
						jq('#lblTipoEnvT').css("color","#000333");
						jq('#lblTipoEnvC').css("background-color","#F5F5F5");
						jq('#lblTipoEnvC').css("color","#000333");
					}
					break;
				case 3:
					if(sprop == 'NP'){
						jq('#lblPropNP').css("background-color","#92FF8A");
						jq('#lblPropNP').css("color","#000333");
						jq('#lblPropSP').css("background-color","#F5F5F5");
						jq('#lblPropSP').css("color","#000333");
					}else{
						jq('#lblPropSP').css("background-color","#92FF8A");
						jq('#lblPropSP').css("color","#000333");
						jq('#lblPropNP').css("background-color","#F5F5F5");
						jq('#lblPropNP').css("color","#000333");
					}
					jq('#lblTipoEnvC').css("background-color","#FAE605");
					jq('#lblTipoEnvC').css("color","#140CC5");
					jq('#lblTipoEnvT').css("background-color","#FAE605");
					jq('#lblTipoEnvT').css("color","#140CC5");
					break;
				case 4:
					if(sprop == 'NP'){
						jq('#lblPropNP').css("background-color","#92FF8A");
						jq('#lblPropNP').css("color","#000333");
						jq('#lblPropSP').css("background-color","#F5F5F5");
						jq('#lblPropSP').css("color","#000333");
					}else{
						jq('#lblPropSP').css("background-color","#92FF8A");
						jq('#lblPropSP').css("color","#000333");
						jq('#lblPropNP').css("background-color","#F5F5F5");
						jq('#lblPropNP').css("color","#000333");
					}
					if(stenv == 'CIL'){
						jq('#lblTipoEnvC').css("background-color","#92FF8A");
						jq('#lblTipoEnvC').css("color","#000333");
						jq('#lblTipoEnvT').css("background-color","#F5F5F5");
						jq('#lblTipoEnvT').css("color","#000333");
					}else{
						jq('#lblTipoEnvT').css("background-color","#92FF8A");
						jq('#lblTipoEnvT').css("color","#000333");
						jq('#lblTipoEnvC').css("background-color","#F5F5F5");
						jq('#lblTipoEnvC').css("color","#000333");
					}
					jq("input:radio[name=EnvDev]").attr("disabled",false);
					jq("input:radio[name=prop][value="+sprop+"]").prop('checked', true);
					jq("input:radio[name=env][value="+stenv+"]").prop('checked', true);
					jq("input:radio[name=prop]").attr("disabled",true);
					jq("input:radio[name=env]").attr("disabled",true);
					jq("#nserie").removeAttr("disabled");
					break;
				case 5:
					jq('#lblPropNP').css("background-color","#FAE605");
					jq('#lblPropNP').css("color","#000333");
					jq('#lblPropSP').css("background-color","#FAE605");
					jq('#lblPropSP').css("color","#000333");
					jq('#lblTipoEnvC').css("background-color","#FAE605");
					jq('#lblTipoEnvC').css("color","#000333");
					jq('#lblTipoEnvT').css("background-color","#FAE605");
					jq('#lblTipoEnvT').css("color","#000333");
					break;
				case 6:
					if(sprop == 'NP'){
						jq('#lblPropNP').css("background-color","#92FF8A");
						jq('#lblPropNP').css("color","#000333");
						jq('#lblPropSP').css("background-color","#F5F5F5");
						jq('#lblPropSP').css("color","#000333");
					}else{
						jq('#lblPropSP').css("background-color","#92FF8A");
						jq('#lblPropSP').css("color","#000333");
						jq('#lblPropNP').css("background-color","#F5F5F5");
						jq('#lblPropNP').css("color","#000333");
					}
					if(sprop == 'NP'){
						jq('#lblPropNP').css("background-color","#92FF8A");
						jq('#lblPropNP').css("color","#000333");
						jq('#lblPropSP').css("background-color","#F5F5F5");
						jq('#lblPropSP').css("color","#000333");
					}else{
						jq('#lblPropSP').css("background-color","#92FF8A");
						jq('#lblPropSP').css("color","#000333");
						jq('#lblPropNP').css("background-color","#F5F5F5");
						jq('#lblPropNP').css("color","#000333");
					}
					if(stenv == 'CIL'){
						jq('#lblTipoEnvC').css("background-color","#92FF8A");
						jq('#lblTipoEnvC').css("color","#000333");
						jq('#lblTipoEnvT').css("background-color","#F5F5F5");
						jq('#lblTipoEnvT').css("color","#000333");
					}else{
						jq('#lblTipoEnvT').css("background-color","#92FF8A");
						jq('#lblTipoEnvT').css("color","#000333");
						jq('#lblTipoEnvC').css("background-color","#F5F5F5");
						jq('#lblTipoEnvC').css("color","#000333");
					}
					jq("input:radio[name=EnvDev]").attr("disabled",true);
					jq("input:radio[name=prop][value="+sprop+"]").prop('checked', true);
					jq("input:radio[name=env][value="+stenv+"]").prop('checked', true);
					jq("input:radio[name=prop]").attr("disabled",true);
					jq("input:radio[name=env]").attr("disabled",true);
					jq("#nserie").removeAttr("disabled");
					break;
				case 7:
					if(sest == 'E'){
						jq('#lblTipoMovE').css("background-color","#92FF8A");
						jq('#lblTipoMovE').css("color","#000333");
						jq('#lblTipoMovD').css("background-color","#F5F5F5");
						jq('#lblTipoMovD').css("color","#000333");
					}else if(sest == 'D'){
						jq('#lblTipoMovD').css("background-color","#92FF8A");
						jq('#lblTipoMovD').css("color","#000333");
						jq('#lblTipoMovE').css("background-color","#F5F5F5");
						jq('#lblTipoMovE').css("color","#000333");
					}else{
						jq('#lblTipoMovD').css("background-color","#FA8A05");
						jq('#lblTipoMovD').css("color","#000333");
						jq('#lblTipoMovE').css("background-color","#FA8A05");
						jq('#lblTipoMovE').css("color","#000333");
					}
					if(stenv == 'CIL'){
						jq('#lblTipoEnvC').css("background-color","#92FF8A");
						jq('#lblTipoEnvC').css("color","#000333");
						jq('#lblTipoEnvT').css("background-color","#F5F5F5");
						jq('#lblTipoEnvT').css("color","#000333");
					}else{
						jq('#lblTipoEnvT').css("background-color","#92FF8A");
						jq('#lblTipoEnvT').css("color","#000333");
						jq('#lblTipoEnvC').css("background-color","#F5F5F5");
						jq('#lblTipoEnvC').css("color","#000333");
					}
					jq.fn.setHiddenV('envdevH', sest);
					jq("input:radio[name=EnvDev][value="+sest+"]").prop('checked', true);
					jq("input:radio[name=prop][value="+sprop+"]").prop('checked', true);
					jq("input:radio[name=env][value="+stenv+"]").prop('checked', true);
					jq("input:radio[name=EnvDev]").attr("disabled",true);
					jq("input:radio[name=prop]").attr("disabled",true);
					jq("input:radio[name=env]").attr("disabled",true);
					jq("#nserie").removeAttr("disabled");
					break;
			}
		}
		
		var scolmod = '<?php echo $scolmod; ?>';
		
		//Procesa los OptionButton Insertar - Modificar - Eliminar
		jq.fn.inputradio = function(nradioVal){ 
			var preI = '<pre class="lx-pre">';
			var preF = '</pre>';
			
			jq.fn.cleandivMSG(true,true,false,false,false);
			
			if (nradioVal == 'A') {
					jq('#lblMsgInformacion').css("background-color","#D1E3FD");
					jq('#lblMsgInformacion').css("color","#000333");
					jq('#lblMsgInformacion').text("Agrega un envase al remito ingresado");
					scolmod = 'col-md-0';
					jq('#lblABMSerie').html(preI+"N° Envase"+preF);
					//console.log("Entrando en A -> ");	
					
					jq('#inpSerieModi').removeClass();
					jq('#inpSerieModi').addClass(scolmod);
					jq('#divSerieModi').removeClass();
					jq('#divSerieModi').addClass(scolmod);
					
					jq.fn.cleandivMSG(true,true,true,true,true);
					jq.fn.cleandivOBJ(true);
					
					var lblrad = '<label><pre class="lx-pre">E <input type="radio" name="EnvDev" class="envdev" value="E" required  /></pre></label><label><pre class="lx-pre">D <input type="radio" name="EnvDev" class="envdev" value="D" required  /></pre></label><label><pre class="lx-pre">NP <input type="radio" name="prop" value="NP" required /></pre></label><label><pre class="lx-pre">SP <input type="radio" name="prop" value="SP" required  /></pre></label><label><pre class="lx-pre">CIL <input type="radio" name="env" value="CIL" required /></pre></label><label><pre class="lx-pre">TER <input type="radio" name="env" value="TER" required  /></pre></label>';
				
					jq("#nremito").val('');
					jq("#nserie").val('');
			}
			else if (nradioVal == 'B') {
					jq('#lblMsgInformacion').css("background-color","#D1E3FD");
					jq('#lblMsgInformacion').css("color","#000333");
					jq('#lblMsgInformacion').text("Elimina un envase del remito ingresado");
					scolmod = 'col-md-0';
					jq('#lblABMSerie').html(preI+"N° Envase"+preF);
					
					jq('#inpSerieModi').removeClass();
					jq('#inpSerieModi').addClass(scolmod);
					jq('#divSerieModi').removeClass();
					jq('#divSerieModi').addClass(scolmod);
					
					jq.fn.cleandivMSG(true,true,true,true,true);
					jq.fn.cleandivOBJ(true);
					
					jq("#nremito").val('');
					jq("#nserie").val('');
					
			}
			else if (nradioVal == 'M') {
					jq('#lblMsgInformacion').css("background-color","#D1E3FD");
					jq('#lblMsgInformacion').css("color","#000333");
					jq('#lblMsgInformacion').text("Modifica serie y/o capacidad de envase en el remito ingresado");
					scolmod = 'col-md-2';
					
					jq('#lblABMSerie').html(preI+"N° Envase (Actual)"+preF);
					
					jq('#divRemito').children().each(function (index) {
						jq(this).remove();
					});
					
					jq('#divCapacidad').children().each(function (index) {
						jq(this).remove();
					});
					
					jq('#inpSerieModi').removeClass();
					jq('#inpSerieModi').addClass(scolmod);
					jq('#divSerieModi').removeClass();
					jq('#divSerieModi').addClass(scolmod);
					
					var oarSerie = '<label id="lblABMSerie"><pre class="lx-pre">N° Envase (Nuevo)</pre></label></br><label><pre class="lx-pre"><input type="text" name="nserieModi" id="nserieModi" class="form-control input-sm" maxlength="12" autocomplete="on" required value="<?php $nserieModi; ?>"/></pre></label>';
					
					jq('#inpSerieModi').append(oarSerie);
					
					jq("#nremito").val('');
					jq("#nserie").val('');
					
			}
		}
		
		jq.fn.inputradio(nradioVal);
		
		
		jq("#nremito").focusout('input', function(){
			
			jq.fn.cleandivMSG(true,true,true,true,true);
			jq("#rows").remove();
			
			var sRemito = jq(this).val();
			jq.ajax({
				url:"./ajax4full-v1.php",
				dataType: "json",
				//data: {"nremito": sRemito, "abmOpcion":abmOpcion},
				data: {"nremito": sRemito},
				type:"POST",
				success:function(response){
					//var bres = false;
					var len = response.length;
					for(var i=0; i<len; i++){
						var ifecha = response[i].var1;
						var iid_xl = response[i].var2;
						var iprop = response[i].var3;
						var itipo = response[i].var4;
						sdatoremito = response[i].var5;
						sprop = response[i].var7;
						stenv = response[i].var8;
						sfecha = response[i].var9;
						sid_xl = response[i].var10;
						sclie = response[i].var11;
						var bres = response[i].var6;
						if(ifecha == 1 && iid_xl == 1 && iprop == 1 && itipo == 1 && bres == true){
							jq("#divRemito").html(sdatoremito);
							jq('#lbldivRemito').css("background-color","#92FF8A");
							jq('#lbldivRemito').css("color","#140CC5");
							jq.fn.setOptionCss(4,sprop,stenv);
							
						}else if(ifecha == 0 && iid_xl == 0 && iprop == 0 && itipo == 0 && bres == true){
							jq("#divRemito").html(sdatoremito);
							jq('#lbldivRemito').css("background-color","#FAE605");
							jq('#lbldivRemito').css("color","#140CC5");
							jq("#nserie").prop("disabled",true);
							jq("input:radio[name=EnvDev]").attr("disabled",true);
							jq("input:radio[name=prop]").attr("disabled",true);
							jq("input:radio[name=env]").attr("disabled",true);
							jq.fn.setOptionCss(1);
						
							var sMsgUno = "<label><pre class='lx-pre' id='lblMSGSerie'>Utilice botón Alta Remito para cargar nuevo remito</pre></label>";
							jq("#divMensaje").html(sMsgUno);
							jq('#lblMSGSerie').css("background-color","#FAE605");
							jq('#lblMSGSerie').css("color","#140CC5");
							
						}else if(ifecha == 0 && iid_xl == 0 && iprop == 0 && itipo == 0 && bres == false){
							jq("#nserie").prop("disabled",true);
							jq("input:radio[name=EnvDev]").attr("disabled",true);
							jq("input:radio[name=prop]").attr("disabled",true);
							jq("input:radio[name=env]").attr("disabled",true);
							
							jq.fn.setOptionCss(1);
							
							var sMsgUno = "<label><pre class='lx-pre' id='lblMSGSerie'>Atención. El dato ingresado no es válido. Remito N° "+sRemito+"</pre></label>";
							jq("#divMensaje").html(sMsgUno);
							jq('#lblMSGSerie').css("background-color","#EE2C25");
							jq('#lblMSGSerie').css("color","#FFFFFF");
						
						}else if(ifecha !== 0 || iid_xl !== 0 || iprop !== 0 || itipo !== 0 && bres == true){
							jq("#divRemito").html(sdatoremito);
							if(iprop > 1 && itipo == 1){
								jq("input:radio[name=env][value="+stenv+"]").prop("checked", true);
								jq.fn.setOptionCss(2,sprop,stenv);
							}
							if(itipo > 1 && iprop == 1){
								jq("input:radio[name=prop][value="+sprop+"]").prop("checked", true);
								jq.fn.setOptionCss(3,sprop,stenv);
							}
							if(itipo > 1 && iprop >1){
								jq("input:radio[name=prop][value="+sprop+"]").removeAttr("checked");
								jq("input:radio[name=env][value="+stenv+"]").removeAttr("checked");
								jq.fn.setOptionCss(5,sprop,stenv);
							}
							jq('#lbldivRemito').css("background-color","#FAE605");
							jq('#lbldivRemito').css("color","#140CC5");
							
							jq("input:radio[name=EnvDev]").attr("disabled",true);
							jq("input:radio[name=prop]").attr("disabled",true);
							jq("input:radio[name=env]").attr("disabled",true);
							jq("#nserie").prop("disabled", true);
							
						}
					}
					
				}
			});
			
		});
		
		jq.fn.serieIngresar = function(nradioVal){
			
			jq.fn.cleandivMSG(false,true,false,false,false);
				
			var lblcapacidadExiste = "<label><pre class='lx-pre' id='capacidadExiste'></pre></label>";
			var sSerie = jq("#nserie").val();
			var sRemito = jq("#nremito").val();
			var aCapacidad = [];
			jq.ajax({
				url:"./ajax1full-v1.php",
				dataType: "json",
				data: {"fecha": sfecha,"nremito": sRemito, "nserie": sSerie, "id_xl": sid_xl, "prop": sprop, "tenv": stenv, "qr": nradioVal},
				//data: {"fecha": sfecha,"nremito": sRemito, "nserie": sSerie, "id_xl": sid_xl, "prop": sprop, "tenv": stenv},
				type:"POST",
				success:function(response){
					var len = response.length;
					for(var i=0; i<len; i++){
						var imov = response[i].var1;
						var ienv = response[i].var2;
						var icap = response[i].var3;
						var sest = response[i].var4;
						var scap = response[i].var5;
						jq("#capacidad").html(scap);
						jq("#capacidad option").each(function()
						{
							aCapacidad.push(jq(this).val());
						});
						
						for(var i=1; i<aCapacidad.length; i++){
							if(ienv == 1){
								var optCap = aCapacidad[i];
								var sCapArr = optCap.split('|');
								if(icap == sCapArr[0]){
									jq("#capacidad option[value='"+optCap+"']").attr("selected", true);
									jq("#capacidad option:selected").css("background-color",'#FAE605');
									jq("#selABMCapacidad").css("background-color",'#FAE605');
								}
							}
						}
						if(imov > 0){
							var sMsg = "<label><pre class='lx-pre' id='lbldivSerie'>Encontrado ("+sest+")</pre></label>";
							jq("#divSerie").html(sMsg);
							jq('#lbldivSerie').css("background-color","#FAE605");
							jq('#lbldivSerie').css("color","#140CC5");
							//console.log("Pasando por encontrado...");
							
							var sMsgUno = "<label><pre class='lx-pre' id='lblMSGSerie'>Envase ingresado en el remito "+sRemito+"</pre></label>";
							jq("#divMensaje").html(sMsgUno);
							jq('#lblMSGSerie').css("background-color","#FAE605");
							jq('#lblMSGSerie').css("color","#140CC5");
							
							bSerieVal = false;
						}else{
							var sMsg = "<label><pre class='lx-pre' id='lbldivSerie'>No Encontrado</pre></label>";
							jq("#divSerie").html(sMsg);
							jq('#lbldivSerie').css("background-color","#92FF8A");
							jq('#lbldivSerie').css("color","#140CC5");
							
							//console.log("Pasando por NO encontrado...");
							
							jq('#divMensaje').children().each(function (index) {
									jq(this).remove();
							});
							bSerieVal = true;
						}
						if(icap > 0){
							var sMsg = "<label><pre class='lx-pre' id='capExiste'>Capacidad: "+icap+"</pre></label>";
							jq("#divCapacidad").html(sMsg);
							jq('#capExiste').css("background-color","#92FF8A");
							jq('#capExiste').css("color","#140CC5");
							jq("#capacidad option:selected").css("background-color",'#92FF8A');
							jq("#selABMCapacidad").css("background-color",'#92FF8A');
							bCapVal = true;
							//console.log("Pasando por ajax...");
						}else{
							var sMsg = "<label><pre class='lx-pre' id='capExiste'>Capacidad: N/D</pre></label>";
							jq("#divCapacidad").html(sMsg);
							jq('#capExiste').css("background-color","#FAE605");
							jq('#capExiste').css("color","#140CC5");
							jq("#capacidad option:selected").css("background-color",'#FAE605');
							jq("#selABMCapacidad").css("background-color",'#FAE605');
						
						}
					}
					jq.fn.chkData();
				}
			})
		}
		
		
		jq.fn.serieModificar = function(oSerie){
			
			jq.fn.cleandivMSG(false,false,false,false,false);
			var lblcapacidadExiste = "<label><pre class='lx-pre' id='capacidadExiste'></pre></label>";
			if(oSerie == 'ns'){
				var sSerie = jq("#nserie").val();
				var odiv = 'divSerie';
				var olbl = 'lbldivSerie';
				var nradioValModi = 'Z';
			}else if(oSerie == 'nsmodi'){
				var sSerie = jq("#nserieModi").val();
				var odiv = 'divSerieModi';
				var olbl = 'lbldivSerieModi';
				var nradioValModi = 'B';
			}
			var sRemito = jq("#nremito").val();
			var aCapacidad = [];
			jq.ajax({
				url:"./ajax1full-v1.php",
				dataType: "json",
				//data: {"fecha": sfecha,"nremito": sRemito, "nserie": sSerie, "id_xl": sid_xl, "prop": sprop, "tenv": stenv},
				data: {"fecha": sfecha,"nremito": sRemito, "nserie": sSerie, "id_xl": sid_xl, "prop": sprop, "tenv": stenv, "qr": nradioValModi},
				type:"POST",
				success:function(response){
					var len = response.length;
					for(var i=0; i<len; i++){
						var imov = response[i].var1;
						var ienv = response[i].var2;
						var icap = response[i].var3;
						var sest = response[i].var4;
						var scap = response[i].var5;
						jq("#capacidad").html(scap);
						jq("#capacidad option").each(function()
						{
							aCapacidad.push(jq(this).val());
						});
						
						if(oSerie == 'nsmodi'){
						for(var i=1; i<aCapacidad.length; i++){
							if(ienv == 1){
								var optCap = aCapacidad[i];
								var sCapArr = optCap.split('|');
								if(icap == sCapArr[0]){
									jq("#capacidad option[value='"+optCap+"']").attr("selected", true);
									jq("#capacidad option:selected").css("background-color",'#FAE605');
									jq("#selABMCapacidad").css("background-color",'#FAE605');
								}
							}
						}
						}
						if(imov > 0){
							if(oSerie == 'ns'){
								var sMsg = "<label><pre class='lx-pre' id='"+olbl+"'>Encontrado ("+icap+" - "+sest+")</pre></label>";
								jq('#'+odiv).html(sMsg);
								//jq('#'+olbl).css("background-color","#92FF8A");
							jq('#'+olbl).css("color","#140CC5");
							}
							
							if(oSerie == 'nsmodi'){
								var sMsg = "<label><pre class='lx-pre' id='"+olbl+"'>Encontrado ("+sest+")</pre></label>";
								jq('#'+odiv).html(sMsg);
								//jq('#'+olbl).css("background-color","#92FF8A");
							jq('#'+olbl).css("color","#140CC5");
							}
							
							if(oSerie == 'ns'){
								bSerieVal = true;
								jq('#'+olbl).css("background-color","#92FF8A");
								//jq.fn.setOptionCss(4,sprop,stenv);
							}
							if(oSerie == 'nsmodi'){
								bSerieModiVal = true;
								jq('#'+olbl).css("background-color","#92FF8A");
								//jq.fn.setOptionCss(6,sprop,stenv);
							}
						}else{
							var sMsg = "<label><pre class='lx-pre' id='"+olbl+"'>No Encontrado</pre></label>";
							jq('#'+odiv).html(sMsg);
							//jq('#'+olbl).css("background-color","#FAE605");
							jq('#'+olbl).css("color","#140CC5");
							
							//console.log("Pasando por NO encontrado...");
							
							if(oSerie == 'ns'){
								bSerieVal = false;
								jq('#'+olbl).css("background-color","#FAE605");
								//jq.fn.setOptionCss(6,sprop,stenv);
							}
							if(oSerie == 'nsmodi'){
								bSerieModiVal = true;
								jq('#'+olbl).css("background-color","#92FF8A");
								//jq.fn.setOptionCss(4,sprop,stenv);
							}
						}
						
						if(bSerieVal == true && bSerieModiVal == true){
							jq.fn.setOptionCss(4,sprop,stenv);
						}else{
							jq.fn.setOptionCss(6,sprop,stenv);
						}
						
						if(oSerie == 'nsmodi'){
							if(icap > 0){
								var sMsg = "<label><pre class='lx-pre' id='capExiste'>Capacidad: "+icap+"</pre></label>";
								jq("#divCapacidad").html(sMsg);
								jq('#capExiste').css("background-color","#92FF8A");
								jq('#capExiste').css("color","#140CC5");
								jq("#capacidad option:selected").css("background-color",'#92FF8A');
								jq("#selABMCapacidad").css("background-color",'#92FF8A');
								bCapVal = true;
								//console.log("Pasando por ajax...");
							}else{
								var sMsg = "<label><pre class='lx-pre' id='capExiste'>Capacidad: N/D</pre></label>";
								jq("#divCapacidad").html(sMsg);
								jq('#capExiste').css("background-color","#FAE605");
								jq('#capExiste').css("color","#140CC5");
								jq("#capacidad option:selected").css("background-color",'#FAE605');
								jq("#selABMCapacidad").css("background-color",'#FAE605');
							}
						}
					}
					jq.fn.chkData();
				}
			})
		}
		
		
		jq.fn.serieEliminar = function(nradioVal){
			
			jq.fn.cleandivMSG(false,true,false,false,false);
			var lblcapacidadExiste = "<label><pre class='lx-pre' id='capacidadExiste'></pre></label>";
			var sSerie = jq("#nserie").val();
			var sRemito = jq("#nremito").val();
			var aCapacidad = [];
			jq.ajax({
				url:"./ajax1full-v1.php",
				dataType: "json",
				//data: {"fecha": sfecha,"nremito": sRemito, "nserie": sSerie, "id_xl": sid_xl, "prop": sprop, "tenv": stenv},
				data: {"fecha": sfecha,"nremito": sRemito, "nserie": sSerie, "id_xl": sid_xl, "prop": sprop, "tenv": stenv, "qr": nradioVal},
				type:"POST",
				success:function(response){
					var len = response.length;
					for(var i=0; i<len; i++){
						var imov = response[i].var1;
						var ienv = response[i].var2;
						var icap = response[i].var3;
						var sest = response[i].var4;
						var scap = response[i].var5;
						jq("#capacidad").html(scap);
						jq("#capacidad option").each(function()
						{
							aCapacidad.push(jq(this).val());
						});
						
						//console.log("Valor de sest -> "+sest);
						
						for(var i=1; i<aCapacidad.length; i++){
							if(ienv == 1){
								var optCap = aCapacidad[i];
								var sCapArr = optCap.split('|');
								if(icap == sCapArr[0]){
									jq("#capacidad option[value='"+optCap+"']").attr("selected", true);
									jq("#capacidad option:selected").css("background-color",'#FAE605');
									jq("#selABMCapacidad").css("background-color",'#FAE605');
								}
							}
						}
						if(imov > 0){
							var sMsg = "<label><pre class='lx-pre' id='lbldivSerie'>Encontrado ("+sest+")</pre></label>";
							jq("#divSerie").html(sMsg);
							jq('#lbldivSerie').css("background-color","#92FF8A");
							jq('#lbldivSerie').css("color","#140CC5");
							
							bSerieVal = true;
						}else{
							var sMsg = "<label><pre class='lx-pre' id='lbldivSerie'>No Encontrado</pre></label>";
							jq("#divSerie").html(sMsg);
							jq('#lbldivSerie').css("background-color","#FAE605");
							jq('#lbldivSerie').css("color","#140CC5");
							
							bSerieVal = false;
						}
						console.log("Valor de icap -> "+icap);
						jq.fn.setOptionCss(7,sprop,stenv,sest);
					}
					jq.fn.chkData();
				}
			})
		}
		
		
		jq("#nserie").focusout('input', function(){
			//console.log("Valor de nradioVal visto desde focusout -> "+nradioVal);
			if (nradioVal == 'A') {
				jq.fn.serieIngresar();
			}
			if (nradioVal == 'M') {
				var oSerie = 'ns';
				jq.fn.serieModificar(oSerie);
			}
			if (nradioVal == 'B') {
				jq.fn.serieEliminar();
			}
			
		});
		
		
		//Event binding on dynamically created elements | Input Serie Modificado
		jq("#inpSerieModi").on('focusout','#nserieModi', function(){
			if (nradioVal == 'M') {
				var oSerie = 'nsmodi';
				jq.fn.serieModificar(oSerie);
			}
		});
		
		
		//OptionButton CIL | TER
		jq("#optMPT").on('click','.envRadio', function(){
			
			sTipo = jq(this).val();	
			jq.ajax({
				url:"./ajaxConsultaTipoEnvase-v1.php",
				dataType: "json",
				data: {"sTipo": sTipo},
				type:"POST",
				success:function(response){
					var len = response.length;
					for(var i=0; i<len; i++){
						var header1 = response[i].header1;
						jq("#capacidad").html(header1);
						}
					}
				});
		});
		
		//OptionButton ENV | DEV
		jq("#optMPT").on('click','.envdevRadio', function(){
			
			if(jq(this).val() == 'E'){
				jq('#lblTipoMovE').css("background-color","#92FF8A");
				jq('#lblTipoMovE').css("color","#000333");
				jq('#lblTipoMovD').css("background-color","#F5F5F5");
				jq('#lblTipoMovD').css("color","#000333");
			}else{
				jq('#lblTipoMovE').css("background-color","#F5F5F5");
				jq('#lblTipoMovE').css("color","#000333");
				jq('#lblTipoMovD').css("background-color","#92FF8A");
				jq('#lblTipoMovD').css("color","#000333");
			}
			bEnvDevVal = true;
			jq.fn.chkData();
		});
		
		//OptionButton Insertar - Modificar - Eliminar
		jq("input[name=abmOpcion]").click(function () {
			jq.fn.setOptionCss(0);
			nradioVal = jq(this).val();
			jq.fn.inputradio(nradioVal);
			jq("#rows").remove();
			
		});
		
		//Event binding on dynamically created elements | Combo Capacidad
		jq("#cmbCapacidad").on('change','#capacidad', function(){
			sCapArr = jq(this).val().split('|');
			iCap = sCapArr[0];
			var sMsg = "<label><pre class='lx-pre' id='capExiste'>Capacidad: "+iCap+"</pre></label>";
			jq("#divCapacidad").html(sMsg);
			jq('#capExiste').css("background-color","#92FF8A");
			jq('#capExiste').css("color","#140CC5");
			if(iCap !== '0'){
				bCapVal = true;
			}else{
				bCapVal = false;
			}
			jq.fn.chkData();
		});
		
		
		
		//Chequea formulario
		jq.fn.chkData = function(){
			var aData = [];
			//console.log("bCapVal -> "+bCapVal+" |-| bEnvDevVal -> "+bEnvDevVal+" |-| bSerieVal -> "+bSerieVal);
			
			switch(nradioVal) {
				case 'B':
					if(bSerieVal == true ){
						aData.push(true);
					}else{
						aData.push(false);
					}
					break;
				
				default:	
					if(jq("#capacidad").val() == 0 ){
						aData.push(false);
					}
								
					if(bCapVal == true ){
						aData.push(true);
					}else{
						aData.push(false);
					}
					
					if(bEnvDevVal == true ){
						aData.push(true);
					}else{
						aData.push(false);
					}
					
					if(bSerieVal == true ){
						aData.push(true);
					}else{
						aData.push(false);
					}
					
					if(bSerieModiVal == true ){
						aData.push(true);
					}else{
						aData.push(false);
					}
			}
			var bVal = true;
			for(j = 0 ;j < aData.length ;j++){
				bVal = bVal && aData[j];
				
			}
			//console.log("Valor de bVal -> "+bVal );
			if(bVal){
				jq('#lbllisto').css("background-color","#92FF8A");
				jq('#lbllisto').css("color","#140CC5");
				jq('#lbllisto').text("Si");
				retVal = true; 
				}else{
					jq('#lbllisto').css("background-color","#EE2C25");
					jq('#lbllisto').css("color","#FFFFFF");
					jq('#lbllisto').text("No");
					retVal = false;
				}
			return retVal;
		}
		
		jq('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
			var returnValue = jq.fn.chkData();
			//var sconfirmsg = '';
			//sconfirmsg = "Desea insertar el movimiento en el remito?";
					
			if(returnValue == true){
				currentForm.submit();
				/*
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
				*/
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


