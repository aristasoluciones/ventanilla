<?php
//*****************SE INICIA SESIÓN********************
@session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//*****************************************************
	require "clase_variables.php";
	require "clase_mysql.php";
	require "clase_funciones.php";
	require 'clase_querys.php';

	$error = null;
    $correo  = limpia($_POST["text_correo"]);
    $folio     = $_POST["text_folio"];

    $idConexion = 1;
    $_SESSION["idConexion"] = $idConexion;

	$conexion  = new DB_mysql($idConexion);
	$funciones = new FuncionesB();
	$querys    = new QuerysB();

    $datos = array(); $jsondata = array();

	$ip = $funciones->getRealIP();
	$navegador = $funciones->getBrowser();
	$so = $funciones->getOs();
	$fecha_actual = date("Y")."-".date("m")."-".date("d");
	$hora_actual = date("H").":".date("i").":".date("s");
	date_default_timezone_set('America/Mexico_City');

    $dato = @$conexion->fetch_array_assoc($querys->existeEmailFolio($correo, $folio));
    $resultados = @$conexion->numregistros();
    if($resultados > 0){
        $_SESSION["autentificado"]  = md5("sistemaventanilla");
        $_SESSION["vUsuario"]       = $dato;

        $jsondata['resp'] = 1;
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata);
        exit();
    } else {
        $jsondata['resp'] = 2;
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata);
        exit();
    }

    function limpia($var){
		$var = strip_tags($var);
		$malo = array("\\",";","+","\'","'","$","%","!","(",")",'"',"*","{","}","xor","XOR","FROM","from","WHERE","where","ORDER","order","GROUP","group","by","BY","UPDATE","update","DELETE","delete",".php",".asp",".aspx",".html",".xml",".js",".css",".exe",".tar",".rar",".ocx"); // Aqui poner caracteres no permitidos
		$i=0;
		$o=count($malo);
		$o= $o-1;
		while($i<=$o) {
			$var = str_replace($malo[$i],"",$var);
			$i++;
		}

		return $var;
	}
  ?>

