<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Settings extends Controller_Admin {

    public function action_index() {
        $this->action_list();
    }

    public function action_list() {
        $configs = ORM::factory('config')
                ->find_all();

        $content = View::factory('admin/settings/list', array(
                    'configs' => $configs
                ));

        Manager_Content::Instance()->setContent($content);
        Manager_Content::Instance()->setTitle('Настройки');
    }

}