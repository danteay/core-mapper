<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Installer\Models;

abstract class Constants
{
    /**
     * Direcciones constantes de archivos de modelado
     */
    CONST MODEL_DEFINITION          = __DIR__ . "/../SuportFiles/modelDefinition.txt";
    CONST CONFIG_FILE               = __DIR__ . "/../SuportFiles/config.yml";

    /**
     * Constantes de llaves de reemplazo
     */
    CONST CLASS_NAME                = ":class-name:";
    CONST MODEL_FIELDS_KEY          = ":model-fields:";
}