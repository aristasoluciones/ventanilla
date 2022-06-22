<?php
@session_start();
require ("clase_variables.php");
require ("clase_mysql.php");
require ("clase_querys.php");
require ("clase_funciones.php");
header('Content-type: application/json; charset=utf-8');
$funciones          = new FuncionesB;
$idConexion         = (isset($_SESSION["idConexion"]))?$_SESSION["idConexion"]:1;
$conexion           = new DB_MySql($idConexion);
$querys             = new QuerysB();
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['opcion'])) $_POST = $data;

switch($_POST['opcion']) {
    case 1:
        $file   = $_POST['file'];
        $uuid   = $file['id'];
        $tipo   = strtolower($file['tipo']);
        $id     = $_POST['id'];
        $sql    = "SELECT evidencia from tbl_solicitud_queja
                   WHERE id_solicitud_queja='".$id."'";
        $existe     = $conexion->fetch_objet($sql);
        $archivos   = $existe ? json_decode($existe->evidencia, true) : [];
        $archivos   = is_array($archivos) ? $archivos : [];
        $path_base  = $funciones->mainDocRoot()."/turismo";

        if(isset($archivos[$tipo])) {
            $temp = [];
            foreach($archivos[$tipo] as $key => $archivo) {
                if($archivo['id'] === $uuid)
                    unlink($path_base.$archivo['path']);
                else
                    array_push($temp, $archivo);
            }

            if(count($temp) <= 0)
                unset($archivos[$tipo]);
            else
                $archivos[$tipo] = $temp;
        }
        $archivos_json = count($archivos) ? "'" . json_encode($archivos) . "'" : 'NULL';
        $sql  = "UPDATE tbl_solicitud_queja SET evidencia = " . $archivos_json;
        $sql .= " WHERE id_solicitud_queja= '" . $id . "' ";
        $conexion->consulta($sql);
        echo json_encode($archivos);
    break;
    case 2:
        $currentFile   = $_POST['file'];
        $uuid   = $currentFile['id'];
        $id     = $_POST['id'];
        $sql = "SELECT archivo, evidencia from tbl_solicitud_queja_recurso
                WHERE id_solicitud_queja_recurso='".$id."'";
        $existe     = $conexion->fetch_objet($sql);
        $archivos   = $existe ? json_decode($existe->archivo, true) : [];
        $archivos   = !is_array($archivos) ? [] : $archivos;
        $evidencias   = $existe ? json_decode($existe->evidencia, true) : [];
        $evidencias   = !is_array($evidencias) ? [] : $evidencias;
        $path_base  = $funciones->mainDocRoot();
        if ($currentFile['tipo'] === 'evidencia' && count($evidencias) > 0) {
            $keyEvidencia = array_search($uuid, array_column($evidencias, 'id'));
            if ($keyEvidencia !== false) {
                $file = $path_base.'/turismo'.$evidencias[$keyEvidencia]['path'];
                if(is_file($file))
                    if(unlink($file))
                        unset($evidencias[$keyEvidencia]);
                $evidencias = array_values($evidencias);

            }
        }
        if ($currentFile['tipo'] === 'acta' && count($archivos) > 0) {
            $keyArchivo = array_search($uuid, array_column($archivos, 'id'));
            if ($keyArchivo !== false) {
                $file = $path_base.'/turismo'.$archivos[$keyArchivo]['path'];
                if(is_file($file))
                    if(unlink($file))
                        unset($archivos[$keyArchivo]);
                $archivos = array_values($archivos);
            }
        }
        $evidenciasJson = count($evidencias) ? "'" . json_encode($evidencias) . "'" : 'NULL';
        $archivosJson   = count($archivos) ? "'" . json_encode($archivos) . "'" : 'NULL';
        $sql = "UPDATE tbl_solicitud_queja_recurso
                SET archivo = " . $archivosJson . ",
                    evidencia = " . $evidenciasJson . "
                WHERE id_solicitud_queja_recurso ='" . $id . "'";

        if ($conexion->consulta($sql) == 0) {
            $jsondata['resp'] = 0;
        } else {
            $jsondata['resp'] = 1;
            $sql = "SELECT * FROM tbl_solicitud_queja_recurso
                    WHERE id_solicitud_queja_recurso= '" . $id . "' AND ISNULL(fecha_eliminado) ";
            $row = $conexion->fetch_objet($sql);
            if ($row) {
                $evidencias = json_decode($row->evidencia, true);
                $evidenciasValidadas =  $funciones->validarExistenciaArchivo($evidencias, 0);
                $row->evidencia =  json_encode($evidenciasValidadas);
                $archivos = json_decode($row->archivo, true);
                $archivosValidados = $funciones->validarExistenciaArchivo($archivos,0);
                $row->archivo =  json_encode($archivosValidados, 0);
                if ((count($evidenciasValidadas) + count($archivosValidados)) <= 0) {
                    $strQuery = "DELETE FROM tbl_solicitud_queja_recurso
                                 WHERE id_solicitud_queja_recurso= '" . $id . "' ";
                    $conexion->consulta($strQuery);
                    $row = [];
                }
            }
            $jsondata['data'] = $row;
        }
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($jsondata);
        break;
}