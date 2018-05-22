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
    
    protected function createForDB($tables)
    {
        // Obtenemos el schema de la DB
        $metadata = \Zend\Db\Metadata\Source\Factory::createSourceFromAdapter($this->getDBAdapter());
        // Recorremos las tablas encontradas
        foreach($metadata->getTableNames() as $tableName){
            if(!in_array($tableName, $tables)){
                continue;
            }
            $this->createForTable($metadata, $tableName);
        }
    }
    /**
     * 
     * @param \Zend\Db\Metadata\MetadataInterface $metadata
     * @param type $tableName
     */
    protected function createForTable($metadata, $tableName)
    {
        // Obtenemos tabla
        $table = $metadata->getTable($tableName);
        // Array para guardar los campos
        $fields = array();
        // recorremos las columnas
        foreach($table->getColumns() as $column){
            $field = $this->generateColumn($column);
            if($field === null){
                continue;
            }
            $fields[] = $field;
        }
        // Crear entidad
        $nameEntity = str_replace(' ', '', ucwords(str_replace('_', ' ', $tableName)));
        $this->createEntity($nameEntity, 'Application', $fields);
        $this->createTable($nameEntity, 'Application', $fields);
    }
    /**
     * Convierte una Columna Metadata en Field
     * @param \Zend\Db\Metadata\Object\ColumnObject $column
     * @return \MIAInstaller\Generate\Field\Base
     */
    protected function generateColumn($column)
    {
        if($column->getName() == 'id'){
            return new \MIAInstaller\Generate\Field\Id();
        }else if($column->getName() == 'created_at'){
            return null;
        }else if($column->getName() == 'updated_at'){
            return null;
        }else if($column->getName() == 'deleted'){
            return null;
        }else if($column->getDataType() == 'bigint'){
            return new \MIAInstaller\Generate\Field\Integer(ucwords(str_replace('_', ' ', $column->getName())), $column->getName());
        }else if($column->getDataType() == 'int'){
            return new \MIAInstaller\Generate\Field\Integer(ucwords(str_replace('_', ' ', $column->getName())), $column->getName());
        }else if($column->getDataType() == 'float'||$column->getDataType() == 'decimal'){
            return new \MIAInstaller\Generate\Field\Double(ucwords(str_replace('_', ' ', $column->getName())), $column->getName());
        }else if($column->getDataType() == 'varchar'){
            return new \MIAInstaller\Generate\Field\StringF(ucwords(str_replace('_', ' ', $column->getName())), $column->getName());
        }else if($column->getDataType() == 'text'){
            return new \MIAInstaller\Generate\Field\Text(ucwords(str_replace('_', ' ', $column->getName())), $column->getName());
        }else if($column->getDataType() == 'datetime'||$column->getDataType() == 'date'){
            return new \MIAInstaller\Generate\Field\Datetime(ucwords(str_replace('_', ' ', $column->getName())), $column->getName());
        }
        throw new Exception("Tipo no valido.");
    }
    /**
     * 
     * @return Adapter
     */
    public function getDBAdapter()
    {
        return $this->getEvent()->getApplication()->getServiceManager()->get('Zend\Db\Adapter\Adapter');
    }
}