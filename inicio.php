<?php require 'header.php'; ?>

<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
				<?php
					if($_SESSION['ABM Serie'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<!--<a href="serieLoteABM-v1.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>ABM Serie</a>-->
						<a href="serieCABM-v1.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>ABM Serie</a>
					</div>';
					}
					if($_SESSION['ABM Serie GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="serieCABM-v2.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>ABM Serie</a>
					</div>';
					}
					if($_SESSION['ABM Serie'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="serieCABM-v3.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>ABM Serie</a>
					</div>';
					}
					if($_SESSION['Alta Remito'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="remitoAlta-v7.3.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Alta Remito</a>
					</div>';
					}
					if($_SESSION['Alta Remito'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="remitoAltaDU-v8.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Alta Remito DU</a>
					</div>';
					}
					if($_SESSION['Alta Remito GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="remitoAlta-v8.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>Alta Remito</a>
					</div>';
					}
					if($_SESSION['Alta Remito'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="remitoAlta-v9.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Alta Remito </a>
					</div>';
					}
					if($_SESSION['Alta Remito SI'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="remitoAltaSI-v7.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Alta Remito SI</a>
					</div>';
					}
					if($_SESSION['Alta Remito SI GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="remitoAltaSI-v8.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>Alta Remito SI</a>
					</div>';
					}
					if($_SESSION['Alta Remito SI'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="remitoAltaSI-v9.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Alta Remito SI</a>
					</div>';
					}
					if($_SESSION['BM Remito'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitoBM-v1.3.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>BM Remito</a>
                    </div>';
					}
					if($_SESSION['BM Remito GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitoBM-v2.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>BM Remito</a>
                    </div>';
					}
					if($_SESSION['BM Remito'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitoBM-v3.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>BM Remito</a>
                    </div>';
					}
					if($_SESSION['Partida'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="partida-v2.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Partida</a>
                    </div>';
					}
					if($_SESSION['Partida GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="partida-v3.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>Partida</a>
                    </div>';
					}
					if($_SESSION['Partida'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="partida-v4.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Partida</a>
                    </div>';
					}
					if($_SESSION['Auditoria'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="auditoria-v1.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>Alta Auditoría</a>
                    </div>';
					}
					if($_SESSION['Auditoria'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="auditoria-v1-1.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>Alta Auditoría</a>
                    </div>';
					}
					if($_SESSION['Auditoria'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="auditoria-v1-2.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>Alta Auditoría</a>
                    </div>';
					}
					if($_SESSION['Auditoria GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="auditoria-v1-2-2.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>Alta Auditoría</a>
                    </div>';
					}
					if($_SESSION['Auditoria'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="auditoria-v2-1.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Alta Auditoría</a>
                    </div>';
					}
					if($_SESSION['Remito Estado'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="remitosDetalleC-v3.3.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Validar Remito</a>
					</div>';
					}
					if($_SESSION['Remito Estado GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="remitosDetalleC-v4.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>Validar Remito</a>
					</div>';
					}
					if($_SESSION['Remito Estado'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="remitosDetalleC-v5.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Validar Remito</a>
					</div>';
					}
					if($_SESSION['M Auditoria GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="auditoriaM-v1-2.php" class="btn btn-sm btn-warning add-new"><i class="fa fa-plus"></i>M Auditoría</a>
                    </div>';
					}
					if($_SESSION['M Auditoria'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="auditoriaM-v1-2-2.php" class="btn btn-sm btn-info add-new"><i class="fa fa-plus"></i>M Auditoría</a>
                    </div>';
					}
					if($_SESSION['AlquilerEnvases'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="alquiler-v1.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Alquiler Envases</a>
					</div>';
					}
					if($_SESSION['AlquilerEnvases'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="alquiler-v2.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Alquiler Envases</a>
                    </div>';
					}
					if($_SESSION['AlquilerEnvases GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="alquiler-v3.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Alquiler Envases</a>
					</div>';
					}
					if($_SESSION['AlquilerEnvases'] == 1)
					{
					echo 
					'<div class="col-sm-2">
						<a href="alquiler-v4.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Alquiler Envases</a>
					</div>';
					}
					if($_SESSION['Auditoria GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="auditoriaConsulta-v1.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Auditorías</a>
                    </div>';
					}
					if($_SESSION['Auditoria'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="auditoriaConsulta-v2.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Auditorías</a>
                    </div>';
					}
					if($_SESSION['Certificados GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="certificado-v1.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Certificados</a>
                    </div>';
					}
					if($_SESSION['AlquilerEnvases'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="certificado-v2.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Certificados</a>
                    </div>';
					}
					if($_SESSION['Auditoria'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="cliente-v1.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Clientes</a>
                    </div>';
					}
					if($_SESSION['CLxSE (SEI)'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="envases-SEI.php" class="btn btn-sm btn-info add-new"><i class="fa fa-plus"></i>CLxSE (SEI)</a>
                    </div>';
					}
					if($_SESSION['Envases Cliente'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="UltimoEnviado-v3.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Envases Cliente</a>
                    </div>';
					}
					if($_SESSION['Envases Cliente GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="UltimoEnviado-v4.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Envases Cliente</a>
                    </div>';
					}
					if($_SESSION['Envases Cliente GE MS'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="UltimoEnviado-v4-1.php" class="btn btn-sm btn-info add-new"><i class="fa fa-plus"></i>Envases Cliente</a>
                    </div>';
					}
					if($_SESSION['Envases Cliente'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="UltimoEnviado-v5.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Envases Cliente</a>
                    </div>';
					}
					if($_SESSION['Envases Cliente (Cap)'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="UltimoEnviadoCC-v3.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Envases Cliente (Cap)</a>
                    </div>';
					}
					if($_SESSION['Envases Cliente (Cap) GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="UltimoEnviadoCC-v4.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Envases Cliente (Cap)</a>
                    </div>';
					}
					if($_SESSION['Envases Cliente (Cap) GE MS'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="UltimoEnviadoCC-v4-1.php" class="btn btn-sm btn-info add-new"><i class="fa fa-plus"></i>Envases Cliente (Cap)</a>
                    </div>';
					}
					if($_SESSION['Envases Cliente (Cap)'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="UltimoEnviadoCC-v5.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Envases Cliente (Cap)</a>
                    </div>';
					}
					if($_SESSION['Error Secuencia'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="errorDeSecuencia-v3.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Error Secuencia</a>
                    </div>';
					}
					if($_SESSION['Error Secuencia GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="errorDeSecuencia-v4.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Error Secuencia</a>
                    </div>';
					}
					if($_SESSION['Error Secuencia GE MS'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="errorDeSecuencia-v4-1.php" class="btn btn-sm btn-info add-new"><i class="fa fa-plus"></i>Error Secuencia</a>
                    </div>';
					}
					if($_SESSION['Historial Envase'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="historialEnvaseConFecha-v3.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Historial Envase</a>
                    </div>';
					}
					if($_SESSION['Historial Envase GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="historialEnvaseConFecha-v4.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Historial Envase</a>
                    </div>';
					}
					if($_SESSION['Historial Envase Old'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="envases-x-Serie.php" class="btn btn-sm btn-primary add-new"><i class="fa fa-plus"></i>Serie (SEI - xls)</a>
                    </div>';
					}
					if($_SESSION['Historial Llenado'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="historialEnvaseLote-v2.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Historial Llenado</a>
                    </div>';
					}
					if($_SESSION['Historial Llenado Alfa'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="historialEnvaseLote-v2.php" class="btn btn-sm btn-info add-new"><i class="fa fa-plus"></i>Historial Llenado</a>
                    </div>';
					}
					if($_SESSION['Kardex'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="kardex-v3.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Kardex</a>
                    </div>';
					}
					if($_SESSION['Kardex GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="kardex-v4.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Kardex</a>
                    </div>';
					}
					if($_SESSION['Lotes'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="envasesLote-v3.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Lotes</a>
                    </div>';
					}
					if($_SESSION['Lotes Alfa'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="envasesLote-v3.php" class="btn btn-sm btn-info add-new"><i class="fa fa-plus"></i>Lotes</a>
                    </div>';
					}
					if($_SESSION['Primero D'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="primeroDevuelto-v2.php" class="btn btn-sm btn-info add-new"><i class="fa fa-plus"></i>Primero D</a>
                    </div>';
					}
					if($_SESSION['Primero D GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="primeroDevuelto-v3.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Primero D</a>
                    </div>';
					}
					if($_SESSION['Remitos'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosDetalle-v3.3.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Remitos</a>
                    </div>';
					}
					if($_SESSION['Remitos GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosDetalle-v4.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Remitos</a>
                    </div>';
					}
					if($_SESSION['Remitos'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosDetalleDU-v4.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Remitos DU</a>
                    </div>';
					}
					if($_SESSION['Remitos'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosDetalle-v5.php" class="btn btn-sm btn-danger add-new"><i class="fa fa-plus"></i>Remitos</a>
                    </div>';
					}
					if($_SESSION['Remitos Cant-ED'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosCantidad-v2.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Remitos Cant-ED</a>
                    </div>';
					}
					if($_SESSION['Remitos Cant-ED v2'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosCantidad-v3.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Remitos Cant-ED v2</a>
                    </div>';
					}
					if($_SESSION['Remitos Cant-ED v2 GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosCantidad-v5.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Remitos Cant-ED v2</a>
                    </div>';
					}
					if($_SESSION['Remitos Cant-ED v2 GE MS'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosCantidad-v5-1.php" class="btn btn-sm btn-info add-new"><i class="fa fa-plus"></i>Remitos Cant-ED v2</a>
                    </div>';
					}
					if($_SESSION['Remitos Cant-ED-Vol'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosVolumen-v4.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Remitos Cant-ED-Vol</a>
                    </div>';
					}
					if($_SESSION['Remitos Cant-ED-Vol GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosVolumen-v5.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Remitos Cant-ED-Vol</a>
                    </div>';
					}
					if($_SESSION['Remitos Granel-Vol'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosGranelVolumen-v2.php" class="btn btn-sm btn-default add-new"><i class="fa fa-plus"></i>Remitos Granel-Vol</a>
                    </div>';
					}
					if($_SESSION['Remitos Granel-Vol GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="remitosGranelVolumen-v3.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Remitos Granel-Vol</a>
                    </div>';
					}
					if($_SESSION['Serie (Repeticiones)'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="cHits-v4.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Serie (Repeticiones)</a>
                    </div>';
					}
					if($_SESSION['Serie (Repeticiones) GE'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="cHits-v5.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Serie (Repeticiones) v2</a>
                    </div>';
					}
					if($_SESSION['Vencimientos'] == 1)
					{
					echo 
					'<div class="col-sm-2">
                        <a href="vencimientos-v1.php" class="btn btn-sm btn-success add-new"><i class="fa fa-plus"></i>Vencimientos</a>
                    </div>';
					}
					echo 
					'<div class="col-sm-2">
						<a href="escritorio.php" class="btn btn-sm btn-primary add-new"><i class="fa fa-plus"></i>Volver</a>
					</div>';
				?>
			</div>
		</div>
	</div>
</div>