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