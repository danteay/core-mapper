<?php
/**
 * @author Eduardo Aguilar <dante.aguilar41@gmail.com>
 */

namespace CorePHP\Installer\Models;

use Symfony\Component\Yaml\Yaml;

class ModelCreator extends Mapper
{
    /**
     * ModelCreator constructor
     *
     * @param string $host
     * @param string $dbas
     * @param string $user
     * @param string $pass
     */
    public function __construct($host, $dbas, $user, $pass)
    {
        parent::__construct($host,$dbas,$user,$pass);

        $this->init();
        $this->conexionInitializer($host, $dbas, $user, $pass);
    }

    /**
     * Inicio del mapeo
     *
     * @throws \Exception
     */
    private function init()
    {
        foreach (parent::getListTables() as $table) {
            $this->createModel($table);
        }
    }

    /**
     * Inicializa los valores de conexion para la clase CorePHP\Core\Conexion
     *
     * @param string $host
     * @param string $dbas
     * @param string $user
     * @param string $pass
     */
    private function conexionInitializer($host, $dbas, $user, $pass)
    {
        $config = Yaml::parse(file_get_contents(parent::CONFIG_FILE));

        $config['database']['host'] = $host;
        $config['database']['dbas'] = $dbas;
        $config['database']['user'] = $user;
        $config['database']['pass'] = $pass;

        file_put_contents(__DIR__ . '/../../config/config.yml', Yaml::dump($config, 2));
    }

    /**
     * Generacion de los Modelos con respecto a la configuracion de las tablas de la base de datos
     *
     * @param string $table
     * @throws \Exception
     */
    public function createModel($table)
    {
        $modelFile = file_get_contents(parent::MODEL_DEFINITION);
        $fields = $this->getListFields($table);

        $modelFile = str_replace(parent::MODEL_FIELDS_KEY, $this->createModelFields($fields), $modelFile);
        $modelFile = str_replace(parent::CLASS_NAME, ucfirst($table), $modelFile);

        $this->createYamlConfigTable($table, $fields);

        file_put_contents(__DIR__ . "/../../Models/" .ucfirst($table).".php", $modelFile);
    }

    /**
     * Creacion de las variables de clase de los modelos
     *
     * @param array $fields
     * @return string
     */
    private function createModelFields(array $fields)
    {
        $fieldString = "";
        $flag = true;

        foreach($fields as $field){
            if($flag){
                $fieldString .= "private \$$field[0];";
                $flag = false;
            }else{
                $fieldString .= "\n\tprivate \$$field[0];";
            }
        }

        return $fieldString;
    }

    /**
     * Mapeo de la tabla en formato Yaml para uso de modelos
     *
     * @param $table
     * @param $fields
     */
    private function createYamlConfigTable($table, $fields)
    {
        $config = array(
            'model' => ucfirst($table),
            'table' => $table,
            'fields' => []
        );

        $foreign_keys = $this->getForeignKeys($table);

        foreach ($fields as $field) {
            $flag = false;
            $reference = null;

            foreach ($foreign_keys as $key) {
                if ($field[0] == $key->origin_field) {
                    $flag = true;
                    $reference = $key;
                    break;
                }
            }

            $config['fields'][] = array(
                'name' => $field[0],
                'type' => Validations::isNumeric($field) ? 'numeric' : 'string',
                'primary' => Validations::isPrimary($field),
                'nullable' => Validations::isNullable($field),
                'is_foreing' => $flag,
                'references' => $flag ? [
                    'table' => $reference->reference_table,
                    'model' => ucfirst($reference->reference_table),
                    'field' => $reference->reference_field
                ] : null
            );
        }

        $yaml = Yaml::dump($config, 2);

        if (!is_dir(__DIR__ . '/../../config/migrate')) {
            mkdir(__DIR__ . '/../../config/migrate');
        }

        file_put_contents(__DIR__ . '/../../config/migrate/' . $config['model'] . '.yml', $yaml);
    }
}