<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Controller_Widget_Search extends Controller_Widget
{

    public $template = 'widget/search';

    public function action_index()
    {

        $module = new Module_Search(array('name' => 'Search'));

        $this->template->page = $module->getPage();
        $this->template->button_enable = $this->getParameterByName('button_enable');

    }

}