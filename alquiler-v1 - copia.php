
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="alquiler-v1.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
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
							<th>CIL</th><th>TER</th>
						</tr>
						<tr>
							<th class="text-center" ><input type="radio" checked="checked" name="tipoenv" value=1 required /></th> 
							<th class="text-center"><input type="radio" name="tipoenv" value=2 required /></th>							
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
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			if ($clienteOption){
				
				$clienteid_xl = explode("|",$_POST['cliente']);
				$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
				$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
				if ($tipoenv == 1){ 
					$tenv = 'CIL';
				}elseif ($tipoenv == 2){
					$tenv = 'TER';
				}
				$res = $DB->prAlquilerEnvasev1($fechaI,$fechaF,$clienteid_xl[0],$tenv);
				
				
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
					$message= "Se obtuvieron ".$row_cnt. " registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Envase: ".$tenv;
					$class="alert alert-success";
				}
				
				
				
				$message= "Se obtuvieron ".$row_cnt. " registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Envase: ".$tenv;
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
				
						
				?>
					<tbody>
						<tr class="<?php echo $claseFondo;?>">
							<td class="text-center"><?php if(isset($row->fecha)){echo $row->fecha;}else{echo "Error";}?></td>
							<td class="text-right"><?php if(isset($row->env)){echo $row->env;}else{echo "Error";}?></td>
							<td class="text-right"><?php if(isset($row->envdist)){echo $row->envdist;}else{echo "Error";}?></td>
							<td class="text-right"><?php if(isset($row->dev)){echo $row->dev;}else{echo "Error";}?></td>
							<td class="text-right"><?php if(isset($row->devdist)){echo $row->devdist;}else{echo "Error";}?></td>
							<td class="text-right"><?php if(isset($row->saldo)){echo $row->saldo;}else{echo "Error";}?></td>
							<td class="text-right"><?php if(isset($row->saldodist)){echo $row->saldodist;}else{echo "Error";}?></td>
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
		
	});
</script>




	</form>
	</body>
</html>

