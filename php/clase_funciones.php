<?php
require_once("clase_variables.php");
require_once("clase_mysql.php");
require_once('tcpdf/tcpdf.php');

class FuncionesB
{
    var $conexion = 0;

    public function webRoot()
    {
        $http_host = $_SERVER['HTTP_HOST'];
        return $http_host !== 'ventanilla.test'
            ? 'https://'.$http_host
            : "http://" . $http_host;
    }

    public function llenarcombo($resultados, $id, $inicio = 0)
    {
        // mostrarmos los registros
        if ($inicio == 0) echo '<option data-id="0;0" value="">Seleccionar...</option>';
        foreach ($resultados as $resultado) {
            $dataId = (isset($resultado->dataId)) ? 'data-id="' . $resultado->dataId . '"' : '';
            if ($id == $resultado->id) {
                echo '<option ' . $dataId .
                    ' value="' . $resultado->id . '" selected="selected">' .
                    $this->cdetectUtf8($this->MayusMin($resultado->valor)) . '</option>';
            } else {
                echo '<option ' . $dataId .
                    ' value="' . $resultado->id . '">' .
                    $this->cdetectUtf8($this->MayusMin($resultado->valor)) . '</option>';
            }
        }
    }

    public function llenarcomboM($resultados, $id)
    {
        $porciones = explode(",", $id);
        // mostrarmos los registros
        echo '<option data-id="0;0" value="">Seleccionar...</option>';
        foreach ($resultados as $resultado) {
            if (in_array($resultado->id, $porciones)) {
                echo '<option data-id="' . $resultado->dataId .
                    '" value="' . $resultado->id . '" selected="selected">' .
                    $this->cdetectUtf8($this->MayusMin($resultado->valor)) . '</option>';
            } else {
                echo '<option data-id="' . $resultado->dataId .
                    '" value="' . $resultado->id . '">' .
                    $this->cdetectUtf8($this->MayusMin($resultado->valor)) . '</option>';
            }
        }
    }

    public function llenarcomboMJson($resultados, $id)
    {
        $porciones = explode(",", $id);
        // mostrarmos los registros
        $combo = array();
        foreach ($resultados as $resultado) {
            if (in_array($resultado->id, $porciones)) {
                $valor = '<option data-id="' . $resultado->dataId .
                    '" value="' . $resultado->id . '" selected="selected">' .
                    $this->cdetectUtf8($this->MayusMin($resultado->valor)) . '</option>';
                array_push($combo, $valor);
            } else {
                $valor = '<option data-id="' . $resultado->dataId .
                    '" value="' . $resultado->id . '">' .
                    $this->cdetectUtf8($this->MayusMin($resultado->valor)) . '</option>';
                array_push($combo, $valor);
            }
        }
        return $combo;
    }

    function cdetectUtf8($str)
    {
        if (mb_detect_encoding($str, "UTF-8, ISO-8859-1") != "UTF-8") {

            return utf8_encode($str);
        } else {
            return $str;
        }

    }

    //limpia cadena para evitar inyeccion SQL
    public function limpia($var)
    {
        $var = strip_tags($var);
        $malo = array("\\", ";", "+", "\'", "'", "$", "%", "!", "(", ")", '"', "*", "{", "}", "xor", "XOR", "FROM", "from", "WHERE", "where", "ORDER", "order", "GROUP", "group", "by", "BY", "UPDATE", "update", "DELETE", "delete", ".php", ".asp", ".aspx", ".html", ".xml", ".js", ".css", ".exe", ".tar", ".rar", ".ocx"); // Aqui poner caracteres no permitidos
        $i = 0;
        $o = count($malo);
        $o = $o - 1;
        while ($i <= $o) {
            $var = str_replace($malo[$i], "", $var);
            $i++;
        }

        return $var;
    }

    public function sanear_string($string)
    {

        $string = trim($string);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "~",
                "#", "@", "|", "!", "\"",
                "·", "$", "%", "&", "/",
                "(", ")", "?", "'", "¡",
                "¿", "[", "^", "`", "]",
                "+", "}", "{", "¨", "´",
                ">", "< ", ";", ",", ":",
                ".", "'", '"', '“', '”'),
            '',
            $string
        );


        return $string;
    }

    //funcion para dar formato de mayusculas y minusculas
    public function MayusMin($cadena)
    {
        $excepciones1 = array('de', 'para', 'en', 'y', 'con');
        $excepciones2 = array('DE', 'PARA', 'EN', 'Y', 'CON');
        $cadenaArray = explode(' ', $cadena);
        $nuevaCadena = "";
        $contador = 0;
        foreach ($cadenaArray as $item) {
            if ((!in_array($item, $excepciones1) && !in_array($item, $excepciones2)) || $contador == 0) {
                $primerLetra = substr($item, 0, 1);
                $primerLetra = strtoupper($primerLetra);
                $caracteresFaltantes = substr($item, 1);
                $caracteresFaltantes = strtolower($caracteresFaltantes);
                $caracteresFaltantes = str_replace(
                    array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'),
                    array('á', 'é', 'í', 'ó', 'ú', 'ñ'),
                    $caracteresFaltantes
                );
                $nuevaCadena .= $primerLetra . $caracteresFaltantes . ' ';
            } else {
                $item = str_replace(
                    array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'),
                    array('á', 'é', 'í', 'ó', 'ú', 'ñ'),
                    $item
                );
                $nuevaCadena .= strtolower($item) . ' ';
            }
            $contador += 1;
        }
        return substr($nuevaCadena, 0, -1);
    }

    public function mes_nombre($mes)
    {

        switch ($mes) {
            case 1:
                $mes = 'Enero';
                break;
            case 2:
                $mes = 'Febrero';
                break;
            case 3:
                $mes = 'Marzo';
                break;
            case 4:
                $mes = 'Abril';
                break;
            case 5:
                $mes = 'Mayo';
                break;
            case 6:
                $mes = 'Junio';
                break;
            case 7:
                $mes = 'Julio';
                break;
            case 8:
                $mes = 'Agosto';
                break;
            case 9:
                $mes = 'Septiembre';
                break;
            case 10:
                $mes = 'Octubre';
                break;
            case 11:
                $mes = 'Noviembre';
                break;
            case 12:
                $mes = 'Diciembre';
                break;
        }
        return $mes;
    }

    // FUNCION PARA GENERAR CONTRASEÑAS

    function create_password($pwd)
    {
        $opciones = [
            'cost' => 12,
        ];
        $pwd = 'sisSiga' . $pwd;
        return password_hash($pwd, PASSWORD_BCRYPT, $opciones);
    }

    function verifica_password($pwd, $hash)
    {
        $pwd = 'sisVentanilla' . $pwd;
        return password_verify($pwd, $hash);
    }

    //Obtiene la ip real
    function getRealIP()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $this->limpia($_SERVER["HTTP_CLIENT_IP"]);
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $this->limpia($_SERVER["HTTP_X_FORWARDED_FOR"]);
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            $ip = $this->limpia($_SERVER["HTTP_X_FORWARDED"]);
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            $ip = $this->limpia($_SERVER["HTTP_FORWARDED_FOR"]);
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            $ip = $this->limpia($_SERVER["HTTP_FORWARDED"]);
        } else {
            $ip = $this->limpia($_SERVER["REMOTE_ADDR"]);
        }

        return $ip;
    }

    function getBrowser()
    {
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $navegadores = array(
            'Opera' => 'Opera',
            'Mozilla Firefox' => '(Firebird)|(Firefox)',
            'Google Chrome' => 'Chrome',
            'Galeon' => 'Galeon',
            'Mozilla' => 'Gecko',
            'MyIE' => 'MyIE',
            'Lynx' => 'Lynx',
            'Google Chrome' => 'Chrome',
            'Konqueror' => 'Konqueror',
            'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
            'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
            'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
            'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
            'Internet Explorer' => 'MSIE',
            'Flock' => 'Flock',
            'Shiira' => 'Shiira',
            'Chimera' => 'Chimera',
            'Phoenix' => 'Phoenix',
            'Camino' => 'Camino',
            'Netscape' => 'Netscape',
            'OmniWeb' => 'OmniWeb',
            'Safari' => 'Safari',
            'icab' => 'iCab',
            'Links' => 'Links',
            'hotjava' => 'HotJava',
            'amaya' => 'Amaya',
            'IBrowse' => 'IBrowse'
        );

        foreach ($navegadores as $navegador => $pattern) {
            if (strpos($user_agent, $pattern) !== false) return $this->limpia($navegador);
        }

    }

    function getOs()
    {
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

        $plataformas = array(
            '/windows nt 10.0/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile WebOS'
        );

        foreach ($plataformas as $regex => $plataforma) {

            if (preg_match($regex, $user_agent)) {
                return $this->limpia($plataforma);
            }
        }

        return 'sistema operativo desconocido';
    }

    function llenaMenu($id, $permisos)
    {
        $this->conexion = new DB_mysql(1);
        foreach ($permisos as $list2) {
            if ($list2->hijo > 0) {
                $query = 'CALL sp_UsuariosPermisos(' . $id . ',' . $list2->id_permiso . ');';
                $permisosPUH = $this->conexion->obtenerlista($query);
                $this->llenaSMenuC($list2);
                $this->llenaMenu($id, $permisosPUH);
            } else {
                $htmlM = '<div class="col-xs-3 form-group">';
                $htmlM .= '<div class="classCheck icheck">';
                $htmlM .= '<label>';
                $htmlM .= '<input id="' . $list2->id_permiso . ';';
                $htmlM .= $list2->id_padre . '" name="';
                $htmlM .= $list2->id_permiso . ';';
                $htmlM .= $list2->id_padre . '" type="checkbox" ';
                $htmlM .= ($list2->id_usuario > 0) ? 'checked' : '';
                $htmlM .= '/>';
                $htmlM .= ' ' . $list2->nombre;
                $htmlM .= '</label>';
                $htmlM .= '</div>';
                $htmlM .= '</div>';
                echo $htmlM;
            }
            $this->conexion->liberarResultados();
            unset($permisosPUH);
        }
        //$this->conexion->cerrarconexion();
        $htmlM = '</div>';
        $htmlM .= '</div>';
        echo $htmlM;
    }

    function llenaMenuC($list)
    {
        $htmlM = '<div class="row">';
        $htmlM .= '<div class="col-xs-12 box box-success">';
        $htmlM .= '<div class="box-header">';
        $htmlM .= '<h3 class="box-title"><b>' . $list->nombre . '</b></h3>';
        $htmlM .= '</div>';
        echo $htmlM;
    }

    function llenaSMenuC($list)
    {
        $htmlM = '<div class="row">';
        $htmlM .= '<div class="col-xs-12">';
        $htmlM .= '<div class="box-header">';
        $htmlM .= '<h3 class="box-title">   ' . $list->nombre . '</h3>';
        $htmlM .= '</div>';
        echo $htmlM;
    }

    public function realDocRoot() {
        return realpath($_SERVER['DOCUMENT_ROOT']);
    }
    public function mainDocRoot() {
        return dirname($this->realDocRoot());
    }

    public function validarExistenciaArchivo ($files, $tipo = 1) {
        $filtrado = [];

        if (!is_array($files))
            return $filtrado;

        $pathBase = $this->mainDocRoot();
        $pathBase = $pathBase === '/var/www/vhosts/plataformasecturchiapas.mx'
            ? $pathBase.'/httpdocs'
            : $pathBase;

        $pathBase = str_replace('\\', '/', $pathBase)."/turismo";
        if ($tipo == 1) {
            foreach ($files as $key => $evidencia) {
                $evidencia = !is_array($evidencia) ? [] : $evidencia;
                foreach ($evidencia as $item) {
                    if (is_file($pathBase.$item['path'])) {
                        if (!isset($filtrado[$key]))
                            $filtrado[$key] = [];
                        array_push($filtrado[$key], $item);
                    }
                }
            }
            return $filtrado;
        }

        foreach ($files as $key => $evidencia) {
            if (is_file($pathBase.$evidencia['path'])) {
                if (!is_array($filtrado))
                    $filtrado = [];
                array_push($filtrado, $evidencia);
            }
        }
        return $filtrado;
    }

}

?>
