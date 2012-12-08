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

        $data   = $errors = array();

        if (Request::current()->method() == Request::POST)
        {
            $data = Arr::extract(Request::current()->post(), array(
                        'username',
                        'email',
                        'password'
                    ));

            $users = new Model_User();

            try
            {
                $users->create_user($data, array(
                    'username',
                    'email',
                    'password'
                ));

                Controller::redirect($this->getPage()->getURL().'/login');

            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }


        $view = View::factory('public/auth/register', array(
                    'page'   => $this->getPage(),
                    'data'   => $data,
                    'errors' => $errors
                ));

        return $view->render();
    }

    protected function logout()
    {

    }

    protected function logined()
    {

    }

    public function getSanitizedModels()
    {
        return array();
    }

}