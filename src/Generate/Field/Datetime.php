<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MIAInstaller\Generate\Field;

/**
 * Description of Datetime
 *
 * @author matiascamiletti
 */
class Datetime extends Base
{
    public function __construct($title, $field)
    {
        parent::__construct('datetime', $title, $field);
    }
    
    public function getDockBlockProperty(): \Zend\Code\Generator\DocBlockGenerator
    {
        return \Zend\Code\Generator\DocBlockGenerator::fromArray([
                        'tags' => [
                                [
                                'name' => 'var',
                                'description' => '\Datetime',
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
        return '$this->'.$this->field.' = $data->'.$this->field.';' . "\n";
    }
    
    public function toInputFilter()
    {
        return '$inputFilter->add([
            \'name\' => \''.$this->field.'\',
            \'required\' => true
        ]);';
    }
    
    public function toForm()
    {
        return '$this->add([
        \'name\' => \''.$this->field.'\',
        \'type\' => \'datetime\',
        \'options\' => [
            \'label\' => \''.$this->title.'\',
            \'format\' => \'Y-m-d H:i:s\'
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
        $code = '        m'. $name .'Text = (EditText) findViewById(R.id.'.lcfirst($name).'Text);' . "\n";
        $code .= '        m'. $name .'Text.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Calendar newCalendar = Calendar.getInstance();
                new DatePickerDialog('.$activity.'.this, new DatePickerDialog.OnDateSetListener() {

                    public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                        m'. $name .'Text.setText(dayOfMonth + "/" + monthOfYear + "/" + year);
                    }

                }, newCalendar.get(Calendar.YEAR), newCalendar.get(Calendar.MONTH), newCalendar.get(Calendar.DAY_OF_MONTH)).show();
            }
        });' . "\n";
        return $code;
    }
    
    public function toPropertyRealm()
    {
        return '    public Date '.$this->field.';';
    }
    
    public function toFromMap()
    {
        return '        entity.'.$this->field.' = DateHelper.stringMysqlToDate(data.get("'.$this->field.'"), true);';
    }
    
    public function toFromJson()
    {
        return '        entity.'.$this->field.' = DateHelper.stringMysqlToDate(json.get("'.$this->field.'").getAsString(), true);';
    }
    
    public function toBindHolder()
    {
        $name = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $this->field))));
        return '        holder.'.$name.'View.setText(DateHelper.dateToStringMysql(holder.item.'.$this->field.'));';
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
