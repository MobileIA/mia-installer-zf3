<?php

namespace MIAInstaller\Generate;

use Zend\Code\Generator\PropertyGenerator;
use \Zend\Code\Generator\PropertyValueGenerator;

/**
 * Description of Controller
 *
 * @author matiascamiletti
 */
class Controller extends Base
{
    protected $class;
    
    protected function createProperties()
    {
        $property = new PropertyGenerator('tableName', '', PropertyGenerator::FLAG_PROTECTED);
        $property->setDefaultValue('\\'. $this->module .'\Table'. $this->getFolderNamespace() .'\\'. $this->name .'Table::class', PropertyValueGenerator::TYPE_INT, PropertyValueGenerator::OUTPUT_SINGLE_LINE);
        
        $property2 = new PropertyGenerator('formName', '', PropertyGenerator::FLAG_PROTECTED);
        $property2->setDefaultValue('\\'. $this->module .'\Form'. $this->getFolderNamespace() .'\\'. $this->name .'::class', PropertyValueGenerator::TYPE_INT, PropertyValueGenerator::OUTPUT_SINGLE_LINE);
        
        $this->class->addProperties([
            $property,
            $property2,
            ['template', 'mia-layout-lte', PropertyGenerator::FLAG_PROTECTED],
            ['route', $this->name, PropertyGenerator::FLAG_PROTECTED]
        ]);
    }
    
    protected function createClass()
    {
        $this->class = new \Zend\Code\Generator\ClassGenerator();
        $this->class->setName($this->name . 'Controller');
        $this->class->setNamespaceName($this->module . '\Controller' . $this->getFolderNamespace());
        $this->class->setExtendedClass('\MIABase\Controller\CrudController');
    }
    
    protected function createMethods()
    {
        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName('columns');
        $method->setVisibility(\Zend\Code\Generator\MethodGenerator::FLAG_PUBLIC);
        $method->setBody($this->generateColumnsBody());
        
        $this->class->addMethodFromGenerator($method);
        $this->class->addMethod('fields');
    }
    
    protected function generateColumnsBody()
    {
        $text = "return array(\n";
        
        foreach($this->columns as $column){
            $text .= $column->toController();
        }
        
        $text .= "  array('type' => 'actions', 'title' => 'Acciones')\n);";
        
        return $text;
    }
    
    protected function addConfig()
    {
        $file = file_get_contents('./module/'.$this->module.'/config/module.config.php');
        
        if(stripos($file, "\n            Controller" . $this->getFolderNamespace() . "\\" . $this->name . "Controller::class => InvokableFactory::class,") !== false){
            return false;
        }
        
        $init = stripos($file, "'controllers' => [");
        $init = stripos($file, "'factories' => [", $init);
        $part1 = substr($file, 0, $init+16);
        $part2 = substr($file, $init+16);
        
        $new = $part1 . "\n            Controller" . $this->getFolderNamespace() . "\\" . $this->name . "Controller::class => InvokableFactory::class," . $part2;
        
        file_put_contents('./module/'.$this->module.'/config/module.config.php', $new);
    }
    
    public function run()
    {
        // Creamos la clase
        $this->createClass();
        // Asignamos los atributos
        $this->createProperties();
        // Crear metodos
        $this->createMethods();
        // Crear archivo
        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setClass($this->class);
        // Guardar
        //echo '../module/'.$this->module.'/src/Controller/'.$this->name.'Controller.php'; exit();
        mkdir('./module/'.$this->module.'/src/Controller'. $this->getFolderPath());
        file_put_contents('./module/'.$this->module.'/src/Controller'. $this->getFolderPath() .'/'.$this->name.'Controller.php', $file->generate());
        // Agregados el controlador al config
        $this->addConfig();
    }
}