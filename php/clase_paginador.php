<?php
/**
 * Clase Paginador.
 * Su responsabilidad es realizarnos el paginado de una consulta, es decir
 * proporcionar datos para realizar la barra de navegacion de la paginacion.
 * @package     varias creado en el projecto opet
 * @copyright   2010 - ObjetivoPHP
 * @license     Gratuito (Free) http://www.opensource.org/licenses/gpl-license.html
 * @author      Marcelo Castro (ObjetivoPHP)
 * @link        objetivophp@*****.***.**
 * @version     2.0.0 (16/06/2008 - 27/08/2010)
 */
class Paginador
{
    /**
     * Contiene los titulos que se mostraran en la barra de navegacion. O sea
     * primera, anteriror, .... , ultima, siguiente etc...
     * @var array 
     */
    private $_titulos = array('primero'           => array('vista'  => '| <<',
                                                           'title'  => 'Ir a la primera Página',
														   'class'  => 'previous',
														   'active' =>  false),
                              'bloqueAnterior'    => array('vista'  => '<<',
                                                           'title'  => 'Bloque Anterior',
														   'class'  => 'previous',
														   'active' =>  false),
                              'anterior'          => array('vista'  => '<',
                                                           'title'  => 'Página Anterior',
														   'class'  => 'previous',
														   'active' =>  false),
                              'siguiente'         => array('vista'  => '>',
                                                           'title'  => 'Página Siguiente',
														   'class'  => 'next',
														   'active' =>  false),
                              'bloqueSiguiente'   => array('vista'  => '>>',
                                                           'title'  => 'Bloque Siguiente',
														   'class'  => 'next',
														   'active' =>  false),
                              'ultimo'            => array('vista'  => '>> |',
                                                           'title'  => 'Ir a la Última Página',
														   'class'  => 'next',
														   'active' =>  false),
                              'numero'            => array('vista'  => null,
                                                           'title'  => 'Ir a la página ',
														   'class'  => null,
														   'active' =>  false),
                              'actual'            => array('vista'  => null,
                                                           'title'  => 'Estás viendo esta página',
														   'class'  => 'active',
														   'active' =>  true)
                             );
 
    /**
     * Contiene los marcadores que van antes y despues de la pagina actual,
     * para identificarla visualmente en la barra de navegacion del paginador.
     * @var array
     */
    private $_marcador = array('antes'      => '',
                               'despues'    => '');
 
    /**
     * Guarda el resultado de la paginacion por si es requrido mas tarde.
     * Formato array('vista' => 'primero', 'numero' => 0).
     * @var array
     */
    private $_paginacion = array();
 
    /**
     * Es la cantidad de registros, filas de la tabla que se mostraran por cada
     * pantalla.
     * @var integer
     */
    private $_cantidadDeRegistrosPorPagina = 10;
 
    /**
     * Es la cantidad de Enlaces o vinculos que contendra el paginador, sin contar
     * los especiales como ser primero, ultimo etc..
     * @var integer
     */
    private $_cantidadDeEnlacesDelPaginador = 10;
 
    /**
     * Contiene la cantidad total de paginas del paginador.
     * @var integer
     */
    private $_cantidadPaginas;
 
    /**
     * Metodo __construct.
     * Crea el objeto Paginador.
     * @param   integer $crpp   Cantidad de Registros a desplegarse en cada Pagina.
     * @param   integer $cepp   Cantidad de enlaces del paginador, sin especiales.
     * @return  void
     */
    public function  __construct($crpp = 10, $cep = 10)
    {
        $this->_cantidadDeRegistrosPorPagina    = ((int)$crpp > 0)? $crpp : 10;
        $this->_cantidadDeEnlacesDelPaginador   = ((int)$cep > 0)? $cep : 10;
    }
 
    /**
     * Metodo setCantidadRegistros.
     * Configura la cantidad de registros que se desplegan en la pantalla.
     * @param   integer $cantidad   Cantidad de Registros por pagina.
     * @return  void
     */
    public function setCantidadRegistros($cantidad = 10)
    {
        $this->_cantidadDeRegistrosPorPagina    = ((int)$cantidad > 0)? $cantidad : 10;
    }
 
    /**
     * Metodo setCantidadEnlaces.
     * Configura la cantidad de enlaces que contendra el paginador sin considerar los
     * enlaces especiales.
     * @param   integer $cantidad   Cantidad de Enlaces que se quieren mostrar.
     * @return  void
     */
    public function setCantidadEnlaces($cantidad = 10)
    {
        $this->_cantidadDeEnlacesDelPaginador   = ((int)$cantidad > 0)? $cantidad : 10;
    }
 
    /**
     * Metodo paginar.
     * Realiza el paginado, generando todos los bloques.
     * @param   integer $_pagina Contiene desde que pagina se desplegara.
     * @param   integer $cantidadDeResultados  total de resutados de la consulta.
     * @return  array
     */
	public function paginar($_pagina,$cantidadDeResultados)
	{
        $_pagina = ((int)$_pagina < 1)? 1 : $_pagina;
        if ($cantidadDeResultados < 1) { // No hay resultados que paginar
            return false;
        }
        // Aqui significa que tenemos resultados y vamos a paginar
        // Preparo las variables que se utilizaran
		$paginaInicial  = $paginaFinal    = 1;
		$paginacion     = array();
		$totalPaginas	= ceil($cantidadDeResultados / $this->_cantidadDeRegistrosPorPagina);
 
		if ($totalPaginas < 2) { // Si es menor a 2 es una pagina por lo tanto no pagino.
            $this->_cantidadPaginas = 1;
            return false;
        }
 
	   	if ($totalPaginas <= $this->_cantidadDeEnlacesDelPaginador) {
            $paginaInicial		= 1;
			$paginaFinal		= $totalPaginas;
		} else {
            $centroPaginador 	= floor($this->_cantidadDeEnlacesDelPaginador / 2);
			$paginaInicial		= ($_pagina+1) - $centroPaginador;
			$paginaFinal		= $paginaInicial + $this->_cantidadDeEnlacesDelPaginador - 1;
 
			if ($paginaFinal > $totalPaginas) {
                $paginaFinal    = $totalPaginas;
				$paginaInicial  = $paginaFinal - ($this->_cantidadDeEnlacesDelPaginador -1);
			}
 
			if ($paginaInicial < 1) {
                $paginaInicial	= 1;
				$paginaFinal	= $this->_cantidadDeEnlacesDelPaginador;
			}
		}
 
		$ajuste				= floor($this->_cantidadDeEnlacesDelPaginador / 2);
		$ajuste2			= 1 - ($this->_cantidadDeEnlacesDelPaginador % 2);
		$blockInicio		= $paginaInicial - $this->_cantidadDeEnlacesDelPaginador + $ajuste  - 1;
		if($blockInicio == 0) $blockInicio = 1;
		
		$blockFinal			= $paginaFinal + $this->_cantidadDeEnlacesDelPaginador - $ajuste  + $ajuste2;
 
		$paginaInicial		= $paginaInicial;
		$paginaFinal		= $paginaFinal;
 
		if ($totalPaginas > 1) {
            if ($paginaInicial != 1) {
                $paginacion[] = array('numero'   => 1,
                                      'vista'    => $this->_titulos['primero']['vista'],
                                      'title'    => $this->_titulos['primero']['title'],
                                      'class'    => $this->_titulos['primero']['class'],
                                      'active'    => $this->_titulos['primero']['active']);
            }
		}
		/* Configurar Block de Inicio */
		if ($blockInicio > $ajuste) {
            $paginacion[]    = array('numero'    => $blockInicio,
                                     'vista'     => $this->_titulos['bloqueAnterior']['vista'],
                                     'title'     => $this->_titulos['bloqueAnterior']['title'],
                                      'class'    => $this->_titulos['bloqueAnterior']['class'],
                                      'active'    => $this->_titulos['bloqueAnterior']['active']);
        }
		/* Configurar anterior */
		if($_pagina > 1) {
            $paginacion[]    = array('numero'    => $_pagina-1,
                                     'vista'     => $this->_titulos['anterior']['vista'],
                                     'title'     => $this->_titulos['anterior']['title'],
                                      'class'    => $this->_titulos['anterior']['class'],
                                      'active'    => $this->_titulos['anterior']['active']);
        }
		/* Inicio Block Central */
		for ( $f = $paginaInicial; $f <= $paginaFinal; $f++) {
            if ($f != $_pagina) {
                $paginacion[]= array('numero'    => $f,
                                     'vista'     => $f,
                                     'title'     => $this->_titulos['numero']['title'] . ($f),
                                      'class'    => $this->_titulos['numero']['class'],
                                      'active'    => $this->_titulos['numero']['active']);
			} else {
                $paginacion[]= array('numero'    => $f,
                                     'vista'     => $this->_marcador['antes']
                                                 . ($f) . $this->_marcador['despues'],
                                     'title'     => $this->_titulos['actual']['title'],
                                      'class'    => $this->_titulos['actual']['class'],
                                      'active'    => $this->_titulos['actual']['active']);
			}
		}
		/* Fin block Central */
		/* Configurar siguiente */
		if ($_pagina < ($totalPaginas)) {
            $paginacion[]    = array('numero'    => $_pagina+1,
                                     'vista'     => $this->_titulos['siguiente']['vista'],
                                     'title'     => $this->_titulos['siguiente']['title'],
                                      'class'    => $this->_titulos['siguiente']['class'],
                                      'active'    => $this->_titulos['siguiente']['active']);
        }
		/* Fin block siguiente */
		/* Configurar Block de Final */
        if ($paginaFinal < ($totalPaginas - $this->_cantidadDeEnlacesDelPaginador - 1)) {
            $paginacion[]    = array('numero'    => $blockFinal-1,
                                     'vista'     => $this->_titulos['bloqueSiguiente']['vista'],
                                     'title'     => $this->_titulos['bloqueSiguiente']['title'],
                                      'class'    => $this->_titulos['bloqueSiguiente']['class'],
                                      'active'    => $this->_titulos['bloqueSiguiente']['active']);
        }
		/* Fin block Final */
		if ( $paginaFinal != ($totalPaginas)) {
            $paginacion[]    = array('numero'    => $totalPaginas,
                                     'vista'     => $this->_titulos['ultimo']['vista'],
                                     'title'     => $this->_titulos['ultimo']['title'],
                                      'class'    => $this->_titulos['ultimo']['class'],
                                      'active'    => $this->_titulos['ultimo']['active']);
		}
		$this->_paginacion      = $paginacion;
        $this->_cantidadPaginas = $totalPaginas;
		return $paginacion;
	}
 
    /**
     * Metodo setTitulosVista.
     * Configura los simbolos que se usaran para el enunciado de bloques,
     * primero, ultimo, anterior, siguiente etc...
     * @param   string  $titulo Titulo que se desea cambiar. primero, ultimo etc.
     * @param   string  $valor  Valor que tendra la etiqueta.
     * @return  void
     */
    public function setTitulosVista($titulo, $valor)
    {
        if (array_key_exists($titulo, $this->_titulos)) {
           $this->_titulos[$titulo]['vista'] = $valor;
        }
    }
 
    /**
     * Metodo setTitulosTitle.
     * @param   string  $titulo Etiqueta a la que se desea cambiar la propiedad title.
     * @param   string  $valor  Valor que tendra la etiqueta.
     * @return  void
     */
    public function setTitulosTitle($titulo, $valor)
    {
        if (array_key_exists($titulo, $this->_titulos)) {
           $this->_titulos[$titulo]['title'] = $valor;
        }
    }
 
    /**
     * Metodo setMarcador.
     * @param   string  $antes      Simbolo que va antes del enlace de pagina actual.
     * @param   string  $despues    Simbolo que va despues del enlace de la pagina actual.
     * @return  void
     */
    public function setMarcador($antes, $despues)
    {
        $this->_marcador['antes']   = $antes;
        $this->_marcador['despues'] = $despues;
    }
 
    /**
     * Metodo getPaginacion.
     * Nos retorna el arreglo de paginacion.
     * @return array
     */
    public function getPaginacion()
    {
        return $this->_paginacion;
    }
 
    /**
     * Metodo getCantidadPaginas.
     * Nos retorna la cantidad de paginas que tiene el paginador.
     * @return integer
     */
    public function getCantidadPaginas()
    {
        return $this->_cantidadPaginas;
    }
}
?>