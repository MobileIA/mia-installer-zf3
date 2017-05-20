<?php

namespace MIAInstaller\Generate;

/**
 * Description of Crud
 *
 * @author matiascamiletti
 */
class Crud extends Base
{
    protected function createController()
    {
        $controller = new \MIAInstaller\Generate\Controller();
        $controller->setName($this->name);
        $controller->setFolder($this->folder);
        $controller->setModule($this->module);
        $controller->setColumns($this->columns);
        $controller->run();
    }
    
    protected function createEntity()
    {
        $entity = new \MIAInstaller\Generate\Entity();
        $entity->setName($this->name);
        $entity->setFolder($this->folder);
        $entity->setModule($this->module);
        $entity->setColumns($this->columns);
        $entity->run();
    }
    
    protected function createForm()
    {
        $form = new \MIAInstaller\Generate\Form();
        $form->setName($this->name);
        $form->setFolder($this->folder);
        $form->setModule($this->module);
        $form->setColumns($this->columns);
        $form->run();
    }
    
    protected function createTable()
    {
        $table = new \MIAInstaller\Generate\Table();
        $table->setName($this->name);
        $table->setFolder($this->folder);
        $table->setModule($this->module);
        $table->setColumns($this->columns);
        $table->run();
    }
    
    public function run()
    {
        $this->createController();
        $this->createEntity();
        $this->createForm();
        $this->createTable();
    }
}