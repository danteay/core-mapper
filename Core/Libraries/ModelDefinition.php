<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Core\Libraries;

use CorePHP\Core\Conexion;

abstract class ModelDefinition{

    /**
     * Variable que se convertira en objeto de conexion dentro de los modelos
     * @var Conexion
     */
    public $conx;

    /**
     * @var string
     * Variable que se combertira en un objecto QueryMap dentro de los modelos
     * para la carga de los querys del respectivo modeo
     */
    protected $query;

    /**
     * Inizializa la conexion del modelo
     * @param Conexion $conx
     * @return mixed
     */
    abstract protected function initConexion(&$conx);

    /**
     * Busca y carga un elemento basado en su ID
     * @param int $id
     * @return bool
     */
    abstract public function getItem($id);

    /**
     * Carga la totalidad de elemtnos y los devuelve en una varia \mysqli_result
     * @return \mysqli_result
     */
    abstract public function getAllItems();

    /**
     * Agrega un nuevo elemento a la tabla designada por el modelo
     * @param array $data
     * @return mixed
     */
    abstract public function insertItem(array $data);

    /**
     * Actualiza la informacion y campos especificados por $data en el elemnto con identificador $id
     * @param int $id
     * @param array $data
     * @return mixed
     */
    abstract public function updateItem($id, array $data);

    /**
     * Elimina un elemento con identificador $id de la tabla especificada en el modelo
     * @param int $id
     * @return mixed
     */
    abstract public function deleteItem($id);

    /**
     * Retorna el maximo identificador disponible en la tabla del modelo
     * @return int
     */
    abstract public function getLastItem();

}
