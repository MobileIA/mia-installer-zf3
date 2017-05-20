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
class Realm extends Base
{
    /**
     * Path del archivo a tener de base
     * @var string
     */
    protected $filePath = './module/MIAInstaller/data/android/Realm.java';
    /**
     * Path de la carpeta donde se va a guardar
     * @var string
     */
    protected $savePath = './data/android/entity/';
    
    public function run()
    {
        $this->file = str_replace('%package%', $this->package, $this->file);
        $this->file = str_replace('%name%', $this->name, $this->file);
        
        $properties = '';
        $fromMap = '';
        $fromJson = '';
        /* @var $column \MIAInstaller\Generate\Field\Base */
        foreach($this->columns as $column){
            $name = str_replace(' ', '', ucwords(str_replace('_', ' ', $column->field)));
            $properties .= $column->toPropertyRealm() . "\n\n";
            $fromMap .= $column->toFromMap() . "\n";
            $fromJson .= $column->toFromJson() . "\n";
        }
        $this->file = str_replace('%properties%', $properties, $this->file);
        $this->file = str_replace('%from_map%', $fromMap, $this->file);
        $this->file = str_replace('%from_json%', $fromJson, $this->file);
        
        // Guardar
        if($this->hasRepository()){
            // Abrimos repositorio
            $repo = $this->openRepository();
            // Hacemos un pull buscando cambios
            $repo->pull('origin');
            // Crear carpeta si no existe
            mkdir($this->getRepositoryPath() . '/app/src/main/java/' . $this->getPackageFolder() . '/entity');
            // Creamos el archivo en la carpeta del repositorio
            file_put_contents($this->getRepositoryPath() . '/app/src/main/java/' . $this->getPackageFolder() . '/entity/'. $this->name . '.java', $this->file);
            // Agregamos al git el archivo generado
            $repo->addFile('app/src/main/java/' . $this->getPackageFolder() . '/entity/'. $this->name . '.java');
            // Hacemos commit
            $repo->commit('Se ha agregado la entidad: ' . $this->name);
            // Hacemos el Push
            $repo->push('origin');
        }else{
            file_put_contents($this->savePath . $this->name . '.java', $this->file);
        }
    }
}