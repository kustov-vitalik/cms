<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Module_Error404 extends Model_Module {

    public function render()
    {
        return View::factory('public/error404/index')->render();
    }

    public function getPositionName()
    {
        return 'center';
    }

}