<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Modules extends Controller_Admin {

    public function before()
    {
        parent::before();
        $title = "Управления модулями системы";
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item($title, '/admin/modules')
        );
    }

    public function action_index()
    {
        $this->action_list();
    }

    public function action_list()
    {
        $modules = ORM::factory('module')
                ->find_all();

        $content = View::factory('admin/modules/list', array(
                    'modules' => $modules
                ));
        $title   = 'Список модулей';
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

        $errors = $data   = array();

        if ($this->request->method() == 'POST')
        {
            $data = $this->request->post();

            $module = new Model_Module();

            try
            {
                if ($module->saveModule($data))
                {
                    $this->redirect('/admin/modules');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {

                $errors = $exc->errors('models');
            }
        }

        $modules = array_keys(Kohana::$config->load('module')->as_array());


        $content = View::factory('admin/modules/add')
                ->set('errors', $errors)
                ->set('modules', $modules)
                ->set('data', $data);
        $title   = 'Добавление нового модуля';
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

        $errors = array();

        if (isset($_POST['no']))
        {
            $this->redirect('/admin/modules');
        }

        if ($this->request->method() == "POST")
        {
            try
            {
                $module = new Model_Module($this->request->post('module_id'));

                if ($module->removeModule())
                {
                    $this->redirect('/admin/modules');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }


        $module = ORM::factory('module', $this->request->param('id'));
        $pages  = $module->pages->find_all();

        $content = View::factory('admin/modules/delete', array(
                    'module' => $module,
                    'errors' => $errors,
                    'pages'  => $pages,
                ));
        $title   = "Удаление модуля '{$module->getName()}'";
        Manager::Instance()
                ->getManagerContent()
                ->setContent($content);
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item($title, $this->request->url())
        );
    }

    public function action_edit()
    {
        $data   = $errors = array();

        if ($this->request->method() == "POST")
        {

            try
            {

                $module = ORM::factory('module', $this->request->post('module_id'));
                $module->values($this->request->post());
                $module->save();
                $this->redirect('/admin/modules');
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $module = ORM::factory('module', $this->request->param('id'));

        $data = array(
            'module_id' => $module->pk(),
            'title'     => $module->title,
        );


        $content = View::factory('admin/modules/edit', array(
                    'data'   => $data,
                    'errors' => $errors,
                ));
        $title   = "Редактирование модуля {$module->getTitle()}";
        Manager::Instance()
                ->getManagerContent()
                ->setContent($content)
                ->setTitle($title);
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item($title, $this->request->url())
        );
    }

    public function action_settings()
    {
        $module = new Model_Module($this->request->param('id'));
        $errors = $data   = array();

        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();

            try
            {
                if ($module->saveModuleConfigs($data))
                {
                    $this->redirect('/admin/modules');
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $content = View::factory('admin/modules/settings', array(
                    'module' => $module,
                ));

        $it = $module->getConfig()->getItems()->getIterator();
        while ($it->valid())
        {
            $item = $it->current();
            if ($item instanceof Config_Item_Interface)
                if ($item->getType() == 'richtext')
                    Manager_Content::Instance()->addCKEditorToElement($item->getName());
            $it->next();
        }



        $title = "Управление настройками модуля '{$module->getTitle()}'";

        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle($title);
        $this->getBreadCrumbs()->addItem(
                new BreadCrumbs_Item($title, $this->request->url())
        );
    }

}