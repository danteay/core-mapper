<?php

namespace CorePHP\Exceptions;

class DirectoryUtilsExeption extends \Exception
{
    /**
     * @var string
     * Mensaje final de la excepsion.
     */
    private $finalMessage;

    /**
     * DirectoryUtilsExeptions constructor.
     * @param string|null $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($rutaOrigen, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->finalMessage = $message . "\n<b>Ruta no encontrada: </b>" . $rutaOrigen;
        parent::__construct($this->finalMessage, $code, $previous);
    }

    /**
     * @return string
     * Impresion personalizada del objeto
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}