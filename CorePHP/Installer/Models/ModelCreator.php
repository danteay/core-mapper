<?php

namespace CorePHP\Installer\Models;

require_once __DIR__."/../../Libraries/autoload.php";

use CorePHP\Installer\Models\Mapper;
use CorePHP\Installer\Models\Validations;
use CorePHP\Exceptions\CorePHPBaseException;

class ModelCreator extends Mapper
{
    /**
     * @var string
     * Nombre de la tabla que implementara la interfaz AdminDefinition
     */
    private $adminTable;

    /**
     * @var string
     * Nombre del campo que servira como usuario del administrador
     */
    private $adminUserField;

    /**
     * @var string
     * Nombre del campo que servira como password del administrador
     */
    private $adminPassField;


    /**
     * ModelCreator constructor.
     * @param string $host
     * @param string $dbas
     * @param string $user
     * @param string $pass
     * @param string|null $adminTable
     * @param string|null $adminUserField
     * @param string|null $adminPassField
     */
    public function __construct(string $host, string $dbas, string $user, string $pass, string $adminTable = null, string $adminUserField = null, string $adminPassField = null)
    {
        parent::__construct($host,$dbas,$user,$pass);
        $this->adminTable = $adminTable;
        $this->adminUserField = $adminUserField;
        $this->adminPassField = $adminPassField;

        $this->__init__();
        $this->conexionInitializer($host, $dbas, $user, $pass);
    }


    /**
     * @throws \Exception
     * Inicio del mapeo
     */
    private function __init__()
    {
        foreach(parent::getListTables() as $table){
            $this->createModel($table);
        }
    }


    /**
     * @param string $host
     * @param string $dbas
     * @param string $user
     * @param string $pass
     * Inicializa los valores de conexion para la clase CorePHP\Core\Conexion
     */
    private function conexionInitializer(string $host, string $dbas, string $user, string $pass)
    {
        $conexionFile = file_get_contents(parent::CONEXION_CLASS);

        $conexionFile = str_replace(parent::HOST_KEY, $host, $conexionFile);
        $conexionFile = str_replace(parent::DBAS_KEY, $dbas, $conexionFile);
        $conexionFile = str_replace(parent::USER_KEY, $user, $conexionFile);
        $conexionFile = str_replace(parent::PASS_KEY, $pass, $conexionFile);

        file_put_contents(parent::CONEXION_CLASS, $conexionFile);
    }


    /**
     * @param string $table
     * @throws CorePHPBaseException
     * @throws \Exception
     * Generacion de los Modelos con respecto a la configuracion de las tablas de la base de datos
     */
    private function createModel(string $table)
    {
        $modelFile = file_get_contents(parent::MODEL_DEFINITION);
        $fields = parent::getListFields($table);

        $this->validateAdminInterface($modelFile, $table);
        $modelFile = str_replace(parent::MODEL_FIELDS_KEY, $this->createModelFields($fields), $modelFile);
        $modelFile = str_replace(parent::INIT_MODEL_FIELDS_KEY, $this->createInitModelFields($fields), $modelFile);
        $modelFile = str_replace(parent::INSERT_MODEL_VALIDATE, $this->createInsertModelValidates($fields), $modelFile);
        $modelFile = str_replace(parent::INSERT_MODEL_DATA_KEY, $this->createInsertModelData($fields), $modelFile);
        $modelFile = str_replace(parent::TABLE_NAME, $table, $modelFile);
        $modelFile = str_replace(parent::CLASS_NAME, ucfirst($table), $modelFile);

        file_put_contents(__DIR__."/../../Models/".ucfirst($table).".php", $modelFile);

        $this->createQueryFunctionModel($table, $fields);
    }


    /**
     * @param string $model
     * @param string $table
     * Validacion para implementar la interfaz AdminDefinition en un modelo
     */
    private function validateAdminInterface(string &$model, string $table)
    {
        if($table == $this->adminTable){
            $functionsAdmin = file_get_contents(parent::ADMIN_FUNCTIONS);
            $functionsAdmin = str_replace(parent::TABLE_NAME, $table, $functionsAdmin);

            $model = str_replace(parent::IMPLEMENTS_ADMIN_KEY, parent::IMPLEMENTS_ADMIN, $model);
            $model = str_replace(parent::USE_ADMIN_KEY, parent::USE_ADMIN, $model);
            $model = str_replace(parent::ADMIN_FUNCTIONS_KEY, $functionsAdmin, $model);
        }else{
            $model = str_replace(parent::IMPLEMENTS_ADMIN_KEY,"",$model);
            $model = str_replace(parent::USE_ADMIN_KEY,"",$model);
            $model = str_replace(parent::ADMIN_FUNCTIONS_KEY,"",$model);
        }
    }


    /**
     * @param array $fields
     * @return string
     * Creacion de las variables de clase de los modelos
     */
    private function createModelFields(array $fields): string
    {
        $fieldString = "";
        $flag = true;

        foreach($fields as $field){
            if($flag){
                $fieldString .= "public \$$field[0];";
                $flag = false;
            }else{
                $fieldString .= "\n\tpublic \$$field[0];";
            }
        }

        return $fieldString;
    }


    /**
     * @param array $fields
     * @return string
     * Creacion de las sentencias de inicializacion para las variable de clase
     */
    private function createInitModelFields(array $fields): string
    {
        $initFieldsString = "";
        $flag = true;

        foreach($fields as $field){
            if($flag){
                $initFieldsString .= "\$this->$field[0] = null;";
                $flag = false;
            }else{
                $initFieldsString .= "\n\t\t\$this->$field[0] = null;";
            }
        }

        return $initFieldsString;
    }


    /**
     * @param array $fields
     * @return string
     * Validaciones de campos para la funcion insertItem de los modelos
     */
    private function createInsertModelValidates(array $fields): string
    {
        $validate = "";
        $flag = true;

        foreach($fields as $field){
            if($flag){
                $validate .= Validations::isPrimary($field[3]) ?
                    (Validations::isAutoIncrement($field[5]) ?
                        "" :
                        (Validations::isNumeric($field[1]) ?
                            "isset(\$$field[0]) && is_numeric(\$$field[0])" :
                            "isset(\$$field[0]) && !empty(\$$field[0])"
                        )
                    ) :
                    (Validations::isNumeric($field[1]) ?
                        "isset(\$$field[0]) && is_numeric(\$$field[0])" :
                        "isset(\$$field[0]) && !empty(\$$field[0])"
                    );
                $flag = $validate != "" ? false : $flag;
            }else{
                $validate .= Validations::isPrimary($field[3]) ?
                    (Validations::isAutoIncrement($field[5]) ?
                        "" :
                        (Validations::isNumeric($field[1]) ?
                            " && isset(\$$field[0]) && is_numeric(\$$field[0])" :
                            " && isset(\$$field[0]) && !empty(\$$field[0])"
                        )
                    ) :
                    (Validations::isNumeric($field[1]) ?
                        " && isset(\$$field[0]) && is_numeric(\$$field[0])" :
                        " && isset(\$$field[0]) && !empty(\$$field[0])"
                    );
            }
        }

        return $validate;
    }


    /**
     * @param array $fields
     * @return string
     * Generacion de las llaves de datos en la funcion insertItem de los modelos
     */
    private function createInsertModelData(array $fields): string
    {
        $validate = "";
        $flag = true;

        foreach($fields as $field){
            if($flag){
                $validate .= Validations::isPrimary($field[3]) ? (
                    Validations::isAutoIncrement($field[5]) ?
                        "" :
                        "\"[[$field[0]]]\" => \$$field[0]"
                ) : "\"[[$field[0]]]\" => \$$field[0]";

                $flag = $validate != "" ? false : $flag;
            }else{
                $validate .= ",\n\t\t\t\t\"[[$field[0]]]\" => \$$field[0]";
            }
        }

        return $validate;
    }


    /**
     * @param string $table
     * @param array $fields
     * @throws CorePHPBaseException
     * Creacion de la funcion especifica del modelo que cargara los querys para su funcionamiento.
     * Dicha funcion se agregara al archivo CorePHP\Libraries\QueryMap.php
     */
    private function createQueryFunctionModel(string $table, array $fields)
    {
        $queryMapFile = file_get_contents(parent::QUERYMAP_CLASS);

        $queryFunction = $table == $this->adminTable ? file_get_contents(parent::ADMIN_QUERY_FUNCTION): file_get_contents(parent::MODEL_QUERY_FUNCTION);
        $queryFunction = str_replace(parent::TABLE_NAME, $table, $queryFunction);
        $queryFunction = str_replace(parent::PRIMARY_KEY, Validations::getPrimaryField($fields), $queryFunction);
        $queryFunction = str_replace(parent::INSERT_QUERY_FIELDS, $this->createInsertQueryFields($fields), $queryFunction);
        $queryFunction = str_replace(parent::INSERT_QUERY_DATA, $this->createInsertQueryData($fields), $queryFunction);

        if($table == $this->adminTable){
            if(Validations::checkFieldExists($this->adminUserField, $fields)){
                $queryFunction = str_replace(parent::USER_ADMIN_KEY, $this->adminUserField, $queryFunction);

                if(Validations::checkFieldExists($this->adminPassField, $fields)){
                    $queryFunction = str_replace(parent::PASS_ADMIN_KEY, $this->adminPassField, $queryFunction);
                }else{
                    throw new CorePHPBaseException("El campo '{$this->adminPassField}' no se encuentra definido dentro de la tabla $table");
                }
            }else{
                throw new CorePHPBaseException("El campo '{$this->adminUserField}' no se encuentra definido dentro de la tabla $table");
            }
        }

        $queryMapFile = str_replace(parent::QUERYMAP_FUNCTION_PLACE, $queryFunction, $queryMapFile);
        file_put_contents(parent::QUERYMAP_CLASS, $queryMapFile);
    }


    /**
     * @param array $fields
     * @return string
     * Crea los campos de insercion para los querys insert de cada modelo
     */
    private function createInsertQueryFields(array $fields): string
    {
        $inserts = "";
        $flag = true;

        foreach($fields as $field){
            if($flag){
                $inserts .= Validations::isPrimary($field[3]) ? (
                    Validations::isAutoIncrement($field[5]) ?
                        "" :
                        $field[0]
                ) : $field[0];
                $flag = $inserts != "" ? false : $flag;
            }else{
                $inserts .= Validations::isPrimary($field[3]) ? (
                    Validations::isAutoIncrement($field[5]) ?
                        "" :
                        ",".$field[0]
                ) : ",".$field[0];
            }
        }

        return $inserts;
    }


    /**
     * @param array $fields
     * @return string
     * Genera las llaves de reemplazo para la informacion que se agregara en los querys insert de cada modelo
     */
    private function createInsertQueryData(array $fields): string
    {
        $data = "";
        $flag = true;

        foreach($fields as $field){
            if($flag){
                $data .= Validations::isPrimary($field[3]) ? (
                    Validations::isAutoIncrement($field[5]) ?
                        "" :
                        (Validations::isNumeric($field[1]) ? "[[$field[0]]]" : "'[[$field[0]]]'")
                ) : (Validations::isNumeric($field[1]) ? "[[$field[0]]]" : "'[[$field[0]]]'");
                $flag = $data != "" ? false : $flag;
            }else{
                $data .= Validations::isPrimary($field[3]) ? (
                    Validations::isAutoIncrement($field[5]) ?
                        "" :
                        (Validations::isNumeric($field[1]) ? ",[[$field[0]]]" : ",'[[$field[0]]]'")
                ) : (Validations::isNumeric($field[1]) ? ",[[$field[0]]]" : ",'[[$field[0]]]'");
            }
        }

        return $data;
    }

}