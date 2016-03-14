<?php

namespace CorePHP\Core\Libraries;

abstract class ModelDefinition{

    /**
     * @var
     * Variable que se convertira en objeto de conexion dentro de los modelos
     */
    public $conx;

    /**
     * @var
     * Variable que se combertira en un objecto QueryMap dentro de los modelos
     * para la carga de los querys del respectivo modeo
     */
    protected $query;

    /**
     * @param int $id
     * @return bool
     * Busca y carga un elemento basado en su ID
     */
    abstract public function getItem($id);

    /**
     * @return \mysqli_result
     * Carga la totalidad de elemtnos y los devuelve en una varia \mysqli_result
     */
    abstract public function getAllItems();

    /**
     * @param array $data
     * @return mixed
     * Agrega un nuevo elemento a la tabla designada pr el modelo
     */
    abstract public function insertItem(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     * Actualiza la informacion y campos especificados por $data en el elemnto con identificador $id
     */
    abstract public function updateItem($id, array $data);

    /**
     * @param int $id
     * @return mixed
     * Elimina un elemento con identificador $id de la tabla especificada en el modelo
     */
    abstract public function deleteItem($id);

    /**
     * @return int
     * Retorna el maximo identificador disponible en la tabla del modelo
     */
    abstract public function getLastItem();

}