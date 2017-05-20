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
            if($column->field == 'created_at'||$column->field == 'updated_at'){
                continue;
            }
            
            $property = new PropertyGenerator($column->field, null, PropertyGenerator::FLAG_PUBLIC);
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
            if($column->field == 'created_at'||$column->field == 'updated_at'){
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
            $body .= $column->toExchangeObject();
        }
        
        $method->setBody($body);
        
        return $method;
        
    }
    
    protected function methodGetInputFilter()
    {
        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName('getInputFilter');
        //$method->setReturnType('\Zend\InputFilter\InputFilterInterface');
        $method->setVisibility(\Zend\Code\Generator\MethodGenerator::FLAG_PUBLIC);
        
        $body = 'if ($this->inputFilter) {
    return $this->inputFilter;
}
        
$inputFilter = new \Zend\InputFilter\InputFilter();' . "\n";
        foreach($this->columns as $column){
            $body .= $column->toInputFilter() . "\n";
        }
        $body .= '$this->inputFilter = $inputFilter;
return $this->inputFilter;';
        
        $method->setBody($body);
        
        return $method;
    }
    
    protected function methodSetInputFilter()
    {
        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName('setInputFilter');
        //$method->setReturnType('\Zend\InputFilter\InputFilterAwareInterface');
        $method->setVisibility(\Zend\Code\Generator\MethodGenerator::FLAG_PUBLIC);
        $method->setParameter(\Zend\Code\Generator\ParameterGenerator::fromArray(array('name' => 'inputFilter', 'type' => '\Zend\InputFilter\InputFilterInterface')));
        
        $body = 'throw new DomainException(sprintf(
            \'%s does not allow injection of an alternate input filter\',
            __CLASS__
        ));';
        
        $method->setBody($body);
        
        return $method;
    }
    
    protected function createMethods()
    {
        $this->class->addMethodFromGenerator($this->methodToArray());
        $this->class->addMethodFromGenerator($this->methodExchangeArray());
        $this->class->addMethodFromGenerator($this->methodExchangeObject());
        $this->class->addMethodFromGenerator($this->methodGetInputFilter());
        $this->class->addMethodFromGenerator($this->methodSetInputFilter());
    }
    
    protected function createClass()
    {
        $this->class = new \Zend\Code\Generator\ClassGenerator();
        $this->class->setName($this->name);
        $this->class->setNamespaceName($this->module . '\Entity' . $this->getFolderNamespace());
        $this->class->setExtendedClass('\MIABase\Entity\Base');
        $this->class->setImplementedInterfaces(array('\Zend\InputFilter\InputFilterAwareInterface'));
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