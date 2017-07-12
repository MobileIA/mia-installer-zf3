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
        
        $init = stripos($new, "'router' => [");
        $init = stripos($new, "'routes' => [", $init);
        $part1 = substr($new, 0, $init+13);
        $part2 = substr($new, $init+13);
        
        $new2 = $part1 . "\n            '".strtolower($this->name)."' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/".strtolower($this->name)."',
                    'defaults' => [
                        'controller' => Controller" . $this->getFolderNamespace() . "\\" . $this->name . "Controller::class,
                        'action'     => 'index',
                    ],
                ],
                'child_routes' => [
                    'list' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/list[/:page]',
                            'defaults' => [
                                'controller' => Controller" . $this->getFolderNamespace() . "\\" . $this->name . "Controller::class,
                                'action'     => 'index',
                                'page'       => 1
                            ],
                        ],
                    ],
                    'add' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'controller' => Controller" . $this->getFolderNamespace() . "\\" . $this->name . "Controller::class,
                                'action'     => 'add',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/edit/:id',
                            'defaults' => [
                                'controller' => Controller" . $this->getFolderNamespace() . "\\" . $this->name . "Controller::class,
                                'action'     => 'edit',
                            ],
                        ],
                    ],
                    'delete' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/delete/:id',
                            'defaults' => [
                                'controller' => Controller" . $this->getFolderNamespace() . "\\" . $this->name . "Controller::class,
                                'action'     => 'delete',
                            ],
                        ],
                    ],
                ]
            ]," . $part2;
        
        $init = stripos($new2, "'authentication_acl' => [");
        if($init === false){
            $new3 = str_replace('];', "\n    'authentication_acl' => [
        'resources' => [
            Controller" . $this->getFolderNamespace() . "\\" . $this->name . "Controller::class => [
                'actions' => [
                    'index' => ['allow' => 'member'],
                    'add' => ['allow' => 'member'],
                    'edit' => ['allow' => 'member'],
                    'delete' => ['allow' => 'member'],
                ]
            ],
        ],
    ],", $new2);
        }else{
            $init = stripos($new2, "'resources' => [", $init);
            $part1 = substr($new2, 0, $init+16);
            $part2 = substr($new2, $init+16);

            $new3 = $part1 . "\n            Controller" . $this->getFolderNamespace() . "\\" . $this->name . "Controller::class => [
                'actions' => [
                    'index' => ['allow' => 'member'],
                    'add' => ['allow' => 'member'],
                    'edit' => ['allow' => 'member'],
                    'delete' => ['allow' => 'member'],
                ]
            ]," . $part2;
        }
        
        file_put_contents('./module/'.$this->module.'/config/module.config.php', $new3);
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