<?Php
	@session_start();
    ini_set('display_errors', '0');
    if(isset($_SESSION["autentificado_sis"])) {
        $autenticado_sis = $_SESSION["autentificado_sis"];
        $vUsuario = $_SESSION["vUsuario"];
        $id_acceso = $_SESSION['id_acceso'];
    }
    else {
        echo'<script languaje="javascript">
				var msg = alert("Su sesión expiro");
				location.href="index.php";
			</script>';
        exit(0);
    }
    require ("php/clase_variables.php");
	require ("php/clase_mysql.php");
	require ("php/clase_funciones.php");
    require ('php/clase_querys.php');

    $funcionesB = new FuncionesB();
    $idConexion = (isset($_SESSION["idConexion"])) ? $_SESSION["idConexion"] : 1;
	$conexion  = new DB_MySql(1);
    $querys     = new QuerysB();

    $modules = [
      'queja',
      'denuncia',
      'conciliacion'
    ];

    if($autenticado_sis == md5("sistemaventanilla")){
        $url = isset($_GET['url']) ? $_GET['url'] : 'inicio';
        $modulo = in_array($url, $modules) ? $url : 'inicio';
        $permiso = 1;
    } else {
        @session_destroy();
        $conexion->cerrarconexion();
        echo'<script languaje="javascript">
				var msg = alert("Acceso Denegado");
				location.href="index.php";
			</script>';
        exit(0);
    }
?>
