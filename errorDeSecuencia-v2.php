
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>

<body>
	<form method="post" action="errorDeSecuencia-v2.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-6"><h4>Errores de Secuencia de Entregas y Devoluciones</h4></div>
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
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$propiedad = isset($_POST['propiedad']) ? $_POST['propiedad'] : null;
			if ($clienteOption){
				$clienteid_xls = explode("|",$_POST['cliente']);
				$idcliente_xls = $clienteid_xls[2];
			}else{
				$idcliente_xls = 1;
			}
			if($tipoenv){
				$tipoenv = $_POST['tipoenv'];
			}else{
				$tipoenv = 1;
			}
			if($propiedad){
				$propiedad = $_POST['propiedad'];
			}else{
				$propiedad = "NP";
			}
			?>
			
			
			<div class="row">
				<div class="col-md-8 table-responsive">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Clientes</th>
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
							<th class="text-center" colspan=2>Propiedad</th>
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
							<th>NP </th><th>SP</th><th>CIL</th><th>TER</th>
						</tr>
						<tr>
							<th class="text-center"><input type="radio" checked="checked" name="propiedad" value="NP" required <?php echo ($propiedad=='NP')?'checked':'' ?>/></th> 
							<th class="text-center"><input type="radio" name="propiedad" value="SP" required <?php echo ($propiedad=='SP')?'checked':'' ?>/></th>
							<th class="text-center" ><input type="radio" checked="checked" name="tipoenv" value=1 required <?php echo ($tipoenv==1)?'checked':'' ?>/></th> 
							<th class="text-center"><input type="radio" name="tipoenv" value=2 required <?php echo ($tipoenv==2)?'checked':'' ?>/></th>							
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
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			if ($clienteOption){
				//echo print_r($_POST);
				$clienteid_xl = explode("|",$_POST['cliente']);
				$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
				$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
				$propiedad = isset($_POST['propiedad']) ? $_POST['propiedad'] : null;
				if ($tipoenv == 1){ 
					$tenv = 'CIL';
				}elseif ($tipoenv == 2){
					$tenv = 'TER';
				}
				//echo "<pre>";
				//echo $fechaI."</br>".$fechaF;
				//echo "</pre>";
				$res = $DB->prErrorDeSecuenciav2($fechaI,$fechaF,$clienteid_xl[0], $propiedad, $tenv);
				//if(!empty($res) AND mysqli_num_rows($res) >= 0){
				if(!empty($res)){				
				
				$fechaI = date_format(date_create($fechaI),"d-m-Y");
				$fechaF = date_format(date_create($fechaF),"d-m-Y");
				
				$row_cnt = mysqli_num_rows($res);
				$message= "Se obtuvieron ".$row_cnt. " registros. (Desde: ".$fechaI." Hasta: ".$fechaF.") Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Propiedad: ".$propiedad.". Envase: ".$tenv;
				if ($row_cnt == 0){
						$class="alert alert-info";
					}elseif ($row_cnt == 1){
						$brow_cnt = true;
						$message= "Se obtuvo ".$row_cnt." registro. Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Propiedad: ".$propiedad.". Envase: ".$tenv;
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
				<div class="col-md-12">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th>Cliente Seleccionado</th>
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
							<td><?php if(isset($row->id_xlEval) && isset($row->nombreV)){echo '('.$row->id_xlEval.') '.$row->nombreV;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->fecha)){echo $row->fecha;}else{echo "Error";}?></td>
							<td class="text-center"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
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
						$res = $DB->closePR();
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
				//dateFormat: "yy-mm-dd"
		});
});
</script>

	</form>
	</body>
</html>

