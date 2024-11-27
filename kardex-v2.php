
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="kardex-v2.php">
    
	
	<div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Kardex v2</h4></div>
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
				
				if ($tipoinf == "D"){
					$tinf = 'Detalle';
					$res = $DB->prKardexv2($fechaI,$fechaF,$clienteid_xl[0],2, $propiedad, $tenv);
				}elseif ($tipoinf == "R"){
					$res = $DB->prKardexv2($fechaI,$fechaF,$clienteid_xl[0],1, $propiedad, $tenv);
					$tinf = 'Resumen';
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
				<div class="col-md-8">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<?php if ($tipoinf == "D"){ ?>
								<th class="text-center">Fecha</th>
								<th>Cliente</th>
								<th class="text-center">Remito</th>
								<th class="text-center">Estado</th>
								<th>N° Serie</th>
								<th class="text-center">Propiedad</th>
								<th class="text-center">Envase</th>
								<th class="text-center">Fake</th>
							<?php }elseif ($tipoinf == "R") {?>
								<th class="text-center">Fecha</th>
								<th>Cliente</th>
								<th class="text-right">Cantidad</th>
								<th class="text-center">Propiedad</th>
								<th class="text-center">Envase</th>
							<?php } ?>	
							
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
					
					if ($tipoinf == "D"){
						if(isset($row->fake) && isset($row->id_xl)){
							$resultado = $row->fake;
							$resultadoidxl = $row->id_xl;
						}
						switch ($resultado) {
							case "Si":
								if($resultadoidxl <> $clienteid_xl[0]){
									$claseFondo = "danger";
								}else{
									$claseFondo = "";
								}
								break;
							case "No":
								$claseFondo = "warning";
								break;
						}
					}
					
				?>
					<tbody>
						<tr class="<?php echo $claseFondo;?>">
							<?php if ($tipoinf == "D"){ ?>
								<td class="text-center"><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->estado)){echo $row->estado;}else{echo "Error";}?></td>
								<td><?php if(isset($row->serie)){echo $row->serie;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->tipo)){echo $row->tipo;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->fake)){echo $row->fake;}else{echo "Error";}?></td>
							<?php }elseif ($tipoinf == "R") {?>
								<td class="text-center"><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->cantidad)){echo $row->cantidad;}else{echo "Error";}?></td>
						        <td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->tipo)){echo $row->tipo;}else{echo "Error";}?></td>
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

