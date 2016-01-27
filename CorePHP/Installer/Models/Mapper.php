<?php


namespace CorePHP\Installer\Models;

require_once __DIR__."/../../Libraries/autoload.php";

use CorePHP\Installer\Models\Constants;


abstract class Mapper extends Constants
{
    /**
     * @var \mysqli
     * Conexion para el mapeo de la base de datos
     */
    private $conx;

    /**
     * @var string
     * Nombre de la base de datos a mapear
     */
    private $dbas;


    /**
     * Mapper constructor.
     * @param string $host
     * @param string $dbas
     * @param string $user
     * @param String $pass
     * @throws \Exception
     */
    public function __construct(string $host, string $dbas, string $user, String $pass)
    {
        $this->conx = new \mysqli($host,$user,$pass,$dbas);
        $this->dbas = $dbas;
        if(!empty($this->conx->connect_error)){
            throw new \Exception($this->conx->connect_error);
        }
    }


    /**
     * @return array
     * @throws \Exception
     * Regresa el listado de tablas en la base de datos para el mapeo
     */
    public function getListTables(): array
    {
        $tableList = array();
        $tables = $this->conx->query("SHOW TABLES FROM {$this->dbas}");

        if(empty($this->conx->error)){
            foreach($tables as $table){
                $tableList[] = $table["Tables_in_{$this->dbas}"];
            }

            if(sizeof($tableList) > 0){
                return $tableList;
            }else{
                throw new \Exception("La base de datos no cuenta con tablas disponibles.");
            }
        }else{
            throw new \Exception($this->conx->error);
        }
    }


    /**
     * @param string $table
     * @return array
     * @throws \Exception
     * Regresa un arreglo con el detalle de los campos de una tabla espesificada
     */
    public function getListFields(string $table): array
    {
        $fieldList = array();
        $fields = $this->conx->query("SHOW COLUMNS FROM {$this->dbas}.$table");

        if(empty($this->conx->error)){
            while($field = $fields->fetch_array(MYSQLI_NUM)){
                $fieldList[] = $field;
            }

            return $fieldList;
        }else{
            throw new \Exception($this->conx->error);
        }
    }

}

#$obj = new Mapper("localhost","farmsystem","root","root");
#print_r($obj->getListTables());
#print_r($obj->getListFields('marcos'));