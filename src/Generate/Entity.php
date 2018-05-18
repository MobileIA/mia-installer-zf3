<?php

namespace MIAInstaller\Generate;

use Zend\Code\Generator\PropertyGenerator;
use \Zend\Code\Generator\PropertyValueGenerator;

/**
 * Description of Entity
 *
 * @author matiascamiletti
 */
class Entity extends Base
{
    protected $class;
    
    protected function createProperties()
    {
        foreach($this->columns as $column){
            if($column->field == 'created_at'||$column->field == 'updated_at'||$column->field == 'id'){
                continue;
            }
            // Definir valor por defecto
            $valueDefault = '';
            if($column->type == 'int'||$column->type == 'double'){
                $valueDefault = 0;
            }
            $property = new PropertyGenerator($column->field, $valueDefault, PropertyGenerator::FLAG_PUBLIC);
            $property->setDocBlock($column->getDockBlockProperty());
            $this->class->addPropertyFromGenerator($property);
        }
    }
    
    protected function methodToArray()
    {
        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName('toArray');
        $method->setVisibility(\Zend\Code\Generator\MethodGenerator::FLAG_PUBLIC);
        
        $body = '$data = parent::toArray();' . "\n";
        foreach($this->columns as $column){
            if($column->field == 'created_at'||$column->field == 'updated_at'||$column->field == 'id'){
                continue;
            }
            $body .= '$data[\''.$column->field.'\'] = $this->'.$column->field.';' . "\n";
        }
        $body .= 'return $data;';
        
        $method->setBody($body);
        
        return $method;
    }
    
    protected function methodExchangeArray()
    {
        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName('exchangeArray');
        $data = new \Zend\Code\Generator\ParameterGenerator();
        $data->setName('data');
        $data->setType('array');
        $method->setParameter($data);
        $method->setVisibility(\Zend\Code\Generator\MethodGenerator::FLAG_PUBLIC);
        
        $body = 'parent::exchangeArray($data);' . "\n";
        foreach($this->columns as $column){
            if($column->field == 'created_at'||$column->field == 'updated_at'||$column->field == 'id'){
                continue;
            }
            $body .= $column->toExchangeArray();
        }
        
        $method->setBody($body);
        
        return $method;
    }
    
    protected function methodExchangeObject()
    {
        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName('exchangeObject');
        $method->setParameter('data');
        $method->setVisibility(\Zend\Code\Generator\MethodGenerator::FLAG_PUBLIC);
        
        $body = 'parent::exchangeObject($data);' . "\n";
        foreach($this->columns as $column){
            if($column->field == 'created_at'||$column->field == 'updated_at'||$column->field == 'id'){
                continue;
            }
            $body .= $column->toExchangeObject();
        }
        
        $method->setBody($body);
        
        return $method;
        
    }
    
    protected function createMethods()
    {
        //$this->class->addMethodFromGenerator($this->methodExchangeArray());
        //$this->class->addMethodFromGenerator($this->methodExchangeObject());
    }
    
    protected function createClass()
    {
        $this->class = new \Zend\Code\Generator\ClassGenerator();
        $this->class->setName($this->name);
        $this->class->setNamespaceName($this->module . '\Entity' . $this->getFolderNamespace());
        $this->class->setExtendedClass('\MIABase\Entity\Base');
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
        mkdir('./module/'.$this->module.'/src/Entity'. $this->getFolderPath());
        file_put_contents('./module/'.$this->module.'/src/Entity'. $this->getFolderPath() .'/'.$this->name.'.php', $file->generate());
    }

}