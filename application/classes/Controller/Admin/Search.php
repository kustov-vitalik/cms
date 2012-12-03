<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Search extends Controller_Admin {

    public function action_manage()
    {
        $page = new Model_Page($this->request->param('id'));

        $content = View::factory('admin/search/manage', array(
                    'page' => $page
                ));

        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle("Модуль поиска");
    }

}