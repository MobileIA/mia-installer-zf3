<?php

namespace MIAInstaller\Generate;

/**
 * Description of File
 *
 * @author matiascamiletti
 */
abstract class File extends Base
{
    /**
     * Path del archivo a tener de base
     * @var string
     */
    protected $filePath = '';
    /**
     * Almacena el contenido del archivo
     * @var string
     */
    protected $file = '';
    /**
     * Path de la carpeta donde se va a guardar
     * @var string
     */
    protected $savePath = '';
    
    public function __construct()
    {
        // Abrir el archivo
        $this->openFile();
    }
    
    protected function openFile()
    {
        $this->file = file_get_contents($this->filePath);
    }
}