
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>

<body>
	<form method="post" action="certificado-v2.php">
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
                    <div id="tit" class="col-sm-6"><h4>Certificados</h4></div>
                </div>
            </div>
            
			<div class="row">
				<div class="col-md-4 table-responsive">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
						</tr>
						<tr>
							<th class="text-center" rowspan=3><input type="text" name="fechaI" id="datepickerI" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
							<th class="text-center" rowspan=3><input type="text" name="fechaF" id="datepickerF" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
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
			$fechaI = isset($_POST['fechaI']) ? $_POST['fechaI'] : null;
			$fechaF = isset($_POST['fechaF']) ? $_POST['fechaF']: null;
			
			if ($fechaI && $fechaF){
				$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
				$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
				
				$res = $DB->prCertificadov3($fechaI,$fechaF);
				$fechaI = date_format(date_create($fechaI),"d-m-Y");
				$fechaF = date_format(date_create($fechaF),"d-m-Y");
				
				//if(!empty($res) AND mysqli_num_rows($res) >= 0){
				if(!empty($res)){				
				$row_cnt = mysqli_num_rows($res);
				$message= "Se obtuvieron ".$row_cnt." registros. (Desde: ".$fechaI." Hasta: ".$fechaF.").";
				if ($row_cnt == 0){
						$class="alert alert-info";
					}elseif ($row_cnt == 1){
						$brow_cnt = true;
						$message= "Se obtuvo ".$row_cnt." registro. (Desde: ".$fechaI." Hasta: ".$fechaF.").";
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
							<th class="text-center">Cliente</th>
							<th class="text-right">Volumen</th>
							<th class="text-center">Partida</th>
							<th class="text-center">Certificado</th>
							<th class="text-center">Tanque Destino</th>
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
								
				?>
					<tbody>
						<tr>
							<td class="text-center"><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
							<td class="text-left"><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
							<td class="text-right"><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->partida) && !is_null($row->partida)){
											echo $row->partida;
										}elseif(!isset($row->partida) && is_null($row->partida)){
											echo "";
										}else{
											echo "Error";
										}
									?>
							</td>
							<td class="text-center"><?php if(isset($row->certificado) && !is_null($row->certificado)){
											echo $row->certificado;
										}elseif(!isset($row->certificado) && is_null($row->certificado)){
											echo "";
										}else{
											echo "Error";
										}
									?>
							</td>
							<td class="text-center"><?php if(isset($row->tdestino) && !is_null($row->tdestino)){
											echo $row->tdestino;
										}elseif(!isset($row->tdestino) && is_null($row->tdestino)){
											echo "";
										}else{
											echo "Error";
										}
									?>
							</td>
							<!--$myvar = NULL; is_null($myvar); // TRUE-->
							<!--$myvar = NULL; isset($myvar);   // FALSE-->
							<!--$myvar = NULL; empty($myvar);   // TRUE-->							
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

