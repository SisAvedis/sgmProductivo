
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>

<body>
	<form method="post" action="cHits-v4.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Cantidad de Apariciones por Envase</h4></div>
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
			}else{
				$idcliente_xls = 1;
			}
			?>
			
			<div class="row">
				<div class="col-md-7">
									
				<table class="table table-bordered" id="tabla2">
					<thead>
						<tr>
							<th class="text-center">Cliente</th>
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
							<th class="text-center" colspan=2>Envase</th>
							<th class="text-center">Cantidad</th>
						</tr>
					</thead>
					<tbody>	
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
							<th class="text-center">CIL</th><th class="text-center">TER</th>
							<th rowspan=2><input type="text" name="cantidad" id="cantidad" class='form-control input-sm' maxlength="2" autocomplete="off" required /><?php $cantidad ?></th>
						</tr>
						<tr>
							<th class="text-center" ><input type="radio" checked="checked" name="tipoenv" value=1 required /></th>
							<th class="text-center"><input type="radio" name="tipoenv" value=2 required /></th>
							
						</tr>
						
					</tbody>
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
			$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : null;
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			
			if(validaNumero($clienteOption && $cantidad)){
				//echo print_r($_POST);
				$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
				$clienteid_xl = explode("|",$_POST['cliente']);
				$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
				$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
				if ($tipoenv == 1){ 
					$tenv = 'CIL';
				}elseif ($tipoenv == 2){
					$tenv = 'TER';
				}
				
				$DB= new Database();
				$res = $DB->prRepeticionesSeriev3($fechaI,$fechaF,$clienteid_xl[0],$tenv,$cantidad);
				$row_cnt = mysqli_num_rows($res);
				$fechaI = date_format(date_create($fechaI),"d-m-Y");
				$fechaF = date_format(date_create($fechaF),"d-m-Y");
				if ($row_cnt == 0){
					$message= "No se obtuvieron registros. (Desde: ".$fechaI." Hasta: ".$fechaF."). Cantidad de Repeticiones: ".$cantidad.". Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1];
					$class="alert alert-info";
				}elseif ($row_cnt == 1){
					$message= "Se obtuvo ".$row_cnt." registro. (Desde: ".$fechaI." Hasta: ".$fechaF."). Cantidad de Repeticiones: ".$cantidad.". Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1];
					$class="alert alert-success";
				}else{
					$message= "Se obtuvieron ".$row_cnt." registros. (Desde: ".$fechaI." Hasta: ".$fechaF."). Cantidad de Repeticiones: ".$cantidad.".  Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1];
					$class="alert alert-success";
				}
				
				
				//$message= "Se obtuvieron ".$row_cnt. " registros. Cantidad de Repeticiones: ".$cantidad." (Desde: ".$fechaI." Hasta: ".$fechaF.")";
				//$class="alert alert-success";
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
							<th>N° Serie</th>
							<th class="text-center">Movimiento</th>
							<th>Cliente</th>
							<th class="text-center">Propiedad</th>
							<th class="text-center">Envase</th>
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
								
				?>
					<tbody>
						<tr>
							<td class="text-center"><?php echo $row->fecha;?></td>
							<td class="text-center"><?php echo $row->remito;?></td>
							<td><?php echo $row->serie;?></td>
							<td class="text-center"><?php echo $row->estado;?></td>
							<td><?php echo '('.$row->id_xl.') '.$row->nombre;?></td>
							<td class="text-center"><?php echo $row->propiedad;?></td>
							<td class="text-center"><?php echo $row->tipo;?></td>
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
		   
			
        </div>
    </div>     
<script type="text/javascript">
	$(document).ready(function(){
		
		var bRes = false;
		
		$.fn.chkPattern = function(iCantidad){
			var pattern = new RegExp('^[1-9]{1,}$');
			if (pattern.test(iCantidad)) {
				$('#cantidad').css("background-color","#92FF8A");
				$('#cantidad').css("color","#A605FA");
				bRes = true;
			}else{
				if($('#cantidad').val() !== ''){
					$('#cantidad').css("background-color","#FAE605");
					$('#cantidad').css("color","#A605FA");
					//$("#cantidad").focus();
				}
				bRes = false;
			}
		}
		
		$("#cantidad").focus();
	
		$("#cantidad").focusout('input', function(){
			var iCantidad = $(this).val();
			$.fn.chkPattern(iCantidad);
		});
		
		$('#cantidad').keypress(function(e) {
			var iCantidad = $(this).val();
			if(e.which == 13) {
				$.fn.chkPattern(iCantidad);
				if(bRes == true){
					$('#frm').submit();
				}
			}else{	
				var iCantidad = e.key;
				$.fn.chkPattern(iCantidad);
			}
		});
			
		
		$("#datepickerI").datepicker({
				dateFormat: "dd-mm-yy"
		});
		$("#datepickerF").datepicker({
				dateFormat: "dd-mm-yy"
				//dateFormat: "yy-mm-dd"
		});
		
		$('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
			if(bRes == true){
				currentForm.submit();
			}
		});
		
});
</script>

	</form>
	</body>
<html/>

