# CorePHPMapper
CorePHPMapper es una serie de scripts que te permiten abstraer de una base de datos, sus tablas y campos, trasformandolas en Clases PHP para su facil manipulacion mediante el patron DAO.

#Datos de compativilidad
* PHP >= 5.5

#Instalación

La manera recomendada para instalar este paquete es mediante composer con el siguiente comando

    $ composer require corephp/mappercore 1.0.0

Para poder ejecutar el mapeo de CorePHPMapper, debe de asegurarse de que puede ejecutar PHP en la consola de comandos desde cualquier punto, para ello abriremos una terminal de sistema y ejecutaremos el comando:

    $ php -v

Si la consola reconoce el comando, debera de regresanos nuestra vercion actual de PHP.

Una vez verificado que podemos ejecutar PHP desde la terminal, procederemos a ejecutar el script de mapeo, para ello igualmente en una consla nos dirigiremos a la ruta donde se encuentran alojado el archivo de instalación:

    $ cd /ruta/del/proyecto/CoprePHP/Installer

Dentro de la carpeta Installer se encuentra el archivo Install.php, el cual es el script principal de instalación que ejecutaremos para el mapeo de nuestra base de datos. Este archivo recibe 7 parametros para poder funcionar correctamente:

* host -> Dirección del servidor que almacena la base de datos
* dbas -> Nombre de la base de datos para el mapeo
* user -> Nombre de usuario de la base de datos
* pass -> Contraseña de la base de datos
* adminTable -> (Opcional) Nombre de la tabla que servira como administrador e implementara la interfaz AdminDefinition
* adminUserField -> (Opcional - Requerido si adminTable es definido) Nombre del campo que servira como usuario del administrador
* adminPassField -> (Opcional - Requerido si adminTable es definido) Nombre del campo que servira como password del administrador

Para ejecutar el archivo de instalación dentro de la consola de comandos ejecutamos:

    $ php Installer.php host dbas user pass adminTable adminUserField adminPassField

Los parametrode pasados al installador debe de ser en el orden mostrado. Una vez finalizado el proceso de modelado, la carpeta CorePHP\Models contendra las clases abstraidas de la base de datos.
