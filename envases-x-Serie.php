
<?php include ("inicio.php"); ?>

<body>
	<form method="post" action="envases-x-Serie.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Consulta por Número de Serie</h4></div>
                </div>
            </div>
            
			<div class="row">
				<div class="col-md-1">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th>XLS</th>
							<th>SEI</th>
						</tr>
						<tr>
							<td><input type="radio" name="sis" value="xls" required checked /> </td><td> <input type="radio" name="sis" value="sei" required /> </td></td>
						</tr>
					</thead>
				</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-2">
					<label>Número de Serie: </label>
					<input type="text" name="nserie" id="nserie" class='form-control' maxlength="100" required value="<?php $nserie ?>" />
				</div>
				<div class="col-md-12 pull-right">
					<hr>
					<button type="submit" class="btn btn-sm btn-danger">Consultar</button>
					<hr>
				</div>
			</div>
			
			
			<?php
			$sis = isset($_POST['sis']) ? $_POST['sis'] : null;
			$nserie = isset($_POST['nserie']) ? $_POST['nserie'] : false;;
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if(validaSerie($nserie)){
					//include ("database_e.php");
					$DB= new Database();
					$nserie = $DB->sanitize($_POST['nserie']);
					if ($sis == "xls"){
						$res = $DB->consultaSNXLS($nserie);
					}else if ($sis == "sei"){
						$res = $DB->consultaSNSEI($nserie);
					}
					$row_cnt = mysqli_num_rows($res);
					$message= "Se obtuvieron ".$row_cnt." movimientos para el Número de Serie ".$nserie;
					$class="alert alert-success";
				?>
			
			
			<div class="<?php echo $class?>" id="rows">
				  
				  <?php echo $message;?>
			</div>
				
			<div class="row">
				<div class="col-md-8">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<?php if ($sis == "xls"){?>
							<th>Fecha</th>
							<th>Remito</th>
							<th>Cliente</th>
							<th>Movimiento</th>
							<th>Propiedad</th>
							<th>Tipo Envase</th>
							<?php } else if ($sis == "sei"){?>
							
							<th>Fecha</th>
							<th>Pedido</th>
							<th>Remito</th>
							<th>Cliente</th>
							<th>Estado</th>
							<th>Tipo Envase</th>
							<th>Lote</th>
							<th>LDR</th>
							
							<?php }?>
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
				?>
					<tbody>
						<tr>
							<?php if ($sis == "xls"){?>
							<td><?php echo date_format(date_create($row->fecha),"d-m-Y");?></td>
							<td><?php echo $row->remito;?></td>
							<td><?php echo $row->cliente;?></td>
							<td><?php echo $row->estado;?></td>
							<td><?php echo $row->propiedad;?></td>
							<td><?php echo $row->tipoenvase;?></td>
							<?php  } else if  ($sis == "sei"){?>
							
							<td><?php echo date_format(date_create($row->fecha),"d-m-Y");?></td>
							<td><?php echo $row->pedido;?></td>
							<td><?php echo $row->remito;?></td>
							<td><?php echo $row->cliente;?></td>
							<td><?php echo $row->estado;?></td>
							<td><?php echo $row->envase;?></td>
							<td><?php echo $row->lote;?></td>
							<td><?php echo $row->ldr;?></td>
							
							<?php }?>
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
		   
			
        </div>
    </div>     
			<?php
						}
					?>




	</form>
	</body>
</html>