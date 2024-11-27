<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="cliente-v1.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Estado de Clientes</h4></div>
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
					$idcliente_xl0 = $clienteid_xls[0];
				}else{
					$idcliente_xls = 0;
					$idcliente_xl0 = 0;
				}
			?>
			
			
			<div class="row">
				<div class="col-md-3 table-responsive">
				<table class="table table-bordered" id="tabla">
					<thead>
						<tr>
							<th class="text-center" colspan=2>Ordenar Por</th>
						</tr>
						<tr>
							<th class="text-center">Cliente</th>
							<th class="text-center">Grupo</th>
						</tr>
						<tr>
							<th class="text-center" ><input type="radio" checked="checked" name="ordenar" value=1 required /></th> 
							<th class="text-center"><input type="radio" name="ordenar" value=2 required /></th>							
						</tr>
						
					</thead>
				</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-5">
					<label><pre class="lx-pre" id="lblMsgInformacion">Consulta Estado del Cliente (Activo | Desactivado)</pre></label></br>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-md-12" id="divDetalleAuditoria">
				</div>
			</div>
			
			<div class="row">	
				<!--<div class="col-md-12 pull-right">-->
				<div class="col-md-12">
					<!--<hr>-->
					<button type="submit" id="btnsubmit" class="btn btn-sm btn-danger">Consultar</button>
					<!--<hr>-->
				</div>
			</div>	
		<!--</div>-->
	<!--</div>-->	

	<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$DB= new Database();
				$ordenar = isset($_POST['ordenar']) ? $_POST['ordenar'] : null;
				if ($ordenar){
				//echo "<pre>";
				//echo print_r($_POST)."</br>";
				//echo "</pre>";
				
				
				//echo "<pre>";
				//echo $seriesCSV."</br>";
				//echo "</pre>";
				
				
				//$clienteid = explode("|",$_POST['cliente']);
				//$fecha = date("Y-m-d", strtotime($_POST['fecha']));
				
				if ($ordenar == 1){ 
					$detpor = 'Cliente';
					$res = $DB->clientesGrupos();
				}elseif ($ordenar == 2){
					$detpor = 'Envases';
					$res = $DB->gruposClientes();
				}
				
				$idusuario=isset($_SESSION['idusuario'])? $_SESSION['idusuario']:"";
				
				
				$row_cnt = mysqli_num_rows($res);
					if ($row_cnt == 0){
						$message= "No se obtuvieron movimientos";
						$class="alert alert-info";
					}elseif($row_cnt == 1){
						$message= "Se obtuvo ".$row_cnt." movimiento con éxito ";
						$class="alert alert-success";
					}else{
						$message= "Se obtuvieron ".$row_cnt." movimientos con éxito ";
						$class="alert alert-success";
					}
					
				}
			}else{
				$class = "";
				$message = "";
				$row_cnt = 0;
			}
				?>
			    
				<div class="<?php echo $class;?>" id="rowmessage">
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
								<?php if ($ordenar == 1){?>
									<th>Cliente</th>
									<th>Grupo</th>
									<th class="text-center">Condición</th>
								<?php		
									}elseif ($ordenar == 2) {?>
										<th>Grupo</th>
										<th>Cliente</th>
										<th class="text-center">Condición</th>
								<?php
									}	
								?>
							</tr>
						</thead>
					<?php 
						while ($row=mysqli_fetch_object($res)){
							
							
						?>
							<tbody>
								<tr class="<?php echo $claseFondo;?>">
									<?php if ($ordenar == 1){?>
										<td><?php if(isset($row->id_xl) && isset($row->cliente)){echo '('.$row->id_xl.') '.$row->cliente;}else{echo "Error";}?></td>
										<td><?php if(isset($row->grupo)){echo $row->grupo;}else{echo "Error";}?></td>
										<td class="text-center">
											<?php if(isset($row->condicion))
												{if($row->condicion == 0){
													echo "Desactivado";
												}else{
													echo "Activo";
												}
												//echo $row->rampabackup;
												}else{echo "Error";}?>
										
										</td>
									<?php		
									}elseif ($ordenar == 2) {?>
										<td><?php if(isset($row->grupo)){echo $row->grupo;}else{echo "Error";}?></td>
										<td><?php if(isset($row->id_xl) && isset($row->cliente)){echo '('.$row->id_xl.') '.$row->cliente;}else{echo "Error";}?></td>
										<td class="text-center">
											<?php if(isset($row->condicion))
												{if($row->condicion == 0){
													echo "Desactivado";
												}else{
													echo "Activo";
												}
												//echo $row->rampabackup;
											}else{echo "Error";}?>
										
										</td>
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
			//}
			
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
	
<script type="text/javascript">
	
	var jq = jQuery.noConflict();
	//jQuery.noConflict();
	jq(document).ready(function(){
		
		jq('#lblMsgInformacion').css("background-color","#B8D4FE");
		jq('#lblMsgInformacion').css("color","#000333");
		
		
		
	});

</script>				
	



	</form>
	</body>
</html>
			
			
			