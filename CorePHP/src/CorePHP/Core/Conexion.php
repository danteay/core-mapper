<?php

namespace CorePHP\Core;

/**
 * Descomentar la linea siguiente si este modulo no fue incluido por composer
 */
#require_once __DIR__."/../Libraries/autoload.php";

use CorePHP\Exceptions\ConexionException;

class Conexion
{
    /**
     * Servidor de la base de datos.
     */
	const HOST = ":host:";

    /**
     * Usuario del servidor.
     */
	const USER = ":user:";

    /**
     * Contraseña de Usuario.
     */
	const PASS = ":pass:";

    /**
     * Nombre de la base de datos.
     */
    const DBAS = ":dbas:";

    /**
     * @var \mysqli
     * Conexion a la base de datos.
     */
    public $conx;

    /**
     * @var string
     * Query a la base de datos.
     */
	private $query = "";


    /**
     * Conexion constructor.
     * @param null $conx
     * @throws ConexionException
     */
	public function __construct(&$conx = null)
    {
        if($conx != null){
            $this->conx = $conx ;
        }else{
            $this->conx = new \mysqli(self::HOST,self::USER,self::PASS,self::DBAS);

            if ($this->conx->connect_errno) {
                throw new ConexionException("Fallo al contenctar a MySQL: (" . $this->conx->connect_errno . ") " . $this->conx->connect_error);
            }
        }
	}


    /**
     * @return string
     * Regresa el query actual
     */
    public function getQuery()
    {
        return $this->query;
    }


    /**
     * @param string $query
     * @param array|null $replace
     * Carga un query ára ser procesado
     */
    public function initializeQuery(string $query, array $replace = null)
    {
        if($replace != null){
            foreach($replace as $key => $value){
                $query = str_replace($key,$value,$query);
            }

        }

        $this->query = $query;
    }


    /**
     * @return bool
     * @throws ConexionException
     * Ejecuta un query que no retorna valores mysql_result
     */
    public function setRequest()
    {
        $this->conx->query($this->query);

        if(empty($this->conx->error)){
            return true;
        }else{
            throw new ConexionException("<b>Error:</b> ".$this->conx->error);
        }
    }


    /**
     * @return bool|\mysqli_result
     * @throws ConexionException
     * Ejecuta un query que retorna valores mysql_result y regresa el resultado obtenido
     */
    public function getRequest()
    {
        $data = $this->conx->query($this->query);

        if(empty($this->conx->error)){
            return $data;
        }else{
            throw new ConexionException("<b>Error:</b> ".$this->conx->error);
        }
    }


    /**
     * Cierra la conexion abierta
     */
    public function closeConexion()
    {
        $this->conx->close();
    }


}

