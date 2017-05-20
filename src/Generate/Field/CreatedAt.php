<?php

namespace MIAInstaller\Generate\Field;

/**
 * Description of CreatedAt
 *
 * @author matiascamiletti
 */
class CreatedAt extends Datetime
{
    public function __construct()
    {
        parent::__construct('Created at', 'created_at');
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
}