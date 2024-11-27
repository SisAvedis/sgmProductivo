<?php
  //Activacion de almacenamiento en buffer
  ob_start();
  session_set_cookie_params(60*60*24*1);
  //iniciamos las variables de session
  session_start();

  if(!isset($_SESSION["nombre"]))
  {
    header("Location: login.html");
  }

  else  //Agrega toda la vista
  {
    require 'header.php';
	require 'consulta.php';
	require 'logout.html';
?>

<?php
  }
  ob_end_flush(); //liberar el espacio del buffer
?>