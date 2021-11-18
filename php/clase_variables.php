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
				$this->BaseDatos = "demosystem_turismosis";
				$this->Usuario = "demosystem_turismosis";
				$this->Clave = "*pharadox";
				//$this->Clave = "fN9En8R3i)";
			break;
			default:
				header('Location: http://demosistema.com/turismo/ventanilla');
				exit(0);
			break;
		}
	}
}
?>
