<?php
	@session_start();
  	error_reporting(E_ALL);
  	ini_set('display_errors', '1');

	require_once("clase_variables.php");
	require_once("clase_mysql.php");
    require_once("clase_funciones.php");
    require_once("clase_querys.php");

	$funciones          = new FuncionesB();
	$idConexion         = (isset($_SESSION["idConexion"]))?$_SESSION["idConexion"]:1;
	$conexion           = new DB_MySql($idConexion);
	$querys             = new QuerysB();
	switch($_POST['opcion']) {
        case 1:
            $id = $_POST['id'];
            $row = $conexion->fetch_objet($querys->getSolicitud($id));
            $id_etapa_siguiente = $row->id_etapa_queja + 1;
            $query  = "CALL sp_ventanillaSeguimientoSolicitud(";
            $query .= $row->id_solicitud_queja;
            $query .= ",".$id_etapa_siguiente;
            $query .= ",0";
            $query .= ",'".$_POST['comentario']."'";
            $query .= ",'[]')";

            if($conexion->consulta($query) == 0){
                $jsondata['resp']   = 0;
                $jsondata['msg']    = $query;
            } else {
                $jsondata['resp']   = 1;
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
        break;
	}
?>