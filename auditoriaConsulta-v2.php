
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="auditoriaConsulta-v2.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php //include ("database_e.php");?>
			<?php include ("database_e4.php");?>
			<?php //require_once 'include/validacion.php';?>
			<?php require_once 'include/validacion4.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Consulta de Auditorías</div>
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
				$idcliente_xls = 0;
			}
			//Todos los productos
			$tLP = 0;
			$DB0= new Database();
			$idPR = 'GR';
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
							<th>Clientes</th>
							<th class="text-center">Fecha Corte</th>
							<th class="text-center" colspan=2>Detallado Por</th>
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
							<th class="text-center" rowspan=3><input type="text" name="fecha" id="datepicker" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
						</tr>
						<tr>
							<th>Cantidad</th><th>Envases</th>
						</tr>
						<tr>
							<th class="text-center"><input type="radio" checked="checked" name="detallepor" value=1 required /></th> 
							<th class="text-center"><input type="radio" name="detallepor" value=2 required /></th>						
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
			$detallepor = isset($_POST['detallepor']) ? $_POST['detallepor'] : null;
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			if ($clienteOption){
				
				$clienteid_xl = explode("|",$_POST['cliente']);
				$fecha = date("Y-m-d", strtotime($_POST['fecha']));
				if ($detallepor == 1){ 
					$clase = 'col-md-6';
					$detpor = 'Cantidad';
				}elseif ($detallepor == 2){
					$clase = 'col-md-12';
					$detpor = 'Envases';
				}
				
				$res = $DB->prConsultarAuditoriasv2($fecha,$clienteid_xl[0],$detallepor);
				
				$fecha = date_format(date_create($fecha),"d-m-Y");
				
				$row_cnt = mysqli_num_rows($res);
				if ($row_cnt == 0){
					$class="alert alert-info";
					$message= "No se obtuvieron registros. (Fecha: ".$fecha."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Detallado Por: ".$detpor;
				}elseif ($row_cnt == 1){
					$class="alert alert-success";
					$message= "Se obtuvo 1 registro.  (Fecha: ".$fecha."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Detallado Por: ".$detpor;
				}else{
					$class="alert alert-success";
					$message= "Se obtuvieron ".$row_cnt." registros. (Fecha: ".$fecha."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Detallado Por: ".$detpor;
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
				<div class="<?php echo $clase;?>">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<?php if ($detallepor == 2){ ?>
								<th class="text-center">Fecha</th>
								<th class="text-center">Comprobante</th>
								<th>Cliente</th>
								<th class="text-center">Producto</th>
								<th>Serie</th>
								<th>Lote</th>
								<th class="text-center">Tipo Envase</th>
								<th class="text-center">Rampa BKP</th>
								<th class="text-center">Auditado</th>
								<th class="text-center">Tipo</th>
							<?php }elseif ($detallepor == 1) {?>
								<th>Fecha</th>
								<th class="text-center">Comprobante</th>
								<th>Cliente</th>
							<?php } ?>	
							
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
				?>
					<tbody>
						<!--<div class="<?php //echo $clase;?>">-->
						<tr>
							<?php if ($detallepor == 2){ ?>
								<td><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
									<td><?php if(isset($row->numerocomprobante)){echo $row->numerocomprobante;}else{echo "Error";}?></td>
									<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
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
									<td class="text-center"><?php if(isset($row->tipo)){echo $row->tipo;}else{echo "Error";}?></td></td>
							<?php }elseif ($detallepor == 1) {?>
								<td><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->numerocomprobante)){echo $row->numerocomprobante;}else{echo "Error";}?></td>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
						     <?php } ?>   
						
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
		$("#datepicker").datepicker({
				dateFormat: "dd-mm-yy"
		});
});
</script>




	</form>
	</body>
</html>

