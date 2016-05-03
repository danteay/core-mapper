<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Installer\Models;

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
    public function __construct($host, $dbas, $user, $pass)
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
    public function getListTables()
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
     * Obtiene los campos que son llaves Foraneas para crear sus custom functions
     * @param $table
     * @return array
     * @throws \Exception
     */
    public function getForeignKeys($table)
    {
        $keys = array();
        $fields = $this->conx->query("
            SELECT b.column_name
            FROM information_schema.table_constraints a
                JOIN information_schema.key_column_usage b
                    ON a.table_schema = b.table_schema AND a.constraint_name = b.constraint_name
                    WHERE a.table_schema=database() AND a.constraint_type='FOREIGN KEY' AND b.table_name='$table'
                    ORDER BY b.table_name, b.constraint_name");

        if(empty($this->conx->error)){
            while ($field = $fields->fetch_array(MYSQLI_NUM)){
                $keys[] = $field;
            }
            return $keys;
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
    public function getListFields($table)
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
