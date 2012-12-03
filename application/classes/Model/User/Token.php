<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_User_Token extends Model_Auth_User_Token
{
    protected $_table_columns = array(
        'id' => NULL,
        'user_id' => NULL,
        'user_agent' => NULL,
        'token' => NULL,
        'type' => NULL,
        'created' => NULL,
        'expires' => NULL,
    );
}