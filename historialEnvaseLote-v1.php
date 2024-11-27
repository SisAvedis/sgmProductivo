<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="historialEnvaseLote-v1.php">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php"); ?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Historial Llenado Envase</h4></div>
                </div>
            </div>
            
			<div class="row">
				<div class="col-md-1">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th class="text-center" colspan=2>Envase</th><th class="text-center" colspan=2>Propiedad</th>
							<th class="text-center" colspan=2>Informe</th>
						</tr>
						<tr>
							<th>CIL</th><th>TER</th><th>NP</th><th>SP</th><th>A</th><th>H</th>
						</tr>
						<tr>
							<th class="text-center" ><input type="radio" checked="checked" name="tipoenv" value=1 required /></th> 
							<th class="text-center"><input type="radio" name="tipoenv" value=2 required /></th>
							<th class="text-center"><input type="radio" checked="checked" name="propiedad" value="NP" required /></th> 
							<th class="text-center"><input type="radio" name="propiedad" value="SP" required /></th>
							<th class="text-center"><input type="radio" checked="checked" name="tipoinf" value="A" required /></th> 
							<th class="text-center"><input type="radio" name="tipoinf" value="H" required /></th>
						</tr>
				
					</thead>
				</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-2">
					<label>Número de Serie: </label>
					<input type="text" name="nserie" id="nserie" class="form-control input-sm" maxlength="100" autocomplete="off" required value="<?php $nserie ?>" />
				</div>
				<div class="col-md-12 pull-right">
					<hr>
					<button type="submit" class="btn btn-sm btn-danger">Consultar</button>
					<hr>
				</div>
			</div>
			
			
			<?php
			$tipoenv = isset($_POST['tipoenv']) ? $_POST['tipoenv'] : null;
			$tipoinf = isset($_POST['tipoinf']) ? $_POST['tipoinf'] : null;
			$nserie = isset($_POST['nserie']) ? $_POST['nserie'] : false;
			$propiedad = isset($_POST['propiedad']) ? $_POST['propiedad'] : null;
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if(validaSerie($nserie)){
					$DB= new Database();
					$nserie = $DB->sanitize($_POST['nserie']);
					if ($tipoenv == 1){ 
							$tenv = 'GOX';
						}elseif ($tipoenv == 2){
							$tenv = 'LOX';
					}
					
					//echo "<pre>";
					//echo $nserie."</br>".$propiedad."</br>".$tenv."</br>".$tipoinf;
					//echo "</pre>";
					
					
					
					$res = $DB->prhistorialEnvaseLotev1($nserie, $propiedad, $tenv, $tipoinf);
					//echo "<pre>";
					//echo $res."</br>";
					//echo "<pre>";
					$row_cnt = mysqli_num_rows($res);
					$message= "Se obtuvieron ".$row_cnt." movimientos para el Número de Serie ".$nserie."</br>";
					$message= $message."Propiedad: ".$propiedad.". Producto: ".$tenv;
					if ($row_cnt == 0){
						$class="alert alert-info";
					}else{
						$class="alert alert-success";
					}
				?>
			
			
			<div class="<?php echo $class?>" id="rows">
				  <?php echo $message;?>
			</div>
			<?php
			if ($row_cnt == 0){
			}else{
				?>	
			<div class="row">
				<div class="col-md-9">
				<table class="table table-bordered" id="tabla1">
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Lote</th>
							<th>Producto</th>
							<th>Partida</th>
							<th>Cliente</th>
							<th>Fecha Rto Clie</th>
							<th>Volumen</th>
							<th>Rto Avedis</th>
							<th>Rto Cliente</th>
							<th>Fecha Rto Avedis</th>
						</tr>
					</thead>
		<?php 
				while ($row=mysqli_fetch_object($res)){
				?>
					<tbody>
						<tr>
							<td><?php if(isset($row->LoteFechaInicio)){echo date_format(date_create($row->LoteFechaInicio),"d-m-Y");}else{echo "Error";}?></td>
							<td><?php if(isset($row->LoteId)){echo $row->LoteId;}else{echo "Error";}?></td>
							<td><?php if(isset($row->LoteGas)){echo $row->LoteGas;}else{echo "Error";}?></td>
							<td><?php if(isset($row->LotePartida)){echo $row->LotePartida;}else{echo "Error";}?></td>
							<td><?php if(isset($row->ExLCliente)){echo $row->ExLCliente;}else{echo "Error";}?></td>
							<td><?php if(isset($row->ExLFecha)){echo $row->ExLFecha;}else{echo "Error";}?></td>
							<td><?php if(isset($row->ExLCapacidad)){echo $row->ExLCapacidad;}else{echo "Error";}?></td>
							<td><?php if(isset($row->ExLRemito)){echo $row->ExLRemito;}else{echo "Error";}?></td>
							<td><?php if(isset($row->ExLRemitoSH)){echo $row->ExLRemitoSH;}else{echo "Error";}?></td>
							<td><?php if(isset($row->ExLFechaSH)){if($row->ExLFechaSH !== ''){echo date_format(date_create($row->ExLFechaSH),"d-m-Y");}}else{echo "Error";}?></td>
						</tr>				
					</tbody>	
					<?php
						}
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
			


	</form>
	</body>
</html>