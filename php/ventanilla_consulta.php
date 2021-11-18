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
      $id =  isset($_SESSION['vUsuario']) ? $_SESSION['vUsuario']['id_turista'] : -1;
      $strQuery = $querys->getListSolicitudByUsuario($id, $_POST['tipo']);
        if(!$Query = $conexion->obtenerlista($strQuery)) {
            $jsondata['resp'] = 0;
            $jsondata['data'] = $strQuery;            
        }
        else {
            if($Query==-1) $array = array();
            else {
                $data = array();

                foreach($Query as $row) {
                    $columna5 = "";
                    if ((int)$row->id_etapa_queja === 2) {
                        $columna5 = "<div class='btn-group'>";
                        $columna5 .= "<button type='button' class='btn btn-info'>Acciones</button>";
                        $columna5 .= "<button type='button' class='btn btn-info dropdown-toggle dropdown-icon' data-toggle='dropdown' >";
                        $columna5 .= "<span class='sr-only'>Toggle Dropdown</span>";
                        $columna5 .= "<div class='dropdown-menu' role='menu'>";
                        if ((int)$row->id_etapa_queja === 2)
                            $columna5 .= "<a class='dropdown-item' href='#' onclick='parent.open_modal_seguimiento(" . $row->id_solicitud_queja . ")'>Confirmar notificacion</a>";
                        $columna5 .= "</div>";
                        $columna5 .= "</button>";
                        $columna5 .= "</div>";
                    }

                    $sub_array = array();
                    $sub_array[] = $row->folio;
                    $sub_array[] = $row->nombre. " ". $row->apellidos;
                    $sub_array[] = $row->etapa." - Nombre de la etapa";
                    $sub_array[] = $columna5;
                    $data[] = $sub_array;
                }
                $jsondata = array(
                    'data' => $data
                );
            }
        }
        
    break;
    case 2:
        $strQuery = "SELECT * FROM vw_mantenimiento WHERE ISNULL(fecha_eliminado);";        
        if(!$Query = $conexion->obtenerlista($strQuery)){
            $jsondata['resp'] = 0;
            $jsondata['data'] = $strQuery;
        }
        else{
            if($Query==-1) $array = array();
            else $array = $Query;
            $jsondata['resp'] = 1;
            $jsondata['data'] = $array;
        }
    break;
    case 3:
        $strWhere = 'id_estado ='.$_POST['id_estado'];
        $combo = @$conexion->obtenerlista($querys->getListCombo("tblc_municipio","id_municipio id,
        nombre valor,CONCAT_WS(';',id_municipio,coordenadas) dataId",$strWhere));        
        $jsondata['resp'] = 1;
		$jsondata['data'] = $funcionesB->llenarcomboMJson($combo,0);
    break;
    case 4:
        $strWhere = 'id_municipio ='.$_POST['id_municipio'];
        $combo = @$conexion->obtenerlista($querys->getListCombo("tblc_colonia","id_colonia id,
        nombre valor,CONCAT_WS(';',id_colonia,cp) dataId",$strWhere));
        $jsondata['resp'] = 1;
		$jsondata['data'] = $funcionesB->llenarcomboMJson($combo,0);
    break;
    case 5:
        $strQuery = "SELECT * FROM vw_pagos WHERE ISNULL(fecha_eliminado);";        
        if(!$Query = $conexion->obtenerlista($strQuery)){
            $jsondata['resp'] = 0;
            $jsondata['data'] = $strQuery;            
        }
        else{
            if($Query==-1) $array = array();
            else $array = $Query;
            $jsondata['resp'] = 1;
            $jsondata['data'] = $array;
        }
    break;
    case 6:
        $strQuery = "SELECT * FROM vw_combustible WHERE ISNULL(fecha_eliminado);";        
        if(!$Query = $conexion->obtenerlista($strQuery)){
            $jsondata['resp'] = 0;
            $jsondata['data'] = $strQuery;            
        }
        else{
            if($Query==-1) $array = array();
            else $array = $Query;
            $jsondata['resp'] = 1;
            $jsondata['data'] = $array;
        }
    break;
    case 7:
        $strQuery = "SELECT * FROM vw_cobros WHERE ISNULL(fecha_eliminado);";        
        if(!$Query = $conexion->obtenerlista($strQuery)){
            $jsondata['resp'] = 0;
            $jsondata['data'] = $strQuery;            
        }
        else{
            if($Query==-1) $array = array();
            else $array = $Query;
            $jsondata['resp'] = 1;
            $jsondata['data'] = $array;
        }
    break;
    case 8:
        $strQuery = "SELECT * FROM tblc_catalago_detalle ";
        $strQuery .= "WHERE id_catalago = " . $_POST['id_catalogo'];
        $strQuery .= " AND listar = 1;";
        $consulta = $conexion->obtenerlista($strQuery);
        $campos = '';
        $nombreCampos='';
        $contador = 0;
        foreach($consulta as $item){
            $contador += 1;
            if($item->tipo == 'date') $campos .= ($contador==1)?'DATE_FORMAT('.$item->nombre_campo.',"%d/%m/%Y") ' . $item->nombre_campo:',DATE_FORMAT('.$item->nombre_campo.',"%d/%m/%Y")'. $item->nombre_campo;
            else $campos .= ($contador==1)?$item->nombre_campo:','.$item->nombre_campo;
            $nombreCampos .= ($contador==1)?$item->campo:','.$item->campo;
        }
        $campos .= ",".$_POST['id'];
        $strQuery = "SELECT " . $campos . " FROM " . $_POST['tabla'];
        $strQuery .= " WHERE ISNULL(fecha_eliminado);";
        if($Query = $conexion->obtenerlista($strQuery)){
            $jsondata['resp'] = 1;
            $jsondata['data'] = $Query;
            $jsondata['campos'] = $nombreCampos;
        }
        else{
            $jsondata['resp'] = 0;
            $jsondata['data'] = $strQuery;
            $jsondata['campos'] = $nombreCampos;
        }        
    break;
    case 9:
        $strQuery = "SELECT * FROM tblc_catalago_detalle ";
        $strQuery .= "WHERE id_catalago = " . $_POST['id_catalogo'];
        $strQuery .= " AND formulario = 1;";
        if($Query = $conexion->obtenerlista($strQuery)){
            if($_POST['id']>0){
                $strQuery2 = "SELECT * FROM " . $_POST['tabla'] . " WHERE " . $_POST['nCampo'] ." = " . $_POST['id'];
                $Query2 = $conexion->obtenerlista($strQuery2);
                foreach($Query as $item){
                    if($item->tipo == 'select'){                        
                        $valorCT = get_object_vars($Query2[0]);
                        $strWhere = 'ISNULL(fecha_eliminado)';
                        $combo = @$conexion->obtenerlista($querys->getListCombo($item->tabla_combo,$item->campos_combo,$strWhere));
                        $jsondata[$item->nombre_campo] = $funcionesB->llenarcomboMJson($combo,$valorCT[$item->nombre_campo]);
                    }
                }
            }
            else{
                $Query2 = array();
                foreach($Query as $item){
                    if($item->tipo == 'select'){                        
                        $strWhere = 'ISNULL(fecha_eliminado)';
                        $combo = @$conexion->obtenerlista($querys->getListCombo($item->tabla_combo,$item->campos_combo,$strWhere));
                        $jsondata[$item->nombre_campo] = $funcionesB->llenarcomboMJson($combo,0);
                    }
                }
            }
            $jsondata['resp'] = 1;
            $jsondata['data'] = $Query;
            $jsondata['dataF'] = $Query2;
            $jsondata['id'] = $_POST['id'];
        }
        else{
            $jsondata['resp'] = 0;
            $jsondata['data'] = $strQuery;
            $jsondata['dataF'] = array();
            $jsondata['id'] = 0;
        }        
    break;
    case 10:
        $id_seguro = $funcionesB->limpia($_POST['id_seguro']);
        $strQuery = "SELECT * FROM vw_seguros WHERE ISNULL(fecha_eliminado)";
        $strQuery .= ($id_seguro > 0)?" AND id_unidad = " . $id_seguro.";":";";
        if(!$Query = $conexion->obtenerlista($strQuery)){
            $jsondata['resp'] = 0;
            $jsondata['data'] = $strQuery;
        }
        else{
            if($Query==-1) $array = array();
            else $array = $Query;            
            $jsondata['resp'] = 1;
            $jsondata['data'] = $array;
            $jsondata['query'] = $strQuery;
        }      
    break;
    case 11:
        $id_man = $funcionesB->limpia($_POST['idMan']);
        $strQuery = "CALL sp_NotificacionesM(". $id_man .");";
        
        if(!$Query = $conexion->obtenerlista($strQuery)){
            $jsondata['resp'] = 0;
            $jsondata['data'] = $strQuery;
        }
        else{
            if($Query==-1) $array = array();
            else $array = $Query;            
            $jsondata['resp'] = 1;
            $jsondata['data'] = $array;
        }
        $conexion->liberarResultados();        
    break;
}
echo json_encode($jsondata);

function formatoFecha($date){
    $fecha = substr($date,0,10);
    $fechaArray = explode('-',$fecha);
    $newDate = $fechaArray[2] . '/' . $fechaArray[1] . '/' . $fechaArray[0];
    return $newDate;
  }
  function formatoHora($date){
    $hora = substr($date,11,19);
    return $hora;
  }

?>