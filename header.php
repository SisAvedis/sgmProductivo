<?php include("include/info.php"); ?>
<?php
  if(strlen(session_id()) < 1) //Si la variable de session no esta iniciada
  {
    //ttl de un día
	//$ttl = (60 * 60 * 24);
	//session_set_cookie_params($ttl);
	ob_start();
	session_set_cookie_params(60*60*24*1);
	session_start();
	//echo session_id();
  }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo($titulo.$seccion); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-multiselect.css">
<!--<link rel="stylesheet" type="text/css" href="css/custom.css">-->
<link rel="stylesheet" type="text/css" href="css/custom2.css">
<link rel="stylesheet" type="text/css" href="css/custom4.css">
<link rel="stylesheet" href="css/material-icons.css">
<link rel="stylesheet" href="css/jquery-ui.css">
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script> <!-- Cuidado. Antes jquery js que bootstrap js-->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/datepicker-es.js"></script>
<script type="text/javascript" src="js/bootbox.min.js"></script>
</head>
   
 
<body>
<div class="container">
	<div align="left">
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100%" height="100%">
					<p align="left"></td>
			</tr>
			<tr>
				<td width="100%" height="100%">
					<p align="left"> <img border="0" src="images/barra3.gif" width="100%" height="5" align="left">	  </td>
			</tr>
			<tr>
				<td width="100%" height="100%">
					<img class="img-responsive" src="images/avedis-logo-transp-header.png" width="15%" height="33%" border="0">
				</td>
				
			</tr>
			<tr>
				<td width="100%" height="100%">
					<p align="left"> <img border="0" src="images/barra3.gif" width="100%" height="5" align="left">	  </td>
			</tr>
			<tr>
				<td width="100%" height="14">
					<p align="left"></td>
			</tr>
		</table>
	</div>
</div>	

	