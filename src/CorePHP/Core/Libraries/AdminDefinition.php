<?php

namespace CorePHP\Core\Libraries;

interface AdminDefinition {

    /**
     * @param string $user
     * @return bool
     * Busca un elemento basado en el usuario
     */
    public function getItemByUser(string $user);

    /**
     * @param $pass
     * @return bool
     * Busca un elemento basado en el password, debe de estar declarado como unico en la base de datos
     * de lo contrario podria generar busquedas equibocadas.
     */
    public function getItemByPassword(string $pass);

}