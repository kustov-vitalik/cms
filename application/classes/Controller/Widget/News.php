<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Widget_News extends Controller_Widget {

    public $template = 'widget/news';

    public function action_index()
    {

        $news = ORM::factory('new')
                ->limit($this->getParameterByName('limit'))
                ->find_all();

        $this->template->news = $news;
    }

}