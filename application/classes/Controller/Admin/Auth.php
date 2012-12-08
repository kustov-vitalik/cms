<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Auth extends Controller {

    public function action_login()
    {


        if (Auth::Instance()->logged_in('admin'))
        {
            $this->request->redirect('/admin');
        }

        $errors = $data   = array();

        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();

            $username = $this->request->post('username');
            $password = $this->request->post('password');
            $remember = array_key_exists(
                            'remember', $this->request->post()) ?
                    (bool) $this->request->post('remember') :
                    FALSE;

            if (Auth::Instance()->login($username, $password, $remember))
            {
                $_SESSION['KCFINDER']             = array();
                $_SESSION['KCFINDER']['disabled'] = false;
                $this->redirect('/admin');
            }
            else
            {
                $errors = array(Kohana::message('auth', 'no_user'));
            }
        }

        $title = "Вход в панель администрирования";

        $content = View::factory('admin/auth/login', array(
                    'data'   => $data,
                    'errors' => $errors,
                    'title'  => $title
                ));

        $this->response->body($content->render());
    }

    public function action_logout()
    {
        if (Auth::instance()->logout())
        {
            $_SESSION['KCFINDER']['disabled'] = TRUE;
            $this->redirect('/admin/auth/login');
        }
    }

    private function newUser($name, $pass, $email)
    {
        $users = ORM::factory('user');
        $users->create_user(
                array(
            'username'         => $name,
            'password'         => $pass,
            'email'            => $email,
            'password_confirm' => $pass
                ), array(
            'username',
            'password',
            'email'
        ));

        $role = ORM::factory('role')
                ->where('name', '=', 'login')
                ->find();
        $users->add('roles', $role);
        $role = ORM::factory('role')
                ->where('name', '=', 'admin')
                ->find();
        $users->add('roles', $role);
    }

}