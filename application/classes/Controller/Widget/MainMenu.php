<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Widget_MainMenu extends Controller_Widget {

    public $template = 'widget/mainmenu';

    public function action_index()
    {
        $this->template->pages = Site::Instance()->getPages();
    }

}