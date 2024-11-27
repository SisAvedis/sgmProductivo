
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="alquiler-v4.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php //include ("database_e.php"); ?>
			<?php include ("database_e4.php"); ?>
			<?php //require_once 'include/validacion.php';?>
			<?php require_once 'include/validacion4.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Cálculo Alquiler Envases</h4></div>
                </div>
            </div>
            
			<?php
			$DB= new Database();
			$idCL = 'XLS';
			$res = $DB->clientessg($idCL);
			//$res = $DB->clientesTodos();
			$iRow = 1;
			$clienteid_xl = array(0,0);
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			if ($clienteOption){
				$clienteid_xls = explode("|",$_POST['cliente']);
				$idcliente_xls = $clienteid_xls[2];
			}else{
				$idcliente_xls = 1;
			}
			?>
			
			
			<div class="row">
				<div class="col-md-6 table-responsive">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Clientes</th>
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
							<th class="text-center" colspan=2>Envase</th>
							<th class="text-center" colspan=2>Comparte</th>
						</tr>
						<tr>
							<th rowspan=3>
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
							<th class="text-center" rowspan=3><input type="text" name="fechaI" id="datepickerI" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
							<th class="text-center" rowspan=3><input type="text" name="fechaF" id="datepickerF" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
						</tr>
						<tr>
							<th class="text-center">CIL</th><th class="text-center">TER</th>
							<th class="text-center">Si</th><th class="text-center">No</th>
						</tr>
						<tr>
							<th class="text-center" ><input type="radio" checked="checked" name="tipoenv" value=1 required /></th> 
							<th class="text-center"><input type="radio" name="tipoenv" value=2 required /></th>
							<th class="text-center" ><input type="radio" name="comparte" value=1 required /></th> 
							<th class="text-center"><input type="radio" checked="checked" name="comparte" value=2 required /></th>
						</tr>
						<tr>	
							<th class="text-center" rowspan=5>Saldo Inicial (Opcional)</th>
							<th class="text-center" colspan=3>Producto</th>
							<th class="text-center" colspan=3>Cantidad</th>
							
						</tr>
						<tr>	
							<th class="text-center" colspan=3>(O2) Oxígeno</th>
							<th class="text-center" colspan=3><input type="text" name="sinicialO2" id="sinicialO2" class="form-control input-sm" maxlength="3" value="<?php $sinicial; ?>" autocomplete="off"/></th>
						</tr>
						<tr>
								<th class="text-center" colspan=3>(CO2) Dióxido de Carbono</th>
								<th class="text-center" colspan=3><input type="text" name="sinicialCO2" id="sinicialCO2" class="form-control input-sm" maxlength="3" value="<?php $sinicial; ?>" autocomplete="off"/></th>						
						</tr>
						<tr>
								<th class="text-center" colspan=3>(N2O) Óxido Nitroso</th>
								<th class="text-center" colspan=3><input type="text" name="sinicialN2O" id="sinicialN2O" class="form-control input-sm" maxlength="3" value="<?php $sinicial; ?>" autocomplete="off"/></th>						
						</tr>
						<tr>
								<th class="text-center" colspan=3>(Aire) Aire</th>
								<th class="text-center" colspan=3><input type="text" name="sinicialAIM" id="sinicialAIM" class="form-control input-sm" maxlength="3" value="<?php $sinicial; ?>" autocomplete="off"/></th>						
						</tr>
						
					
					
					</thead>
				</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-10">
				
				</div>
			
				<div class="col-md-12 pull-right">
					<button type="submit" class="btn btn-sm btn-danger">Consultar</button>
				</div>
				<hr>
			</div>
			
			
			<?php
			$TotalDias = '';
			$message = '';
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$comparte = isset($_POST['comparte']) ? $_POST['comparte'] : null;
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			$sinicialO2 = isset($_POST['sinicialO2']) ? $_POST['sinicialO2'] : null;
			$sinicialCO2 = isset($_POST['sinicialCO2']) ? $_POST['sinicialCO2'] : null;
			$sinicialN2O = isset($_POST['sinicialN2O']) ? $_POST['sinicialN2O'] : null;
			$sinicialAIM = isset($_POST['sinicialAIM']) ? $_POST['sinicialAIM'] : null;
			
			if ($tipoenv == 1){ 
				$tenv = 'CIL';
			}elseif ($tipoenv == 2){
				$tenv = 'TER';
			}
			
			if ($comparte == 1){ 
				$comp = 'S';
				$comparte = 'Si';
			}elseif ($comparte == 2){
				$comp = 'N';
				$comparte = 'No';
			}
			
			if ($sinicialO2){
				$sinicialO2 = $_POST['sinicialO2'];
			}else{
				$sinicialO2 = 0;
			}
			
			if ($sinicialCO2){
				$sinicialCO2 = $_POST['sinicialCO2'];
			}else{
				$sinicialCO2 = 0;
			}
			
			if ($sinicialN2O){
				$sinicialN2O = $_POST['sinicialN2O'];
			}else{
				$sinicialN2O = 0;
			}
			
			if ($sinicialAIM){
				$sinicialAIM = $_POST['sinicialAIM'];
			}else{
				$sinicialAIM = 0;
			}
			
			
			if ($clienteOption){
				
				$clienteid_xl = explode("|",$_POST['cliente']);
				$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
				$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
				if ($tipoenv == 1){ 
					$tenv = 'CIL';
				}elseif ($tipoenv == 2){
					$tenv = 'TER';
				}
				$res = $DB->prAlquilerEnvasev6($fechaI,$fechaF,$sinicialO2,$sinicialCO2,$sinicialN2O,$sinicialAIM,$clienteid_xl[0],$tenv,$comp);
				
				
				$fechaI = date_format(date_create($fechaI),"d-m-Y");
				$fechaF = date_format(date_create($fechaF),"d-m-Y");
				
				$row_cnt = mysqli_num_rows($res);
				
				if ($row_cnt == 0){
					$message= "No se obtuvieron registros";
					$class="alert alert-info";
				}elseif ($row_cnt == 1){
					$message= "Se obtuvo ".$row_cnt." registro";
					$class="alert alert-success";
				}else{
					$message= "Se obtuvieron ".$row_cnt. " registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Envase: ".$tenv.$tenv.". Comparte Envase: ".$comparte;
					$class="alert alert-success";
				}
				
				
				
				$message= "Se obtuvieron ".$row_cnt. " registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Envase: ".$tenv.". Comparte Envases: ".$comparte;
				if ($row_cnt == 0){
					$class="alert alert-info";
				}else{
					$class="alert alert-success";
				}
				?>
			
			<div class="<?php echo $class;?>" id="rows">
				  <?php echo $message;?>
			</div>
			<?php
			if ($row_cnt == 0){
			}else{
				$iCantRows = 1;
				?>
			
			<div class="row">
				<div class="col-md-8">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Fecha</th>
							<th class="text-center">Remito</th>
							<th class="text-center">Producto</th>
							<th class="text-right">Env</th>
							<th class="text-right">EnvDif</th>
							<th class="text-right">Dev</th>
							<th class="text-right">DevDif</th>
							<th class="text-right">Saldo</th>
							<th class="text-right">SaldoDif</th>
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
					
					if ($iCantRows == $row_cnt ){
						if(isset($row->fecha)){
							$TotalDias = $row->saldo;
							$TotalDiasDist = $row->saldodist;
						}else{
							$TotalDias = "Error";
							$TotalDiasDist = "Error";
						}
					}
					
					if(isset($row->ultimo)){
						$resultadoUL = $row->ultimo;
					}else{
						$resultadoUL = "N";
					}
					switch ($resultadoUL) {
						case "N":
							$claseULinea = "";
							break;
					case "S":
							$claseULinea = "success";
							break;
					}
					
						
				?>
					<tbody>
						<tr>
							<td class="text-center <?php echo $claseULinea;?>"><?php if(isset($row->fecha)){echo $row->fecha;}else{echo "Error";}?></td>
							<td class="text-center <?php echo $claseULinea;?>"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
							<td class="text-center <?php echo $claseULinea;?>"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
							<td class="text-right <?php echo $claseULinea;?>"><?php if(isset($row->env) && !is_null($row->env)){
											echo $row->env;
											}elseif(!isset($row->env) && is_null($row->env)){
												echo "";
											}else{
												echo "Error";
											}
										?>
							</td>
							<td class="text-right <?php echo $claseULinea;?>"><?php if(isset($row->envdist) && !is_null($row->envdist)){
											echo $row->envdist;
											}elseif(!isset($row->envdist) && is_null($row->envdist)){
												echo "";
											}else{
												echo "Error";
											}
										?>
							</td>
							<td class="text-right <?php echo $claseULinea;?>"><?php if(isset($row->dev) && !is_null($row->dev)){
											echo $row->dev;
											}elseif(!isset($row->dev) && is_null($row->dev)){
												echo "";
											}else{
												echo "Error";
											}
										?>
							</td>
							<td class="text-right <?php echo $claseULinea;?>"><?php if(isset($row->devdist) && !is_null($row->devdist)){
											echo $row->devdist;
											}elseif(!isset($row->devdist) && is_null($row->devdist)){
												echo "";
											}else{
												echo "Error";
											}
										?>
							</td>
							<td class="text-right <?php echo $claseULinea;?>"><?php if(isset($row->saldo) && !is_null($row->saldo)){
											echo $row->saldo;
											}elseif(!isset($row->saldo) && is_null($row->saldo)){
												echo "0";
											}else{
												echo "Error";
											}
										?>
							</td>
							<td class="text-right <?php echo $claseULinea;?>"><?php if(isset($row->saldodist) && !is_null($row->saldodist)){
											echo $row->saldodist;
											}elseif(!isset($row->saldodist) && is_null($row->saldodist)){
												echo "0";
											}else{
												echo "Error";
											}
										?>
							</td>
							
						</tr>				
					</tbody>	
					<?php
						$iCantRows++;
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
	$(document).ready(function(){
		$("#datepickerI").datepicker({
				dateFormat: "dd-mm-yy"
		});
		$("#datepickerF").datepicker({
				dateFormat: "dd-mm-yy"
				//dateFormat: "yy-mm-dd"
		});
		
		var totaldias = '<?php echo $TotalDias; ?>';
		var message = '<?php echo $message; ?>';
		//console.log("totaldias -> "+totaldias);
		if (totaldias !== ''){
			$('#rows').html(message+'. Total alquiler: '+totaldias+' unidades');
		}else{
			$('#rows').html(message);
		}
		
		var bsiniVal = true;
		var bkeyPressed = false;
		var siniVal;
		
		$.fn.chkSinicial = function(value){
			var regExp = /^([0-9]{1,3})$/;
			//var regExp = /^([0-9]{5})$|^([0-9]{9})$/;
			if(value.trim() !== ''){
				if(!value.match(regExp)){
					return false;
				}else{
					return true;
				}
			}else{
				return true;
			}
		}
		
		$.fn.setCss = function(value){
			console.log("Valor de $(sinicial).val() -> "+$(sinicial).val());
			if(value == true){
				$("#sinicial").css("background-color","#92FF8A");
				$("#sinicial").css("color","#000333");
			}else{
				$("#sinicial").css("background-color","#FAE605");
				$("#sinicial").css("color","#000333");
			}
		}
		
		$("#sinicial").focusout('input', function(){
			siniVal = $(this).val();
			if(siniVal !== ''){
				bsiniVal = $.fn.chkSinicial(siniVal);
				$.fn.setCss(bsiniVal);
			}
		})
		
				
		$('#sinicial').keypress(function(e) {
			siniVal = $(this).val();
			if(siniVal !== ''){
				bsiniVal = $.fn.chkSinicial(siniVal);
				$.fn.setCss(bsiniVal);
		
				if(e.which == 13) {
					if(bsiniVal == true){
						bkeyPressed = true;
						$('#frm').submit();
					}
				}
			}
		});
		
		
		$('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
			if(bsiniVal == true && bkeyPressed == false){
				currentForm.submit();
			}
			bkeyPressed = false;
		});
		
		
		
		
		
		
	});
</script>




	</form>
	</body>
</html>

