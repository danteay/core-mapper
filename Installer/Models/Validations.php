<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Installer\Models;

class Validations
{
    /**
     * @param string $field
     * @return bool
     * Rgresar verdadero en caso de que el campo validado se de algun tipo numerico, falso en caso contrario
     */
    public static function isNumeric($field)
    {
        return (preg_match("/int/",$field[1]) || preg_match("/dec/",$field[1]) || preg_match("/numeric/",$field[1]) ||
            preg_match("/real/",$field[1]) || preg_match("/float/",$field[1]) || preg_match("/double/",$field[1]) ||
            preg_match("/precision/",$field[1])
        );
    }

    /**
     * Regresa verdadero en caso de que el campo validado se de algun tipo interpretable como texto, falso en caso
     * contrario
     *
     * @param string $field
     * @return bool
     */
    public static function isText($field)
    {
        return (preg_match("/text/",$field[1]) || preg_match("/string/",$field[1]) || preg_match("/blob/",$field[1]));
    }

    /**
     * Regresa verdadero en caso de que el campo validado sea de algun tipo de dato archivo (blob), falso en caso
     * contrario
     *
     * @param string $field
     * @return bool
     */
    public static function isData($field)
    {
        return (preg_match("/blob/",$field[1]));
    }

    /**
     * @param string $field
     * @return bool
     * Regresa verdadero en caso de que el campo validado resulte ser llave primaria de la tabla que lo contiene
     */
    public static function isPrimary($field)
    {
        return $field[3] == "PRI";
    }

    /**
     * @param string $field
     * @return bool
     * Regresa verdadero en caso de que el campo validado se autoincrementable
     */
    public static function isAutoIncrement($field)
    {
        return $field[5] == "auto_increment";
    }

    /**
     * @param string $field
     * @return bool
     * Regresa verdadero en caso de que el campo validado pueda recibir valores nulos
     */
    public static function isNullable($field)
    {
        return $field[2] == "SI" || $field[2] == "YES";
    }

    /**
     * Regresa el nombre de la llave primaria de una lista de campos de una tabla.
     *
     * @param array $fields
     * @return string
     */
    public static function getPrimaryField(array $fields)
    {
        foreach($fields as $field){
            if(self::isPrimary($field[3])){
                return $field[0];
            }
        }

        return null;
    }


    /**
     * Revisa la existencia de un campo dentro de un arreglo de campos de una tabla.
     *
     * @param string $check
     * @param array $fields
     * @return bool
     */
    public static function checkFieldExists($check, array $fields)
    {
        foreach($fields as $field){
            if($field[0] == $check){
                return true;
            }
        }

        return false;
    }
}