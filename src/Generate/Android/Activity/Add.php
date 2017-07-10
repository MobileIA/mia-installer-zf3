<?php

namespace MIAInstaller\Generate\Android\Activity;

/**
 * Description of Add
 *
 * @author matiascamiletti
 */
class Add extends \MIAInstaller\Generate\Android\Base
{
    /**
     * Path del archivo a tener de base
     * @var string
     */
    protected $filePath = './vendor/mobileia/mia-installer-zf3/data/android/activity/Add.java';
    protected $fileXmlPath = './vendor/mobileia/mia-installer-zf3/data/android/activity/add.xml';
    /**
     * Path de la carpeta donde se va a guardar
     * @var string
     */
    protected $savePath = './data/android/activity/';
    
    protected function createXml()
    {
        $xml = file_get_contents($this->fileXmlPath);
        $xml = str_replace('%package%', $this->package, $xml);
        $xml = str_replace('%name%', $this->name, $xml);
        
        $views = '';
        /* @var $column \MIAInstaller\Generate\Field\Base */
        foreach($this->columns as $column){
            $views .= $column->toTextInputLayoutAndroid() . "\n";
        }
        $xml = str_replace('%content%', $views, $xml);
        
        // Guardar
        $name = 'activity_' . strtolower(preg_replace('/\B([A-Z])/', '_$1', str_replace('Activity', '', $this->name)));
        file_put_contents($this->savePath . $name . '.xml', $xml);
    }
    
    protected function createActivity()
    {
        $this->file = str_replace('%package%', $this->package, $this->file);
        $this->file = str_replace('%name%', $this->name, $this->file);
        
        $xml = strtolower(preg_replace('/\B([A-Z])/', '_$1', str_replace('Activity', '', $this->name)));
        $this->file = str_replace('%xml%', $xml, $this->file);
        
        $properties = '';
        $views = '';
        /* @var $column \MIAInstaller\Generate\Field\Base */
        foreach($this->columns as $column){
            if($column->field == 'id'||$column->field == 'created_at'||$column->field == 'updated_at'){
                continue;
            }
            $name = str_replace(' ', '', ucwords(str_replace('_', ' ', $column->field)));
            $properties .= '    protected EditText m'. $name .'Text;' . "\n";
            $views .= $column->toInitViewAndroid($this->name);
        }
        $this->file = str_replace('%properties%', $properties, $this->file);
        $this->file = str_replace('%views%', $views, $this->file);
        
        // Guardar
        file_put_contents($this->savePath . $this->name . '.java', $this->file);
    }
    
    public function run()
    {
        $this->createActivity();
        $this->createXml();
    }
    
}
