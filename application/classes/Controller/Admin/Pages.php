<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Pages extends Controller_Admin {

    public function action_index()
    {
        $this->action_list();
    }

    public function action_list()
    {

        $pages = ORM::factory('page')
                ->order_by('sequence', 'ASC')
                ->find_all();

        $content = View::factory('admin/pages/list', array('pages' => $pages));

        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle("Список страниц");
    }

    public function action_add()
    {

        $errors = $data   = array();

        if ($this->request->method() == 'POST')
        {

            try
            {

                $data = $this->request->post();

                $page = new Model_Page();

                if ($page->createPage($data))
                {
                    $this->redirect('/admin/pages');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $modules = ORM::factory('module')
                ->find_all();

        $content = View::factory('admin/pages/add')
                ->set('errors', $errors)
                ->set('modules', $modules)
                ->set('data', $data);

        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle('Добавление новой страницы');
    }

    public function action_edit()
    {

        $data   = $errors = array();

        if ($this->request->method() == Request::POST)
        {

            $data = $this->request->post();

            try
            {

                $page = new Model_Page($data['page_id']);
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

        $page = new Model_Page($this->request->param('id'));


        $data = array(
            'page_id' => $page->pk(),
            'title'   => $page->getTitle(),
            'url'     => $page->getURL(),
            'in_menu' => $page->inMenu(),
        );

        $content = View::factory('admin/pages/edit', array(
                    'data'   => $data,
                    'errors' => $errors,
                ));

        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle("Редактирование страницы {$page->getTitle()}");
    }

    public function action_delete()
    {

        $errors = array();

        if (isset($_POST['no']))
        {
            $this->redirect('/admin/pages');
        }

        if (isset($_POST['submit']))
        {
            try
            {

                $page = new Model_Page($this->request->post('page_id'));

                if ($page->removePage())
                {
                    $this->redirect('/admin/pages');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $page = ORM::factory('page', $this->request->param('id'));

        $content = View::factory('admin/pages/delete', array(
                    'page'   => $page,
                    'errors' => $errors
                ));

        Manager::Instance()
                ->getManagerContent()
                ->setContent($content);
    }

    public function action_manage()
    {

        $page = new Model_Page($this->request->param('id'));

        if ($page->loaded())
        {
            $this->redirect('/admin/' . $page->getModule()->getName() . '/manage/' . $page->pk());
        }
    }

    public function action_widgets()
    {
        $page = new Model_Page($this->request->param('id'));


        $content = View::factory('admin/pages/widgets', array(
                    'page' => $page,
                ));
        $title   = "Управление виджетами страницы {$page->getTitle()}";

        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle($title);
    }

    public function action_moveUpWidget()
    {
        $param     = explode(':', $this->request->param('id'));
        $page_id   = $param[1];
        $widget_id = $param[0];

        $page   = new Model_Page($page_id);
        $widget = new Model_Widget($widget_id);

        try
        {
            if ($widget->moveOnPageCurrentPosition($page, 'up'))
            {
                $this->redirect('/admin/pages/widgets/' . $page_id);
            }
        }
        catch (Exception $exc)
        {
            throw $exc;
        }
    }

    public function action_moveDownWidget()
    {
        $param     = explode(':', $this->request->param('id'));
        $page_id   = $param[1];
        $widget_id = $param[0];

        $page   = new Model_Page($page_id);
        $widget = new Model_Widget($widget_id);

        try
        {
            if ($widget->moveOnPageCurrentPosition($page, 'down'))
            {
                $this->redirect('/admin/pages/widgets/' . $page_id);
            }
        }
        catch (Exception $exc)
        {
            throw $exc;
        }
    }

    public function action_moveUp()
    {
        $page = new Model_Page($this->request->param('id'));

        try
        {
            if ($page->moveUp())
            {
                $this->redirect('/admin/pages');
            }
        }
        catch (Exception $exc)
        {
            throw $exc;
        }
    }

    public function action_moveDown()
    {
        $page = new Model_Page($this->request->param('id'));

        try
        {
            if ($page->moveDown())
            {
                $this->redirect('/admin/pages');
            }
        }
        catch (Exception $exc)
        {
            throw $exc;
        }
    }

    public function action_showInMenuOff()
    {
        $page = new Model_Page($this->request->param('id'));

        try
        {
            if ($page->showInMenu('off'))
            {
                $this->redirect('/admin/pages');
            }
        }
        catch (ORM_Validation_Exception $exc)
        {
            throw $exc;
        }
    }

    public function action_showInMenuOn()
    {
        $page = new Model_Page($this->request->param('id'));

        try
        {
            if ($page->showInMenu('on'))
            {
                $this->redirect('/admin/pages');
            }
        }
        catch (ORM_Validation_Exception $exc)
        {
            throw $exc;
        }
    }

    public function action_settings()
    {
        $page = new Model_Page($this->request->param('id'));


        $errors = $data   = array();

        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();

            try
            {
                if ($page->saveModuleConfigs($data))
                {
                    $this->redirect('/admin/pages');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $content = View::factory('admin/pages/settings', array(
                    'page' => $page,
                ));

        $it = $page->getConfig()->getItems()->getIterator();
        while ($it->valid())
        {
            $item = $it->current();
            if ($item instanceof Config_Item_Interface)
                if ($item->getType() == 'richtext')
                    Manager_Content::Instance()->addCKEditorToElement($item->getName());
            $it->next();
        }



        $title = "Управление настройками модуля '{$page->getModule()->getTitle()}'
        для страницы '{$page->getTitle()}'";

        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle($title);
    }

}