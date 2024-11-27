
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="UltimoEnviadoCC-v4-1.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php //include ("database_e3.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Envases en Cliente (Cap)</h4></div>
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
			$tLP = 0;
			$DB0= new Database();
			$idPR = 'LG';
			$res0 = $DB0->prProductov1($idPR,$tLP);
			$iRow0 = 1;
			$producto = array(0,0);
			$i=0;
			$idproductoOption = isset($_POST['idproducto']) ? $_POST['idproducto'] : false;;
			$valores = $idproductoOption;
			if($idproductoOption == 6)
			{
				$valores = array('1|O2|Oxígeno|1', '2|CO2|Dióxido de Carbono|2', '3|N2O|Oxido Nitroso|3','5|Aire|Aire|4');
			}
			
			if ($idproductoOption){
				if($idproductoOption == 6)
				{
					$productoOption = explode("|",$valores[$i]);
				}else{
					$productoOption = explode("|",$_POST['idproducto']);
				}
				
				$productoNom = $productoOption[2];
			}else{
				$productoNom = 0;
			}
			?>
			
			
			<div class="row">
				<div class="col-md-10">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Clientes</th>
							<th class="text-center">Fecha Corte</th>
							<th class="text-center">Producto</th>
							<th class="text-center" colspan=2>Tipo Informe</th>
							<th class="text-center" colspan=2>Detallado Por</th>
							<th class="text-center" colspan=3>Propiedad</th>
							<th class="text-center" colspan=2>Envase</th>
						</tr>
						<tr>
							<th rowspan=3>
								<select name="cliente[]" id="cliente" class="form-control input-sm" multiple="multiple">
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
							<th rowspan=3><input type="text" name="fecha" id="datepicker" class="form-control input-sm" maxlength="10" autocomplete="off"  required /></th>
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
								<option value="6">Todos</option>
								</select>
							</th>
						</tr>
						<tr>
							<th>Ultimo_E</th><th>Ultimo_D</th><th>Cantidad</th><th>Envases</th><th>NP<th>SP</th><th>NP+SP</th><th>CIL</th><th>TER</th>
						</tr>
						<tr>
							<th class="text-center" ><input type="radio" checked="checked" name="tipoinf" value=1 required /></th> 
							<th class="text-center"><input type="radio" name="tipoinf" value=2 required /></th>	
							<th class="text-center"><input type="radio" checked="checked" name="detallepor" value=1 required /></th> 
							<th class="text-center"><input type="radio" name="detallepor" value=2 required /></th>						
							<th class="text-center"><input type="radio" checked="checked" name="propiedad" value="NP" required /></th> 
							<th class="text-center"><input type="radio" name="propiedad" value="SP" required /></th>
							<th class="text-center"><input type="radio" name="propiedad" value="NS" required /></th>
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
			
				<!--<div class="col-md-12 pull-right">-->
				<div class="col-md-12">
					<button type="submit" class="btn btn-sm btn-danger">Consultar</button>
				</div>
				<hr>
			</div>
			
			
			<?php
			$clientes = '';
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$tipoinf = isset($_POST['tipoinf']) ? $_POST['tipoinf'] : null;
			$detallepor = isset($_POST['detallepor']) ? $_POST['detallepor'] : null;
			$propiedad = isset($_POST['propiedad']) ? $_POST['propiedad'] : null;
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
			$valores = $idproductoOption;
			if($idproductoOption == 6)
			{
				$valores = array('1|O2|Oxígeno|1', '2|CO2|Dióxido de Carbono|2', '3|N2O|Oxido Nitroso|3','5|Aire|Aire|4');
			}

			
			for($i=0;$i<4;$i++)
			{	
				if($idproductoOption != 6)
				{
					$i = 3;
				}
			if ($clienteOption && $detallepor && $idproductoOption){
				
				$clientesCSV = '';
				$clientesRPT = '';
				foreach ($categoryIds as $categoryId) {
					$clienteid_xl = explode("|",$categoryId);
					$clientesCSV = $clientesCSV.$clienteid_xl[0].',';
					$clientesRPT = $clientesRPT.' ('.$clienteid_xl[0].') '.$clienteid_xl[1].', ';
				}
				$clientesCSV = substr($clientesCSV, 0, strlen($clientesCSV)-1);
				$clientesRPT = substr($clientesRPT, 0, strlen($clientesRPT)-2);
				
				
				//echo "<pre>";
				//echo $clientesRPT;
				//echo "</pre>";
				
				if($idproductoOption == 6)
				{
					$producto = explode("|",$valores[$i]);
				}else{
					$producto = explode("|",$_POST['idproducto']);
				}

				$fecha = date("Y-m-d", strtotime($_POST['fecha']));
				
				if ($detallepor == 1){ 
					$clase = 'col-md-10';
					$detpor = 'Cantidad';
				}elseif ($detallepor == 2){
					$clase = 'col-md-12';
					$detpor = 'Envases';
				}
				
				if ($tipoenv == 1){ 
					$tenv = 'CIL';
				}elseif ($tipoenv == 2){
					$tenv = 'TER';
				}
				
				if ($tipoinf == 1){ 
					$estado = 'E';
					$tinf = 'Ultimo Enviado';
					
				}elseif ($tipoinf == 2){
					$estado = 'D';
					$tinf = 'Ultimo Devuelto';
				}
				$res = $DB->prUltimoEnviadoCCv411($fecha,$clientesCSV,$detallepor,$propiedad,$tenv,$estado,$producto[0]);
				
				$fecha = date_format(date_create($fecha),"d-m-Y");
				
				$row_cnt = mysqli_num_rows($res);
				if ($row_cnt == 0){
					$class="alert alert-info";
					$message= "No se obtuvieron registros. "."(Fecha: ".$fecha."). Cliente: ".$clientesRPT."</br>";
					//$message= "No se obtuvieron registros. "."(Fecha: ".$fecha."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1]."</br>";
					$message= $message."Tipo Informe: ".$tinf.". Detallado Por: ".$detpor.". Propiedad: ".$propiedad.". Envase: ".$tenv.". Producto: (".$producto[1].") ".$producto[2];
				}elseif ($row_cnt == 1){
					$class="alert alert-success";
					$message= "Se obtuvo 1 registro. "."(Fecha: ".$fecha."). Cliente: ".$clientesRPT."</br>";
					//$message= "Se obtuvo 1 registro. "."(Fecha: ".$fecha."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1]."</br>";
					$message= $message."Tipo Informe: ".$tinf.". Detallado Por: ".$detpor.". Propiedad: ".$propiedad.". Envase: ".$tenv.". Producto: (".$producto[1].") ".$producto[2];
				}else{
					$class="alert alert-success";
					$message= "Se obtuvieron ".$row_cnt." registros. "."(Fecha: ".$fecha."). Cliente: ".$clientesRPT."</br>";
					//$message= "Se obtuvieron ".$row_cnt." registros. "."(Fecha: ".$fecha."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1]."</br>";
					$message= $message."Tipo Informe: ".$tinf.". Detallado Por: ".$detpor.". Propiedad: ".$propiedad.". Envase: ".$tenv.". Producto: (".$producto[1].") ".$producto[2];
				}
				?>
			
			<div class="<?php echo $class;?>" id="rows">
				  <?php echo $message;?>
			</div>
			<?php
			if ($row_cnt == 0){
			}else{
				?>	
				
				<?php
				//echo "<pre>";
				//echo $detallepor."</br>".$propiedad;
				//echo "</pre>";
				?>
				
				
			<div class="row">
				<div class="<?php echo $clase;?>">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<?php if ($detallepor == 1){
								if ($tipoenv == 1){	
									?>
								<th>Cliente</th>
								<th>Producto</th>
								<th class="text-center">Propiedad</th>
								<?php
									switch ($producto[0]) {
										case 1:
											?>
											<th class="text-right">0.0</th>
											<th class="text-right">0.5</th>
											<th class="text-right">1.0</th>
											<th class="text-right">2.1</th>
											<th class="text-right">3.2</th>
											<th class="text-right">4.2</th>
											<th class="text-right">4.3</th>
											<th class="text-right">6.4</th>
											<th class="text-right">8.5</th>
											<th class="text-right">10.6</th>
											<th class="text-right">Total</th>
									<?php		
										break;	
										case 2:
											?>	
											<th class="text-right">0</th>
											<th class="text-right">13</th>
											<th class="text-right">18</th>
											<th class="text-right">20</th>
											<th class="text-right">25</th>
											<th class="text-right">27</th>
											<th class="text-right">30</th>
											<th class="text-right">33</th>
											<th class="text-right">34</th>
											<th class="text-right">35</th>
											<th class="text-right">37</th>
											<th class="text-right">Total</th>
									<?php		
										break;	
										case 3:
											?>		
											<th class="text-right">0</th>
											<th class="text-right">25</th>
											<th class="text-right">27</th>
											<th class="text-right">Total</th>
									<?php		
										break;	
										case 5:
											?>		
											<th class="text-right">0</th>
											<th class="text-right">1.0</th>
											<th class="text-right">2.0</th>
											<th class="text-right">6.0</th>
											<th class="text-right">6.4</th>
											<th class="text-right">6.5</th>
											<th class="text-right">7.0</th>
											<th class="text-right">8.0</th>
											<th class="text-right">10.0</th>
											<th class="text-right">Total</th>
								<?php		
										break;		
									}	
								?>		
								
								<?php }elseif ($tipoenv == 2){
									?>
								<th>Cliente</th>
								<th>Producto</th>
								<th class="text-center">Propiedad</th>
								<th class="text-right">45</th>
								<th class="text-right">125</th>
								<th class="text-right">140</th>
								<th class="text-right">150</th>
								<th class="text-right">180</th>
								<th class="text-right">Total</th>
								<?php }
								?>
							<?php }elseif ($detallepor == 2) {?>
								<th class="text-center">Fecha</th>
								<th>Cliente</th>
								<th class="text-center">Remito</th>
								<th class="text-center">Estado</th>
								<th class="text-center">Tipo Remito</th>
								<th class="text-center">Producto</th>
								<th>N° Serie</th>
								<th class="text-right">Capacidad</th>
								<th class="text-center">Propiedad</th>
							<?php } ?>	
							
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
								
				?>
					<tbody>
						<tr>
							<?php if ($detallepor == 1){
								if ($tipoenv == 1){
									?>
								<?php
									switch ($producto[0]) {
										case 1:
											?>
											<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
											<td class="text-center"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
											<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_000)){echo $row->c_000;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_050)){echo $row->c_050;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_100)){echo $row->c_100;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_210)){echo $row->c_210;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_320)){echo $row->c_320;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_420)){echo $row->c_420;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_430)){echo $row->c_430;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_640)){echo $row->c_640;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_850)){echo $row->c_850;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_106)){echo $row->c_106;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_total)){echo $row->c_total;}else{echo "Error";}?></td>
									<?php		
										break;	
										case 2:
											?>
											<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
											<td class="text-center"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
											<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_000)){echo $row->c_000;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_130)){echo $row->c_130;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_180)){echo $row->c_180;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_200)){echo $row->c_200;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_250)){echo $row->c_250;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_270)){echo $row->c_270;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_300)){echo $row->c_300;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_330)){echo $row->c_330;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_340)){echo $row->c_340;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_350)){echo $row->c_350;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_370)){echo $row->c_370;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_total)){echo $row->c_total;}else{echo "Error";}?></td>
									<?php		
										break;	
										case 3:
											?>
											<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
											<td class="text-center"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
											<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_000)){echo $row->c_000;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_250)){echo $row->c_250;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_270)){echo $row->c_270;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_total)){echo $row->c_total;}else{echo "Error";}?></td>
									<?php		
										break;	
										case 5:
											?>
											<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
											<td class="text-center"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
											<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_000)){echo $row->c_000;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_100)){echo $row->c_100;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_200)){echo $row->c_200;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_600)){echo $row->c_600;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_640)){echo $row->c_640;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_650)){echo $row->c_650;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_700)){echo $row->c_700;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_800)){echo $row->c_800;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_1000)){echo $row->c_1000;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_total)){echo $row->c_total;}else{echo "Error";}?></td>
								<?php		
										break;		
									}	
								?>
								
								<?php }elseif ($tipoenv == 2){
									?>
									
									<?php
									switch ($producto[0]) {
										case 1:
											?>
											<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
											<td class="text-center"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
											<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_045)){echo $row->c_045;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_125)){echo $row->c_125;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_140)){echo $row->c_140;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_150)){echo $row->c_150;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_180)){echo $row->c_180;}else{echo "Error";}?></td>
											<td class="text-right"><?php if(isset($row->c_total)){echo $row->c_total;}else{echo "Error";}?></td>
								
								<?php		
										break;		
									}	
								}	
								?>
								
								<?php }elseif ($detallepor == 2) {?>
								<td class="text-center"><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->codigo2)){echo $row->codigo2;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->tiporemito)){echo $row->tiporemito;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->producto)){echo $row->producto;}else{echo "Error";}?></td>
								<td><?php if(isset($row->serie)){echo $row->serie;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Falta";}?></td>
								<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
								<?php } ?>   
						
						</tr>				
					</tbody>	
					<?php
						}
						//$res = $DB->closePR();
					?>
						
					
				</table>
				</div>
			</div>
			
			<?php
						}
					?>
		   
		   <?php
							}
						}
						$res = $DB->closePR();
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
		//$('#tit').children().each(function (index) {
		//		alert('Index: ' + index + ', html: ' + $(this).html());
		//	});
			//-----
		
		$("#datepicker").datepicker({
				dateFormat: "dd-mm-yy"
		});
		
		$('#cliente').multiselect({
            includeSelectAllOption: true,
			maxHeight: 200,
			dropUp: true,
			inheritClass: true,
			buttonText: function(options, select) {
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
		
		$("input[name=tipoinf]").click(function () {
			
			var divHeader = "<div>"+"</div>";
			
			$('h2').remove();	
			$('#tit').append(divHeader);
			$('#tit').addClass('col-sm-8');
			$('#tit').children().each(function (index) {
						$(this).remove();
					});
			
			if (this.value == 1) {
					$('#tit').append("<h4>Ultimo Entregado</h4>");
			}
			else if (this.value == 2) {
					$('#tit').append("<h4>Ultimo Devuelto</h4>");
			}
					
		})
});
</script>




	</form>
	</body>
</html>

