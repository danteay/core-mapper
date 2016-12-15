<?php

namespace CorePHP\Models;

use CorePHP\Core\Conexion;
use CorePHP\Core\Abs\ModelDefinition;

class Prospectos extends ModelDefinition
{
    private $idProspectos;
	private $servicio;
	private $contacto;
	private $precioTentativo;
	private $precioFinal;
}
