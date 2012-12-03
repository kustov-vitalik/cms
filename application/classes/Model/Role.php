<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Role extends Model_Auth_Role implements Zend_Acl_Role_Interface {

    protected $_table_columns = array(
        'id'          => NULL,
        'name'        => NULL,
        'description' => NULL,
    );

    public function getRoleId()
    {
        return $this->getName();
    }

    public function getName()
    {
        return $this->get('name');
    }

}