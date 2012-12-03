<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_News extends Controller_Admin {

    public function action_manage()
    {
        $page_id = $this->request->param('id');

        $this->redirect('/admin/news/list/' . $page_id);
    }

    public function action_list()
    {

        $page_id = $this->request->param('id');

        $news = ORM::factory('new')
                ->where('page_id', '=', $page_id)
                ->order_by('new_id', 'DESC')
                ->find_all();

        $page = ORM::factory('page', $page_id);

        $content = View::factory('admin/news/list', array(
                    'news' => $news,
                    'page' => $page,
                ));

        Manager_Content::Instance()->setContent($content);
        Manager_Content::Instance()->setTitle('Список новостей страницы "' . $page->title . '"');
    }

    public function action_add()
    {

        $page_id = $this->request->param('id');

        $errors = $data   = array();

        if ($this->request->method() == "POST")
        {

            $data = $this->request->post();

            try
            {

                $new = new Model_New();
                if ($new->saveNew($data))
                {
                    $this->redirect('/admin/news/list/' . $page_id);
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $page = ORM::factory('page', $page_id);

        $content = View::factory('admin/news/add', array(
                    'data'   => $data,
                    'errors' => $errors,
                    'page'   => $page,
                ));

        Manager_Content::Instance()
                ->addCKEditorToElement('text')
                ->addCKEditorToElement('announce')
                ->setContent($content)
                ->setTitle("Добавление новости на страницу {$page->title}");
    }

    public function action_edit()
    {

        $new_id = $this->request->param('id');
        $new    = new Model_New($new_id);

        $errors = $data   = array();

        if ($this->request->method() == "POST")
        {

            $data = $this->request->post();

            try
            {

                if ($new->saveNew($data))
                {
                    $this->redirect('/admin/news/list/' . $new->page_id);
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $data = array(
            'title'    => $new->title,
            'text'     => $new->text,
            'announce' => $new->announce,
            'date'     => $new->date,
            'page_id'  => $new->page_id,
            'new_id'   => $new->new_id,
        );

        $content = View::factory('admin/news/edit', array(
                    'data'   => $data,
                    'errors' => $errors,
                ));

        Manager_Content::Instance()
                ->addCKEditorToElement('text')
                ->addCKEditorToElement('announce')
                ->setContent($content)
                ->setTitle("Редактирование новости {$new->title}");
    }

    public function action_delete()
    {

        $errors = array();

        $new_id  = $this->request->param('id');
        $new     = new Model_New($new_id);
        $page_id = $new->page_id;

        if (isset($_POST['no']))
        {
            $this->redirect('/admin/news/list/' . $page_id);
        }

        if (isset($_POST['submit']))
        {
            try
            {

                if ($new->deleteNew())
                {
                    $this->redirect('/admin/news/list/' . $page_id);
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }


        $content = View::factory('admin/news/delete', array(
                    'new'    => $new,
                    'errors' => $errors
                ));

        Manager::Instance()
                ->getManagerContent()
                ->setContent($content);
    }

}