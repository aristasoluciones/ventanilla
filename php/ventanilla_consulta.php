<?php
@session_start();
header('Content-type: application/json; charset=utf-8');
require ("clase_variables.php");
require ("clase_mysql.php");
require ("clase_funciones.php");
require ('clase_querys.php');

$funcionesB = new FuncionesB();    
$idConexion = (isset($_SESSION["idConexion"]))?$_SESSION["idConexion"]:1;
$conexion  = new DB_MySql(1);
$querys     = new QuerysB();

$datos = array(); $jsondata = array();
$data = json_decode(file_get_contents('php://input'), true);
if(isset($data['opcion'])) $_POST = $data;

switch($_POST['opcion']) {
    case 1:
        $id = $funcionesB->limpia($_POST['id']);
        $row = $conexion->fetch_objet($querys->getSolicitud($id));
        $jsondata['data'] = $row;
        break;
    case 2:
        $paises = @$conexion->obtenerlista($querys->getListCombo("tblc_pais",
            "id_pais as id, nombre as valor",
            ""));
        $jsondata['items'] = $paises;
        break;
    case 3:
        $resultados = @$conexion->obtenerlista($querys->getListCombo("tblc_municipio",
            "id_municipio as id, nombre as valor",
            "ISNULL(fecha_eliminado) AND id_estado = 7"));
        $jsondata['items'] = $resultados;
        break;
    case 4:
        $resultados = @$conexion->obtenerlista($querys->getListCombo("tbl_establecimiento",
            "id_establecimiento as id, nombre as valor",
            "ISNULL(fecha_eliminado)"));
        $jsondata['items'] = $resultados;
        break;
    case 5:
        $id_municipio = $_POST['id_municipio'] ? (int) $_POST['id_municipio'] : 0;
        $strWhere =  'id_municipio =' . $id_municipio;
        $resultados = @$conexion->obtenerlista($querys->getListCombo("tblc_localidad_delegacion", "id_localidad_delegacion id,
        nombre valor", $strWhere));
        $jsondata['items'] = !is_array($resultados) ? [] :  $resultados;
        break;
    }
    echo json_encode($jsondata);
?>