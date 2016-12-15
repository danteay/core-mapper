<?php

namespace CorePHP\Models;

use CorePHP\Core\Conexion;
use CorePHP\Core\Abs\ModelDefinition;

class ContactoCliente extends ModelDefinition
{
    private $idContactoCliente;
	private $nombre;
	private $apellidos;
	private $correo;
	private $telefono;
	private $telefonoOficina;
	private $cliente;
	private $tipo;
}
