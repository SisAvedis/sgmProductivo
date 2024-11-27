
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="remitosVolumen-v3.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Cantidad Volumen Envases Remito</h4></div>
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
				<div class="col-md-9 table-responsive">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Clientes</th>
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
							<th class="text-center" colspan=2>Informe</th>
							<th class="text-center" colspan=3>Propiedad</th>
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
							<th>Resumen</th><th>Detalle</th><th>NP </th><th>SP</th><th>NP+SP</th><th>CIL</th><th>TER</th>
						</tr>
						<tr>
							
							<th class="text-center"><input type="radio" checked="checked" name="tipoinf" value="R" required /></th>
							<th class="text-center"> <input type="radio" name="tipoinf" value="D" required /></th>
							<th class="text-center"><input type="radio" checked="checked" name="propiedad" value="NP" required /></th> 
							<th class="text-center"><input type="radio" name="propiedad" value="SP" required /></th>
							<th class="text-center"><input type="radio" name="propiedad" value="NS" required /></th><th class="text-center" ><input type="radio" checked="checked" name="tipoenv" value=1 required /></th> 
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
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$tipoinf = isset($_POST['tipoinf']) ? $_POST['tipoinf'] : null;
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			if ($clienteOption && $tipoinf){
				
				$clienteid_xl = explode("|",$_POST['cliente']);
				$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
				$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
				$propiedad = isset($_POST['propiedad']) ? $_POST['propiedad'] : null;
				if ($tipoenv == 1){ 
					$tenv = 'CIL';
				}elseif ($tipoenv == 2){
					$tenv = 'TER';
				}
				
				if ($tipoinf == "R"){
					$tinf = 'Resumen';
					$res = $DB->prRemitosVolumenv3($fechaI,$fechaF,$clienteid_xl[0],1, $propiedad, $tenv);
				}elseif ($tipoinf == "D"){
					$res = $DB->prRemitosVolumenv3($fechaI,$fechaF,$clienteid_xl[0],2, $propiedad, $tenv);
					$tinf = 'Detalle';
				}
				
				$fechaI = date_format(date_create($fechaI),"d-m-Y");
				$fechaF = date_format(date_create($fechaF),"d-m-Y");
				
				$row_cnt = mysqli_num_rows($res);
				
				if ($row_cnt == 0){
					$message= "No se obtuvieron registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Informe: ".$tinf.". Propiedad: ".$propiedad.". Envase: ".$tenv;
					$class="alert alert-info";
				}elseif ($row_cnt == 1){
					$message= "Se obtuvo ".$row_cnt." registro. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Informe: ".$tinf.". Propiedad: ".$propiedad.". Envase: ".$tenv;
					$class="alert alert-success";
				}else{
					$message= "Se obtuvieron ".$row_cnt. " registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Informe: ".$tinf.". Propiedad: ".$propiedad.". Envase: ".$tenv;
					$class="alert alert-success";
				}
				
				/*
				$message= "Se obtuvieron ".$row_cnt. " registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Informe: ".$tinf.". Propiedad: ".$propiedad.". Envase: ".$tenv;
				if ($row_cnt == 0){
					$class="alert alert-info";
				}else{
					$class="alert alert-success";
				}
				*/
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
							<?php if ($tipoinf == "D"){ ?>
								<th class="text-center">Fecha</th>
								<th class="text-center">Remito</th>
								<th class="text-center">Propiedad</th>
								<th>Cliente</th>
								<th class="text-right">Env</th>
								<th class="text-right">Dev</th>
								<th class="text-right">Saldo</th>
								<th class="text-right">Cantidad Metros</th>
								<th class="text-center">Metros Ingresados</th>
							<?php }elseif ($tipoinf == "R") {?>
								<th>Nombre</th>
								<th class="text-center">Propiedad</th>
								<th class="text-right">Env</th>
								<th class="text-right">Dev</th>
								<th class="text-right">Saldo</th>
								<th class="text-right">Cantidad Metros</th>
								<th class="text-center">Metros Ingresados</th>
							<?php } ?>	
							
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
								
				?>
					<tbody>
						<tr>
							<?php if ($tipoinf == "D"){ ?>
							<?php
							if(isset($row->ER)){
								$resultado = $row->ER;
								}
							switch ($resultado) {
								case "Total":
									$claseFondo = "text-right info";
									break;
								case "Parcial":
									$claseFondo = "text-right warning";
									break;
								case "Sin Datos":
									$claseFondo = "text-right danger ";
									break;
							}
							?>					
							
							
								
								
								<td class="text-center"><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->Env)){echo $row->Env;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->Dev)){echo $row->Dev;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->ED)){echo $row->ED;}else{echo "Error";}?></td>
								<td class="<?php echo $claseFondo;?>"><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Error";}?></td>
								<!--
								<td class="<?php //echo $claseFondo;?>"><?php //if(isset($row->volumen) && !is_null($row->volumen)){
											//echo $row->volumen;
											//}elseif(!isset($row->volumen) && is_null($row->volumen)){
											//	echo "0.00";
											//}else{
											//	echo "Error";
											//}
										?>
								</td>
								-->
								<!--$myvar = NULL; is_null($myvar); // TRUE-->
								<!--$myvar = NULL; isset($myvar);   // FALSE-->
								<!--$myvar = NULL; empty($myvar);   // TRUE-->
								
								
								
								
								
								
								
								<td class="text-center"><?php if(isset($row->ER)){echo $row->ER;}else{echo "Error";}?></td>
							<?php }elseif ($tipoinf == "R") {?>
								<?php
									if(isset($row->ER)){
										$resultado = $row->ER;
									}
									switch ($resultado) {
										case "Total":
											$claseFondo = "text-right info";
											break;
									case "Parcial":
											$claseFondo = "text-right warning";
											break;
									case "Sin Datos":
										$claseFondo = "text-right danger";
										break;
									}
									
									if(isset($row->ultimo)){
										$resultadoUL = $row->ultimo;
									}else{
										$resultadoUL = "N";
									}
									switch ($resultadoUL) {
										case "N":
											$claseULinea = "";
											break;
									case "S":
											$claseULinea = "success";
											$claseFondo = "text-right success";
											break;
									}
									
									
									?>
							
								<td class="text-left <?php echo $claseULinea;?>"><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
						        <td class="text-center <?php echo $claseULinea;?>"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
								<td class="text-right <?php echo $claseULinea;?>"><?php if(isset($row->se)){echo $row->se;}else{echo "Error";}?></td>
						        <td class="text-right <?php echo $claseULinea;?>"><?php if(isset($row->sd)){echo $row->sd;}else{echo "Error";}?></td>
								<td class="text-right <?php echo $claseULinea;?>"><?php if(isset($row->saldoED)){echo $row->saldoED;}else{echo "Error";}?></td>
						        <td class="<?php echo $claseFondo;?>"><?php if(isset($row->volumen) && !is_null($row->volumen)){
											echo $row->volumen;
											}elseif(!isset($row->volumen) && is_null($row->volumen)){
												echo "0.0";
											}else{
												echo "Error";
											}
										?>
								</td>
								<!--$myvar = NULL; is_null($myvar); // TRUE-->
								<!--$myvar = NULL; isset($myvar);   // FALSE-->
								<!--$myvar = NULL; empty($myvar);   // TRUE-->
								
								
								<td class="text-center <?php echo $claseULinea;?>"><?php if(isset($row->ER)){echo $row->ER;}else{echo "Error";}?></td>
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

