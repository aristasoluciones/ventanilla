<?php

class QuerysB
{
    public function getListSolicitudByUsuario($data, $tipo) {

      $strQuery  = "SELECT a.id_solicitud_queja,a.folio, a.nombre, a.apellidos, a.fecha_queja,
                  a.id_etapa_queja, c.nombre as nacionalidad, d.nombre as etapa, b.nombre as lugar,e.nombre as localidad
                  FROM tbl_solicitud_queja  a
                  INNER JOIN tblc_municipio b ON a.id_municipio_hecho = b.id_municipio
                  INNER JOIN tblc_localidad_delegacion e ON a.id_localidad_hecho = e.id_localidad_delegacion
                  LEFT JOIN tblc_pais c ON a.id_pais = c.id_pais
                  LEFT JOIN tblc_etapa_queja d ON a.id_etapa_queja = d.id_etapa_queja
                  WHERE ISNULL(a.fecha_eliminado) and (a.id_turista = '".$data['id_turista']."' and a.correo='".$data['correo']."') 
                  AND a.id_tipo_queja = '".$tipo."' ";
        return $strQuery;
    }

    public function getSolicitud($id) {
        $strQuery  = "SELECT a.*, b.nombre tipo_queja FROM tbl_solicitud_queja a 
                  INNER JOIN tblc_tipo_queja b ON a.id_tipo_queja=b.id_tipo_queja
                  WHERE a.id_solicitud_queja = '". $id."'";
        return $strQuery;
    }

    function existeEmailFolio($email = '', $folio = '')
    {
        $sentencia = " AND u.correo = '" . $email . "'";
        $sentencia .= " AND u.folio = '" . $folio . "'";
        $strQuery = "SELECT u.* ";
        $strQuery .= "FROM tbl_solicitud_queja u ";
        $strQuery .= "WHERE u.estatus = 1 " . $sentencia;
        return $strQuery;
    }

    //Obtiene permiso de los usuarios por módulo
    function obtenerPermisoModulo($idUsuario, $modulo)
    {
        $strQuery = "SELECT COUNT(up.id_permiso) AS PERMISO ";
        $strQuery .= "FROM tbl_usuario_permiso up ";
        $strQuery .= "JOIN tblc_permiso p ";
        $strQuery .= "ON(up.id_permiso = p.id_permiso) ";
        $strQuery .= "WHERE up.id_usuario = " . $idUsuario . " AND p.archivo LIKE '%" . $modulo . "%'";

        return $strQuery;
    }

    //---------------------------TABLA PERMISO-----------------------------
    function permisosmenuusuario($id_usuario_sis)
    {
        $strQuery = "SELECT DISTINCT up.id_permiso as id, p.* FROM tblc_permiso AS p";
        $strQuery .= " INNER JOIN tbl_usuario_permiso AS up ON p.id_permiso = up.id_permiso";
        $strQuery .= "  WHERE up.id_usuario =" . $id_usuario_sis . " AND p.id_padre = 0 AND p.estatus = 1 ORDER BY p.orden";

        return $strQuery;
    }

    // Obtiene los hijos del menu
    function permisosubmenuusuario($id_usuario_sis, $idpadre)
    {
        $strQuery = "SELECT DISTINCT up.id_permiso as id, p.* FROM tblc_permiso AS p";
        $strQuery .= " INNER JOIN tbl_usuario_permiso AS up ON p.id_permiso = up.id_permiso";
        $strQuery .= " WHERE up.id_usuario = " . $id_usuario_sis . " AND p.id_padre = " . $idpadre . " AND p.estatus = 1 ORDER BY p.orden";

        return $strQuery;
    }

    // Cuenta los hijos del menu
    function Conteopermisosubmenuusuariomodulo($id_usuario_sis, $idpadre)
    {
        $strQuery = "SELECT COUNT(up.id_permiso) FROM tblc_permiso AS p";
        $strQuery .= " INNER JOIN tbl_usuario_permiso AS up ON p.id_permiso = up.id_permiso";
        $strQuery .= " WHERE up.id_usuario =" . $id_usuario_sis . " AND p.id_padre = " . $idpadre . " AND p.estatus = 1;";

        return $strQuery;
    }

    public function getListCombo($tabla, $campos, $where = '')
    {
        $strQuery = "SELECT " . $campos . " FROM " . $tabla;
        $strQuery .= ($where != '') ? ' WHERE ' . $where : $where;
        $strQuery .= " ORDER BY valor";
        return $strQuery;
    }
}

?>
