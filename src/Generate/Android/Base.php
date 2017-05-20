<?php

namespace MIAInstaller\Generate\Android;

/**
 * Description of Base
 *
 * @author matiascamiletti
 */
abstract class Base extends \MIAInstaller\Generate\File
{
    /**
     * Almacena el package de la clase
     * @var string
     */
    protected $package = '';
    /**
     * Almacena URL del repositorio.
     * @var string
     */
    protected $repository = '';
    /**
     * PATH de la carpeta donde se guardan los repositorios
     * @var string
     */
    protected $repositoryFolder = './data/repositories/';
    /**
     * Abre y/o clona el repositorio
     * @return \Cz\Git\GitRepository
     */
    public function openRepository()
    {
        try {
            // Clonar repositorio
            return \Cz\Git\GitRepository::cloneRepository($this->repository, $this->repositoryFolder . $this->getRepositoryFolderName());
        } catch (\Cz\Git\GitException $exc) {
            // Si ya existe abrimos el repositorio.
            return new \Cz\Git\GitRepository($this->repositoryFolder . $this->getRepositoryFolderName());
        }
    }
    /**
     * Devuelve el path de la carpeta del repositorio
     * @return string
     */
    public function getRepositoryPath()
    {
        return $this->repositoryFolder . $this->getRepositoryFolderName();
    }
    /**
     * Devuelve el nombre de la carpeta del repositorio
     * @return string
     */
    public function getRepositoryFolderName()
    {
        $data = explode('/', $this->repository);
        $name = $data[count($data)-1];
        return str_replace('.git', '', $name);
    }
    /**
     * Determina si tiene setea un repositorio
     * @return boolean
     */
    public function hasRepository()
    {
        if($this->repository == ''){
            return false;
        }
        return true;
    }
    /**
     * Devuelve en PATH el package de la aplicación
     * @return string
     */
    public function getPackageFolder()
    {
        $data = explode('.', $this->package);
        $folder = '';
        for($i = 0; $i < count($data); $i++){
            if($i > 0){
                $folder .= '/';
            }
            $folder .= $data[$i];
        }
        return $folder;
    }
    /**
     * Setea el package de la aplicacion
     * @param string $package
     */
    public function setPackage($package)
    {
        $this->package = $package;
    }
    /**
     * Setea la URL del repositorio.
     * @param string $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }
}