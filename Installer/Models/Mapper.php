<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Installer\Models;

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
     * Mapper constructor
     *
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

        if (!empty($this->conx->connect_error)) {
            throw new \Exception($this->conx->connect_error);
        }
    }


    /**
     * Regresa el listado de tablas en la base de datos para el mapeo
     *
     * @return array
     * @throws \Exception
     */
    public function getListTables()
    {
        $tableList = array();
        $tables = $this->conx->query("SHOW TABLES FROM {$this->dbas}");

        if (empty($this->conx->error)) {
            foreach ($tables as $table) {
                $tableList[] = $table["Tables_in_{$this->dbas}"];
            }

            if (sizeof($tableList) > 0) {
                return $tableList;
            } else {
                throw new \Exception("La base de datos no cuenta con tablas disponibles.");
            }
        } else {
            throw new \Exception($this->conx->error);
        }
    }

    /**
     * Obtiene los campos que son llaves Foraneas para crear sus custom functions
     *
     * @param $table
     * @return array
     * @throws \Exception
     */
    public function getForeignKeys($table)
    {
        $keys = array();
        $fields = $this->conx->query("
            SELECT 
                table_name AS 'origin_table', 
                column_name AS 'origin_field', 
                referenced_table_name AS 'reference_table', 
                referenced_column_name AS 'reference_field' 
                    FROM information_schema.key_column_usage 
                        WHERE referenced_table_name IS NOT NULL 
                        AND table_name = '{$table}' 
                        AND table_schema = '{$this->dbas}'
        ");

        if (empty($this->conx->error)) {
            while ($field = $fields->fetch_object()) {
                $keys[] = $field;
            }
            return $keys;
        } else {
            throw new \Exception($this->conx->error);
        }
    }


    /**
     * Regresa un arreglo con el detalle de los campos de una tabla espesificada
     *
     * @param string $table
     * @return array
     * @throws \Exception
     */
    public function getListFields($table)
    {
        $fieldList = array();
        $fields = $this->conx->query("SHOW COLUMNS FROM {$this->dbas}.$table");

        if (empty($this->conx->error)) {
            while ($field = $fields->fetch_array(MYSQLI_NUM)) {
                $fieldList[] = $field;
            }

            return $fieldList;
        } else {
            throw new \Exception($this->conx->error);
        }
    }

}
