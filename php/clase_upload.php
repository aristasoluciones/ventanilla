<?php
class upload {

	var $image;
	var $type;
	var $typetxt;
	var $width;
	var $height;
	var $pesoarchivo;
	var $nombrearchivo;
	var $archivotemporal;	
	var $nombre_final;
	var $nom_completo;
	
	var $isimage = false;
	var $quality = 100;	
	var $maxsize = 0;
    //var $blocked = array("php","phtml","php3","php4","js","shtml","pl","py","xml","xhtml","html");
    var $blocked = array("php","phtml","php3","php4","js","shtml","pl","py","xhtml","html");
	
	var $msg_eror;
	var $msj_error;
	var $isupload;
//---Método de leer archivo
	function load($archivo) {	
		
		$this->nombrearchivo = $_FILES[$archivo]['name'];
        if ($this->nombrearchivo == "") {
        	$this->msg_eror = "No se especifico ningun archivo!!";
            $this->isupload = false;
            return false;
            }
			
		$this->pesoarchivo = $_FILES[$archivo]['size'];
        $this->archivotemporal = $_FILES[$archivo]['tmp_name'];
		$this->type = $_FILES[$archivo]['type'];		
		//$this->type = mime_content_type($this->archivotemporal);		
        $this->typetxt = substr($this->nombrearchivo, strrpos($this->nombrearchivo, '.')+1);
		$this->nombre_final = substr(md5(uniqid(rand())),0,8)."_".date("dmY")."_".date("Hi").".".$this->typetxt;

		// verificar si no es un tipo de archivo no deseado
        if (in_array($this->typetxt, $this->blocked)) {
            $this->msg_eror = "Archivo no Permitido - ".$this->typetxt;
            $this->isupload = false;
            return false;
            }
		
		}

	//metodo para establecer si el archivo es imagen
    function setisimage($value) {
        $this->isimage = $value;
		if($this->isimage == true)
			$this->obtener_medidas_img();
    }
	
	//funcion para establecer el tamaño maximo del archivo
    function setmaxsize($value) {
        $this->maxsize = $value;   
    	}
			
	//metodo para establecer la calidad a guardar de la imagen
    function setquality($value) {
        $this->quality = $value;
    	}
		
	function save($name){
		// verificar el tamaño maximo del archivo
        if ($this->maxsize != 0) {
            if ($this->pesoarchivo > $this->maxsize*1024) {
                $this->msg_eror = "El archivo sobrepasa el tamaño especificado: ".$this->maxsize;
                $this->isupload = false;
                return false;
                }
            }
		
		$this->nom_completo = $name;
		
		if ($this->isimage == true) $this->saveimg();
		else $this->savedoc();
		
		return $this->isupload;
		}
	//---Método de guardar la imagen
	function saveimg() {
						
		//---Dependiendo del tipo de imagen crear una nueva imagen
		switch($this->type){
			case IMAGETYPE_JPEG:
				$this->image = imagecreatefromjpeg($this->archivotemporal);
				imagejpeg($this->image, $this->nom_completo, $this->quality);
			break;
			case IMAGETYPE_GIF:
				$this->image = imagecreatefromgif($this->archivotemporal);
				imagegif($this->image, $this->nom_completo);
			break;
			case IMAGETYPE_PNG:
				$this->image = imagecreatefrompng($this->archivotemporal);
				$pngquality = floor(($this->quality - 10) / 10);
				imagealphablending($this->image, false);
				imagesavealpha($this->image, true);				
				imagepng($this->image, $this->nom_completo, $pngquality);
			break;
			}			

			$this->msg_eror = "El archivo se guardo con éxito!";
            $this->isupload = true;
		}
	
	function obtener_medidas_img(){
		//---Tomar las dimensiones de la imagen
			$info = getimagesize($this->archivotemporal);			
			$this->width = $info[0];
			$this->height = $info[1];
			$this->type = $info[2];			
		}
	
	//Funcion para guardar documentos
	function savedoc(){
		if (is_uploaded_file($this->archivotemporal)) {                   
            if (move_uploaded_file($this->archivotemporal, $this->nom_completo)) {
                $this->msg_eror = "El archivo se guardo con éxito!";
                $this->isupload = true;
                return true;
            	} else {
                $this->msg_eror = "El archivo no fue guardado por favor inténtalo de nuevo";
                $this->isupload = false;
                return false;
            	}
        	} else {
            $this->msg_eror = "El archivo no fue guardado por favor inténtalo de nuevo";
            $this->isupload = false;
            return false;
        	}		
		}

	//---Método de mostrar la imagen sin salvarla
	function show() {
		if ($this->isimage == true) {
		//---Mostrar la imagen dependiendo del tipo de archivo
			switch($this->type){
				case IMAGETYPE_JPEG:
				imagejpeg($this->image);
				break;
				case IMAGETYPE_GIF:
				imagegif($this->image);
				break;
				case IMAGETYPE_PNG:
				imagepng($this->image);
				break;
				}
			}
		}

//---Método de redimensionar la imagen sin deformarla
	function resize($value, $prop){
		if ($this->isimage == true) {
			//---Determinar la propiedad a redimensionar y la propiedad opuesta
			$prop_value = ($prop == 'width') ? $this->width : $this->height;
			$prop_versus = ($prop == 'width') ? $this->height : $this->width;
	
			//---Determinar el valor opuesto a la propiedad a redimensionar
			$pcent = $value / $prop_value;
			$value_versus = $prop_versus * $pcent;
	
			//---Crear la imagen dependiendo de la propiedad a variar
			$image = ($prop == 'width') ? imagecreatetruecolor($value, $value_versus) : imagecreatetruecolor($value_versus, $value);
	
			//---Hacer una copia de la imagen dependiendo de la propiedad a variar
			switch($prop){
		
				case 'width':
				imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value, $value_versus, $this->width, $this->height);
				break;
				
				case 'height':
				imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value_versus, $value, $this->width, $this->height);
				break;
		
			}
	
			//---Actualizar la imagen y sus dimensiones
			//$info = getimagesize($image);
			
			$this->width = imagesx($image);
			$this->height = imagesy($image);
			$this->image = $image;
			}

		}

//---Método de extraer una sección de la imagen sin deformarla
	function crop($cwidth, $cheight, $pos = 'center') {
		if ($this->isimage == true) {
			//---Dependiendo del tamaño deseado redimensionar primero la imagen a uno de los valores
			if($cwidth > $cheight){
			$this->resize($cwidth, 'width');
			}else{
			$this->resize($cheight, 'height');
			}
	
			//---Crear la imagen tomando la porción del centro de la imagen redimensionada con las dimensiones deseadas
			$image = imagecreatetruecolor($cwidth, $cheight);
			
			switch($pos){
	
				case 'center':
				imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
				break;
				
				case 'left':
				imagecopyresampled($image, $this->image, 0, 0, 0, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
				break;
				
				case 'right':
				imagecopyresampled($image, $this->image, 0, 0, $this->width - $cwidth, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
				break;
				
				case 'top':
				imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), 0, $cwidth, $cheight, $cwidth, $cheight);
				break;
				
				case 'bottom':
				imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), $this->height - $cheight, $cwidth, $cheight, $cwidth, $cheight);
				break;
				
				}
	
			$this->image = $image;
			}
		}

	}
?>