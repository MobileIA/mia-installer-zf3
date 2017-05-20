<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MIAInstaller\Generate\Android;

/**
 * Description of Realm
 *
 * @author matiascamiletti
 */
class Adapter extends Base
{
    /**
     * Path del archivo a tener de base
     * @var string
     */
    protected $filePath = './module/MIAInstaller/data/android/adapter/RecyclerViewAdapter.java';
    protected $fileXmlPath = './module/MIAInstaller/data/android/adapter/item_adapter.xml';
    /**
     * Path de la carpeta donde se va a guardar
     * @var string
     */
    protected $savePath = './data/android/adapter/';
    
    protected function createXml()
    {
        $xml = file_get_contents($this->fileXmlPath);
        
        $views = '';
        /* @var $column \MIAInstaller\Generate\Field\Base */
        foreach($this->columns as $column){
            $views .= $column->toViewForViewHolder() . "\n";
        }
        $xml = str_replace('%content%', $views, $xml);
        
        // Guardar
        $name = 'item_list_' . strtolower(preg_replace('/\B([A-Z])/', '_$1', $this->name));
        if($this->hasRepository()){
            // Abrimos repositorio
            $repo = $this->openRepository();
            // Hacemos un pull buscando cambios
            $repo->pull('origin');
            // Creamos el archivo en la carpeta del repositorio
            file_put_contents($this->getRepositoryPath() . '/app/src/main/res/layout/'. $name . '.xml', $xml);
            // Agregamos al git el archivo generado
            $repo->addFile('app/src/main/res/layout/'. $name . '.xml');
            // Hacemos commit
            $repo->commit('Se ha agregado el adapter: ' . $this->name);
            // Hacemos el Push
            $repo->push('origin');
        }else{
            file_put_contents($this->savePath . $name . '.xml', $xml);
        }
    }
    
    public function run()
    {
        $this->file = str_replace('%package%', $this->package, $this->file);
        $this->file = str_replace('%name%', $this->name, $this->file);
        $this->file = str_replace('%name_lower%', strtolower($this->name), $this->file);
        
        $properties = '';
        $onBindHolder = '';
        $propertiesInit = '';
        /* @var $column \MIAInstaller\Generate\Field\Base */
        foreach($this->columns as $column){
            $properties .= $column->toPropertyViewHolder() . "\n";
            $onBindHolder .= $column->toBindHolder() . "\n";
            $propertiesInit .= $column->toPropertyInitViewHolder() . "\n";
        }
        $this->file = str_replace('%properties%', $properties, $this->file);
        $this->file = str_replace('%on_bind_holder%', $onBindHolder, $this->file);
        $this->file = str_replace('%properties_init%', $propertiesInit, $this->file);
        
        // Guardar
        if($this->hasRepository()){
            // Abrimos repositorio
            $repo = $this->openRepository();
            // Hacemos un pull buscando cambios
            $repo->pull('origin');
            // Crear carpeta si no existe
            mkdir($this->getRepositoryPath() . '/app/src/main/java/' . $this->getPackageFolder() . '/adapter');
            // Creamos el archivo en la carpeta del repositorio
            file_put_contents($this->getRepositoryPath() . '/app/src/main/java/' . $this->getPackageFolder() . '/adapter/'. $this->name . 'Adapter.java', $this->file);
            // Agregamos al git el archivo generado
            $repo->addFile('app/src/main/java/' . $this->getPackageFolder() . '/adapter/'. $this->name . 'Adapter.java');
        }else{
            file_put_contents($this->savePath . $this->name . 'Adapter.java', $this->file);
        }
        
        $this->createXml();
    }
}