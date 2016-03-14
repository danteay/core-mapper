<?php

namespace CorePHP\Installer;

require_once __DIR__ . "/../Libraries/autoload.php";


use CorePHP\Exceptions\CorePHPBaseException;
use CorePHP\Installer\Models\ModelCreator;

class Install
{
    private $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

    public function __init__()
    {
        if(sizeof($this->data) == 4){
            new ModelCreator($this->data[0], $this->data[1], $this->data[2], $this->data[3]);
        }else if(sizeof($this->data) == 7){
            new ModelCreator($this->data[0], $this->data[1], $this->data[2], $this->data[3],$this->data[4], $this->data[5], $this->data[6]);
        }else{
            throw new CorePHPBaseException("Parametros incompletos.");
        }
    }

    public function help()
    {
        echo "### Ayuda de instalacion\n\n";
        echo "La instalacion de este sistema require el paso de parametros
de una manera especifica en el siguiente orden:\n
host dbas user pass adminTable=null adminUserField=null adminPassField=null\n
Definiciones:
    host\t\tServidor donde se encuentra la base de datos.

    dbas\t\tNombre de la base de datos a mapear.

    pass\t\tPassword de la base de datos.

    adminTable\t\t(Opcional) Define una tabla para iplementar la interface
              \t\tde administrador.

    adminUserField\t(Opcional - Obligatorio si adminTable fue espesificado)
                  \tNombre del campo de la tabla definida en adminTable que
                  \tfuncionara como nombre administrador.

    adminPassField\t(Opcional - Obligatorio si adminTable fue espesificado)
                  \tNombre del campo de la tabla definida en adminTable que
                  \tfuncionara como password de administrador.";
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

