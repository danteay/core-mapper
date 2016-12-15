<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Core\Abs;

use CorePHP\Core\Conexion;

abstract class ModelDefinition
{
    /**
     * Variable que se convertira en objeto de conexion dentro de los modelos
     * @var Conexion
     */
    protected $conx;


    public function __construct()
    {
        global $conx;

        if (!empty($conx)) {
            $this->conx = $conx;
            echo "\nExistent Conexion";
        } else {
            $this->conx = new Conexion();
            $GLOBALS['conx'] = $this->conx;
            echo "\nNew Conexion";
        }

    }


    public function __call($name, $arguments)
    {
        echo "\nLlamando a $name\n";
        var_dump($arguments);
    }

}
