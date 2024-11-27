<?php
    //Redireccionar al Login
    ob_start();
	session_set_cookie_params(60*60*24*1);
	session_start();
    header('location:login.html');
?>