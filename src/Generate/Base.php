<?php

namespace MIAInstaller\Generate;

/**
 * Description of Base
 *
 * @author matiascamiletti
 */
abstract class Base
{
    /**
     * Nombre del archivo
     * @var string
     */
    protected $name = '';
    /**
     * Nombre del modulo
     * @var string
     */
    protected $module = '';
    /**
     * Almacena las columnas
     * @var array
     */
    protected $columns = array();
    /**
     * Por si se necesita guardar el archivo en una carpeta
     * @var string
     */
    protected $folder = '';
    
    abstract public function run();
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setModule($module)
    {
        $this->module = $module;
    }
    
    public function addColumn($column)
    {
        $this->columns[] = $column;
    }
    
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }
    
    public function setFolder($folder)
    {
        $this->folder = $folder;
    }
    
    public function getFolderPath()
    {
        if($this->folder == ''){
            return '';
        }
        
        return '/' . $this->folder;
    }
    
    public function getFolderNamespace()
    {
        if($this->folder == ''){
            return '';
        }
        
        return '\\' . $this->folder;
    }
}
