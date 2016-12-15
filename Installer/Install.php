<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Installer;
  
require_once __DIR__ . "/../../../autoload.php";

use CorePHP\Exceptions\CorePHPBaseException;
use CorePHP\Installer\Models\ModelCreator;

class Install
{
    private $data;
    private $shell_data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

    public function __init__()
    {
        if(sizeof($this->data) == 4){
            new ModelCreator($this->data[0], $this->data[1], $this->data[2], $this->data[3]);
            $this->shell_data = shell_exec("cd ".__DIR__."/../../../../ && composer dumpautoload -o");
	    }else{
            throw new CorePHPBaseException("Parametros incompletos.");
        }
    }

    public function help()
    {
        echo "### Ayuda de instalacion\n\n";
        echo "La instalacion de este sistema require el paso de parametros
de una manera especifica en el siguiente orden:\n
host dbas user pass\n
Definiciones:
    host\t\tServidor donde se encuentra la base de datos.

    dbas\t\tNombre de la base de datos a mapear.
    
    user\t\tNom de usuario de la base de datos

    pass\t\tPassword de la base de datos.\n\n";
    }
}

if(isset($argv)){
    if ($argc > 1){
        if($argc == 5){
            $data = array($argv[1],$argv[2],$argv[3],$argv[4]);
            try{
                $obj = new Install($data);
                $obj->__init__();
            }catch(\Exception $e){
                echo $e->getMessage();
            }
        }else if($argc == 8){
            $data = array($argv[1],$argv[2],$argv[3],$argv[4],$argv[5],$argv[6],$argv[7]);
            try{
                $obj = new Install($data);
                $obj->__init__();
            }catch(\Exception $e){
                echo $e->getMessage();
            }
        }else{

            echo "Numero de parametros invalidos : $argc";
        }
    }else{
        $obj = new Install();
        $obj->help();
    }
}

