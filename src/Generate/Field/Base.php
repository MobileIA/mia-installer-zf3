<?php

namespace MIAInstaller\Generate\Field;

/**
 * Description of Base
 *
 * @author matiascamiletti
 */
abstract class Base 
{
    /**
     *
     * @var string
     */
    public $type;
    /**
     *
     * @var string
     */
    public $title;
    /**
     *
     * @var string
     */
    public $field;
    
    public function __construct($type, $title, $field)
    {
        $this->type = $type;
        $this->title = $title;
        $this->field = $field;
    }
    
    public function toController()
    {
        return "  array('type' => '".$this->type."', 'title' => '".$this->title."', 'field' => '".$this->field."', 'is_search' => true),\n";
    }
    
    /**
     * @return \Zend\Code\Generator\DocBlockGenerator
     */
    abstract public function getDockBlockProperty(): \Zend\Code\Generator\DocBlockGenerator;
    
    abstract public function toExchangeArray();
    
    abstract public function toExchangeObject();
    
    abstract public function toInputFilter();
    
    abstract public function toForm();
    
    abstract public function toTextInputLayoutAndroid();
    
    abstract public function toInitViewAndroid($activity = 'Activity');
    
    abstract public function toPropertyRealm();
    
    abstract public function toFromMap();
    
    abstract public function toFromJson();
    
    abstract public function toBindHolder();
    
    abstract public function toPropertyViewHolder();
    
    abstract public function toPropertyInitViewHolder();
    
    abstract public function toViewForViewHolder();
}