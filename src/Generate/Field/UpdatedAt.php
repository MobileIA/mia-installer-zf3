<?php

namespace MIAInstaller\Generate\Field;

/**
 * Description of UpdatedAt
 *
 * @author matiascamiletti
 */
class UpdatedAt extends Datetime
{
    public function __construct()
    {
        parent::__construct('Updated at', 'updated_at');
    }
    
    public function toExchangeArray()
    {
        return '';
    }
    
    public function toExchangeObject()
    {
        return '';
    }
    
    public function toInputFilter()
    {
        return '';
    }
    
    public function toForm()
    {
        return '';
    }
    
    public function toTextInputLayoutAndroid()
    {
        return '';
    }
    
    public function toInitViewAndroid($activity = 'Activity')
    {
        return '';
    }
    
    public function toBindHolder()
    {
        return '';
    }
}