<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Module_Search extends Module {

    public function render()
    {

        $query = Arr::get($_GET, 'query');

        if ($query !== NULL)
        {

            $hits = Search::instance()->find($query);

            $content = View::factory('public/search/index', array(
                        'query'  => $query,
                        'hits'   => $hits,
                        'module' => $this
                    ));

            Manager::Instance()->getManagerContent()->setContent($content)
                    ->setTitle("Результаты поиска по запросу '{$query}'");
        } else {
            $content = View::factory('public/search/index', array(
                        'query'  => '',
                        'module' => $this
                    ));


        }

        return $content->render();
    }

    public function getSanitizedModels()
    {

    }

}