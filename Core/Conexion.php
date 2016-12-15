<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Core;

use CorePHP\Core\Exceptions\ConexionException;
use Symfony\Component\Yaml\Yaml;

class Conexion
{
    public $conx;

    public $query;

    /**
     * Conexion constructor.
     * @param null $conx
     * @throws ConexionException
     */
	public function __construct(&$conx = null)
    {
        if ($conx != null) {
            $this->conx = $conx ;
        } else {
            try {
                $config = Yaml::parse(file_get_contents(__DIR__.'/../config/config.yml'));

                $this->conx = new \mysqli(
                    $config['database']['host'],
                    $config['database']['user'],
                    $config['database']['pass'],
                    $config['database']['dbas']
                );

            } catch (\Throwable $e) {
                throw new ConexionException("Unable to parse the YAML string: %s", $e->getMessage());
            }

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
    public function initializeQuery($query, array $replace = null)
    {
        if ($replace != null) {
            foreach ($replace as $key => $value) {
                $query = str_replace($key,$value,$query);
            }
        }

        $this->query = $query;
    }

    /**
     * Ejecuta un query que no retorna valores mysql_result
     *
     * @return bool
     * @throws ConexionException
     */
    public function setRequest()
    {
        $this->conx->query($this->query);

        if (empty($this->conx->error)) {
            return true;
        } else {
            throw new ConexionException("Error: ".$this->conx->error);
        }
    }

    /**
     * Ejecuta un query que retorna valores mysql_result y regresa el resultado obtenido
     *
     * @return bool|\mysqli_result
     * @throws ConexionException
     */
    public function getRequest()
    {
        $data = $this->conx->query($this->query);

        if (empty($this->conx->error)) {
            return $data;
        } else {
            throw new ConexionException("Error: ".$this->conx->error);
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

