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
}