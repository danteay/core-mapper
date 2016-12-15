<?php

namespace CorePHP\Models;

use CorePHP\Core\Conexion;
use CorePHP\Core\Abs\ModelDefinition;

class Servicios extends ModelDefinition
{
    private $idServicios;
	private $nombre;
	private $descripcion;
	private $fechaInsercion;
	private $tiempoDesarrollo;
	private $fechaEstimadaEntrega;
	private $fechaEntrega;
	private $estatus;
	private $tipo;
}
