<?php

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
        return (preg_match("/int/",$field) || preg_match("/dec/",$field) || preg_match("/numeric/",$field) || preg_match("/real/",$field) || preg_match("/float/",$field) || preg_match("/double/",$field) || preg_match("/precision/",$field));
    }


    /**
     * @param string $field
     * @return bool
     * Regresa verdadero en caso de que el campo validado se de algun tipo interpretable como texto, falso en caso contrario
     */
    public static function isText($field)
    {
        return (preg_match("/text/",$field) || preg_match("/string/",$field) || preg_match("/blob/",$field));
    }


    /**
     * @param string $field
     * @return bool
     * Regresa verdadero en caso de que el campo validado sea de algun tipo de dato archivo (blob), falso en caso contrario
     */
    public static function isData($field)
    {
        return (preg_match("/blob/",$field));
    }


    /**
     * @param string $field
     * @return bool
     * Regresa verdadero en caso de que el campo validado resulte ser llave primaria de la tabla que lo contiene
     */
    public static function isPrimary($field)
    {
        return $field == "PRI";
    }


    /**
     * @param string $field
     * @return bool
     * Regresa verdadero en caso de que el campo validado se autoincrementable
     */
    public static function isAutoIncrement($field)
    {
        return $field == "auto_increment";
    }


    /**
     * @param string $field
     * @return bool
     * Regresa verdadero en caso de que el campo validado pueda recibir valores nulos
     */
    public static function isNullable($field)
    {
        return $field == "SI" || $field == "YES";
    }


    /**
     * @param array $fields
     * @return string
     * Regresa el nombre de la llave primaria de una lista de campos de una tabla.
     */
    public static function getPrimaryField(array $fields)
    {
        foreach($fields as $field){
            if(self::isPrimary($field[3])){
                return $field[0];
            }
        }
    }


    /**
     * @param string $check
     * @param array $fields
     * @return bool
     * Revisa la existencia de un campo dentro de un arreglo de campos de una tabla.
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