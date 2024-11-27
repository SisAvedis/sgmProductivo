
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="UltimoEnviado-v3.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Envases en Cliente</h4></div>
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
				<div class="col-md-9">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Clientes</th>
							<th class="text-center">Fecha Corte</th>
							<th class="text-center" colspan=3>Tipo Informe</th>
							<th class="text-center" colspan=2>Detallado Por</th>
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
							<th rowspan=3><input type="text" name="fecha" id="datepicker" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
						</tr>
						<tr>
							<th>Ultimo_E</th><th>Ultimo_D</th><th>Ultimo_DA</th><th>Cantidad</th><th>Envases</th><th>NP </th><th>SP</th><th>NP+SP</th><th>CIL</th><th>TER</th>
						</tr>
						<tr>
							<th class="text-center" ><input type="radio" checked="checked" name="tipoinf" value=1 required /></th> 
							<th class="text-center"><input type="radio" name="tipoinf" value=2 required /></th>	
							<th class="text-center"><input type="radio" name="tipoinf" value=3 required /></th>
							<th class="text-center"><input type="radio" checked="checked" name="detallepor" value=1 required /></th> 
							<th class="text-center"><input type="radio" name="detallepor" value=2 required /></th>						
							<th class="text-center"><input type="radio" checked="checked" name="propiedad" value="NP" required /></th> 
							<th class="text-center"><input type="radio" name="propiedad" value="SP" required /></th>
							<th class="text-center"><input type="radio" name="propiedad" value="NS" required /></th></th><th class="text-center" ><input type="radio" checked="checked" name="tipoenv" value=1 required /></th>
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
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$tipoinf = isset($_POST['tipoinf']) ? $_POST['tipoinf'] : null;
			$detallepor = isset($_POST['detallepor']) ? $_POST['detallepor'] : null;
			$propiedad = isset($_POST['propiedad']) ? $_POST['propiedad'] : null;
			$clienteOption = isset($_POST['cliente']) ? $_POST['cliente'] : false;;
			if ($clienteOption && $detallepor){
				
				$clienteid_xl = explode("|",$_POST['cliente']);
				$fecha = date("Y-m-d", strtotime($_POST['fecha']));
				
				if ($detallepor == 1){ 
					$clase = 'col-md-6';
					$detpor = 'Cantidad';
				}elseif ($detallepor == 2){
					$clase = 'col-md-8';
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
				
				elseif ($tipoinf == 3){
					$estado = 'A';
					$tinf = 'Ultimo Devuelto Acumulado';
				}
				
				
				$res = $DB->prinUltimoEnviadov3($fecha,$clienteid_xl[0],$detallepor,$propiedad,$tenv,$estado,1);
				
				$fecha = date_format(date_create($fecha),"d-m-Y");
				
				$row_cnt = mysqli_num_rows($res);
				if ($row_cnt == 0){
					$class="alert alert-info";
					$message= "No se obtuvieron registros. "."(Fecha: ".$fecha."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1]."</br>";
					$message= $message."Tipo Informe: ".$tinf.". Detallado Por: ".$detpor.". Propiedad: ".$propiedad.". Envase: ".$tenv;
				}elseif ($row_cnt == 1){
					$class="alert alert-success";
					$message= "Se obtuvo 1 registro. "."(Fecha: ".$fecha."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1]."</br>";
					$message= $message."Tipo Informe: ".$tinf.". Detallado Por: ".$detpor.". Propiedad: ".$propiedad.". Envase: ".$tenv;
				}else{
					$class="alert alert-success";
					$message= "Se obtuvieron ".$row_cnt." registros. "."(Fecha: ".$fecha."). Cliente: (".$clienteid_xl[0].") ".$clienteid_xl[1]."</br>";
					$message= $message."Tipo Informe: ".$tinf.". Detallado Por: ".$detpor.". Propiedad: ".$propiedad.". Envase: ".$tenv;
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
							<?php if ($detallepor == 1){ ?>
								<th>Cliente</th>
								<th class="text-center">Propiedad</th>
								<th class="text-right">Cantidad</th>
							<?php }elseif ($detallepor == 2) {?>
								<th class="text-center">Fecha</th>
								<th>Cliente</th>
								<th class="text-center">Remito</th>
								<th class="text-center">Estado</th>
								<th class="text-center">Tipo Remito</th>
								<th>N° Serie</th>
								<th class="text-center">Volumen</th>
								<th class="text-center">Propiedad</th>
							<?php } ?>	
							
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
								
				?>
					<tbody>
						<tr>
							<?php if ($detallepor == 1){ ?>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->cantidad)){echo $row->cantidad;}else{echo "Error";}?></td>
							<?php }elseif ($detallepor == 2) {?>
								<td class="text-center"><?php if(isset($row->fecha)){echo date_format(date_create($row->fecha),"d-m-Y");}else{echo "Error";}?></td>
								<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->codigo)){echo $row->codigo;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->tiporemito)){echo $row->tiporemito;}else{echo "Error";}?></td>
								<td><?php if(isset($row->serie)){echo $row->serie;}else{echo "Error";}?></td>
								<td class="text-right"><?php if(isset($row->volumen)){echo $row->volumen;}else{echo "Error";}?></td>
								<td class="text-center"><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
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
		//$('#tit').children().each(function (index) {
		//		alert('Index: ' + index + ', html: ' + $(this).html());
		//	});
			//-----
		
		$("#datepicker").datepicker({
				dateFormat: "dd-mm-yy"
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

