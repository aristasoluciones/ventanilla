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

        $evidencias = [];
        $evidencias_filtradas = [];
        if ($row) {
            $evidencias  = json_decode($row->evidencia, true);
        }
        $path_base = $funcionesB->mainDocRoot();
        $path_base = str_replace('\\', '/', $path_base)."/turismo";
        foreach ($evidencias as $key => $evidencia) {
            $evidencia = !is_array($evidencia) ? [] : $evidencia;
            foreach ($evidencia as $item) {
                if (is_file($path_base.$item['path'])) {
                    if (!isset($evidencias_filtradas[$key]))
                        $evidencias_filtradas[$key] = [];
                    array_push($evidencias_filtradas[$key], $item);
                }

            }
        }

        $row->evidencia =  json_encode($evidencias_filtradas);
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
        $id_municipio = $_POST['id_municipio'] ? (int)$_POST['id_municipio'] : 0;
        $strWhere = 'id_municipio =' . $id_municipio;
        $resultados = @$conexion->obtenerlista($querys->getListCombo("tblc_localidad_delegacion", "id_localidad_delegacion id,
        nombre valor", $strWhere));
        $jsondata['items'] = !is_array($resultados) ? [] : $resultados;
        break;
    case 6:
        $manifestacion = $_POST['manifestacion'];
        $id_solicitud_queja = $funcionesB->limpia($manifestacion['id_solicitud_queja']);
        $manifestacion_row =  @$conexion->fetch_array($querys->getSolicitud($id_solicitud_queja));
        $etapa = $_POST['etapa'];
        $sql = "SELECT id_solicitud_queja_seguimiento, seguimiento, fecha FROM tbl_solicitud_queja_seguimiento 
                WHERE id_solicitud_queja='".$id_solicitud_queja."'
                AND  id_etapa_queja = " . $etapa . " ORDER BY id_solicitud_queja_seguimiento DESC LIMIT 1";
        $row_etapa =  $conexion->fetch_array($sql);
        if(!$row_etapa) {
            $jsondata['resp'] = 0;
            $jsondata['msg'] = $sql;
        } else {
            $manifestacion['texto_pdf'] = $row_etapa['seguimiento'];
            $manifestacion['fecha_seguimiento'] = $row_etapa['fecha'];
            $dato = $funcionesB->generarAcuerdoPdf($manifestacion, 'S', 2);
            $jsondata['resp'] = 1;
            $jsondata['file'] = base64_encode($dato);
        }
        break;
    case 7:
        $manifestacion = $_POST['manifestacion'];
        $etapa = $_POST['etapa'];
        $sql = "SELECT seguimiento, fecha 
                FROM tbl_solicitud_queja_seguimiento 
                WHERE id_solicitud_queja='".$manifestacion['id_solicitud_queja']."'
                AND  id_etapa_queja = " . $etapa . " ORDER BY id_solicitud_queja_seguimiento DESC LIMIT 1";
        $row_etapa =  $conexion->fetch_array($sql);

        if(!$row_etapa) {
            $jsondata['resp'] = 0;
            $jsondata['msg'] = $sql;
        } else {
            $seguimiento =  json_decode($row_etapa['seguimiento'], true);
            $manifestacion['texto_pdf'] = $seguimiento['contenido_acta']['texto'];
            $manifestacion['fecha_seguimiento'] = $seguimiento['contenido_acta']['fecha'];
            $dato = $funcionesB->generarAcuerdoPdf($manifestacion, 'S', 2);
            $jsondata['resp'] = 1;
            $jsondata['file'] = base64_encode($dato);
        }
        break;
    }
    echo json_encode($jsondata);
?>