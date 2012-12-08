<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Module_Page extends Module {

    public function render()
    {

        //$this->getConfig()->getItems();


        $page = ORM::factory('pages_page', array(
                    'page_id' => $this->getPage()->pk()
                ));

        Manager_Content::Instance()->setTitle($page->getTitle());
        $content = View::factory('public/page/view', array(
                    'page' => $page
                ));

        return $content->render();
    }

    public function getSanitizedModels()
    {
        return array(
            'Pages_Page'
        );
    }

}