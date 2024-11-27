<?php 
 
 function validaCampo($valor){
    $pattern = '/^[0-9]{11}$/';
	if(preg_match($pattern, $valor)){
    return true;
} else{
    return false;
}
}

function validaNumero($valor){
    $pattern = '/^[0-9]{1,}+(\.|\,){0,}+[0-9]{0,}$/';
	if(preg_match($pattern, $valor)){
    return true;
} else{
    return false;
}
}

function validaSerie($valor){
    $pattern = '/^[0-9][a-z][A-Z]{1,}$/';
	if(preg_match($pattern, $valor)){
    return true;
} else{
    return true;
}
}

function validaRemito($valor){
    //$pattern = '/^[0-9]{4,6}$/';
	//$pattern = '/^[0-9]{4}$|^[0-9]{6}$/';
	$pattern = '/^[0-9]{13}$/';
	if(preg_match($pattern, $valor)){
    return true;
} else{
    return false;
}
}

function validaLote($valor){
    $pattern = '/^[0-9]{5}$/';
	$pattern2 = '/^[A-Z]{4}?[0-9]{1}$/';
	if(preg_match($pattern, $valor)){
    return true;
} else{
    return true;
}
}

function validaPote($valor){
    $pattern = '/\A[0-9]{6}\z/';
	if(preg_match($pattern, $valor)){
    return true;
} else{
    return true;
}
}

?>