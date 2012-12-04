<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Catalogs extends Controller_Admin {

    public function action_index()
    {
        $this->action_list();
    }

    public function action_list()
    {

        $catalogs = ORM::factory('Catalog')
                ->where('parent_catalog_id', 'IS', NULL)
                ->find_all();

        $content = View::factory('admin/catalogs/list', array(
                    'catalogs' => $catalogs,
                ));
        

        Manager_Content::Instance()->setContent($content)
                ->setTitle('Список каталогов');
    }

}