<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Pages extends Controller_Admin {

    public function before()
    {
        parent::before();
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item('Управление страницами', '/admin/pages')
        );
    }

    public function action_index()
    {
        $this->action_list();
    }

    public function action_list()
    {
        $page = new Model_Page($this->request->param('id'));


        $content = View::factory('admin/pages/list', array('page' => $page));
        $title   = "Список страниц";
        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle($title);
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item($title, $this->request->url())
        );
    }

    public function action_add()
    {
        $parentPage = new Model_Page($this->request->param('id'));
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
                ->set('parentPage', $parentPage)
                ->set('data', $data);
        $title   = 'Добавление новой страницы';
        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle($title);
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item($title, $this->request->url())
        );
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
        $title   = "Редактирование страницы {$page->getTitle()}";
        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle($title);
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item($title, $this->request->url())
        );
    }

    public function action_delete()
    {
        $page = new Model_Page($this->request->param('id'));
        $errors = array();

        if (isset($_POST['no']))
        {
            $this->redirect('/admin/pages');
        }

        if (isset($_POST['submit']))
        {
            try
            {
                if ($page->removePage())
                {

                    $this->redirect('/admin/pages');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
            catch (Exception $e)
            {
                throw $e;
            }
        }



        $content = View::factory('admin/pages/delete', array(
                    'page'   => $page,
                    'errors' => $errors
                ));
        $title   = "Удаление страницы '{$page->getTitle()}'";
        Manager::Instance()
                ->getManagerContent()
                ->setContent($content);
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item($title, $this->request->url())
        );
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
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item($title, $this->request->url())
        );
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
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item($title, $this->request->url())
        );
    }

    public function action_createParent()
    {

        $page = new Model_Page($this->request->param('id'));

        $errors = array();

        if ($this->request->method() == Request::POST)
        {
            try
            {
                if ($page->createParent($this->request->post('parent_page_id')))
                {
                    $this->goBack();
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $pages = ORM::factory('Page')
                ->where('page_id', '!=', $page->pk())
                ->find_all();

        $title   = "Назначить странице '{$page->getTitle()}' родительскую страницу";
        $content = View::factory('admin/pages/createparent', array(
                    'pages'  => $pages,
                    'errors' => $errors,
                    'page'   => $page
                ));
        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle($title);
        $this->getBreadCrumbs()->addItem(new BreadCrumbs_Item($title, $this->request->url()));
    }

}