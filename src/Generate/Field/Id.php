<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MIAInstaller\Generate\Field;

/**
 * Description of Id
 *
 * @author matiascamiletti
 */
class Id extends Integer
{
    public function __construct()
    {
        parent::__construct('ID', 'id');
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
    
    public function toPropertyRealm()
    {
        return '@PrimaryKey'. "\n" .'    public int '.$this->field.';';
    }
    
    public function toBindHolder()
    {
        return '';
    }
    
    public function toPropertyViewHolder()
    {
        return '';
    }
    
    public function toPropertyInitViewHolder()
    {
        return '';
    }
    
    public function toViewForViewHolder()
    {
        return '';
    }
}