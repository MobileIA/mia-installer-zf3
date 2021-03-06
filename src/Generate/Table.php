<?php

namespace MIAInstaller\Generate;

use Zend\Code\Generator\PropertyGenerator;
use \Zend\Code\Generator\PropertyValueGenerator;

/**
 * Description of Table
 *
 * @author matiascamiletti
 */
class Table extends Base
{
    protected function createProperties()
    {
        $property = new PropertyGenerator('tableName', '', PropertyGenerator::FLAG_PROTECTED);
        $property->setDefaultValue(strtolower($this->name));
        
        $property2 = new PropertyGenerator('entityClass', '', PropertyGenerator::FLAG_PROTECTED);
        $property2->setDefaultValue('\\'. $this->module .'\Entity'. $this->getFolderNamespace() .'\\'. $this->name .'::class', PropertyValueGenerator::TYPE_INT, PropertyValueGenerator::OUTPUT_SINGLE_LINE);
        
        $this->class->addProperties([
            $property,
            $property2
        ]);
    }
    
    protected function createClass()
    {
        $this->class = new \Zend\Code\Generator\ClassGenerator();
        $this->class->setName($this->name . 'Table');
        $this->class->setNamespaceName($this->module . '\Table' . $this->getFolderNamespace());
        $this->class->setExtendedClass('\MIABase\Table\Base');
    }
    
    protected function addConfig()
    {
        $file = file_get_contents('./module/'.$this->module.'/config/module.config.php');
        
        if(stripos($file, "\n            Table" . $this->getFolderNamespace() . "\\" . $this->name . "Table::class => \MIABase\Factory\TableFactory::class,") !== false){
            return false;
        }
        
        $init = stripos($file, "'service_manager' => [");
        $init = stripos($file, "'factories' => [", $init);
        $part1 = substr($file, 0, $init+16);
        $part2 = substr($file, $init+16);
        
        $new = $part1 . "\n            Table" . $this->getFolderNamespace() . "\\" . $this->name . "Table::class => \MIABase\Factory\TableFactory::class," . $part2;
        
        file_put_contents('./module/'.$this->module.'/config/module.config.php', $new);
    }
    
    public function run()
    {
        // Creamos la clase
        $this->createClass();
        // Asignamos los atributos
        $this->createProperties();
        // Crear archivo
        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setClass($this->class);
        // Guardar
        mkdir('./module/'.$this->module.'/src/Table'. $this->getFolderPath());
        file_put_contents('./module/'.$this->module.'/src/Table'. $this->getFolderPath() .'/'.$this->name.'Table.php', $file->generate());
        // Agregados el Table al config
        $this->addConfig();
    }
}