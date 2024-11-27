
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>			

<body>
	<form method="post" action="envases-SEI.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Cliente x N° Serie (SEI)</h4></div>
                </div>
            </div>
            
			<?php
			$DB= new Database();
			$idCL = 'SEI';
			$res = $DB->clientesTodos($idCL);
			//$res = $DB->clientesTodos();
			$iRow = 1;
			$clienteid_sei = array(0,0);
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			if ($clienteOption){
				$clienteid_sei = explode("|",$_POST['cliente']);
				$idcliente_sei = $clienteid_sei[2];
			}else{
				$idcliente_sei = 1;
			}
			?>
			
			
			<div class="row">
				<div class="col-md-4">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th>Clientes</th>
						</tr>
						<tr>
							<th>
								<select name="cliente" id="cliente" class='form-control'>
								<option value="0">Clientes</option>
								<?php while ($row=mysqli_fetch_object($res)){ 
									if ($iRow == $idcliente_sei){?>
										<option value="<?php echo $row->id_sei.'|'.$row->nombre.'|'.$iRow ;?>" selected><?php echo $iRow;$iRow++;?> - <?php echo $row->nombre;?> - (<?php echo $row->id_sei;?>)</option>
									<?php
									}else {
									?>
										<option value="<?php echo $row->id_sei.'|'.$row->nombre.'|'.$iRow ;?>"><?php echo $iRow; $iRow++;?> - <?php echo $row->nombre;?> - (<?php echo $row->id_sei;?>)</option>
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
				<div class="col-md-4">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th>Vacío Playa</th>
							<th>En Cliente</th>
							<th>CIL</th>
							<th>TER</th>
						</tr>
						<tr>
							<td><input type="radio" name="estadoEnvase" value=2 required /> </td><td> <input type="radio" name="estadoEnvase" value=1 required checked /> </td></td>
							<td><input type="radio" name="tipoEnvase" value=1 required checked /> </td><td> <input type="radio" name="tipoEnvase" value=2 required /> </td></td>
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
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			$estado = isset($_POST['estadoEnvase']) ? $_POST['estadoEnvase'] : false;;
			$tipo = isset($_POST['tipoEnvase']) ? $_POST['tipoEnvase'] : false;;
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if ($clienteOption && $estado){
				$clienteid_sei = explode("|",$_POST['cliente']);
				$estado = $_POST['estadoEnvase'];
				$tipo = $_POST['tipoEnvase'];
				if ($estado == 1){
					$estadoStr = 'En Cliente';
				}elseif ($estado == 2){
					$estadoStr = 'Vacío en Playa';
				}
				if ($tipo == 1){
					$tipoStr = 'CIL';
					$producto = 'M09000';
				}elseif ($tipo == 2){
					$tipoStr = 'TER';
					$producto = 'M09021';
				}
					
				
				$res = $DB->ultimaFDSEI($clienteid_sei[0],$estado,$tipoStr,$producto);
				$row_cnt = mysqli_num_rows($res);
				$message= "Cliente: ".$clienteid_sei[1].". Se obtuvieron ".$row_cnt. " registros. "."Estado: ".$estadoStr.". "."Tipo: ".$tipoStr;
				$class="alert alert-success";
				?>
			
			<div class="<?php echo $class?>" id="rows">

				  <?php echo $message;?>
			</div>
				
			<div class="row">
				<div class="col-md-12">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Pedido</th>
							<th>Remito</th>
							<th>Cliente</th>
							<th>LDR</th>
							<th>N° Serie</th>
							<th>Envase</th>
							<th>Estado Rto</th>
							<th>Ex?</th>
							<th>Fecha XLS</th>
							<th>Remito XLS</th>
							<th>Est XLS</th>
							<th>Nombre XLS</th>
							<th>Hits</th>
							<th>Repite</th>
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
								
				?>
					<tbody>
						<tr>
							<!--<td><?php //echo date_format(date_create($row->fecha),"d-m-Y");?></td>-->
							<td><?php echo $row->fecha;?></td>
							<td><?php echo $row->pedido;?></td>
							<td><?php echo $row->remito;?></td>
							<td><?php echo $row->cliente;?></td>
							<td><?php echo $row->ldr;?></td>
							<td><?php echo $row->serie;?></td>
							<td><?php echo $row->tipoenvase;?></td>
							<?php
								if ($row->estador == '8')  {
								?>
								<td>Actualizado</td>
							<?php	
								}elseif ($row->estador == 'X'){
							?>
							<td>Anulado</td>
							<?php
								}else{
								?>	
								<td></td>
								<?php
								}
								?>
							<td><?php echo $row->existe;?></td>
							<!--<td><?php //echo date_format(date_create($row->fechaXLS),"d-m-Y");?></td>-->
							<!--<td><?php echo $row->fechaXLS;?></td>-->
							
							<td><?php if(isset($row->fechaXLS) && !is_null($row->fechaXLS)){
											echo date_format(date_create($row->fechaXLS),"d-m-Y");
											}elseif(!isset($row->fechaXLS) && is_null($row->fechaXLS)){
												echo "";
											}else{
												echo "Error";
											}
										?>
								</td>
							
							
							
							
							
							
							
							
							<td><?php echo $row->remitoXLS;?></td>
							<td><?php echo $row->e_XLS;?></td>
							<td><?php echo $row->nombreXLS;?></td>
							<td><?php echo $row->hits;?></td>
							<td><?php echo $row->repite;?></td>
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
		   
			
        </div>
    </div>     





	</form>
	</body>
</html>


