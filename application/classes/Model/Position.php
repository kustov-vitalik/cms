<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Position extends ORM
{
    protected $_table_name = 'position';
    protected $_primary_key = 'position_id';
    protected $_table_columns = array(
        'position_id' => NULL,
        'name' => NULL,
    );

    protected $_has_many = array(

    );

    public function rules() {
        return array(
            'name' => array(
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
                array('not_empty'),
            ),
        );
    }

    public function labels() {
        return array(
            'name' => 'Системное имя группы настроек',
        );
    }

    public function getName() {
        return $this->get('name');
    }
}