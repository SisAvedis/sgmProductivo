<?php include ("inicio.php"); ?>
<?php try{ ?>
<body>
	<form method="post" action="remitosDetalle-v3.3.php" id="frm">
    <div class="container">
		<!-- HEADER (start) -->
			<?php include ("database_e.php");?>
			<?php require_once 'include/validacion.php';?>
		<!-- HEADER (end) -->
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div id="tit" class="col-sm-8"><h4>Remito (Detalle)</h4></div>
                </div>
            </div>
            
			<div class="row">
				<div class="col-md-2">
					<label><pre class="lx-pre">Número de Remito</pre></label></br>
					<pre class="lx-pre"><input type="text" name="nremito" id="nremito" class="form-control input-sm" maxlength="6" required value="<?php $nremito; ?>" /></pre>
				</div>
				
				<div class="col-md-2" id="lblExisteRemito">
				</div>	
				<div class="col-md-2" id="lblExisteRemito2">
				</div>
				<div class="col-md-1" id="lblExisteRemito3">
				</div>
				<div class="col-md-1" id="lblExisteRemito4">
				</div>
				<div class="col-md-8" id="lblExisteRemito5">
				</div>
				
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
	function getRemito(sRemito, callbackFn){
		//console.log("Valor de nradioVal -> "+nradioVal);
		if(sRemito.trim() !== ''){
			jq.ajax({
				url:"./ajaxRemitoDetalle-v3.3.php",
				dataType: "json",
				data: {"nremito": sRemito},
				type:"POST",
				success:function(response){
					callbackFn(response);
				}					
			})
		}
	}
	var jq = jQuery.noConflict();
	//jQuery.noConflict();
	jq(document).ready(function(){
		
		var bRes = false;
		var sRemito = '';
		var bkeyPressed = false;
		
		jq.fn.chkPattern = function(sRemito){
			var pattern = new RegExp('^[0-9]{4}$|^[0-9]{6}$');
			if (pattern.test(sRemito)) {
				jq('#nremito').css("background-color","#92FF8A");
				jq('#nremito').css("color","#A605FA");
				bRes = true;
			}else{
				if(jq('#nremito').val() !== ''){
					jq('#nremito').css("background-color","#FAE605");
					jq('#nremito').css("color","#A605FA");
					jq("#nremito").focus();
				}
				bRes = false;
			}
		}
		
		//jq("#nremito").focus();
		
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
			getRemito(sRemito, function(data) {
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
							//jq('#msgENV').css("background-color","#E6FBF9");
							//Color de fondo de la sección "Detalle"
							jq('#msgDEV').css("background-color","#FFFFFF");
							jq('#msgDEV').css("color","#000333");
							jq("#msgDEV").html(sMSGDev);
							if(dMSGMot == null){
								jq("#lbcantidadE").html('Enviados - Cantidad: '+iMSGEnv+' || Volumen Despachado: '+dMSGEnv+' ||<span style="color:'+sReColor+';"> '+sReCont);
							}else{
								jq("#lbcantidadE").html('Enviados - Cantidad: '+iMSGEnv+' || <span style="color:#FF00FF;">Volumen Despachado: '+dMSGEnv+' </span> || <span style="color:#FF00FF;">Observaciones: '+dMSGMot+' || <span style="color:'+sReColor+';">'+sReCont)+'</span>';
							}
							//jq("#lbcantidadE").html('Enviados - Cantidad: '+iMSGEnv+' || Volumen Despachado: '+Math.round(dMSGEnv * 10 ) / 10);
							//jq("#lbcantidadE").html('Enviados - Cantidad: '+iMSGEnv+' || Volumen Despachado: '+parseFloat(dMSGEnv.toFixed(2)));
							//jq("#lbcantidadE").html(dMSGEnv);
							jq("#lbcantidadD").html('Devueltos - Cantidad: '+iMSGDev);
						}else{
							var sMSGEnv = data[i].header11;
							var dMSGEnv = data[i].header15;
							var sLblEnv = "<label id='env'><pre class='lx-pre'></pre></label></br>";
							jq("#lblExisteRemito5").append(sLblEnv);
							jq("#env pre").attr('id', 'msgENV');
							jq('#msgENV').css("background-color","#E6FBF9");
							jq('#msgENV').css("color","#000333");
							jq("#msgENV").html(sMSGEnv);
							jq("#lbvolumenE").html('Volumen Despachado: '+dMSGEnv+' || <span style="color:'+sReColor+';">'+sReCont);
						}
						
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

		
		jq("#nremito").focusout('input', function(){
			sRemito = jq(this).val();
		});
		
		
		jq('#nremito').keypress(function(e) {
			sRemito = jq(this).val();
			if(e.which == 13) {
				jq.fn.chkPattern(sRemito);
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
				jq.fn.procesaRemito(sRemito);
			}
			bkeyPressed = false;
		});

	});
</script>				
	



	</form>
	</body>
</html>

