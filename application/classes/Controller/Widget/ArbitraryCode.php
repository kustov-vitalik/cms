<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Widget_ArbitraryCode extends Controller_Widget {

    public $template = 'widget/arbitrarycode';


    public function action_index()
    {
        $this->template->code = $this->getParameterByName('code');
    }

}