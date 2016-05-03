<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Core\Utils;


class Validations
{
    /**
     * Valida los datos de una peticion,
     * @param array $fields     Arreglo bidimencional con los datos esperados y su tipo [['campo','tipo'],[...],[...]]
     * @param array $data       Arreglo con los datos de la peticion 
     * @return array
     */
    public static function validatePost(array $fields, array $data)
    {
        $error = array();
        foreach ($fields as $field) {
            if(array_key_exists($field[0],$data)) {
                if (empty($data[$field[0]])) {
                    $error[] = "El campo ".$field[0]." esta vacio.";
                }else if($field[1] == 'numeric'){
                    if(!is_numeric($data[$field[0]])){
                        $error[] = "El campo ".$field[0]."no es numerico";
                    }
                }
            }else{
                $error[] = "El campo ".$field[0]." no existe.";
            }
        }
        return sizeof($error) ? [false,$error] : [true,null];
    }

    private static function cleanQueryData(array $fields, array $data){

    }
}