
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="remitosCantidad-v5-1.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php //include ("database_e3.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Cantidad Envases Remito</h4></div>
                </div>
            </div>
            
			<?php
			$DB= new Database();
			$idCL = 'XLS';
			$res = $DB->clientesTodosBis($idCL);
			//$res = $DB->clientesTodos();
			$iRow = 1;
			$clienteid_xl = array(0,0);
			/*
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			if ($clienteOption){
				$clienteid_xls = explode("|",$_POST['cliente']);
				$idcliente_xls = $clienteid_xls[2];
			}else{
				$idcliente_xls = 0;
			}
			*/
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
				<div class="col-md-12">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Clientes</th>
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
							<th class="text-center">Producto</th>
							<th class="text-center" colspan=2>Informe</th>
							<th class="text-center" colspan=3>Tipo Remito</th>
							<th class="text-center" colspan=3>Propiedad</th>
							<th class="text-center" colspan=2>Envase</th>
						</tr>
						<tr>
							<th rowspan=3>
								<select name="cliente[]" id="cliente" class="form-control input-sm" multiple="multiple">
								<!--<select name="cliente[]" id="cliente" class="form-control input-sm" >-->
								<!--<select id="cliente" class="form-control input-sm" >-->
								<!--<option value="0">Clientes</option>-->
								<?php while ($row=mysqli_fetch_object($res)){ 
									if (1 <> 1){?>
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
						</tr>
						<tr>
							<th>Resumen</th><th>Detalle</th><th>RDIST</th><th>RSUBI</th><th>AMBOS</th><th>NP </th><th>SP</th><th>NP+SP</th><th>CIL</th><th>TER</th>
						</tr>
						<tr>
							
							<th class="text-center"><input type="radio" checked="checked" name="tipoinf" value="R" required /></th>
							<th class="text-center"> <input type="radio" name="tipoinf" value="D" required /></th>
							<th class="text-center"><input type="radio" checked="checked" name="tiporemito" value="D" required /></th>
							<th class="text-center"> <input type="radio" name="tiporemito" value="S" required /></th>
							<th class="text-center"> <input type="radio" name="tiporemito" value="A" required /></th>
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
			$clientes = '';
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$tipoinf = isset($_POST['tipoinf']) ? $_POST['tipoinf'] : null;
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				
				$categoryIds = $_POST['cliente'];
				foreach ($categoryIds as $categoryId) {
					$clientes = $clientes.$categoryId."</br>";
				}
				
				//echo "<pre>";
				//echo $clientes;
				//echo "</pre>";
			}
			
			$idproductoOption = isset($_POST['idproducto']) ? $_POST['idproducto'] : false;;
			if ($clienteOption && $tipoinf && $idproductoOption){
				
				$clientesCSV = '';
				$clientesRPT = '';
				foreach ($categoryIds as $categoryId) {
					$clienteid_xl = explode("|",$categoryId);
					$clientesCSV = $clientesCSV.$clienteid_xl[0].',';
					$clientesRPT = $clientesRPT.' ('.$clienteid_xl[0].') '.$clienteid_xl[1].', ';
				}
				$clientesCSV = substr($clientesCSV, 0, strlen($clientesCSV)-1);
				$clientesRPT = substr($clientesRPT, 0, strlen($clientesRPT)-2);
				
				$producto = explode("|",$_POST['idproducto']);
				$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
				$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
				$propiedad = isset($_POST['propiedad']) ? $_POST['propiedad'] : null;
				$tiporemito = isset($_POST['tiporemito']) ? $_POST['tiporemito'] : null;
				switch ($tiporemito) {
					case "A":
						$tiporemitoC = "AMBOS";
						break;
					case "D":
						$tiporemitoC = "RDIST";
						break;
					case "S":
						$tiporemitoC= "RSUBI";
						break;
				}
				
				if ($tipoenv == 1){ 
					$tenv = 'CIL';
				}elseif ($tipoenv == 2){
					$tenv = 'TER';
				}
				
				//echo "<pre>";
				//echo $clientesCSV."</br>";
				//echo "</pre>";
				
				if ($tipoinf == "R"){
					$tinf = 'Resumen';
					$res = $DB->prRemitosCantidadv511($fechaI,$fechaF,$clientesCSV,1, $propiedad, $tenv, $tiporemito, $producto[0]);
				}elseif ($tipoinf == "D"){
					$res = $DB->prRemitosCantidadv511($fechaI,$fechaF,$clientesCSV,2, $propiedad, $tenv, $tiporemito, $producto[0]);
					$tinf = 'Detalle';
				}
				
				$fechaI = date_format(date_create($fechaI),"d-m-Y");
				$fechaF = date_format(date_create($fechaF),"d-m-Y");
				
				$row_cnt = mysqli_num_rows($res);
				
				if ($row_cnt == 0){
					$message= "No se obtuvieron registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: ".$clientesRPT.". Informe: ".$tinf.". Remitos: ".$tiporemitoC.". Propiedad: ".$propiedad.". Envase: ".$tenv.". Producto: (".$producto[1].") ".$producto[2];
					//$message= "No se obtuvieron registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Informe: ".$tinf.". Remitos: ".$tiporemitoC.". Propiedad: ".$propiedad.". Envase: ".$tenv.". Producto: (".$producto[1].") ".$producto[2];
					$class="alert alert-info";
				}elseif ($row_cnt == 1){
					$message= "Se obtuvo ".$row_cnt." registro. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: ".$clientesRPT.". Informe: ".$tinf.". Remitos: ".$tiporemitoC.". Propiedad: ".$propiedad.". Envase: ".$tenv.". Producto: (".$producto[1].") ".$producto[2];
					//$message= "Se obtuvo ".$row_cnt." registro. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Informe: ".$tinf.". Remitos: ".$tiporemitoC.". Propiedad: ".$propiedad.". Envase: ".$tenv.". Producto: (".$producto[1].") ".$producto[2];
					$class="alert alert-success";
				}else{
					$message= "Se obtuvieron ".$row_cnt. " registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: ".$clientesRPT.") ".$clienteid_xl[1].". Informe: ".$tinf.". Remitos: ".$tiporemitoC.". Propiedad: ".$propiedad.". Envase: ".$tenv.". Producto: (".$producto[1].") ".$producto[2];
					//$message= "Se obtuvieron ".$row_cnt. " registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1].". Informe: ".$tinf.". Remitos: ".$tiporemitoC.". Propiedad: ".$propiedad.". Envase: ".$tenv.". Producto: (".$producto[1].") ".$producto[2];
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
				<div class="col-md-12">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<?php if ($tipoinf == "D"){ ?>
								<th class="text-center">Fecha</th>
								<th class="text-center">Remito</th>
								<th class="text-center">Estado</th>
								<th class="text-center">T Remito</th>
								<th>Cliente</th>
								<th class="text-center">Producto</th>
								<th class="text-center">Prop</th>
								<th class="text-center">Envase</th>
								<th class="text-right">ResE</th>
								<th class="text-right">Env</th>
								<th class="text-right">EnvDif</th>
								<th class="text-right">ResD</th>
								<th class="text-right">Dev</th>
								<th class="text-right">DevDif</th>
								<th class="text-right">ED</th>
								<th class="text-right">EDDif</th>
								<th class="text-center">Obs</th>
							<?php }elseif ($tipoinf == "R") {?>
								<th class="text-center">Nombre</th>
								<th class="text-center">Tipo Remito</th>
								<th class="text-center">Producto</th>
								<th class="text-center">Propiedad</th>
								<th class="text-center">Envase</th>
								<th class="text-right">Env</th>
								<th class="text-right">EnvDif</th>
								<th class="text-right">Dev</th>
								<th class="text-right">DevDif</th>
								<th class="text-right">Saldo</th>
								<th class="text-right">SaldoDif</th>
							<?php } ?>	
							
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
					
					if ($tipoinf == "D"){
							
						
						if(($row->ED) == 0 && ($row->EDdiff) == 0){
							$saldo = 'O';
						}else{
							$saldo = 'N';
						}
						$fondo = $row->ResE.$row->ResD.$saldo;
						
						//echo "<pre>";
						//echo $saldo."</br>";
						//echo "</pre>";
						
						switch ($fondo) {
							case "BBO":
								$claseFondo = "";
								break;
							case "BBN":
								$claseFondo = "success";
								break;
							default:
								$claseFondo = "danger";
								break;
						}
						/*
						switch ($resED) {
							case "BB":
								$claseFondo = "";
								break;
							default:
								$claseFondo = "warning";
								break;
						}
						*/
						
						
						
						
					}else{
						$claseFondo = "";
					}
					
					
					


						
				?>
					<tbody>
						<tr class="<?php echo $claseFondo;?>">
							<?php if ($tipoinf == "D"){ ?>
								<td class="text-center"><?php if(isset($row->fecha)){echo $row->fecha;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->codigo2)){echo $row->codigo2;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->tiporemito)){echo $row->tiporemito;}else{echo "Error";}?></td>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->tipoenvase)){echo $row->tipoenvase;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->ResE)){echo $row->ResE;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->Env)){echo $row->Env;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->EnvDist)){echo $row->EnvDist;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->ResD)){echo $row->ResD;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->Dev)){echo $row->Dev;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->DevDist)){echo $row->DevDist;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->ED)){echo $row->ED;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->EDdiff)){echo $row->EDdiff;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->codigo)){echo $row->codigo;}else{echo "Error";}?></td>
							<?php }elseif ($tipoinf == "R") {?>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->tiporemito)){echo $row->tiporemito;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
						        <td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->tipoenvase)){echo $row->tipoenvase;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->se)){echo $row->se;}else{echo "Error";}?></td>
						        <td class="text-right"><?php if(isset($row->see)){echo $row->see;}else{echo "Error";}?></td>
						        <td class="text-right"><?php if(isset($row->sd)){echo $row->sd;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->sdd)){echo $row->sdd;}else{echo "Error";}?></td>
						        <td class="text-right"><?php if(isset($row->saldoED)){echo $row->saldoED;}else{echo "Error";}?></td>
						        <td class="text-right"><?php if(isset($row->saldoEDDif)){echo $row->saldoEDDif;}else{echo "Error";}?></td>
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
		
		//var sMS = 'multiple';
		//$('#cliente').attr('multiple',sMS);
		
		
		$('#cliente').multiselect({
			includeSelectAllOption: true,
			maxHeight: 200,
			dropUp: true,
			inheritClass: true,
			onInitialized: function(select, container) {
                    //alert('Initialized.');
            },
			buttonText: function(options, select) {
				//console.log('Valor de options.length -> '+options.length);
                if (options.length === 0) {
                    return 'Cliente';
                }
                else if (options.length > 1) {
                    return  options.length+' Clientes';
                }
                 else {
                     var labels = [];
                     options.each(function() {
                         if ($(this).attr('label') !== undefined) {
                             labels.push($(this).attr('label'));
                         }
                         else {
                             labels.push($(this).html());
                         }
                     });
                     return labels.join(', ') + '';
                 }
            }
			
        });
		
});
</script>




	</form>
	</body>
</html>

