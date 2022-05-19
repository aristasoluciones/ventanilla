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

    function existeEmailFolio($email = '', $folio = '')
    {
        $sentencia = " WHERE u.correo = '" . $email . "'";
        $sentencia .= " AND u.folio = '" . $folio . "'";
        $strQuery = "SELECT u.* ";
        $strQuery .= "FROM tbl_solicitud_queja u ";
        $strQuery .= $sentencia;
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
    public function getListHistoriaSolicitud($id) {

        $strQuery  = "SELECT a.id_solicitud_queja_seguimiento, 
                  DATE_FORMAT(a.fecha_registro, '%d/%m/%Y') as fecha, 
                  a.seguimiento, a.id_etapa_queja, 
                  c.nombre as nombre_usuario,
                  b.nombre as etapa,
                  a.id_usuario,
                  a.comentario_etapa,
                  a.tipo_usuario
                  FROM tbl_solicitud_queja_seguimiento a
                  INNER JOIN tblc_etapa_queja b ON a.id_etapa_queja = b.id_etapa_queja 
                  LEFT JOIN tbl_usuario c ON a.id_usuario = c.id_usuario 
                  WHERE a.fecha_eliminado is null and a.id_solicitud_queja = '".$id."' ORDER BY a.fecha_registro DESC";
        return $strQuery;
    }

    public function getUsuarioPrestadorDoSeguimiento($id) {
        $sql = "SELECT nombre, apellidos  FROM tbl_solicitud_queja_seguimiento a
            INNER JOIN tbl_establecimiento_usuario b ON a.id_usuario = b.id_establecimiento_usuario
            WHERE id_solicitud_queja_seguimiento= '".$id."' ";
        return $sql;
    }
    public function getTotalSolicitud ($tipo = 0) {
        $strFiltro = $tipo ? " and a.id_tipo_queja = '".$tipo."' " : "";

        $strQuery = "SELECT count(a.id_solicitud_queja) total
                     FROM (select sa.*, sb.tipo from tbl_solicitud_queja sa join tblc_tipo_queja sb on sa.id_tipo_queja=sb.id_tipo_queja)  a
                     LEFT JOIN tblc_municipio b ON a.id_municipio_hecho = b.id_municipio
                     LEFT JOIN tblc_localidad_delegacion e ON a.id_localidad_hecho = e.id_localidad_delegacion
                     LEFT JOIN tblc_pais c ON a.id_pais = c.id_pais
                     LEFT JOIN tblc_etapa_queja d ON a.id_etapa_queja = d.id_etapa_queja
                     WHERE ISNULL(a.fecha_eliminado) ".$strFiltro."  AND a.id_turista='".$_SESSION['vUsuario']['id_turista']."' ";
        return $strQuery;
    }

    public function getListSolicitud($inicio, $limite, $tipo = 0) {
        $strFiltro = $tipo ? " and a.id_tipo_queja = '".$tipo."' " : "";

        $strQuery  = "SELECT a.id_solicitud_queja,a.folio, a.nombre, a.apellidos, date_format(a.fecha_queja, '%d/%m/%Y') fecha_queja,
                  a.id_etapa_queja, c.nombre as nacionalidad, d.nombre as etapa, b.nombre as lugar,e.nombre as localidad,
                  a.estatus, a.tipo, a.nombre_manifestacion, a.anonima,
                  (SELECT tipo_respuesta_etapa 
                    FROM tbl_solicitud_queja_seguimiento
                    WHERE id_solicitud_queja = a.id_solicitud_queja order by id_solicitud_queja_seguimiento desc limit 1) as tipo_respuesta_etapa,  
                  IF(a.id_etapa_queja IN(8), 1, 0) finalizado
                  FROM (select sa.*, sb.tipo, sb.nombre nombre_manifestacion from tbl_solicitud_queja sa join tblc_tipo_queja sb on sa.id_tipo_queja=sb.id_tipo_queja)  a
                  LEFT JOIN tblc_municipio b ON a.id_municipio_hecho = b.id_municipio
                  LEFT JOIN tblc_localidad_delegacion e ON a.id_localidad_hecho = e.id_localidad_delegacion
                  LEFT JOIN tblc_pais c ON a.id_pais = c.id_pais
                  LEFT JOIN tblc_etapa_queja d ON a.id_etapa_queja = d.id_etapa_queja
                  WHERE ISNULL(a.fecha_eliminado) ".$strFiltro." AND a.id_turista='".$_SESSION['vUsuario']['id_turista']."' 
                  ORDER BY a.fecha_registro DESC ";
        $strQuery .= " LIMIT ".$inicio. ",".$limite;

        return $strQuery;
    }

    /*
     * @param int $id
     * return String $strQuery
     */
    public function getSolicitud($id) {
        $strQuery  = "SELECT 
                  a.id_solicitud_queja,
                  a.nombre,
                  a.apellidos,
                  a.correo,
                  a.telefono,
                  date_format(a.fecha_nacimiento, '%d/%m/%Y') fecha_nacimiento,
                  a.fecha_nacimiento fecha_nacimiento_fm,
                  a.calle_numero_seguimiento,
                  a.colonia_seguimiento,
                  a.cp_seguimiento,
                  date_format(a.fecha_queja, '%d/%m/%Y') fecha_queja,
                  a.fecha_queja fecha_queja_fm,
                  a.folio,
                  a.estatus,
                  a.id_etapa_queja,  
                  a.descripcion_hecho,
                  a.referencia_hecho,
                  a.propuesta_solucion,
                  a.coordenada_lugar_hecho,
                  a.tipo_seguimiento,
                  CASE a.tipo_seguimiento
                      WHEN 1 THEN 'Subrrogación de derechos'
                      WHEN 2 THEN 'Personal'
                  END AS nombre_tipo_seguimiento,
                  a.estado_turista,
                  a.municipio_turista,
                  a.calle_numero_turista,
                  a.colonia_turista,
                  a.cp_turista,
                  a.fmm_turista,
                  a.evidencia,  
                  a.id_municipio_hecho,
                  a.id_localidad_hecho,  
                  a.id_establecimiento_hecho,  
                  IF(a.id_establecimiento_hecho > 0, b.nombre, a.nombre_establecimiento_hecho) nombre_establecimiento,
                  b.correo correo_establecimiento,
                  b.nombre_representante,
                  b.direccion,
                  b.colonia,
                  b.razon_social,
                  b.rfc,
                  a.id_pais,  
                  c.nombre nombre_genero,
                  d.nombre nombre_municipio_seguimiento,
                  e.nombre nombre_municipio_hecho,
                  f.nombre nombre_queja,
                  f.tipo,
                  g.nombre nombre_pais,
                  (SELECT tipo_respuesta_etapa 
                    FROM tbl_solicitud_queja_seguimiento
                    WHERE id_solicitud_queja = a.id_solicitud_queja order by id_solicitud_queja_seguimiento desc limit 1) as tipo_respuesta_etapa, 
                  (SELECT JSON_OBJECT('subsanado', subsanado, 'fecha', fecha, 'seguimiento', seguimiento) 
                    FROM tbl_solicitud_queja_seguimiento
                    WHERE id_solicitud_queja = a.id_solicitud_queja order by id_solicitud_queja_seguimiento desc limit 1) as seguimiento_corriente,
                  (SELECT CONCAT('[',GROUP_CONCAT(
                          JSON_OBJECT(
                          'id_solicitud_queja_seguimiento', id_solicitud_queja_seguimiento,
                          'subsanado', subsanado, 
                          'fecha', fecha,
                          'id_etapa_queja', id_etapa_queja,
                          'seguimiento', seguimiento
                          )
                          ), ']') 
                    FROM tbl_solicitud_queja_seguimiento
                    WHERE id_solicitud_queja = a.id_solicitud_queja GROUP BY id_solicitud_queja order by id_solicitud_queja_seguimiento desc ) as pila_seguimiento, 
                  (select count(id_etapa_queja) from tblc_etapa_queja where id_tipo_queja=a.id_tipo_queja AND fecha_eliminado is null) as total_etapa,	
				  (select count(id_solicitud_queja_seguimiento) from tbl_solicitud_queja_seguimiento where id_solicitud_queja=a.id_solicitud_queja) as total_etapa_avanzada,
				  IF((select id_etapa_queja from tblc_etapa_queja where id_tipo_queja=a.id_tipo_queja AND fecha_eliminado is null ORDER BY orden DESC limit 1)=(select id_etapa_queja from tbl_solicitud_queja_seguimiento where id_solicitud_queja=a.id_solicitud_queja ORDER BY id_solicitud_queja_seguimiento DESC LIMIT 1), 1, 0) finalizado  
                  FROM tbl_solicitud_queja a
                  LEFT JOIN tbl_establecimiento b ON a.id_establecimiento_hecho = b.id_establecimiento
                  LEFT JOIN tblc_genero c ON a.id_genero = c.id_genero
                  LEFT JOIN tblc_municipio d ON a.id_municipio_seguimiento = d.id_municipio   
                  LEFT JOIN tblc_municipio e ON a.id_municipio_hecho = e.id_municipio  
                  INNER JOIN tblc_tipo_queja f ON a.id_tipo_queja = f.id_tipo_queja
                  LEFT JOIN tblc_pais g ON a.id_pais = g.id_pais
                  WHERE a.id_solicitud_queja = '". $id."' AND a.id_turista='".$_SESSION['vUsuario']['id_turista']."'";
        return $strQuery;
    }
}

?>
