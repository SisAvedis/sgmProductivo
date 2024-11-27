<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="historialEnvaseConFecha-v4.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php //include ("database_e3.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Historial Envase</h4></div>
                </div>
            </div>
            
			<?php
			$DB= new Database();
			$idCL = 'XLS';
			$res = $DB->clientesTodosSG($idCL);
			$iRow = 0;
			$clienteid_xl = array(0,0);
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$propiedad = isset($_POST['propiedad']) ? $_POST['propiedad'] : null;
			
			$classF = 'col-md-10';
			
			if ($clienteOption){
				$clienteid_xls = explode("|",$_POST['cliente']);
				$idcliente_xls = $clienteid_xls[2];
				}else{
				$idcliente_xls = 0;
			}
			
			//Todos los productos
			$tLP = 0;
			$DB0= new Database();
			$idPR = 'LG';
			$res0 = $DB0->prProductov1($idPR,$tLP);
			$iRow0 = 1;
			$producto = array(0,0);
			$idproductoOption = isset($_POST['idproducto']) ? $_POST['idproducto'] : false;;
			if ($idproductoOption){
				$productoOption = explode("|",$_POST['idproducto']);
				$productoNom = $productoOption[2];
			}else{
				$productoNom = 0;
			}
			
			if($propiedad){
				$propiedad = $_POST['propiedad'];
			}else{
				$propiedad = "NP";
			}
						
			if($tipoenv){
				$tipoenv = $_POST['tipoenv'];
			}else{
				$tipoenv = 1;
			}
			
			if ($tipoenv == 1){ 
				$tenv = 'CIL';
			}elseif ($tipoenv == 2){
				$tenv = 'TER';
			}
			
			if(!$fecha){
				$fecha = 2;
			}
			
			$spacesCount = 45;
			$spaces = '';
			for($z = 0 ; $z < $spacesCount; $z++){
				$spaces = $spaces.'&nbsp';
			}
			
			?>
			
			<div class="row">
				<div class="<?php echo $classF;?>" id="classf">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr id="tr1">
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
							<th class="text-center" colspan=2>Fecha</th>
							<th class="text-center" colspan=2>Propiedad</th>
							<th class="text-center" colspan=2 id="env">Envase</th>
							<th class="text-center" id="clitit">Clientes<?php echo $spaces;?></th>
							<th class="text-center">Producto</th>
						</tr>
						<tr id="tr2" class="tr2class">
							<th class="text-center" rowspan=3><input type="text" name="fechaI" id="datepickerI" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
							<th class="text-center" rowspan=3><input type="text" name="fechaF" id="datepickerF" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>							
							<th>Si</th><th>No</th><th>NP</th><th>SP</th><th>CIL</th><th>TER</th>
							<th rowspan=2  id="clicmb">
								<select name="cliente" id="cliente" class="form-control input-sm">
								<option value="0" selected>Clientes</option>
								<?php while ($row=mysqli_fetch_object($res)){ 
									?>
										<option value="<?php echo $row->id_xl.'|'.$row->nombre.'|'.$iRow ; $iRow++;?>"><?php echo $row->id_xl?> - <?php echo $row->nombre;?></option>
									<?php }
									?>
								</select>
							</th>
							<th rowspan=3 id="prodcmb">
								<select name="idproducto" id="idproducto" class="form-control input-sm">
								<option value="0">Producto</option>
								<?php while ($row0=mysqli_fetch_object($res0)){ 
									if ($iRow0 == $productoNom){?>
										<option value="<?php echo $row0->id.'|'.$row0->codigo.'|'.$row0->nombre.'|'.$iRow0 ; $iRow0++;?>" selected>(<?php echo $row0->codigo;?>) <?php echo $row0->nombre;?></option>
									<?php
									}else {
									?>
										<option value="<?php echo $row0->id.'|'.$row0->codigo.'|'.$row0->nombre.'|'.$iRow0; $iRow0++;?>">(<?php echo $row0->codigo;?>) <?php echo $row0->nombre;?></option>
									<?php } ?>
									
								<?php } ?>
								</select>
							</th>
						</tr>
						<tr>
							<th class="text-center"><input type="radio" name="fecha" value=1 required <?php echo ($fecha==1)?'checked':'' ?>/></th> 
							<th class="text-center"><input type="radio" name="fecha" value=2 required <?php echo ($fecha==2)?'checked':'' ?>/></th>
							<th class="text-center"><input type="radio" checked="checked" name="propiedad" value="NP" required <?php echo ($propiedad=='NP')?'checked':'' ?>/></th> 
							<th class="text-center"><input type="radio" name="propiedad" value="SP" required <?php echo ($propiedad=='SP')?'checked':'' ?>/></th>
							<th class="text-center"><input type="radio" checked="checked" name="tipoenv" value=1 required <?php echo ($tipoenv==1)?'checked':'' ?>/></th> 
							<th class="text-center"><input type="radio" name="tipoenv" value=2 required <?php echo ($tipoenv==2)?'checked':'' ?>/></th>	
						</tr>
				
					</thead>
				</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-2">
					<label>Número de Serie: </label>
					<input type="text" name="nserie" id="nserie" class="form-control input-sm" maxlength="12" autocomplete="off" required value="<?php $nserie ?>" />
				</div>
				<div class="col-md-12 pull-right">
					<hr>
					<button type="submit" class="btn btn-sm btn-danger">Consultar</button>
					<hr>
				</div>
			</div>
			
			
			<?php
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$nserie = isset($_POST['nserie']) ? $_POST['nserie'] : false;;
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			$idproductoOption = isset($_POST['idproducto']) ? $_POST['idproducto'] : false;;
			//$propiedad = isset($_POST['propiedad']) ? $_POST['propiedad'] : null;
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if(validaSerie($nserie) && $idproductoOption){
					//$DB= new Database();
					//$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
					//$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
					$nserie = $DB->sanitize($_POST['nserie']);
					
					if ($clienteOption){
						$clienteid_xl = explode("|",$_POST['cliente']);
					}
					
					$producto = explode("|",$_POST['idproducto']);
					
					if ($fecha == 1){
						$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
						$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
						$res = $DB->prHistorialEnvaseConFechav3($fechaI,$fechaF,$clienteid_xl[0],$nserie, $propiedad, $tenv, $producto[0]);
					}else{
						$res = $DB->prinHistorialEnvaseSinFechav4($clienteid_xl[0],$nserie, $propiedad, $tenv, 1, $producto[0]);
					}
				
					if(!empty($res)){
						$row_cnt = mysqli_num_rows($res);
						if ($row_cnt == 0){
							$class="alert alert-info";
							if ($fecha == 1){
								$fechaI = date_format(date_create($fechaI),"d-m-Y");
								$fechaF = date_format(date_create($fechaF),"d-m-Y");
								$message= "No se obtuvieron movimientos para el Número de Serie ".$nserie.". Producto: (".$producto[1].") ".$producto[2]." (Desde: ".$fechaI." Hasta: ".$fechaF.")";
							}elseif($fecha == 2){
								$message= "No se obtuvieron movimientos para el Número de Serie ".$nserie.". Producto: (".$producto[1].") ".$producto[2];
							}
						}elseif ($row_cnt == 1){
							$class="alert alert-success";
							if ($fecha == 1){
								$fechaI = date_format(date_create($fechaI),"d-m-Y");
								$fechaF = date_format(date_create($fechaF),"d-m-Y");
								$message= "Se obtuvo 1 movimiento para el Número de Serie ".$nserie.". Producto: (".$producto[1].") ".$producto[2]." (Desde: ".$fechaI." Hasta: ".$fechaF.")";
							}elseif($fecha == 2){
								$message= "Se obtuvo 1 movimiento para el Número de Serie ".$nserie.". Producto: (".$producto[1].") ".$producto[2];
							}
						}else{
							$class="alert alert-success";
							if ($fecha == 1){
								$fechaI = date_format(date_create($fechaI),"d-m-Y");
								$fechaF = date_format(date_create($fechaF),"d-m-Y");
								$message= "Se obtuvieron ".$row_cnt." movimientos para el Número de Serie ".$nserie.". Producto: (".$producto[1].") ".$producto[2]." (Desde: ".$fechaI." Hasta: ".$fechaF.")";
							}elseif($fecha == 2){
								$message= "Se obtuvieron ".$row_cnt." movimientos para el Número de Serie ".$nserie.". Producto: (".$producto[1].") ".$producto[2];
							}
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
				<div class="col-md-12">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Fecha</th>
							<th class="text-center">Remito</th>
							<th class="text-center">Tipo Remito</th>
							<th class="text-center">Lote</th>
							<th>Cliente</th>
							<th class="text-center">Producto</th>
							<th class="text-center">Movimiento</th>
							<th class="text-center">Volumen</th>
							<th class="text-center">Propiedad</th>
							<th class="text-center">Envase</th>
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
				?>
					<tbody>
						<tr>
							<td class="text-center"><?php if(isset($row->fecha)){echo $row->fecha;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->tiporemito)){echo $row->tiporemito;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->lote)){echo $row->lote;}else{echo "Error";}?></td>
							<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->estado)){echo $row->estado;}else{echo "Error";}?></td>
							<td class="text-right"><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->tipoenvase)){echo $row->tipoenvase;}else{echo "Error";}?></td>
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
				}else{
					$message= "La consulta arrojó un error.";
					$class="alert alert-warning";
				?>
					<div class="<?php echo $class;?>" id="rows">
						<?php echo $message;?>
					</div>
				<?php		
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
	$(document).ready(function(){
		
		var sprop = '<?php echo $propiedad; ?>';
		var stipoe = '<?php echo $tenv; ?>';
		var sserie = '';
		var idproducto = 0;
		var bclienteOption = '<?php echo $clienteOption; ?>';
		
		//funciones
		$.fn.cmbClienteDelete = function(){ 
			$('#cliente option:not(:first)').remove();
		}
		
		$.fn.cmbProductoDelete = function(){ 
			console.log("Pasando por Producto -> Delete");
			$('#idproducto option:not(:first)').remove();
		}
		
		$.fn.cmbProductoDelete();
		
		$.fn.cliente = function(sserie,stipoe,idproducto){
			//console.log('Desde $.fn.cliente ->| '+sserie+' |<->| '+sprop+' |<->| '+stipoe+' |<->| ');
			//$.fn.cmbClienteDelete();
			
			if (sprop == 'SP') {
				$.ajax({
					url:"./ajax6full-v2.php",
					dataType: "json",
					data: {"nserie": sserie, "tipoenv": stipoe, "idproducto": idproducto},
					type:"POST",
					success:function(response){
						var len = response.length;
						for(var i=0; i<len; i++){
							var nombre = response[i].nombre;
							$("#cliente").html(nombre);	
						}
					}
				});
			}
		}
		
		$.fn.producto = function(sserie,stipoe){
			//console.log('Desde $.fn.cliente ->| '+sserie+' |<->| '+sprop+' |<->| '+stipoe+' |<->| ');
			//$.fn.cmbClienteDelete();
			
			$.ajax({
				url:"./ajax7full-v1.php",
				dataType: "json",
				data: {"nserie": sserie, "tipoenv": stipoe},
				type:"POST",
				success:function(response){
					var len = response.length;
					for(var i=0; i<len; i++){
						var nombre = response[i].nombre;
						$("#idproducto").html(nombre);	
					}
				}
			});
			
		}
		
		//funciones
		
		if (sprop == 'NP') {
			$.fn.cmbClienteDelete();
		}
		
		var bfechaOption = '<?php echo $fecha; ?>';
		if (bfechaOption == 2) {
			$('#datepickerI').prop('required',false);
			$('#datepickerI').prop('disabled', true);
			$('#datepickerF').prop('required',false);
			$('#datepickerF').prop('disabled', true);
		}else{
			$('#datepickerI').prop('required',true);
			$('#datepickerI').prop('disabled', false);
			$('#datepickerF').prop('required',true);
			$('#datepickerF').prop('disabled', false);
		}
		
		$.fn.cmbCliente = function(nVal){ 
			if (nVal == 'NP') {
				$.fn.cmbClienteDelete();
			}
		}
		
		$.fn.inputradioF = function(nradioVal){ 
			
			if (nradioVal == 2) {
					$('#datepickerI').prop('required',false);
					$('#datepickerI').prop('disabled', true);
					$('#datepickerF').prop('required',false);
					$('#datepickerF').prop('disabled', true);
			}
			else if (nradioVal == 1) {
				$('#datepickerI').prop('required',true);
				$('#datepickerI').prop('disabled', false);
				$('#datepickerF').prop('required',true);
				$('#datepickerF').prop('disabled', false);
			}
		}
		//Option Button Propiedad
		$("input[name=propiedad]").click(function () {
			sprop = $(this).val();
			sserie = $("#nserie").val();
			$.fn.cmbCliente(sprop);
			$.fn.cliente(sserie,stipoe);
			$.fn.producto(sserie,stipoe);
		});
		//Option Button Tipo de Envase
		$("input[name=tipoenv]").click(function () {
			itipoe = $(this).val();
			if(itipoe == 1){
				stipoe = 'CIL';
			}else{
				stipoe = 'TER';
			}
			sserie = $("#nserie").val();
			$.fn.cliente(sserie,stipoe);
			$.fn.producto(sserie,stipoe);
		});
		//Option Button Fecha
		$("input[name=fecha]").click(function () {
			var nradioVal = $(this).val();
			$.fn.inputradioF(nradioVal);
		});
		//input Serie	
		$("#nserie").focusout(function(){
			//alert('Perdio el foco nserie!!');
			sserie = $(this).val();		
			//$.fn.cliente(sserie,stipoe);
			$.fn.producto(sserie,stipoe);
			$.fn.cliente(sserie,stipoe);
		});
		
		//Combo Producto
		$("#prodcmb").on('change','#idproducto', function(){
		//$("idproducto").click(function () {
			sprod = $(this).val();
			sprodArr = sprod.split('|');
			iProd = sprodArr[0];
			console.log(iProd);
			//sserie = $("#nserie").val();
			//$.fn.cmbCliente(sprop);
			$.fn.cliente(sserie,stipoe,iProd);
			//$.fn.producto(sserie,stipoe);
		});
		
		$("#datepickerI").datepicker({
				dateFormat: "dd-mm-yy"
		});
		
		$("#datepickerF").datepicker({
				dateFormat: "dd-mm-yy"
		});
				
});
</script>	
	
	


	</form>
	</body>
</html>