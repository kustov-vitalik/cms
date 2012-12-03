<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Widgets extends Controller_Admin {

    public function action_index()
    {
        $this->action_list();
    }

    public function action_list()
    {

        $widgets = new Model_Widget();

        $content = View::factory('admin/widgets/list', array(
                    'widgets' => $widgets->find_all()
                ));

        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle('Виджеты');
    }

    public function action_add()
    {

        $data   = $errors = array();

        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();

            try
            {
                $widget = new Model_Widget();

                if ($widget->createWidget($data))
                {
                    $this->redirect('/admin/widgets');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $widgets = array_keys(Kohana::$config->load('widget')->as_array());

        $content = View::factory('admin/widgets/add', array(
                    'data'    => $data,
                    'errors'  => $errors,
                    'widgets' => $widgets,
                ));

        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle('Добавление нового виджета');
    }

    public function action_edit()
    {

        $widget = new Model_Widget($this->request->param('id'));
        $data   = $errors = array();

        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();

            try
            {

                if ($widget->saveWidget($data))
                {
                    $this->redirect('/admin/widgets');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $data = $widget->as_array();

        $content = View::factory('admin/widgets/edit', array(
                    'data'    => $data,
                    'errors'  => $errors,
                ));

        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle('Редактирование виджета: ' . $widget->title);
    }

    public function action_delete()
    {
        $widget = new Model_Widget($this->request->param('id'));

        $errors = $data   = array();

        if ($this->request->method() == Request::POST)
        {

            $data = $this->request->post();

            if (isset($data['no']))
            {
                $this->redirect('admin/widgets');
            }

            if (isset($data['submit']))
            {

                try
                {
                    if ($widget->deleteWidget())
                    {
                        $this->redirect('admin/widgets');
                    }
                }
                catch (ORM_Validation_Exception $exc)
                {
                    $errors = $exc->errors('models');
                }
            }
        }


        $content = View::factory('admin/widgets/delete', array(
                    'errors' => $errors,
                    'data'   => $widget->as_array()
                ));

        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle('Удаление виджета: ' . $widget->title);
    }

    public function action_manage()
    {
        $widget = new Model_Widget($this->request->param('id'));
        $pages  = new Model_Page();

        if ($this->request->method() == Request::POST)
        {

        }

        $content = View::factory('admin/widgets/manage', array(
                    'widget' => $widget,
                    'pages'  => $pages->find_all()
                ));

        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle("Управление виджетом '{$widget->title}'");
    }

    public function action_managerelation()
    {
        $wp        = explode(':', $this->request->param('id'));
        $widget_id = $wp[0];
        $page_id   = $wp[1];

        $page   = new Model_Page($page_id);
        $widget = new Model_Widget($widget_id);

        $data   = $errors = array();

        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();

            try
            {
                $widget->savePositionForPage($data['position'], $page);
                unset($data['position']);
                $widget->saveConfigsForPage($data, $page);
                $this->goBack();
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $positions       = new Model_Position();
        $currentConfig   = $widget->getConfigForPage($page);
        $currentPosition = $widget->getPositionForPage($page);

        $data = array(
            'page'            => $page,
            'widget'          => $widget,
            'currentConfig'   => $currentConfig,
            'currentPosition' => $currentPosition,
            'positions'       => $positions->find_all(),
            'errors'          => $errors,
        );

        $content = View::factory('admin/widgets/managerelation', $data);

        foreach ($currentConfig->getItems() as $item)
        {
            if ($item->getType() == 'richtext')
            {
                Manager_Content::Instance()->addCKEditorToElement($item->getName());
            }
        }

        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle("Управление связью виджета '{$widget->getTitle()}'
                и страницы '{$page->getTitle()}'"
        );
    }

    public function action_addrelation()
    {
        $wp        = explode(':', $this->request->param('id'));
        $widget_id = $wp[0];
        $page_id   = $wp[1];

        $page   = new Model_Page($page_id);
        $widget = new Model_Widget($widget_id);

        try
        {
            if ($page->addWidget($widget))
            {
                $this->redirect('/admin/widgets/manage/' . $widget_id);
            }
        }
        catch (ORM_Validation_Exception $exc)
        {
            throw $exc;
        }
    }

    public function action_removerelation()
    {
        $wp        = explode(':', $this->request->param('id'));
        $widget_id = $wp[0];
        $page_id   = $wp[1];

        $page   = new Model_Page($page_id);
        $widget = new Model_Widget($widget_id);

        if ($page->removeWidget($widget))
        {
            $this->redirect('/admin/widgets/manage/' . $widget->pk());
        }
    }

    public function action_settings()
    {
        $widget = new Model_Widget($this->request->param('id'));

        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();

            try
            {
                if ($widget->saveWidgetConfigs($data))
                {
                    $this->redirect('/admin/widgets');
                }
            }
            catch (Exception $exc)
            {
                throw $exc;
            }
        }

        $content = View::factory('admin/widgets/settings', array(
                    'widget' => $widget,
                ));

        foreach ($widget->getSelfConfig()->getItems() as $item)
        {
            if ($item->getType() == 'richtext')
            {
                Manager_Content::Instance()->addCKEditorToElement($item->getName());
            }
        }

        $title = "Управление настройками виджета '{$widget->getTitle()}'";

        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle($title);
    }

}