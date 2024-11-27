<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="remitosDetalleC-v5.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php //include ("database_e.php");?>
			<?php include ("database_e4.php");?>
			<?php //require_once 'include/validacion.php';?>
			<?php require_once 'include/validacion4.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Validar Remito</h4></div>
                </div>
            </div>
            
			<div class="row">
				<div class="col-md-2">
					<label><pre class="lx-pre">Número de Remito</pre></label></br>
					<pre class="lx-pre"><input type="text" name="nremito" id="nremito" class="form-control input-sm" maxlength="13" required value="<?php $nremito; ?>" /></pre>
				</div>
				
				<div class="col-md-2" id="lblExisteRemito">
				</div>	
				<div class="col-md-2" id="lblExisteRemito2">
				</div>
				<div class="col-md-1" id="lblExisteRemito3">
				</div>
				<div class="col-md-1" id="lblExisteRemito4">
				</div>
				<div class="col-md-1" id="lblExisteRemito6">
				</div>
				<div class="col-md-12" id="lblExisteRemito5">
				</div>
				
				<?php
				$supdated = 0;
				$idusuario=isset($_SESSION['idusuario'])? $_SESSION['idusuario']:"";
				$ctlCHKH = isset($_POST['ctlCHKH']) ? $_POST['ctlCHKH'] : false;;
				$nremito = isset($_POST['nremito']) ? $_POST['nremito'] : false;;
				//echo "<pre>";
				//echo $ctlCHKH."</br>";
				//echo "</pre>";
				if($nremito && $ctlCHKH == 1){
					$supdated = 1;
				}else{
					$supdated = 0;
				}
				?>
				
				
				<!--<div class="col-md-12 pull-right">-->
				<div class="col-md-12">
					<hr>
					<button type="submit" id="abutton" class="btn btn-sm btn-danger">Consultar</button>
					<hr>
				</div>
			</div>
		</div>	
	</div>	
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
	
	//Chequea si ya existe el remito - usuarios concurrentes - al salir del input nremito
	function getRemito(sRemito, sctlCHK, sUsuario, callbackFn){
		//console.log("Valor de nradioVal -> "+nradioVal);
		if(sRemito.trim() !== ''){
			jq.ajax({
				url:"./ajaxRemitoDetalleC-v5.php",
				dataType: "json",
				//data: {"nremito": sRemito},
				data: {"nremito": sRemito,"ctlCHKH": sctlCHK,"idusuario": sUsuario},
				type:"POST",
				success:function(response){
					callbackFn(response);
				}					
			})
		}
	}
	
	//Función que inserta string en una posición especificada
	function insertAtIndex(str, substring, index) {
		return str.slice(0, index) + substring + str.slice(index);
	}
	
	var jq = jQuery.noConflict();
	//jQuery.noConflict();
	jq(document).ready(function(){
		
		var bRes = false;
		var sRemito = '';
		var bkeyPressed = false;
		
		var sctlCHK = 2;
		var sUsuario = '<?php echo $idusuario; ?>';
		
		var sUpdated = '<?php echo $supdated; ?>';
		
		
		
		//var sctlCHK = jq('#ctlCHKH').val();
		//console.log('Valor de sctlCHKH luego de document ready -> '+sctlCHK);
		
		
		var bctlCHK = false;
		
		jq.fn.chkPattern = function(sRemito1){
			//sRemitoInc = jq(this).val();
			sRemitoInc = sRemito1;
			var pattern = /^([0-9]{1,5})+\-([0-9]{1,8})$/;
			//var pattern2 = /^([0-9]{4})+([1-9]{1})+([0-9]{8})$/;
			var pattern2 = /^(?!00000)([0-9]{5})(?!00000000)([0-9]{8})$/;
			//insertAtIndex
			console.log("Función chkPattern entrando -> "+sRemitoInc);
			if (pattern.test(sRemitoInc)) {
				sArr = sRemitoInc.split('-');
				iPV = 5;
				iNC = 8;
				lenPV = sArr[0].length;
				lenNC = sArr[1].length;
				//sPV = '';
				
				for(var i=lenPV; i<iPV; i++){
					sArr[0] = insertAtIndex(sArr[0], '0', 0);
				}
				
				for(var i=lenNC; i<iNC; i++){
					sArr[1] = insertAtIndex(sArr[1], '0', 0);
				}
				
				sRemito = sArr[0]+sArr[1];
				jq('#nremito').css("background-color","#92FF8A");
				jq('#nremito').css("color","#A605FA");
				jq('#nremito').val(sRemito)
				bRes = true;
				//console.log("Función chkPattern if True...");
			}else if (pattern2.test(sRemitoInc)){
				if(jq('#nremito').val() !== ''){
					sRemito = sRemitoInc;
					jq('#nremito').css("background-color","#92FF8A");
					jq('#nremito').css("color","#A605FA");
					jq('#nremito').val(sRemito)
					bRes = true;
					//console.log("Función chkPattern else if True...");
				}
			}else{
				if(jq('#nremito').val() !== ''){
					jq('#nremito').css("background-color","#FAE605");
					jq('#nremito').css("color","#A605FA");
					jq("#nremito").focus();
				}
				sRemito = '';
				bRes = false;
				//console.log("Función chkPattern if False...");
			}
			//console.log("Ver rutina...");
		}
		
		//jq("#nremito").focus();
		
		// Decrease Image Size       
        jq.fn.achicaImg = function(sObj,sTipo){
			
			var currentImgWidth = jq('#'+sObj).css('width');  
			var currentImgHeigth = jq('#'+sObj).css('height');		
			//console.log(sObj+" Width -> "+currentImgWidth+" Height -> "+currentImgHeigth);
			switch(sTipo){
				//CIL
				case 'CIL':
					var currentImgWidth = parseFloat(currentImgWidth)*0.3;  
					var currentImgHeigth = parseFloat(currentImgHeigth)*0.3;
				break;
				//TER
				case 'TER':
					var currentImgWidth = parseFloat(currentImgWidth)*0.75;  
					var currentImgHeigth = parseFloat(currentImgHeigth)*0.75;
				break;
				//GRANEL
				case 'Granel':
					var currentImgWidth = parseFloat(currentImgWidth)*0.2;  
					var currentImgHeigth = parseFloat(currentImgHeigth)*0.2;
				break;
				
			}
			
			var currentImgWidth = currentImgWidth.toFixed(0); 
			var currentImgHeigth = currentImgHeigth.toFixed(0);
			
			jq("#"+sObj).css({
				'width': currentImgWidth+'px',
				'height': currentImgHeigth+'px'
			});
			//console.log(sObj+" Width -> "+currentImgWidth+" Height -> "+currentImgHeigth);
        }
		
		jq.fn.setHiddenV = function(hId, hValue){
			jq('#'+hId).val(hValue)
                 //.trigger('change');
		}
		
		//Limpia la grilla de entregados y devueltos
		jq.fn.procesaRemito = function(sRemito){
			jq('#lblExisteRemito').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito2').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito3').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito4').children().each(function (index) {
				jq(this).remove();
			});
			jq('#lblExisteRemito5').children().each(function (index) {
				jq(this).remove();
			});
			//var sRemito = jq(this).val();
			//jq.fn.chkPattern(sRemito);
			getRemito(sRemito, sctlCHK, sUsuario, function(data) {
			//getRemito(sRemito, function(data) {
				var len = data.length;
			//console.log("Valor de len -> "+len);
				for(var i=0; i<len; i++){
					bRemitoExiste = data[i].header1;
					bEnvasado = data[i].header10;
					var scolmod0 = data[i].header20;
					var scolmod1 = data[i].header21;
					var scolmod2 = data[i].header22;
					var scolmod3 = data[i].header23;
					var scolmod4 = data[i].header24;
					jq("#lblExisteRemito").removeClass();
					jq("#lblExisteRemito").addClass(scolmod0);
					jq("#lblExisteRemito2").removeClass();
					jq("#lblExisteRemito2").addClass(scolmod1);
					jq("#lblExisteRemito3").removeClass();
					jq("#lblExisteRemito3").addClass(scolmod2);
					jq("#lblExisteRemito4").removeClass();
					jq("#lblExisteRemito4").addClass(scolmod3);
					jq("#lblExisteRemito5").removeClass();
					jq("#lblExisteRemito5").addClass(scolmod4);
					if(bRemitoExiste == true){
						var sMsgUno = data[i].header2;
						var sMSGDos = data[i].header3;
						var sMSGTre = data[i].header4;
						var sMSGCua = data[i].header5;
						var sMSGCin = data[i].header6;
						var sMSGSei = data[i].header7;
						var sTipoRe = data[i].header17;
						var sReCont = data[i].header19;
						var sReCoId = data[i].header191;
						switch(sTipoRe){
							//RDIST
							case 'RDIST':
								var sBGColor = "#E8F7AC";
							break;
							//RSUBI
							case 'RSUBI':
								var sBGColor = "#F7CA14";
							break;
						}
						switch(sReCoId){
							//Sin Datos
							case '0':
								var sReColor = "#9D00FF";
							break;
							//No Controlado
							case '1':
								var sReColor = "#FD1C03";
							break;
							//Controlado
							case '2':
								var sReColor = "#0000FF";
							break;
						}
						var sGRBGColor = "#FFFF00";
						var sLblUno = "<label id='uno'><pre class='lx-pre'></pre></label></br>";
						var sLblDos = "<label id='dos'><pre class='lx-pre'></pre></label></br>";
						var sLblTre = "<label id='tre'><pre class='lx-pre'></pre></label></br>";
						var sLblCua = "<label id='cua'><pre class='lx-pre'></pre></label></br>";
						var sLblCin = "<label id='cin'><pre class='lx-pre'></pre></label></br>";
						var sLblSei = "<label id='sei'><pre class='lx-pre'></pre></label></br>";
						jq("#lblExisteRemito").append(sLblUno);
						jq("#uno pre").attr('id', 'msgUNO');
						jq("#lblExisteRemito").append(sLblDos);
						jq("#dos pre").attr('id', 'msgDOS');
						jq("#lblExisteRemito2").append(sLblTre);
						jq("#tre pre").attr('id', 'msgTRE');
						jq("#lblExisteRemito2").append(sLblCua);
						jq("#cua pre").attr('id', 'msgCUA');
						jq("#lblExisteRemito3").append(sLblCin);
						jq("#cin pre").attr('id', 'msgCIN');
						jq("#lblExisteRemito3").append(sLblSei);
						jq("#sei pre").attr('id', 'msgSEI');
						jq('#msgUNO').css("background-color","#F5F5F5");
						jq('#msgUNO').css("color","#000333");
						jq("#msgUNO").text(sMsgUno);
						jq('#msgDOS').css("background-color",sBGColor);
						jq('#msgDOS').css("color","#000333");
						jq("#msgDOS").text(sMSGDos);
						jq('#msgTRE').css("background-color","#F5F5F5");
						jq('#msgTRE').css("color","#000333");
						jq("#msgTRE").text(sMSGTre);
						jq('#msgCUA').css("background-color",sBGColor);
						jq('#msgCUA').css("color","#000333");
						jq("#msgCUA").text(sMSGCua);
						jq('#msgCIN').css("background-color","#F5F5F5");
						jq('#msgCIN').css("color","#000333");
						jq("#msgCIN").text(sMSGCin);
						jq('#msgSEI').css("background-color",sBGColor);
						jq('#msgSEI').css("color","#000333");
						jq("#msgSEI").text(sMSGSei);
						if(bEnvasado == true){
							var sMSGEnv = data[i].header11;
							var iMSGEnv = data[i].header12;
							var sMSGDev = data[i].header13;
							var iMSGDev = data[i].header14;
							var dMSGEnv = data[i].header15;
							var dMSGMot = data[i].header18;
							var sMSGSie = data[i].header8;
							var sMSGOch = data[i].header9;
							var sLblSie = "<label id='sie'><pre class='lx-pre'></pre></label></br>";
							var sLblOch = "<label id='och'><pre class='lx-pre'></pre></label></br>";
							var sLblEnv = "<label id='env'><pre class='lx-pre'></pre></label></br>";
							var sLblDev = "<label id='dev'><pre class='lx-pre'></pre></label></br>";
							jq("#lblExisteRemito4").append(sLblSie);
							jq("#sie pre").attr('id', 'msgSIE');
							jq("#lblExisteRemito4").append(sLblOch);
							jq("#och pre").attr('id', 'msgOCH');
							jq("#lblExisteRemito5").append(sLblEnv);
							jq("#env pre").attr('id', 'msgENV');
							jq("#lblExisteRemito5").append(sLblDev);
							jq("#dev pre").attr('id', 'msgDEV');
							//jq("#lblExisteRemito5").append(sLblOch);
							//jq("#och pre").attr('id', 'msgOCH');
							jq('#msgSIE').css("background-color","#F5F5F5");
							jq('#msgSIE').css("color","#000333");
							jq("#msgSIE").text(sMSGSie);
							jq('#msgOCH').css("background-color",sBGColor);
							jq('#msgOCH').css("color","#000333");
							jq("#msgOCH").text(sMSGOch);
							//jq('#msgENV').css("background-color","#E6FBF9");
							//Color de fondo de la sección "Detalle"
							jq('#msgENV').css("background-color","#FFFFFF");
							jq('#msgENV').css("color","#000333");
							jq("#msgENV").html(sMSGEnv);
							jq.fn.achicaImg("imagenE",sMSGSei);
							//jq('#msgENV').css("background-color","#E6FBF9");
							//Color de fondo de la sección "Detalle"
							jq('#msgDEV').css("background-color","#FFFFFF");
							jq('#msgDEV').css("color","#000333");
							jq("#msgDEV").html(sMSGDev);
							jq.fn.achicaImg("imagenD",sMSGSei);
							if(dMSGMot == null){
								jq("#lbcantidadE").html('<pre class="lx-pre" style="background-color:'+sGRBGColor+';">'+'Enviados - Cantidad: '+iMSGEnv+' || Volumen Despachado: '+dMSGEnv+' ||<span style="color:'+sReColor+';"> '+sReCont+' (N° Remito: '+sRemito+')');
							}else{
								jq("#lbcantidadE").html('<pre class="lx-pre" style="background-color:'+sGRBGColor+';">'+'Enviados - Cantidad: '+iMSGEnv+' ||<span style="color:#FF00FF;">Volumen Despachado: '+dMSGEnv+' </span> || <span style="color:'+sReColor+';">Observaciones: '+dMSGMot+' || <span style="color:'+sReColor+';"> '+sReCont)+'</span>'+' (N° Remito: '+sRemito+')';
							}
							//jq("#lbcantidadE").html('Enviados - Cantidad: '+iMSGEnv+' || Volumen Despachado: '+Math.round(dMSGEnv * 10 ) / 10);
							//jq("#lbcantidadE").html('Enviados - Cantidad: '+iMSGEnv+' || Volumen Despachado: '+parseFloat(dMSGEnv.toFixed(2)));
							//jq("#lbcantidadE").html(dMSGEnv);
							jq("#lbcantidadD").html('Devueltos - Cantidad: '+iMSGDev);
							
							
							switch(sReCoId){
								//Sin Datos
								case '0':
									var sReColor = "#9D00FF";
								break;
								//No Controlado
								case '1':
									jq('#ctlCHK').prop('disabled', false);
								break;
								//Controlado
								case '2':
									jq("#ctlCHK").attr("disabled", true);
								break;
							}
							
						
						}else{
							var sMSGEnv = data[i].header11;
							var dMSGEnv = data[i].header15;
							var sLblEnv = "<label id='env'><pre class='lx-pre'></pre></label></br>";
							jq("#lblExisteRemito5").append(sLblEnv);
							jq("#env pre").attr('id', 'msgENV');
							jq('#msgENV').css("background-color","#E6FBF9");
							jq('#msgENV').css("color","#000333");
							jq("#msgENV").html(sMSGEnv);
							jq.fn.achicaImg("imagenF",sMSGSei);
							jq("#lbvolumenE").html('<pre class="lx-pre" style="background-color:'+sGRBGColor+';">'+'Volumen Despachado: '+dMSGEnv+' ||<span style="color:'+sReColor+';"> '+sReCont+' (N° Remito: '+sRemito+')'+'</pre>');
							
							
							switch(sReCoId){
								//Sin Datos
								case '0':
									var sReColor = "#9D00FF";
								break;
								//No Controlado
								case '1':
									jq('#ctlCHK').prop('disabled', false);
								break;
								//Controlado
								case '2':
									jq("#ctlCHK").attr("disabled", true);
								break;
							}
							
							//jq("#ctlCHK").attr("disabled", true);
							//sctlCHK = jq('#ctlCHKH').val();
							//var sctlCHK = jq('#ctlCHKH').val();
							//console.log('Valor de sctlCHKH -> '+sctlCHK);
						}
						
						sctlCHK = jq('#ctlCHKH').val();
						console.log('Valor de sctlCHKH -> '+sctlCHK);

						
					}else{
						var sMsgUno = data[i].header2;
						var sMSGDos = data[i].header3;
						var sLblUno = "<label id='uno'><pre class='lx-pre'></pre></label></br>";
						var sLblDos = "<label id='dos'><pre class='lx-pre'></pre></label></br>";
						jq("#lblExisteRemito").append(sLblUno);
						jq("#uno pre").attr('id', 'msgUNO');
						jq("#lblExisteRemito").append(sLblDos);
						jq("#dos pre").attr('id', 'msgDOS');
						jq('#msgUNO').css("background-color","#F5F5F5");
						jq('#msgUNO').css("color","#000333");
						jq("#msgUNO").text(sMsgUno);
						jq('#msgDOS').css("background-color","#E8F7AC");
						jq('#msgDOS').css("color","#000333");
						jq("#msgDOS").text(sMSGDos);
					}
				}
				
			});
		
		}
		
		
		
		
		
		
		
		
		//Event binding on dynamically created elements | CheckBox ctlCHK abutton
		jq("#lblExisteRemito5").on('click','#ctlCHK', function(){
			
			if(jq("#ctlCHK").prop("checked") == true){
				jq('#abutton').text('Actualizar');
				bctlCHK = true;
				jq.fn.setHiddenV('ctlCHKH', 1);
			}else{
				jq('#abutton').text('Consultar');
				bctlCHK = false;
				jq.fn.setHiddenV('ctlCHKH', 0);
			}
			//console.log('Valor de ctlCHKH -> '+jq(ctlCHKH).val());
		});
		
		
		if(sUpdated == 1){
			sRemito = '<?php echo $nremito; ?>';
			jq.fn.procesaRemito(sRemito);
		}
		
		jq("#nremito").focusout('input', function(){
			
			sRemito1 = jq(this).val();
			jq.fn.chkPattern(sRemito1);
			/*
			sRemitoInc = jq(this).val();
			var pattern = /^([0-9]{1,5})+\-([0-9]{1,8})$/;
			insertAtIndex
			if (pattern.test(sRemitoInc)) {
				sArr = sRemitoInc.split('-');
				iPV = 5;
				iNC = 8;
				lenPV = sArr[0].length;
				lenNC = sArr[1].length;
				//sPV = '';
				
				for(var i=lenPV; i<iPV; i++){
					sArr[0] = insertAtIndex(sArr[0], '0', 0);
				}
				
				for(var i=lenNC; i<iNC; i++){
					sArr[1] = insertAtIndex(sArr[1], '0', 0);
				}
				
				sRemito = sArr[0]+sArr[1];
				jq('#nremito').css("background-color","#92FF8A");
				jq('#nremito').css("color","#A605FA");
				jq('#nremito').val(sRemito)
				bRes = true;
			}else{
				if(jq('#nremito').val() !== ''){
					jq('#nremito').css("background-color","#FAE605");
					jq('#nremito').css("color","#A605FA");
					jq("#nremito").focus();
				}
				sRemito = '';
				bRes = false;
			}
			*/
		});
		
		
		jq('#nremito').keypress(function(e) {
			sRemito1 = jq(this).val();
			if(e.which == 13) {
				jq.fn.chkPattern(sRemito1);
				if(bRes == true){
					bkeyPressed = true;
					jq.fn.procesaRemito(sRemito);
				}
			}
		});
		
		
		
		
		jq('#frm').on('submit', function(e){	
			var currentForm = this;
			e.preventDefault();
			sClick = jq(this).val();
			jq.fn.chkPattern(sRemito);
			if(bRes == true && bkeyPressed == false){
				//console.log('Dentro de preventDefault...');
				
				
				
				//jq.fn.procesaRemito(sRemito);
				
				var formData = new FormData(jq('#frm')[0]);
				if(jq('#ctlCHK').prop('checked') == true){
					console.log('Por True dentro de preventDefault...');
					formData.set("ctlCHKH", jq(ctlCHKH).val());
					formData.set("idusuario", sUsuario);
					sctlCHK = 1;
				}else{
					/*
					if(sctlCHK == 0){
						formData.set("ctlCHKH", jq(ctlCHKH).val());
					}
					*/
					//sctlCHK = 0;
					console.log('Por False dentro de preventDefault...');
				}
				//formData.set("sctlCHKH", jq(ctlCHKH).val());
				for (var pair of formData.entries()) {
					console.log(pair[0]+ ', ' + pair[1]); 
				}
				
				//console.log('Valor de sctlCHK antes de llamar a la función procesaRemito -> '+sctlCHK);
				
				jq.fn.procesaRemito(sRemito);
				
				
				
				
				//console.log("Valor de bctlCHK -> "+bctlCHK);
				var sconfirmsg = '';
				if(bctlCHK == true){
					sconfirmsg = "Confirma el remito "+sRemito+" como controlado?";
					bootbox.confirm({
						message: sconfirmsg,
							size: 'small',
							buttons: {
							confirm: {
								label: 'Si',
								className: 'btn-success'
							},
							cancel: {
							label: 'No',
							className: 'btn-warning'
							}
						},
						callback: function (result) {
							if(result == true){
								currentForm.submit();
							}else{
								//jq('#abutton').text('Consultar');
								
								bctlCHK = false;
								sctlCHK = 0;
								//console.log('Valor de sctlCHK saliendo por false de CallBack -> '+sctlCHK);
								jq.fn.procesaRemito(sRemito);
							}
						}	
					});
				}
				
			}
			bkeyPressed = false;
		});

	});
</script>				
	



	</form>
	</body>
</html>

