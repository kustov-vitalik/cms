<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_User extends Model_Auth_User {

    protected $_table_name    = 'users';
    protected $_primary_key   = 'id';
    protected $_table_columns = array(
        'id'         => NULL,
        'email'      => NULL,
        'username'   => NULL,
        'password'   => NULL,
        'logins'     => NULL,
        'last_login' => NULL,
    );
    protected $_has_many      = array(
        'user_tokens' => array(
            'model' => 'user_token'
        ),
        'roles'       => array(
            'model'   => 'role',
            'through' => 'roles_users'
        ),
        'ulogins'     => array(
        ),
    );

    public function rules()
    {
        return array_merge(parent::rules(), array(
                ));
    }

    public function filters()
    {
        return array_merge(parent::filters(), array(
            'email'    => array(
                array('trim'),
                array('strip_tags'),
            ),
            'username' => array(
                array('trim'),
                array('strip_tags'),
            ),
                ));
    }

    public function labels()
    {
        return array(
            'email'      => 'Email',
            'username'   => 'Имя пользователя',
            'password'   => 'Пароль',
            'logins'     => 'Количество авторизаций',
            'last_login' => 'Дата последней авторизации',
        );
    }

    public function getEmail()
    {
        return $this->get('email');
    }

    public function getUserName()
    {
        return $this->get('username');
    }

}