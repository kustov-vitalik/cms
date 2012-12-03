<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Controller_Widget_Banner extends Controller_Widget {

    public $template = 'widget/banner';

    public function action_index()
    {
        $this->template->banner_code = $this->getParameterByName('banner_code');
    }

}