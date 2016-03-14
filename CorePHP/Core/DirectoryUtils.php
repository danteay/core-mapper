<?php

namespace CorePHP\Core;

use CorePHP\Exceptions\DirectoryUtilsExeption;

class DirectoryUtils{

	/**
	 * @param string $ruta
	 * Crea un directorio en la ruta especificada
	 */
	public function makeDir($ruta)
	{
		if(!file_exists($ruta)){
			mkdir($ruta);
		}
	}


	/**
	 * @param string $ruta
	 * @return int
	 * Regresa el numero total de elementos contenidos en un directorio
	 */
	public function countElements($ruta)
    {
		$directorio = opendir($ruta);
		$cont = 0;
		
		while($archivo = readdir($directorio)){
			if($archivo != '.' && $archivo != '..'){
				$cont++;
			}
		}
		
		return $cont;
	}

	/**
	 * @param string $ruta
	 * @param string|null $patern
	 * @return array
     * @throws DirectoryUtilsExeption
	 * Genera el listado con los nombres de los archivos contenidos en un directorio
	 */
	public function listFiles($ruta, $patern = null)
    {
        if(!is_dir($ruta)){
            throw new DirectoryUtilsExeption($ruta,"La ruta no es un directorio valido.");
        }

		$directorio = opendir($ruta);
		$lista = array();
		$cont = 0;
		
		while($archivo = readdir($directorio)){
			if($archivo != '.' && $archivo != '..'){

                if(!empty($patern)){
                    if(preg_match($patern,$archivo)){
                        $lista[$cont] = $archivo;
                        $cont++;
                    }
                }else{
                    $lista[$cont] = $archivo;
                    $cont++;
                }
			}
		}
		
		return $lista;
	}


	/**
	 * @param string $ruta
     * @throws DirectoryUtilsExeption
	 * Borra un archivo
	 */
	public function deleteFile($ruta)
    {
		if(file_exists($ruta)){
			unlink($ruta);
		}else{
            throw new DirectoryUtilsExeption($ruta,"El archivo espesificado no existe.");
        }
	}


    /**
     * @param string $ruta
     * @throws DirectoryUtilsExeption
     * Borra un directorio especificado
     */
	public function deleteDirectory($ruta)
    {
		if(is_dir($ruta)){
			$lista = $this->listFiles($ruta);
			
			foreach($lista as $item){
				if(is_dir($ruta."/".$item)){
                    try{
                        $this->deleteDirectory($ruta."/".$item);
                    }catch(DirectoryUtilsExeption $e){
                        throw new DirectoryUtilsExeption($ruta,$e);
                    }
				}else{
					$this->deleteFile($ruta."/".$item);
				}
			}
			
			rmdir($ruta);
		}else{
            throw new DirectoryUtilsExeption($ruta, "La ruta no existe o no es un directorio.");
        }
	}


    /**
     * @param string $origen
     * @param string $destino
     * @throws DirectoryUtilsExeption
     * Copia el contenido de una carpeta y su contenido en una ruta especificada
     */
    public function fullCopy($origen, $destino)
	{
        if ( is_dir( $origen ) ) {
            @mkdir( $destino );
            $d = dir( $origen );
            while ( FALSE !== ( $entry = $d->read() ) ) {
                if ( $entry == '.' || $entry == '..' ) {
                    continue;
                }
                $Entry = $origen . '/' . $entry;
                if ( is_dir( $Entry ) ) {
                    $this->fullCopy( $Entry, $destino . '/' . $entry );
                    continue;
                }
                copy( $Entry, $destino . '/' . $entry );
            }

            $d->close();
        }elseif(is_file($origen)) {
            copy( $origen, $destino );
        }else{
            throw new DirectoryUtilsExeption($origen, "Ruta de origen invalida.");
        }
    }
	
}