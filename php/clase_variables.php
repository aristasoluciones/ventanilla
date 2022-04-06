<?php
require ("../config.php");
class Variables {
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;
	var $Puerto;
	public function opcion($opc){
		switch($opc){
			case 1:
				$this->Servidor = DB_HOST;
				$this->BaseDatos = DB_NAME;
				$this->Usuario =DB_USER;
				$this->Clave = DB_PASS;
			break;
			default:
				header('Location: http://demosistema.com/turismo/ventanilla');
				exit(0);
			break;
		}
	}
}
?>
