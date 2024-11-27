
<?php set_time_limit(300);?>
<?php include ("inicio.php"); ?>
			
<?php try{ ?>
<body>
	<form method="post" action="vencimientos-v1.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Vencimiento de Producto</h4></div>
                </div>
            </div>
			<?php
			$tipoinf = isset($_POST['tipoinf']) ? $_POST['tipoinf'] : null;
			if(!$tipoinf){
				$tipoinf = 1;
			}
            //echo "<pre>";
			//echo $tipoinf."</br>";
			//echo "</pre>";
			
			?>			
			<div class="row">
				<div class="col-md-5 table-responsive">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center">Fecha Inicial</th>
							<th class="text-center">Fecha Final</th>
							<th class="text-center" colspan=2>Ordenado Por</th>
						</tr>
						<tr>
							<th class="text-center" rowspan=3><input type="text" name="fechaI" id="datepickerI" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
							<th class="text-center" rowspan=3><input type="text" name="fechaF" id="datepickerF" class="form-control input-sm" maxlength="10" autocomplete="off" required /></th>
							<th>Envase</th><th>Cliente</th>
						</tr>
						<tr>
							<th class="text-center"><input type="radio" checked="checked" name="tipoinf" value=1 required /></th>
							<th class="text-center"> <input type="radio" name="tipoinf" value=2 required /></th>
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
			$fechaF = isset($_POST['fechaF']) ? $_POST['fechaF'] : null;
			if ($fechaI && $fechaF){
				$fechaI = date("Y-m-d", strtotime($_POST['fechaI']));
				$fechaF = date("Y-m-d", strtotime($_POST['fechaF']));
				
				if ($tipoinf == 1){
					$tinf = 'Envase';
				}else{
					$tinf = 'Cliente';
				}
				
				$res = $DB->prVencimientov1($fechaI,$fechaF,$tipoinf);
				
				$fechaI = date_format(date_create($fechaI),"d-m-Y");
				$fechaF = date_format(date_create($fechaF),"d-m-Y");
				
				$row_cnt = mysqli_num_rows($res);
				$message= "Se obtuvieron ".$row_cnt. " registros. "."(Desde: ".$fechaI." Hasta: ".$fechaF.")";
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
				?>
			
			<div class="row">
				<div class="col-md-10">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th>Fecha Remito</th>
							<th>Remito</th>
							<th>Fecha Lote</th>
							<th>Lote</th>
							<th>Cliente</th>
							<th>Serie</th>
							<th>Movimiento</th>
							<th>Propiedad</th>
							<th>Envase</th>
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
								
				?>
					<tbody>
						<tr>
							<td><?php if(isset($row->fechaR)){echo date_format(date_create($row->fechaR),"d-m-Y");}else{echo "Error";}?></td>
							<td><?php if(isset($row->remito)){echo $row->remito;}else{echo "Error";}?></td>
							<td><?php if(isset($row->fechaL)){echo date_format(date_create($row->fechaL),"d-m-Y");}else{echo "Error";}?></td>
							<td><?php if(isset($row->lote)){echo $row->lote;}else{echo "Error";}?></td>
							<td><?php if(isset($row->id_xl) && isset($row->nombre)){echo '('.$row->id_xl.') '.$row->nombre;}else{echo "Error";}?></td>
							<td><?php if(isset($row->serie)){echo $row->serie;}else{echo "Error";}?></td>
							<td><?php if(isset($row->estado)){echo $row->estado;}else{echo "Error";}?></td>
							<td><?php if(isset($row->propiedad)){echo $row->propiedad;}else{echo "Error";}?></td>
							<td><?php if(isset($row->tipoenvase)){echo $row->tipoenvase;}else{echo "Error";}?></td>	
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

