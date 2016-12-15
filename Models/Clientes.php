<?php

namespace CorePHP\Models;

use CorePHP\Core\Conexion;
use CorePHP\Core\Abs\ModelDefinition;

class Clientes extends ModelDefinition
{
    private $idClientes;
	private $razonSocial;
	private $sitio;
	private $direccion;
	private $telefono;
	private $correo;
	private $estatus;
	private $tipo;
	private $giro;
}
