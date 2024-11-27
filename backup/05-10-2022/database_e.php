<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	class Database{
		private $con;
		private $dbhost="localhost";
		private $dbuser="root";
		private $dbpass="";
		private $dbname="test";
		function __construct(){
			$this->connect_db();
		}
		public function connect_db(){
			$this->con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
			if(mysqli_connect_error()){
				die("Error al conectar a la base de datos... " . mysqli_connect_error() . mysqli_connect_errno());
			}
			//Encoding
			mysqli_set_charset($this->con,'utf8');
		}
		
		public function sanitize($var){
			$return = mysqli_real_escape_string($this->con, $var);
			return $return;
		}
		//Ok
		public function verificar($id1,$id2){
			$sql = "SELECT idusuario,nombre,imagen,login FROM usuario WHERE login = '".$id1."' AND clave = '".$id2."' AND condicion = 1";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok
		public function listarmarcados($id1){
			$sql = "SELECT * FROM usuario_permiso WHERE idusuario= '".$id1."' AND condicion = 1";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		
		public function single_record($tbl){
			$sql = "SELECT * FROM ".$tbl."";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		public function selectM($tbl,$column){
			$sql = "SELECT * from ".$tbl." where ".$tbl.".".$column." = 0";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		
		public function single_recordA($tbl){
			$sql = "SELECT id, codigo FROM ".$tbl."";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok -	 
		public function prKardexv2($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te){
			$sql = "CALL prKardexv2('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok	
		public function prKardexv3($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te){
			$sql = "CALL prKardexv3('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok -	
		public function prUltimoEnviadov2($fecha,$id_xl,$qr,$v_pr,$v_te,$es){
			$sql = "CALL prUltimoEnviadov2('".$fecha."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$es."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok	
		public function prinUltimoEnviadov3($fecha,$id_xl,$qr,$v_pr,$v_te,$es,$tproc){
			$sql = "CALL prinUltimoEnviadov3('".$fecha."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$es."','".$tproc."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok	
		public function prinUltimoEnviadov31($fecha,$id_xl,$qr,$v_pr,$v_te,$es,$tproc){
			$sql = "CALL prinUltimoEnviadov31('".$fecha."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$es."','".$tproc."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prRemitosCantidadv2($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te){
			$sql = "CALL prRemitosCantidadv2('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prRemitosCantidadv3($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te,$v_tr){
			$sql = "CALL prRemitosCantidadv3('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$v_tr."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prRemitosVolumenv2($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te){
			$sql = "CALL prRemitosVolumenv2('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prRemitosVolumenv4($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te){
			$sql = "CALL prRemitosVolumenv4('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prRemitosGranelv2($fechaI,$fechaF,$id_xl,$qr,$v_tipo){
			$sql = "CALL prRemitosGranelv2('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_tipo."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prRemitoEnvasesv1($remito,$id_xl,$qr){
			$sql = "CALL prRemitoEnvasesv1('".$remito."','".$id_xl."','".$qr."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		
		//Ok	
		public function prUltimoEnviadoCCv3($fecha,$id_xl,$qr,$v_pr,$v_te,$es){
			$sql = "CALL prUltimoEnviadoCCv3('".$fecha."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$es."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok 		
		public function prRepeticionesSeriev3($id1,$id2,$id3,$id4,$id5){
			$sql = "CALL prRepeticionesSeriev3('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function ultimaFDSEI($id1,$id2,$id3,$id4){
			$sql = "CALL clienteUFNS2v3('".$id1."','".$id2."','".$id3."','".$id4."')";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok
		public function consultaSNXLS($id){
				$sql = "SELECT fecha, remito, cliente.nombre AS cliente, estado, propiedad, tipoenvase 
			from movimientos mov INNER JOIN cliente ON mov.id_xl = cliente.id_xl
			WHERE serie = '".$id."' order by fecha DESC";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok
		public function consultaSNSEI($id){
			$sql = "CALL detalleSNSEI('".$id."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prHistorialEnvaseConFechav2($id1,$id2,$id3,$id4,$id5,$id6){
			$sql = "CALL prHistorialEnvaseConFechav2('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prHistorialEnvaseSinFechav2($id1,$id2,$id3,$id4){
			$sql = "CALL prHistorialEnvaseSinFechav2('".$id1."','".$id2."','".$id3."','".$id4."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prinHistorialEnvaseSinFechav3($id1,$id2,$id3,$id4,$id5){
			$sql = "CALL prinHistorialEnvaseSinFechav3('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prPrimeraDevolucionv3($id1,$id2,$id3,$id4){
			$sql = "CALL prPrimeraDevolucionv3('".$id1."','".$id2."','".$id3."','".$id4."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok -
		public function prErrorDeSecuenciav2($id1,$id2,$id3,$id4,$id5){
			$sql = "CALL prErrorDeSecuenciav2('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prErrorDeSecuenciav3($id1,$id2,$id3,$id4,$id5){
			$sql = "CALL prErrorDeSecuenciav3('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prErrorDeSecuenciav2_1($id1,$id2,$id3,$id4,$id5){
			$sql = "CALL prErrorDeSecuenciav2_1('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok		
		public function prhistorialEnvaseLotev1($id1,$id2,$id3,$id4){
			$sql = "CALL prhistorialEnvaseLotev1('".$id1."','".$id2."','".$id3."','".$id4."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prEnvasesLotev1($id1){
			$sql = "CALL prEnvasesLotev1('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prLotesFechav1($id1,$id2){
			$sql = "CALL prLotesFechav1('".$id1."','".$id2."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok		
		public function prAlquilerEnvasev3($id1,$id2,$id3,$id4,$id5){
			$sql = "CALL prAlquilerEnvasev3('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function consultaRemitoXLSArray($id1){
			$sql = "SELECT MV.fecha AS fecha, CL.nombre AS nombre FROM movimientos MV
			JOIN cliente CL ON CL.id_xl = MV.id_xl 
			WHERE remito = '".$id1."' LIMIT 1";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function consultaRemitoXLSArrayv2($id1){
			$sql = "SELECT COUNT(DISTINCT(fecha)) AS cantFecha, m.fecha AS fecha, COUNT(DISTINCT(m.id_xl)) AS cantId_xl, c.nombre AS nombre, m.id_xl, 
			COUNT(DISTINCT(propiedad)) AS cantPropiedad, m.propiedad AS propiedad, COUNT(DISTINCT(tipoenvase)) AS cantTipoenvase, 
			m.tipoenvase AS tipoenvase FROM movimientos m
			JOIN cliente c ON m.id_xl = c.id_xl  
			WHERE remito = '".$id1."'";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function consultaSerieRemitoSinClienteXLS($id1,$id2){
			$sql = "SELECT DATE_FORMAT(fecha,'%d-%m-%Y') as fecha, remito, lote, CL.nombre AS nombre, estado, propiedad, tipoenvase FROM movimientos MV 
			JOIN cliente CL ON MV.id_xl = CL.id_xl
			WHERE remito = '".$id1."' AND serie = '".$id2."'"	;
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function insertaSerieRemitoSinClienteXLS($id1,$id2,$id3,$id4,$id5){
			$sql = "CALL insertarXLS('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function insertaSerieRemitoConClienteXLS($id1,$id2,$id3,$id4,$id5,$id6,$id7){
			$sql = "CALL insertarRemitoXLS('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function actualizaSerieRemitoSinClienteXLS($id1,$id2,$id3){
			$sql = "CALL actualizarXLS('".$id1."','".$id2."','".$id3."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function eliminaSerieRemitoSinClienteXLS($id1,$id2){
			$sql = "CALL eliminarXLS('".$id1."','".$id2."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prABMv1($id1,$id2,$id3,$id4,$id5,$id6,$id7){
			$sql = "CALL prABMv1('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prABMSeriev1($id1,$id2,$id3,$id4,$id5,$id6){
			$sql = "CALL prABMSeriev1('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prBMRemitoLGv1($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11){
			$sql = "CALL prBMRemitoLGv1('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."'
										,'".$id9."','".$id10."','".$id11."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok - v3
		public function prBMRemitoLGv13($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11){
			$sql = "CALL prBMRemitoLGv13('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."'
										,'".$id9."','".$id10."','".$id11."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prBMRemitoGRv1($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11,$id12,$id13,$id14,$id15,$id16){
			$sql = "CALL prBMRemitoGRv1('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."'
										,'".$id9."','".$id10."','".$id11."','".$id12."','".$id13."','".$id14."','".$id15."'
										,'".$id16."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok - v3
		public function prBMRemitoGRv13($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11,$id12,$id13,$id14,$id15,$id16){
			$sql = "CALL prBMRemitoGRv13('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."'
										,'".$id9."','".$id10."','".$id11."','".$id12."','".$id13."','".$id14."','".$id15."'
										,'".$id16."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok - v3
		public function prActualizarEstadoGRv13($id1,$id2){
			$sql = "CALL prActualizarEstadoGRv13('".$id1."','".$id2."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok - v3
		public function prActualizarEstadov13($id1,$id2){
			$sql = "CALL prActualizarEstadov13('".$id1."','".$id2."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prVencimientov1($id1,$id2,$id3){
			$sql = "CALL prVencimientov1('".$id1."','".$id2."','".$id3."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok -> reemplazado por el siguiente
		public function prRemitoDetallev1($id1,$id2){
			$sql = "CALL prRemitoDetallev1('".$id1."','".$id2."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prRemitoDetallev2($id1){
			$sql = "CALL prRemitoDetallev2('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prRemitoDetallev3($id1){
			$sql = "CALL prRemitoDetallev3('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok - Para Detonar
		public function prRemitoDetallev33($id1){
			$sql = "CALL prRemitoDetallev33('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function clientesTodos($id1){
			switch($id1)
			{
				case "SEI":
					$id = 'id_sei';
					break;
				case "XLS":
					$id = 'id_xl';
					break;
			}
			
			$sql = "SELECT * FROM cliente WHERE ".$id." <> '' order by id_xl asc";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok
		public function clientesTodosSG($id1){
			switch($id1)
			{
				case "SEI":
					$id = 'id_sei';
					break;
				case "XLS":
					$id = 'id_xl';
					break;
			}
			
			$sql = "SELECT * FROM cliente WHERE ".$id." < '900' order by id_xl asc";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok
		public function clientesSP($id1,$id2){
			$sql = "SELECT DISTINCT(cl.id_xl), cl.id, cl.nombre, cl.id_sei,  cl.id_yl FROM cliente cl
					INNER JOIN movimientos mo ON cl.id_xl = mo.id_xl
					WHERE mo.serie = ".$id1." AND mo.propiedad = 'SP' AND tipoenvase = '".$id2."' AND cl.id_xl < '900' 
					ORDER BY cl.id_xl ASC";
			
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok
		public function prInsertarCSVv5($id1,$id2,$id3,$id4,$id5,$id6,$id7){
			$sql = "CALL prInsertarCSVv5('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prInsertarCSVv6($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10){
			$sql = "CALL prInsertarCSVv6('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."','".$id10."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok - v3
		public function prInsertarCSVv63($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10){
			$sql = "CALL prInsertarCSVv63('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."','".$id10."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prInsertarCSVSIv6($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9){
			$sql = "CALL prInsertarCSVSIv6('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prInsertarGRv1($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11,$id12,$id13,$id14){
			$sql = "CALL prInsertarGRv1('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."','".$id10."','".$id11."','".$id12."','".$id13."','".$id14."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prInsertarGRv13($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11,$id12,$id13,$id14){
			$sql = "CALL prInsertarGRv13('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."','".$id10."','".$id11."','".$id12."','".$id13."','".$id14."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prSerieExistev1($id1,$id2,$id3,$id4){
			$sql = "CALL prSerieExistev1('".$id1."','".$id2."','".$id3."','".$id4."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prSerieExistev2($id1,$id2,$id3,$id4){
			$sql = "CALL prSerieExistev2('".$id1."','".$id2."','".$id3."','".$id4."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prConsultaPCTv1($id1){
			$sql = "CALL prConsultaPCTv1('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prConsultaPCTv2($id1,$id2,$id3){
			$sql = "CALL prConsultaPCTv2('".$id1."','".$id2."','".$id3."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		public function prActualizaPCTv1($id1){
			$sql = "CALL prActualizaPCTv1('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function getCap($id1){
			$sql = "SELECT DISTINCT capacidad FROM tipoenvcap WHERE tipoenvase = '".$id1."' ORDER BY capacidad";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok
		public function getTanque(){
			$sql = "SELECT id, nombre FROM tanque WHERE tipo = 'M' AND id > 0 ORDER BY nombre";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function getidTanque($id1){
			$sql = "SELECT id FROM tanque WHERE nombre = '".$id1."' AND tipo = 'M' AND id > 0";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prGetNumeroRemitov1(){
			$sql = "CALL prGetNumeroRemitov1";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function getMotivo(){
			$sql = "SELECT * FROM motivoremito WHERE condicion = 1";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function clientesSG($id1){
			switch($id1)
			{
				case "SEI":
					$id = 'id_sei';
					break;
				case "XLS":
					$id = 'id_xl';
					break;
			}
			$sql = "SELECT * FROM cliente WHERE ".$id." <> '' AND id_xl < '900' order by id_xl asc";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok
		public function closePR(){
			$res = mysqli_close($this->con);
			return $res;
		}
		
		
}
?>