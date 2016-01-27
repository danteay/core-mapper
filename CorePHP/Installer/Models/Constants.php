<?php

namespace CorePHP\Installer\Models;


abstract class Constants
{
    /*
     * Direcciones constantes de archivos de modelado
     */
    CONST MODEL_DEFINITION = __DIR__."/../SuportFiles/modelDefinition.txt";
    CONST ADMIN_QUERY_FUNCTION = __DIR__."/../SuportFiles/adminQueryFunction.txt";
    CONST MODEL_QUERY_FUNCTION = __DIR__ . "/../SuportFiles/modelQueryFunction.txt";
    CONST ADMIN_FUNCTIONS = __DIR__."/../SuportFiles/adminFunctions.txt";
    CONST QUERYMAP_CLASS = __DIR__."/../../Libraries/QueryMap.php";
    CONST CONEXION_CLASS = __DIR__."/../../Core/Conexion.php";

    /*
     * Constantes de reeplazo de interfaces, llamdas a clases y clases abstractas opcionles
     */
    CONST IMPLEMENTS_ADMIN = "implements AdminDefinition";
    CONST USE_ADMIN = "use CorePHP\\Core\\Libraries\\AdminDefinition;";

    /*
     * Constantes de llaves de reemplazo
     */
    CONST TABLE_NAME = ":table:";
    CONST CLASS_NAME = ":class-name:";
    CONST IMPLEMENTS_ADMIN_KEY = ":admin-implements:";
    CONST USE_ADMIN_KEY = ":admin-use-class:";
    CONST ADMIN_FUNCTIONS_KEY = ":admin-functions:";
    CONST MODEL_FIELDS_KEY = ":model-fields:";
    CONST INIT_MODEL_FIELDS_KEY = ":init-model-fields:";
    CONST INSERT_MODEL_DATA_KEY = ":insert-model-data:";
    CONST INSERT_MODEL_VALIDATE = ":insert-model-validate:";

    CONST QUERYMAP_FUNCTION_PLACE = "/*add-function-model*/";
    CONST PRIMARY_KEY = ":primary:";
    CONST USER_ADMIN_KEY = ":user:";
    CONST PASS_ADMIN_KEY = ":passwd:";
    CONST INSERT_QUERY_FIELDS = ":insert-fields:";
    CONST INSERT_QUERY_DATA = ":insert-data:";

    CONST HOST_KEY = ":host:";
    CONST DBAS_KEY = ":dbas:";
    CONST USER_KEY = ":user:";
    CONST PASS_KEY = ":pass:";
}