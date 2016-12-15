<?php

namespace CorePHP\Models;

use CorePHP\Core\Conexion;
use CorePHP\Core\Abs\ModelDefinition;

class Usuarios extends ModelDefinition
{
    private $idUsuarios;
	private $nombre;
	private $apellidoPaterno;
	private $apellidoMaterno;
	private $correo;
	private $password;
	private $tipo;
}
