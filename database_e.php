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
		//Ok - 	
		public function prKardexv3($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te){
			$sql = "CALL prKardexv3('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok	
		public function prKardexv4($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te,$id_pr){
			$sql = "CALL prKardexv4('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$id_pr."')";
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
		//Ok-v2	
		public function prinUltimoEnviadov4($fecha,$id_xl,$qr,$v_pr,$v_te,$es,$tproc,$v_idproducto){
			$sql = "CALL prinUltimoEnviadov4('".$fecha."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$es."','".$tproc."','".$v_idproducto."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2	
		public function prinUltimoEnviadov41($fecha,$id_xl,$qr,$v_pr,$es,$tproc,$v_idproducto){
			$sql = "CALL prinUltimoEnviadov41('".$fecha."','".$id_xl."','".$qr."','".$v_pr."','".$es."','".$tproc."','".$v_idproducto."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2	
		public function prinUltimoEnviadov41a($fecha,$id_xl,$qr,$v_pr,$es,$tproc,$v_idproducto){
			$sql = "CALL prinUltimoEnviadov41a('".$fecha."','".$id_xl."','".$qr."','".$v_pr."','".$es."','".$tproc."','".$v_idproducto."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2	
		public function prinUltimoEnviadov411($fecha,$id_xl,$qr,$v_pr,$tipo,$es,$v_idproducto){
			$sql = "CALL prinUltimoEnviadov411('".$fecha."','".$id_xl."','".$qr."','".$v_pr."','".$tipo."','".$es."','".$v_idproducto."')";
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
		//Ok-v2
		public function prRemitosCantidadv5($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te,$v_tr,$v_idproducto){
			$sql = "CALL prRemitosCantidadv5('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$v_tr."','".$v_idproducto."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prRemitosCantidadv511($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te,$v_tr,$v_idproducto){
			$sql = "CALL prRemitosCantidadv511('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$v_tr."','".$v_idproducto."')";
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
		//Ok-v2
		public function prRemitosVolumenv5($fechaI,$fechaF,$id_xl,$qr,$v_pr,$v_te,$v_idproducto){
			$sql = "CALL prRemitosVolumenv5('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$v_idproducto."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prRemitosGranelv3($fechaI,$fechaF,$id_xl,$qr,$v_tipo,$v_idproducto){
			$sql = "CALL prRemitosGranelv3('".$fechaI."','".$fechaF."','".$id_xl."','".$qr."','".$v_tipo."','".$v_idproducto."')";
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
		//Ok-v2	
		public function prUltimoEnviadoCCv4($fecha,$id_xl,$qr,$v_pr,$v_te,$es,$v_idproducto){
			$sql = "CALL prUltimoEnviadoCCv4('".$fecha."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$es."','".$v_idproducto."')";
			$res = mysqli_query($this->con, $sql);
			
			//Alejo
			if (!$res) {
				echo "Error en la consulta SQL: " . mysqli_error($this->con);
			}

			while (mysqli_next_result($this->con)) {
				if (!mysqli_more_results($this->con)) {
					break;
				}
			}
			//Alejo Fin
			
			return $res;
		}
		//Ok-v2	
		public function prUltimoEnviadoCCv411($fecha,$id_xl,$qr,$v_pr,$v_te,$es,$v_idproducto){
			$sql = "CALL prUltimoEnviadoCCv411('".$fecha."','".$id_xl."','".$qr."','".$v_pr."','".$v_te."','".$es."','".$v_idproducto."')";
			$res = mysqli_query($this->con, $sql);
			
			//Alejo
			if (!$res) {
				echo "Error en la consulta SQL: " . mysqli_error($this->con);
			}

			while (mysqli_next_result($this->con)) {
				if (!mysqli_more_results($this->con)) {
					break;
				}
			}
			//Alejo Fin
			
			return $res;
		}
		//Ok 		
		public function prRepeticionesSeriev3($id1,$id2,$id3,$id4,$id5){
			$sql = "CALL prRepeticionesSeriev3('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok 		
		public function prRepeticionesSeriev4($id1,$id2,$id3,$id4,$id5,$id6){
			$sql = "CALL prRepeticionesSeriev4('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."')";
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
		//Ok-v2
		public function prHistorialEnvaseConFechav3($id1,$id2,$id3,$id4,$id5,$id6,$id7){
			$sql = "CALL prHistorialEnvaseConFechav3('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."')";
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
		//Ok-v2
		public function prinHistorialEnvaseSinFechav4($id1,$id2,$id3,$id4,$id5,$id6){
			$sql = "CALL prinHistorialEnvaseSinFechav4('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prPrimeraDevolucionv3($id1,$id2,$id3,$id4){
			$sql = "CALL prPrimeraDevolucionv3('".$id1."','".$id2."','".$id3."','".$id4."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prPrimeraDevolucionv4($id1,$id2,$id3,$id4,$id5){
			$sql = "CALL prPrimeraDevolucionv4('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prCertificadov2($id1,$id2){
			$sql = "CALL prCertificadov2('".$id1."','".$id2."')";
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
		//Ok-v2
		public function prErrorDeSecuenciav4($id1,$id2,$id3,$id4,$id5,$id6){
			$sql = "CALL prErrorDeSecuenciav4('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."')";
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
		//Ok-v2		
		public function prAlquilerEnvasev4($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8){
			$sql = "CALL prAlquilerEnvasev4('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2		
		public function prAlquilerEnvasev5($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9){
			$sql = "CALL prAlquilerEnvasev5('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."')";
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
		//Ok-v2
		public function prABMv2($id1,$id2,$id3,$id4,$id5,$id6,$id7){
			$sql = "CALL prABMv2('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v3
		public function prABMv3($id1,$id2,$id3,$id4,$id5,$id6,$id7){
			$sql = "CALL prABMv3('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prABMSeriev1($id1,$id2,$id3,$id4,$id5,$id6){
			$sql = "CALL prABMSeriev1('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prABMSeriev2($id1,$id2,$id3,$id4,$id5,$id6){
			$sql = "CALL prABMSeriev2('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v3
		public function prABMSeriev3($id1,$id2,$id3,$id4,$id5,$id6){
			$sql = "CALL prABMSeriev3('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prBMRemitoLGv13($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11){
			$sql = "CALL prBMRemitoLGv13('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."'
										,'".$id9."','".$id10."','".$id11."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prBMRemitoLGv2($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11){
			$sql = "CALL prBMRemitoLGv2('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."'
										,'".$id9."','".$id10."','".$id11."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prBMRemitoGRv13($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11,$id12,$id13,$id14,$id15,$id16){
			$sql = "CALL prBMRemitoGRv13('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."'
										,'".$id9."','".$id10."','".$id11."','".$id12."','".$id13."','".$id14."','".$id15."'
										,'".$id16."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prBMRemitoGRv2($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11,$id12,$id13,$id14,$id15,$id16){
			$sql = "CALL prBMRemitoGRv2('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."'
										,'".$id9."','".$id10."','".$id11."','".$id12."','".$id13."','".$id14."','".$id15."'
										,'".$id16."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prActualizarEstadoGRv13($id1,$id2){
			$sql = "CALL prActualizarEstadoGRv13('".$id1."','".$id2."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prActualizarEstadov13($id1,$id2,$id3){
			$sql = "CALL prActualizarEstadov13('".$id1."','".$id2."','".$id3."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prActualizarEstadov2($id1,$id2,$id3){
			$sql = "CALL prActualizarEstadov2('".$id1."','".$id2."','".$id3."')";
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
		//Ok-v2
		public function prRemitoDetallev4($id1){
			$sql = "CALL prRemitoDetallev4('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prRemitoDetallev43($id1){
			$sql = "CALL prRemitoDetallev43('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prRemitoDetalleDUv43($id1){
			$sql = "CALL prRemitoDetalleDUv43('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prRemitoDetallev5($id1){
			$sql = "CALL prRemitoDetallev5('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prRemitoDetallev6($id1){
			$sql = "CALL prRemitoDetallev6('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prRemitoProductov1($id1){
			$sql = "CALL prRemitoProductov1('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prProductov1($id1,$id2){
			$sql = "CALL prProductov1('".$id1."','".$id2."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prRemitoSeriev1($id1){
			$sql = "CALL prRemitoSeriev1('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v3
		public function prRemitoSeriev2($id1){
			$sql = "CALL prRemitoSeriev2('".$id1."')";
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
		public function clientesTodosBis($id1){
			switch($id1)
			{
				case "SEI":
					$id = 'id_sei';
					break;
				case "XLS":
					$id = 'id_xl';
					break;
			}
			
			$sql = "SELECT * FROM clientebis WHERE ".$id." <> '' AND condicion = 1 order by id_xl asc";
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
		//Ok-v2 Ojo con la tabla!!! movimientos3
		public function clientesSPv2($id1,$id2,$id3){
			$sql = "SELECT DISTINCT(cl.id_xl), cl.id, cl.nombre, cl.id_sei,  cl.id_yl FROM cliente cl
					INNER JOIN movimientos mo ON cl.id_xl = mo.id_xl
					WHERE mo.serie = '".$id1."' AND mo.propiedad = 'SP' AND tipoenvase = '".$id2."' AND idproducto = ".$id3." AND cl.id_xl < '900' 
					ORDER BY cl.id_xl ASC";
			
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok-v2 Ojo con la tabla!!! movimientos3
		public function productoSeriev1($id1,$id2){
			$sql = "SELECT pr.id, pr.codigo, pr.nombre FROM producto pr
					INNER JOIN movimientos mo ON pr.id = mo.idproducto
					WHERE mo.serie = '".$id1."' AND tipoenvase = '".$id2."' 
					GROUP BY pr.id
					ORDER BY pr.id";
			
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
		public function prInsertarCSVv63($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10){
			$sql = "CALL prInsertarCSVv63('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."','".$id10."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prInsertarCSVv7($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11,$id12){
			$sql = "CALL prInsertarCSVv7('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."','".$id10."','".$id11."','".$id12."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prInsertarCSVSIv6($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9){
			$sql = "CALL prInsertarCSVSIv6('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prInsertarCSVSIv7($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11){
			$sql = "CALL prInsertarCSVSIv7('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."','".$id10."','".$id11."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prInsertarCSVDUv7($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11,$id12,$id13){
			$sql = "CALL prInsertarCSVDUv7('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."','".$id10."','".$id11."','".$id12."','".$id13."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prInsertarGRv13($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11,$id12,$id13,$id14){
			$sql = "CALL prInsertarGRv13('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."','".$id10."','".$id11."','".$id12."','".$id13."','".$id14."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok-v2
		public function prInsertarGRv2($id1,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11,$id12,$id13,$id14,$id15,$id16){
			$sql = "CALL prInsertarGRv2('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."','".$id6."','".$id7."','".$id8."','".$id9."','".$id10."','".$id11."','".$id12."','".$id13."','".$id14."','".$id15."','".$id16."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prInsertarAUCSVv1($id1,$id2,$id3,$id4){
			$sql = "CALL prInsertarAUCSVv1('".$id1."','".$id2."','".$id3."','".$id4."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prModificarAUCSVv1($id1,$id2,$id3,$id4){
			$sql = "CALL prModificarAUCSVv1('".$id1."','".$id2."','".$id3."','".$id4."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prDetalleAuditoriav1($id1){
			$sql = "CALL prDetalleAuditoriav1('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			return $res;
		}
		//Ok
		public function prConsultarAuditoriasv1($id1,$id2,$id3){
			$sql = "CALL prConsultarAuditoriasv1('".$id1."','".$id2."','".$id3."')";
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
		//Ok-v2
		public function prSerieExistev3($id1,$id2,$id3,$id4,$id5){
			$sql = "CALL prSerieExistev3('".$id1."','".$id2."','".$id3."','".$id4."','".$id5."')";
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
		//Ok-v2
		public function getCapProd($id1,$id2){
			$sql = "SELECT DISTINCT capacidad FROM tipoenvcap WHERE idproducto = '".$id1."' AND tipoenvase = '".$id2."' ORDER BY capacidad";
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
		//Ok-v2
		public function prGetNumeroRemitov2(){
			$sql = "CALL prGetNumeroRemitov2";
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
		public function clientesGRUPO($id1){
			$sql = "CALL prClienteGrupov1('".$id1."')";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok
		public function clientesGrupos(){
			$sql = "SELECT CL.id_xl, CL.nombre cliente, COALESCE(CONCAT(GR.nombre,' (',GR.id_xl,')'), 'Sin Grupo') grupo, 
						COALESCE(CL.condicion,'') condicion FROM 
						(SELECT cl.nombre, cl.id_xl, cl.id_yl, cl.condicion FROM clientebis cl 
							WHERE cl.id_yl <> '') CL
					LEFT JOIN 
						(SELECT cl.nombre, cl.id_xl, cl.id_yl FROM clientebis cl 
							WHERE cl.id_yl = '') GR
					ON CL.id_yl = GR.id_xl
							ORDER BY CL.id_xl";
			$res = mysqli_query($this->con, $sql);
			//$return = mysqli_fetch_object($res );
			//return $return ;
			return $res;
		}
		//Ok
		public function gruposClientes(){
			$sql = "SELECT CL.id_xl, COALESCE(CONCAT(GR.nombre,' (',GR.id_xl,')'), 'Sin Grupo') grupo, 
						CL.nombre cliente, COALESCE(CL.condicion,'') condicion FROM 
						(SELECT cl.nombre, cl.id_xl, cl.id_yl, cl.condicion FROM clientebis cl 
							WHERE cl.id_yl <> '' AND cl.id_xl <> cl.id_yl
						 UNION ALL	
						 SELECT cl.nombre, cl.id_xl, 'XXX', cl.condicion FROM clientebis cl 
							WHERE cl.id_xl = cl.id_yl AND cl.id_yl <> '') CL
					RIGHT JOIN 
						(SELECT cl.nombre, cl.id_xl, cl.id_yl FROM clientebis cl 
							WHERE cl.id_yl = ''
						UNION ALL	
						SELECT 'Sin Grupo', 'XXX', '') GR
					ON CL.id_yl = GR.id_xl
						ORDER BY GR.id_xl,CL.id_xl";
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