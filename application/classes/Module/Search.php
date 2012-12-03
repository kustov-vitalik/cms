<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Module_Search extends Model_Module {

    public function render()
    {

        $query = Arr::get($_GET, 'query');

        if ($query !== NULL)
        {

            //$query = Zend_Search_Lucene_Search_QueryParser::parse($query);

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

}