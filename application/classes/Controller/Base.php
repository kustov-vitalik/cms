<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Controller_Base extends Controller_Template
{
    public $template = 'index';


    public function before() {
        parent::before();
    }

    public function action_index()
    {
        Site::Instance();
        Manager_PageMap::Instance();
    }


    public function after() {
        $this->template
                ->set('title', Manager_Content::Instance()->getTitle())
                ->set('styles', Manager_Content::Instance()->getStyles())
                ->set('scripts', Manager_Content::Instance()->getScripts());
        parent::after();
    }

}