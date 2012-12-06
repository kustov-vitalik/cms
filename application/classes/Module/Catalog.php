<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Module_Catalog extends Module {

    public function render()
    {

        // TO DO
        return "CATALOG";

    }

    public function catalog()
    {
        $view = View::factory('public/catalog/catalog', array(
                ));
        return $view->render();
    }

    public function good()
    {

        $view = View::factory('public/catalog/good', array(
                ));
        return $view->render();
    }

    public function getSanitizedTables()
    {
        return array(
            'catalogs' => 'Catalog',
            'goods' => 'Good',
        );
    }

}