<?php

class DB_mysql extends Variables
{
    var $Conexion_ID = 0;
    var $Consulta_ID = 0;
    var $Errno = 0;
    var $Error = "";
    var $msjError = 'ERROR al realizar la consulta';

    public function __construct($opc)
    {
        $this->opcion($opc);
        $this->Conexion_ID = mysqli_connect($this->Servidor, $this->Usuario, $this->Clave, $this->BaseDatos);

        if (!$this->Conexion_ID) {
            $this->Error = "Ha fallado la conexión.";
            return 0;
        }
        mysqli_set_charset($this->Conexion_ID, 'utf8');
        return $this->Conexion_ID;
    }

    function escapar_variable($var)
    {
        $var = @mysqli_real_escape_string($var);
        return $var;
    }

    public function consulta($sql = "")
    {
        if ($sql == "") {
            $this->Error = "No ha especificado una consulta SQL";
            return 0;
        }

        $this->Consulta_ID = @mysqli_query($this->Conexion_ID, $sql);

        if (!$this->Consulta_ID) {
            $this->Errno = mysqli_errno($this->Conexion_ID);
            $this->Error = mysqli_error($this->Conexion_ID);
            $this->msjError = mysqli_error($this->Conexion_ID);
        }
        return $this->Consulta_ID;
    }

    public function conteoconsulta($sql)
    {
        if ($this->consulta($sql) == 0) {
            echo $this->msjError;
            exit(0);
        }
        return mysqli_num_rows($this->Consulta_ID);
    }

    /* Devuelve el el ultimo id insertado */

    public function obtenerconexion()
    {
        return $this->Conexion_ID;
    }

    public function ultimoid()
    {
        return mysqli_insert_id($this->Conexion_ID);
    }

    /* Devuelve el número de campos de una consulta */

    public function numcampos()
    {
        return mysqli_num_fields($this->Consulta_ID);
    }

    /* Devuelve el número de registros de una consulta */

    public function numregistros()
    {
        return mysqli_num_rows($this->Consulta_ID);
    }

    /* Devuelve el nombre de un campo de una consulta */

    public function nombrecampo($numcampo)
    {
        return mysqli_field_name($this->Consulta_ID, $numcampo);
    }

    /* Muestra los datos de una consulta */

    public function verconsulta($sql)
    {
        if ($this->consulta($sql) == 0) {
            echo $this->msjError;
            exit(0);
        }

        echo "<table border=1>\n";
        // mostramos los nombres de los campos
        for ($i = 0; $i < $this->numcampos(); $i++) {
            echo "<td><b>" . $this->nombrecampo($i) . "</b></td>\n";
        }
        echo "</tr>\n";
        // mostrarmos los registros
        while ($row = mysqli_fetch_row($this->Consulta_ID)) {
            echo "<tr> \n";
            for ($i = 0; $i < $this->numcampos(); $i++) {
                echo "<td>" . $row[$i] . "</td>\n";
            }
            echo "</tr>\n";
        }
    }

    public function obtenerlista($sql)
    {
        if (!$consulta = $this->consulta($sql)) {
            echo $this->msjError;
            return $consulta;
        }

        $array = [];
        while ($row = mysqli_fetch_object($this->Consulta_ID)) {
            $array[] = $row;
        }
        if (count($array) == 0) return -1;
        return $array;
    }

    public function consultadato($sql)
    {
        if (!$respuesta = $this->consulta($sql)) {
            return -1;
        }
        // mostrarmos los registros
        $row = mysqli_fetch_array($this->Consulta_ID);
        return $row[0];
    }

    public function consultaregistro($sql)
    {
        if ($this->consulta($sql) == 0) {
            echo $this->msjError;
            echo '<br>' . $this->Error;
            echo '<br>' . $sql;
            exit(0);
        }
        // mostrarmos los registros
        $row = mysqli_fetch_array($this->Consulta_ID);
        return $row[0];
    }

    public function consultaexistencia($sql)
    {
        if ($this->consulta($sql) == 0) {
            echo $this->msjError;
            exit(0);
        }
        // mostrarmos los registros
        $row = mysqli_fetch_array($this->Consulta_ID);
        //identifica si existen datos para enviar el ID de lo contrario regresa cero
        if ($this->numregistros() >= 1)
            return $row[0];
        else
            return 0;
    }

    public function fetch_array($sql)
    {
        if (!$this->consulta($sql)) {
            echo $this->msjError;
            echo '<br>' . $this->Error;
            exit(0);
        }
        // mostrarmos los registros
        return mysqli_fetch_array($this->Consulta_ID);
    }

    public function fetch_array_assoc($sql)
    {
        if (!$this->consulta($sql)) {
            echo $this->msjError;
            echo '<br>' . $this->Error;
            exit(0);
        }
        return mysqli_fetch_assoc($this->Consulta_ID);
    }


    public function fetch_objet($sql)
    {
        if (!$this->consulta($sql)) {
            echo $this->msjError;
            exit(0);
        }
        // mostrarmos los registros
        return mysqli_fetch_object($this->Consulta_ID);
    }

    //cerrar coexion
    public function cerrarconexion()
    {
        @mysqli_free_result($this->Consulta_ID);
        @mysqli_close($this->Conexion_ID);

    }

    public function liberarResultados()
    {
        @mysqli_free_result($this->Consulta_ID);
        @mysqli_next_result($this->Conexion_ID);
    }
} //fin de la Clse DB_mysql
?>
