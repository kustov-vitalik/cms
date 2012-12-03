<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Page extends Controller_Admin {

    public function action_manage()
    {


        $Spage = new Model_Page($this->request->param('id'));
        $page = new Model_Pages_Page(array('page_id' => $Spage->pk()));

        if ($page->loaded())
        {
            $this->redirect('/admin/page/edit/' . $page->pk());
        }
        else
        {
            $this->redirect('/admin/page/add/' . $Spage->pk());
        }
    }

    public function action_add()
    {

        $page_id = $this->request->param('id');

        $errors = array();

        if ($this->request->method() == Request::POST)
        {

            try
            {

                $page = new Model_Pages_Page();
                if ($page->savePage($this->request->post()))
                {
                    $this->redirect('/admin/page/edit/' . $page->pk());
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $data = array(
            'page_id' => $page_id
        );

        $data = array_merge($data, $this->request->post());

        $content = View::factory('admin/page/add')
                ->set('errors', $errors)
                ->set('data', $data);

        Manager_Content::Instance()
                ->addCKEditorToElement('text')
                ->setContent($content)
                ->setTitle("Создание текстовой страницы");
    }

    public function action_edit()
    {

        $page = new Model_Pages_Page($this->request->param('id'));

        $errors = $data   = array();

        $data = $page->as_array();

        if ($this->request->method() == Request::POST)
        {

            $data = $this->request->post();

            try
            {

                $page = new Model_Pages_Page($this->request->post('page_page_id'));
                if ($page->savePage($data))
                {
                    $this->redirect('/admin/pages');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }


        $content = View::factory('admin/page/edit')
                ->set('errors', $errors)
                ->set('data', $data);

        Manager_Content::Instance()
                ->addCKEditorToElement('text')
                ->setContent($content)
                ->setTitle("Редактирование текстовой страницы");
    }

}