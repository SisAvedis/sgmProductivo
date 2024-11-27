<?php
//session_start();

define('root_path', '/');

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

$curPage = curPageName();

$titulo = "AVEDIS | ";

$activo = "activo";

switch ($curPage){
	
	case 'abms.php':
		$seccion = "ABM";
		$create = $activo;
	break;
	case 'abmSerie-v1.php':
		$seccion = "ABM v2";
		$create = $activo;
	break;
	case 'alquiler-v2.php':
		$seccion = "Alquiler Envases";
		$create = $activo;
	break;
	case 'alquiler-v3.php':
		$seccion = "Alquiler Envases";
		$create = $activo;
	break;
	case 'alquiler-v4.php':
		$seccion = "Alquiler Envases";
		$create = $activo;
	break;
	case 'auditoria-v1.php':
		$seccion = "Alta Auditoría";
		$create = $activo;
	break;
	case 'auditoria-v1-1.php':
		$seccion = "Alta Auditoría";
		$create = $activo;
	break;
	case 'auditoria-v1-2.php':
		$seccion = "Alta Auditoría";
		$create = $activo;
	break;
	case 'auditoria-v1-2-2.php':
		$seccion = "Alta Auditoría";
		$create = $activo;
	break;
	case 'auditoria-v2.php':
		$seccion = "Alta Auditoría";
		$create = $activo;
	break;
	case 'auditoriaM-v1-2.php':
		$seccion = "M Auditoría";
		$create = $activo;
	break;
	case 'auditoriaM-v1-2-2.php':
		$seccion = "M Auditoría";
		$create = $activo;
	break;
	case 'certificado-v1.php':
		$seccion = "Certificado";
		$create = $activo;
	break;
	case 'certificado-v2.php':
		$seccion = "Certificado";
		$create = $activo;
	break;
	case 'auditoriaConsulta-v1.php':
		$seccion = "Consulta de Auditorías";
		$create = $activo;
	break;
	case 'auditoriaConsulta-v2.php':
		$seccion = "Consulta de Auditorías";
		$create = $activo;
	break;
	case 'cHits-v4.php':
		$seccion = "Serie (Repeticiones)";
		$create = $activo;
	break;
	case 'cHits-v5.php':
		$seccion = "Serie (Repeticiones)";
		$create = $activo;
	break;
	case 'cliente-v1.php':
		$seccion = "Clientes";
		$create = $activo;
	break;
	case 'consultas.php':
		$seccion = "Consultas";
		$create = $activo;
	break;
	case 'envasesLote-v2.php':
		$seccion = "Lotes";
		$create = $activo;
	break;
	case 'envasesLote-v3.php':
		$seccion = "Lotes";
		$create = $activo;
	break;
	case 'envases-SEI.php':
		$seccion = "CLxSE (SEI)";
		$create = $activo;
	break;
	case 'envases-x-Serie.php':
		$seccion = "Serie (SEI - xls)";
		$create = $activo;
	break;
	case 'errorDeSecuencia-v4.php':
		$seccion = "Error Secuencia";
		$create = $activo;
	break;
	case 'errorDeSecuencia-v4-1.php':
		$seccion = "Error Secuencia";
		$create = $activo;
	break;
	case 'errorDeSecuencia-v2_1.php':
		$seccion = "Error Secuencia v2_1";
		$create = $activo;
	break;
	case 'escritorio.php':
		$seccion = "Escritorio";
		$create = $activo;
	break;
	case 'historialEnvaseConFecha-v4.php':
		$seccion = "Historial Envase";
		$create = $activo;
	break;
	case 'historialEnvaseLote-v1.php':
		$seccion = "Historial Llenado";
		$create = $activo;
	break;
	case 'historialEnvaseLote-v2.php':
		$seccion = "Historial Llenado";
		$create = $activo;
	break;
	case 'inicio.php':
		$seccion = "Inicio";
		$create = $activo;
	break;
	case 'kardex-v3.php':
		$seccion = "Kardex";
		$create = $activo;
	break;
	case 'kardex-v4.php':
		$seccion = "Kardex";
		$create = $activo;
	break;
	case 'partida-v3.php':
		$seccion = "Partida";
		$create = $activo;
	break;
	case 'partida-v4.php':
		$seccion = "Partida";
		$create = $activo;
	break;
	case 'primeroDevuelto-v2.php':
		$seccion = "Primero D";
		$create = $activo;
	break;
	case 'primeroDevuelto-v3.php':
		$seccion = "Primero D";
		$create = $activo;
	break;
	case 'remitoAlta-v7.php':
		$seccion = "Alta Remito";
		$create = $activo;
	break;
	case 'remitoAlta-v8.php':
		$seccion = "Alta Remito";
		$create = $activo;
	break;
	case 'remitoAlta-v9.php':
		$seccion = "Alta Remito";
		$create = $activo;
	break;
	case 'remitoAltaSI-v8.php':
		$seccion = "Alta Remito SI";
		$create = $activo;
	break;
	case 'remitoAltaSI-v9.php':
		$seccion = "Alta Remito SI";
		$create = $activo;
	break;
	case 'remitosCantidad-v2.php':
		$seccion = "Remitos Cant-ED";
		$create = $activo;
	break;
	case 'remitosCantidad-v5.php':
		$seccion = "Remitos Cant-ED v2";
		$create = $activo;
	break;
	case 'remitosCantidad-v5-1.php':
		$seccion = "Remitos Cant-ED v2";
		$create = $activo;
	break;
	case 'remitosDetalle-v4.php':
		$seccion = "Remitos";
		$create = $activo;
	break;
	case 'remitosDetalle-v5.php':
		$seccion = "Remitos";
		$create = $activo;
	break;
	case 'remitosDetalleC-v4.php':
		$seccion = "Validar Remito";
		$create = $activo;
	break;
	case 'remitosDetalleC-v5.php':
		$seccion = "Validar Remito";
		$create = $activo;
	break;
	case 'remitoBM-v2.php':
		$seccion = "BM Remito";
		$create = $activo;
	break;
	case 'remitoBM-v3.php':
		$seccion = "BM Remito";
		$create = $activo;
	break;
	case 'remitosVolumen-v5.php':
		$seccion = "Remitos Cant-ED-Vol";
		$create = $activo;
	break;
	case 'remitosGranelVolumen-v3.php':
		$seccion = "Remitos Granel-Vol";
		$create = $activo;
	break;
	case 'serieCABM-v2.php':
		$seccion = "ABM Serie";
		$create = $activo;
	break;
	case 'serieCABM-v3.php':
		$seccion = "ABM Serie";
		$create = $activo;
	break;
	case 'serieLoteABM-v1.php':
		$seccion = "ABM Serie";
		$create = $activo;
	break;
	case 'UltimoEnviadoCC-v4.php':
		$seccion = "Envases Cliente (Cap)";
		$create = $activo;
	break;
	case 'UltimoEnviadoCC-v4-1.php':
		$seccion = "Envases Cliente (Cap)";
		$create = $activo;
	break;
	case 'UltimoEnviado-v4.php':
		$seccion = "Envases Cliente";
		$create = $activo;
	break;
	case 'UltimoEnviado-v4-1.php':
		$seccion = "Envases Cliente";
		$create = $activo;
	break;
	case 'UltimoEnviado-v5.php':
		$seccion = "Envases Cliente";
		$create = $activo;
	break;
	case 'UltimoEnviado-v31.php':
		$seccion = "Envases Cliente SI";
		$create = $activo;
	break;
	case 'vencimientos-v1.php':
		$seccion = "Vencimientos";
		$create = $activo;
	break;
	
	
}

?>