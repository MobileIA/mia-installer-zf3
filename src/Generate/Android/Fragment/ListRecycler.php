<?php

namespace MIAInstaller\Generate\Android\Fragment;

/**
 * Description of Realm
 *
 * @author matiascamiletti
 */
class ListRecycler extends \MIAInstaller\Generate\Android\Base
{
    /**
     * Path del archivo a tener de base
     * @var string
     */
    protected $filePath = './module/MIAInstaller/data/android/fragment/RecyclerList.java';
    protected $fileXmlPath = './module/MIAInstaller/data/android/fragment/recycler_list.xml';
    /**
     * Path de la carpeta donde se va a guardar
     * @var string
     */
    protected $savePath = './data/android/fragment/';
    
    protected function createXml()
    {
        $xml = file_get_contents($this->fileXmlPath);
        $xml = str_replace('%package%', $this->package, $xml);
        $xml = str_replace('%name%', $this->name, $xml);
        $xml = str_replace('%name_lower%', strtolower($this->name), $xml);
        
        // Guardar
        $name = 'fragment_' . strtolower(preg_replace('/\B([A-Z])/', '_$1', $this->name)) . '_list';
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
            $repo->commit('Se ha agregado el Fragment: ' . $this->name);
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
        
        // Guardar
        if($this->hasRepository()){
            // Abrimos repositorio
            $repo = $this->openRepository();
            // Hacemos un pull buscando cambios
            $repo->pull('origin');
            // Crear carpeta si no existe
            mkdir($this->getRepositoryPath() . '/app/src/main/java/' . $this->getPackageFolder() . '/fragment');
            // Creamos el archivo en la carpeta del repositorio
            file_put_contents($this->getRepositoryPath() . '/app/src/main/java/' . $this->getPackageFolder() . '/fragment/'. $this->name . 'Fragment.java', $this->file);
            // Agregamos al git el archivo generado
            $repo->addFile('app/src/main/java/' . $this->getPackageFolder() . '/fragment/'. $this->name . 'Fragment.java');
        }else{
            file_put_contents($this->savePath . $this->name . 'Fragment.java', $this->file);
        }
        
        $this->createXml();
    }
}