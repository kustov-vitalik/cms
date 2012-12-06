<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Module_Auth extends Module {

    public function render()
    {
        $action = Manager_URL::Instance()->getControl();

        switch ($action)
        {
            case 'login':
                return $this->login();
                break;
            case 'logout':
                return $this->logout();
                break;
            case 'register':
                return $this->register();
                break;
            case 'logined':
                return $this->logined();
                break;
        }
    }

    protected function login()
    {

    }

    protected function register()
    {

    }

    protected function logout()
    {

    }

    protected function logined()
    {

    }

}