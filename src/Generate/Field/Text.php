<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MIAInstaller\Generate\Field;

/**
 * Description of Text
 *
 * @author matiascamiletti
 */
class Text extends Base
{
    public function __construct($title, $field)
    {
        parent::__construct('text', $title, $field);
    }
    
    public function getDockBlockProperty(): \Zend\Code\Generator\DocBlockGenerator
    {
        return \Zend\Code\Generator\DocBlockGenerator::fromArray([
                        'tags' => [
                                [
                                'name' => 'var',
                                'description' => 'string',
                            ],
                        ],
            ]);
    }
    
    public function toExchangeArray()
    {
        return '$this->'.$this->field.' = (!empty($data[\''.$this->field.'\'])) ? $data[\''.$this->field.'\'] : \'\';' . "\n";
    }
    
    public function toExchangeObject()
    {
        return '$this->'.$this->field.' = $data->'.$this->field.';' . "\n";;
    }
    
    public function toInputFilter()
    {
        return '$inputFilter->add([
            \'name\' => \''.$this->field.'\',
            \'required\' => true,
            \'filters\' => [
                [\'name\' => \Zend\Filter\StripTags::class],
                [\'name\' => \Zend\Filter\StringTrim::class],
            ],
        ]);';
    }
    
    public function toForm()
    {
        return '$this->add([
        \'name\' => \''.$this->field.'\',
        \'type\' => \'textarea\',
        \'options\' => [
            \'label\' => \''.$this->title.'\'
        ]
    ]);';
    }
    
    public function toTextInputLayoutAndroid()
    {
        $name = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $this->field))));
        return '            <android.support.design.widget.TextInputLayout
                android:id="@+id/'.$name.'Container"
                android:layout_width="match_parent"
                android:layout_height="wrap_content">

                <EditText
                    android:id="@+id/'.$name.'Text"
                    android:layout_width="match_parent"
                    android:layout_height="wrap_content"
                    android:hint="'.$this->title.'"
                    android:maxLines="1"
                    android:inputType="text|textCapSentences|textAutoCorrect|textAutoComplete"
                    android:singleLine="true" />

            </android.support.design.widget.TextInputLayout>' . "\n";
    }
    
    public function toInitViewAndroid($activity = 'Activity')
    {
        $name = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->field)));
        return '        m'. $name .'Text = (EditText) findViewById(R.id.'.lcfirst($name).'Text);' . "\n";
    }
    
    public function toPropertyRealm()
    {
        return '    public String '.$this->field.';';
    }
    
    public function toFromMap()
    {
        return '        entity.'.$this->field.' = data.get("'.$this->field.'");';
    }
    
    public function toFromJson()
    {
        return '        entity.'.$this->field.' = json.get("'.$this->field.'").getAsString();';
    }
    
    public function toBindHolder()
    {
        $name = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $this->field))));
        return '        holder.'.$name.'View.setText(holder.item.'.$this->field.');';
    }
    
    public function toPropertyViewHolder()
    {
        $name = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $this->field))));
        return '        public final TextView '.$name.'View;';
    }
    
    public function toPropertyInitViewHolder()
    {
        $name = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $this->field))));
        return '            '.$name.'View = (TextView) view.findViewById(R.id.'.$name.');';
    }
    
    public function toViewForViewHolder()
    {
        $name = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $this->field))));
        return '    <TextView
        android:id="@+id/'.$name.'"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:layout_margin="@dimen/text_margin" />';
    }
}