<?php

namespace CorePHP\Core;

class SessionUtils{

	/**
	 * @var
	 * variable de manejo de session
	 */
    private $session;


	/**
	 * Constructor de clase
	 */
	public function __construct(){
		session_start();
        $this->session = $_SESSION;
	}


	/**
	 * @param $dato
	 * @param $valor
	 * Seter's de clase
	 */
	public function __set($dato,$valor){
		if($dato != ''){
			$_SESSION[$dato] = $valor;
            $this->session = $_SESSION;
		}
	}


	/**
	 * Cierra la seccion y borra los valores almacenados en ella
	 */
	public function closeSession(){
		$this->session = null;
        $_SESSION = null;
        session_destroy();
	}
}