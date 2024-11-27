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
	case 'alquiler-v1.php':
		$seccion = "Alquileres";
		$create = $activo;
	break;
	case 'cHits-v4.php':
		$seccion = "Serie (Repeticiones)";
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
	case 'envases-SEI.php':
		$seccion = "CLxSE (SEI)";
		$create = $activo;
	break;
	case 'envases-x-Serie.php':
		$seccion = "Serie (SEI - xls)";
		$create = $activo;
	break;
	case 'errorDeSecuencia-v3.php':
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
	case 'historialEnvaseConFecha-v3.php':
		$seccion = "Historial Envase";
		$create = $activo;
	break;
	case 'historialEnvaseLote-v1.php':
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
	case 'partida-v2.php':
		$seccion = "Partida";
		$create = $activo;
	break;
	case 'primeroDevuelto-v2.php':
		$seccion = "Primero D";
		$create = $activo;
	break;
	case 'remitoAlta-v7.php':
		$seccion = "Alta Remito";
		$create = $activo;
	break;
	case 'remitoAlta-v7.1.php':
		$seccion = "Alta Remito";
		$create = $activo;
	break;
	case 'remitoAltaSI-v7.php':
		$seccion = "Alta Remito SI";
		$create = $activo;
	break;
	case 'remitosCantidad-v2.php':
		$seccion = "Remitos Cant-ED";
		$create = $activo;
	break;
	case 'remitosCantidad-v3.php':
		$seccion = "Remitos Cant-ED v2";
		$create = $activo;
	break;
	case 'remitosDetalle-v3.php':
		$seccion = "Remitos";
		$create = $activo;
	break;
	case 'remitoBM-v1.php':
		$seccion = "Remitos BM";
		$create = $activo;
	break;
	case 'remitosBM-v2.php':
		$seccion = "Remitos BM(v2)";
		$create = $activo;
	break;
	case 'remitosVolumen-v4.php':
		$seccion = "Remitos Cant-ED-Vol";
		$create = $activo;
	break;
	case 'remitosGranelVolumen-v2.php':
		$seccion = "Remitos Granel-Vol";
		$create = $activo;
	break;
	case 'serieCABM-v1.php':
		$seccion = "ABM Serie";
		$create = $activo;
	break;
	case 'serieLoteABM-v1.php':
		$seccion = "ABM Serie";
		$create = $activo;
	break;
	case 'UltimoEnviadoCC-v3.php':
		$seccion = "Envases Cliente (Cap)";
		$create = $activo;
	break;
	case 'UltimoEnviado-v3.php':
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