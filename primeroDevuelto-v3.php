
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>

<body>
	<form method="post" action="primeroDevuelto-v3.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-6"><h4>Primero Devuelto</h4></div>
                </div>
            </div>
            
			<?php
			//Todos los productos
			$tLP = 1;
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
			?>
			
			<div class="row">
				<div class="col-md-6 table-responsive">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
							<th class="text-center">Producto</th>
							<th class="text-center" colspan=2>Propiedad</th>
							<th class="text-center" colspan=2>Envase</th>
						</tr>
						<tr>
							<th class="text-center" rowspan=3><input type="text" name="fechaI" id="datepickerI" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
							<th class="text-center" rowspan=3><input type="text" name="fechaF" id="datepickerF" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
							<th rowspan=3>
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
							<th>NP </th><th>SP</th><th>CIL</th><th>TER</th>
						</tr>
						<tr>
							
							<th class="text-center"><input type="radio" checked="checked" name="propiedad" value="NP" required /></th> 
							<th class="text-center"><input type="radio" name="propiedad" value="SP" required /></th>
							<th class="text-center" ><input type="radio" checked="checked" name="tipoenv" value=1 required /></th> 
							<th class="text-center"><input type="radio" name="tipoenv" value=2 required /></th>							
						</tr>
						<tr>
							
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
			$DB= new Database();
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$idproductoOption = isset($_POST['idproducto']) ? $_POST['idproducto'] : false;;
			
			if ($tipoenv && $idproductoOption){
				$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
				$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
				$propiedad = isset($_POST['propiedad']) ? $_POST['propiedad'] : null;
				$producto = explode("|",$_POST['idproducto']);
				
				if ($tipoenv == 1){ 
					$tenv = 'CIL';
				}elseif ($tipoenv == 2){
					$tenv = 'TER';
				}
				
				$res = $DB->prPrimeraDevolucionv4($fechaI,$fechaF,$propiedad,$tenv,$producto[0]);
				$fechaI = date_format(date_create($fechaI),"d-m-Y");
				$fechaF = date_format(date_create($fechaF),"d-m-Y");
				
				//if(!empty($res) AND mysqli_num_rows($res) >= 0){
				if(!empty($res)){				
				$row_cnt = mysqli_num_rows($res);
				$message= "Se obtuvieron ".$row_cnt." registros. (Desde: ".$fechaI." Hasta: ".$fechaF."). Propiedad: ".$propiedad.". Envase: ".$tenv;
				if ($row_cnt == 0){
						$class="alert alert-info";
					}elseif ($row_cnt == 1){
						$brow_cnt = true;
						$message= "Se obtuvo ".$row_cnt." registro. (Desde: ".$fechaI." Hasta: ".$fechaF."). Propiedad: ".$propiedad.". Envase: ".$tenv;
						$class="alert alert-success";
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
				?>		
			<div class="row">
				<div class="col-md-10">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Fecha</th>
							<th class="text-center">Remito</th>
							<th class="text-center">Producto</th>
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
							<td class="text-center"><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
							<td class="text-left <?php echo $claseULinea;?>"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
							<td><?php if(isset($row->serie)){echo $row->serie;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->estado)){echo $row->estado;}else{echo "Error";}?></td>
							<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->tipo)){echo $row->tipo;}else{echo "Error";}?></td>							
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
		   
			
        </div>
    </div>     
	<script type="text/javascript">
		$(document).ready(function(){
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

