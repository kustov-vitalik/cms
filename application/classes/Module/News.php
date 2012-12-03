<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Module_News extends Model_Module {

    protected $_sanitized_tables = array(
        'news' => 'New'
    );

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


        $limit  = $this->getConfig()->getItem('limit');

        $pageNun = Request::initial()->param('page');

        //$offset  = $limit * ($pageNun - 1);

        $news = ORM::factory('new')
                ->where('page_id', '=', $this->getPage()->pk())
                ->order_by('new_id', 'DESC')
                //->limit($limit)
                //->offset($offset)
                ->find_all();

        $news_count = ORM::factory('new')
                ->where('page_id', '=', $this->getPage()->pk())
                ->count_all();

        $pagination = Pagination::factory(array(
                    'total_items'       => $news_count,
                    //'items_per_page'    => $limit,
                    'view'              => 'pagination/basic',
                    'auto_hide'         => FALSE,
                    'first_page_in_url' => FALSE,
                ));



        $content = View::factory('public/news/list', array(
                    'news'       => $news,
                    'module'     => $this,
                    'pagination' => $pagination
                ));

        return $content->render();
    }

}