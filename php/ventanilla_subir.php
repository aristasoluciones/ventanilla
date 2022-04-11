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
    $data = json_decode(file_get_contents('php://input'), true);
    if(isset($data['opcion'])) $_POST = $data;
	switch($_POST['opcion']) {
        case 1:
            $id = $_POST['id'];
            $tipo = $_POST['tipo'];
            $path_base = $funciones->mainDocRoot();
            $path_base = str_replace('\\', '/', $path_base)."/turismo";
            $carpeta_destino = 'archivos/ventanilla/quejas_denuncias';
            $dir_destino = $path_base . $carpeta_destino;
            if (!is_dir($dir_destino))
                mkdir($dir_destino, 0777, true);

            $sql = "SELECT evidencia from tbl_solicitud_queja
                    WHERE id_solicitud_queja = '" . $id . "' ";
            $current = $conexion->fetch_objet($sql);
            $archivos = $current->evidencia != '' ? json_decode($current->evidencia, true) : [];
            $archivos = is_array($archivos) ? $archivos : [];
            if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $file_name = $_FILES['file']['name'];
                $extension_name = explode('.', $file_name);
                $extension = end($extension_name);
                $id_archivo = uniqid();
                $path = "/" . $carpeta_destino . "/" . $tipo . "_" . $id_archivo . '.' . $extension;

                if (!isset($archivos[$tipo]))
                    $archivos[$tipo] = [];

                if (move_uploaded_file($_FILES['file']['tmp_name'], $path_base . $path)) {
                    $cad['id'] = $id_archivo;
                    $cad['tipo'] = ucfirst(strtolower($tipo));
                    $cad['title'] = $file_name;
                    $cad['path'] = $path;
                    $cad['validado'] = false;
                    array_push($archivos[$tipo], $cad);

                    $archivos_json = count($archivos) ? "'" . json_encode($archivos) . "'" : 'NULL';
                    $sql = "UPDATE tbl_solicitud_queja SET evidencia = " . $archivos_json . " WHERE id_solicitud_queja= '" . $id . "' ";
                    $conexion->consulta($sql);
                }
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($archivos);
        break;
        case 2:
            $solicitud =  $_POST['manifestacion'];
            $id_localidad_hecho = isset($solicitud['id_localidad_hecho'])
                ? $funciones->limpia($solicitud['id_localidad_hecho'])
                : '';

            $id_establecimiento_hecho = $solicitud['id_establecimiento_hecho'] === ''
                ? 0
                : $funciones->limpia($solicitud['id_establecimiento_hecho']);

            $id_municipio_seg = isset($solicitud['id_municipio_direccion'])
                ? $funciones->limpia($solicitud['id_municipio_direccion'])
                : '';

            $strQuery = "CALL sp_ventanillaActualizarPrevencion(";
            $strQuery .= "'" . $solicitud['id_solicitud_queja'] . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['id_pais']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['nombre']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['apellidos']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['telefono']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['fecha_nacimiento_fm']) . "',";
            $strQuery .= "'" . $id_municipio_seg . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['calle_numero_seguimiento']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['colonia_seguimiento']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['cp_seguimiento']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['fecha_queja_fm']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['descripcion_hecho']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['id_municipio_hecho']) . "',";
            $strQuery .= "'" . $id_localidad_hecho. "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['referencia_hecho']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['coordenada_lugar_hecho']) . "',";
            $strQuery .= "'" . $id_establecimiento_hecho . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['nombre_establecimiento']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['estado_turista']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['municipio_turista']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['colonia_turista']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['calle_numero_turista']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['cp_turista']) . "',";
            $strQuery .= "'" . $funciones->limpia($solicitud['propuesta_solucion']) . "',";
            $strQuery .= "'" . json_encode($solicitud['evidencia']). "',";
            $strQuery .= "@idRegistro)";
            if ($conexion->consulta($strQuery) == 0) {
                $jsondata['resp'] = 0;
                $jsondata['msg'] = $strQuery;
            } else {
                $jsondata['resp'] = 1;
                $id = $funciones->limpia($solicitud['id_solicitud_queja']);
                $row = $conexion->fetch_objet($querys->getSolicitud($id));
                $jsondata['data'] = $row;
            }
            echo json_encode($jsondata);
        break;
    }
?>