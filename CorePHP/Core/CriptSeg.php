<?php

namespace CorePHP\Core;

class CriptSeg{

    /**
     * Hash salt para encriptacion, (recomendable modificar)
     */
    const HASHCRYPT = "@#hJSD*&as@#$%&/&%$%&asdEFGThd";

    /**
     * @param string $cadena
     * @return string
     * Encripta una cadena de texto en formato MD5.
     */
	public function crypStringMD5($cadena)
	{
		return hash('md5',$cadena);
	}


    /**
     * @param string $cadena
     * @return string
     * Encripta una cadena de texto en formato SHA512.
     */
	public function crypStringSHA512($cadena)
	{
		return hash('sha512',$cadena);
	}


    /**
     * @param string $cadena
     * @return string
     * Encripta una cadena de texto en formato SHA256.
     */
	public function crypStringSHA256($cadena)
	{
		return hash('sha256', $cadena);
	}


    /**
     * @param string $cadena
     * @return string
     * Genera una doble encriptacion a una dena, promero en formato MD5 y posteriormente SHA512
     */
	public function doubleCrypString($cadena)
	{
		return $this->CrypStringSHA512($this->CrypStringMD5($cadena));
	}


    /**
     * @param string $cadena
     * @return string
     * Encripta una cadena de texto en formato base64.
     */
	public function stringToBase64($cadena)
	{
		return base64_encode($cadena);
	}


    /**
     * @param string $cadena
     * @return string
     * Encripta una cadena de texto en formato salt con el hash especificado el inicio de la clase
     */
    public function saltCrypt($cadena)
	{
        return crypt($cadena, self::HASHCRYPT);
    }

}

