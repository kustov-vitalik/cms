<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Module_News extends Module {

    public function render()
    {
        $action = Manager_URL::Instance()->getControl();

        switch ($action)
        {
            case 'show':
                return $this->show(Manager_URL::Instance()->getAct());
                break;
            default:
                return $this->listNews();
                break;
        }
    }

    private function show($new_id)
    {
        $new = ORM::factory('new', $new_id);
        if (!$new->loaded())
        {
            throw HTTP_Exception::factory(404, 'Новость не найдена');
        }
        $content = View::factory('public/news/show', array(
                    'new' => $new
                ));

        return $content->render();
    }

    private function listNews()
    {


        $limit = $this->getConfig()->getItem('limit');

        $pageNun = Request::initial()->param('page');


        $news_count = ORM::factory('new')
                ->where('page_id', '=', $this->getPage()->pk())
                ->count_all();

        $pagination = Pagination::factory(array(
                    'total_items'       => $news_count,
                ));


        $news = ORM::factory('new')
                ->where('page_id', '=', $this->getPage()->pk())
                ->order_by('new_id', 'DESC')
                ->limit($pagination->items_per_page)
                ->offset($pagination->offset)
                ->find_all();


        $content = View::factory('public/news/list', array(
                    'news'       => $news,
                    'module'     => $this,
                    'pagination' => $pagination
                ));

        return $content->render();
    }

    public function getSanitizedTables()
    {
        return array(
            'news' => 'New'
        );
    }

}