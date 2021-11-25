<?php
class Variables {
	var $BaseDatos;
	var $Servidor;
	var $Usuario;
	var $Clave;
	var $Puerto;
	public function opcion($opc){
		switch($opc){
			case 1:
				$this->Servidor = "localhost";
				$this->BaseDatos = "turismo";
				$this->Usuario = "root";
				$this->Clave = "";
			break;
			default:
				header('Location: http://demosistema.com/turismo/ventanilla');
				exit(0);
			break;
		}
	}
}
?>
