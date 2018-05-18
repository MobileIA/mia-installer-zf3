<?php

namespace MIAInstaller\Generate;

/**
 * Description of Form
 *
 * @author matiascamiletti
 */
class Form extends Base
{
    protected function createMethods()
    {
        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName('__construct');
        $method->setVisibility(\Zend\Code\Generator\MethodGenerator::FLAG_PUBLIC);
        $method->setParameters([\Zend\Code\Generator\ParameterGenerator::fromArray(array('name' => 'name', 'defaultvalue' => null)), \Zend\Code\Generator\ParameterGenerator::fromArray(array('name' => 'options', 'defaultvalue' => array()))]);
        
        $body = 'parent::__construct(\''. strtolower($this->name) .'\', $options);' . "\n";
        foreach($this->columns as $column){
            $body .= $column->toForm() . "\n";
        }
        $body .= '$this->add([
            \'name\' => \'submit\',
            \'type\' => \'submit\',
            \'attributes\' => [
                \'value\' => \'Enviar\',
                \'id\'    => \'submitbutton\',
            ],
        ]);';
        
        $method->setBody($body);
        
        $this->class->addMethodFromGenerator($method);
        $this->class->addMethodFromGenerator($this->methodAddInputFilter());
    }
    
    protected function methodAddInputFilter()
    {
        $method = new \Zend\Code\Generator\MethodGenerator();
        $method->setName('addInputFilter');
        //$method->setReturnType('\Zend\InputFilter\InputFilterInterface');
        $method->setVisibility(\Zend\Code\Generator\MethodGenerator::FLAG_PUBLIC);
        
        $body = '     
$inputFilter = new \Zend\InputFilter\InputFilter();' . "\n";
        foreach($this->columns as $column){
            if($column->field == 'created_at'||$column->field == 'updated_at'||$column->field == 'id'){
                continue;
            }
            $body .= $column->toInputFilter() . "\n";
        }
        $body .= '$this->setInputFilter($inputFilter);';
        
        $method->setBody($body);
        
        return $method;
    }
    
    protected function createClass()
    {
        $this->class = new \Zend\Code\Generator\ClassGenerator();
        $this->class->setName($this->name);
        $this->class->setNamespaceName($this->module . '\Form' . $this->getFolderNamespace());
        $this->class->setExtendedClass('\MIABase\Form\Base');
    }
    
    public function run()
    {
        // Creamos la clase
        $this->createClass();
        // Crear metodos
        $this->createMethods();
        // Crear archivo
        $file = new \Zend\Code\Generator\FileGenerator();
        $file->setClass($this->class);
        // Guardar
        mkdir('./module/'.$this->module.'/src/Form'. $this->getFolderPath());
        file_put_contents('./module/'.$this->module.'/src/Form'. $this->getFolderPath() .'/'.$this->name.'.php', $file->generate());
    }
}