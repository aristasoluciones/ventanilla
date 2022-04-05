<?php
	@session_start();
	if(isset($_SESSION["autentificado"])){
        $idConexion = (isset($_SESSION["idConexion"]))?$_SESSION["idConexion"]:1;
		$dUsuario = (isset($_SESSION["vUsuario"]))?$_SESSION["vUsuario"]:array();
    }
    else{
        echo'<script languaje="javascript">
				var msg = alert("Su sesión expiro");
				location.href="index.php";
			</script>';
        exit(0);
    }
	date_default_timezone_set('America/Mexico_City');
	
	require_once("clase_variables.php");
	require_once("clase_mysql.php");
	include_once("clase_querys.php");
	include_once("clase_funciones.php");
	include_once("clase_paginador.php");

//--------------------------------------------------
	
	$conexion  = new DB_MySql($idConexion);
	$funciones = new FuncionesB();
	$querys    = new QuerysB();
?>
