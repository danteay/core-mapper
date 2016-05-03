<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Core\Libraries;

interface AdminDefinition {

    /**
     * Busca un elemento basado en el usuario
     * @param string $user
     * @return bool
     */
    public function getItemByUser($user);

    /**
     * Busca un elemento basado en el password, debe de estar declarado como unico en la base de datos
     * de lo contrario podria generar busquedas equibocadas.
     * @param string $pass
     * @return bool
     */
    public function getItemByPassword($pass);

}