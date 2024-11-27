
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="remitosGranelVolumen-v1.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Remitos Granel</h4></div>
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
				<div class="col-md-7 table-responsive">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th>Clientes</th>
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
							<th class="text-center" colspan=2>Informe</th>
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
							<th>Resumen</th><th>Detalle</th>
						</tr>
						<tr>
							
							<th class="text-center"><input type="radio" checked="checked" name="tipoinf" value="R" required /></th>
							<th class="text-center"> <input type="radio" name="tipoinf" value="D" required /></th>
														
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
			$tipoinf = isset($_POST['tipoinf']) ? $_POST['tipoinf'] : null;
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			if ($clienteOption && $tipoinf){
				
				$clienteid_xl = explode("|",$_POST['cliente']);
				$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
				$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
				if ($tipoinf == "R"){
					$tinf = 'Resumen';
					$res = $DB->prRemitosGranelv1($fechaI,$fechaF,$clienteid_xl[0],1,"ZZZ");
				}elseif ($tipoinf == "D"){
					$res = $DB->prRemitosGranelv1($fechaI,$fechaF,$clienteid_xl[0],2,"ZZZ");
					$tinf = 'Detalle';
				}
				
				$fechaI = date_format(date_create($fechaI),"d-m-Y");
				$fechaF = date_format(date_create($fechaF),"d-m-Y");
				
				$row_cnt = mysqli_num_rows($res);
				if ($row_cnt == 0){
					$class="alert alert-info";
					$message= "No se obtuvieron registros. (Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Informe: ".$tinf;
				}elseif ($row_cnt == 1){
					$class="alert alert-success";
					$message= "Se obtuvo 1 registro.  (Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Informe: ".$tinf;
				}else{
					$class="alert alert-success";
					$message= "Se obtuvieron ".$row_cnt." registros. (Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Informe: ".$tinf;
				}
				
				?>
			
			<div class="<?php echo $class;?>" id="rows">
				  <?php echo $message;?>
			</div>
			<?php
			if ($row_cnt == 0){
			}else{
				?>
			
			<?php if ($tipoinf == "D"){ 
				$classtable = "col-md-7";
			}else{
				$classtable = "col-md-5";
			}
			?>
			
			<div class="row">
				<div class="<?php echo $classtable;?>">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<?php if ($tipoinf == "D"){ ?>
								<th class="text-center">Fecha</th>
								<th class="text-center">Remito</th>
								<th>Cliente</th>
								<th class="text-center">Certificado</th>
								<th class="text-right">Volumen</th>
							<?php }elseif ($tipoinf == "R") {?>
								<th>Nombre</th>
								<th class="text-right">Volumen</th>
							<?php } ?>	
							
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
				?>
					<tbody>
						<?php if ($tipoinf == "D"){ 
								$claseFondo = "";
							}else{
								if(isset($row->ultimo)){
									$fondo = $row->ultimo;
								}
								switch ($fondo) {
									case "N":
										$claseFondo = "";
										break;
									case "S":
										$claseFondo = "success";
										break;
								}
							}
						?>
						<tr class="<?php echo $claseFondo;?>">
							<?php if ($tipoinf == "D"){ ?>
								<td class="text-center"><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->certificado)){echo $row->certificado;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Error";}?></td>
							<?php }elseif ($tipoinf == "R") {?>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
						        <td class="text-right"><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Error";}?></td>
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

