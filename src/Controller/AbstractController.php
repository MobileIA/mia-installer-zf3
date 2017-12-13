<?php

namespace MIAInstaller\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Description of AbstractController
 *
 * @author matiascamiletti
 */
class AbstractController extends AbstractActionController
{
    protected function createEntity($name, $module, $columns, $folder = '')
    {
        $entity = new \MIAInstaller\Generate\Entity();
        $entity->setName($name);
        $entity->setModule($module);
        $entity->setFolder($folder);
        $entity->setColumns($columns);
        $entity->run();
    }
    
    protected function createTable($name, $module, $columns, $folder = '')
    {
        $table = new \MIAInstaller\Generate\Table();
        $table->setName($name);
        $table->setModule($module);
        $table->setFolder($folder);
        $table->setColumns($columns);
        $table->run();
    }
    
    protected function createForm($name, $module, $columns, $folder = '')
    {
        $table = new \MIAInstaller\Generate\Form();
        $table->setName($name);
        $table->setModule($module);
        $table->setFolder($folder);
        $table->setColumns($columns);
        $table->run();
    }
    
    protected function createRealm($name, $columns, $package, $repository)
    {
        $android = new \MIAInstaller\Generate\Android\Realm();
        $android->setPackage($package);
        $android->setName($name);
        $android->setColumns($columns);
        $android->setRepository($repository);
        $android->run();
    }
    
    protected function createBackend($name, $module, $columns)
    {
        $controller = new \MIAInstaller\Generate\Controller();
        $controller->setName($name);
        $controller->setModule($module);
        $controller->setColumns($columns);
        $controller->run();
    }
    
    protected function createApi($name, $module, $columns)
    {
        $controller = new \MIAInstaller\Generate\Api\Controller();
        $controller->setName($name);
        $controller->setModule($module);
        $controller->setColumns($columns);
        $controller->run();
    }
}