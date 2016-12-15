<?php

namespace CorePHP\Models;

use CorePHP\Core\Conexion;
use CorePHP\Core\Abs\ModelDefinition;

class AgendaUsuario extends ModelDefinition
{
    private $idAgendaUsuario;
	private $usuario;
	private $contacto;
	private $fecha;
	private $lugar;
	private $observaciones;
	private $estatus;
	private $tipoReunion;
}
