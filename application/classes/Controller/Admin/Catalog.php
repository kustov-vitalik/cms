<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Catalog extends Controller_Admin {

    public function action_manage()
    {
        $page_id = $this->request->param('id');

        $this->redirect('/admin/catalog/list/' . $page_id . ':');
    }

    public function action_index()
    {
        $this->action_list();
    }

    public function action_list()
    {
        /* @var $page Model_Page */
        /* @var $currentCatalog Model_Catalog */
        list($page, $currentCatalog) = $this->initPageCatalog();

        $catalogs = Model_Catalog::getCatalogs($page, $currentCatalog->pk());

        $content = View::factory('admin/catalog/list', array(
                    'catalogs'       => $catalogs,
                    'currentCatalog' => $currentCatalog,
                    'page'           => $page,
                ));


        Manager_Content::Instance()->setContent($content)
                ->setTitle("Список каталогов/товаров страницы '{$page->getTitle()}'
                и каталога '{$currentCatalog->getTitle()}'");
    }

    public function action_addCatalog()
    {
        /* @var $page Model_Page */
        /* @var $currentCatalog Model_Catalog */
        list($page, $currentCatalog) = $this->initPageCatalog();
        $data   = $errors = array();

        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();

            try
            {
                if ($currentCatalog->createCatalog($data))
                {
                    $this->redirect('/admin/catalog/list/' . $page->pk()
                            . ':' . $currentCatalog->getParentCatalog()->pk());
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $title = "Добавление каталога на страницу '{$page->getTitle()}'
            в каталог '{$currentCatalog->getTitle()}'";

        $content = View::factory('admin/catalog/addcatalog', array(
                    'page'           => $page,
                    'currentCatalog' => $currentCatalog,
                    'data'           => $data,
                    'errors'         => $errors
                ));

        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle($title);
    }

    public function action_editCatalog()
    {
        /* @var $page Model_Page */
        /* @var $currentCatalog Model_Catalog */
        list($page, $currentCatalog) = $this->initPageCatalog();

        $data   = $errors = array();


        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();

            try
            {
                if ($currentCatalog->saveCatalog($data))
                {
                    $this->redirect('/admin/catalog/list/' . $page->pk()
                            . ':' . $currentCatalog->getParentCatalog()->pk());
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }

        $title = "Редактирование каталога '{$currentCatalog->getTitle()}'";

        $content = View::factory('admin/catalog/editcatalog', array(
                    'currentCatalog' => $currentCatalog,
                    'errors'         => $errors,
                    'page'           => $page
                ));

        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle($title);
    }

    public function action_deleteCatalog()
    {
        /* @var $page Model_Page */
        /* @var $currentCatalog Model_Catalog */
        list($page, $currentCatalog) = $this->initPageCatalog();
        $errors = array();

        if (Request::current()->method() == Request::POST)
        {
            if (isset($_POST['no']))
            {
                $this->redirect('/admin/catalog/list/' . $page->pk()
                        . ':' . $currentCatalog->getParentCatalog()->pk());
            }

            if (isset($_POST['yes']))
            {
                try
                {
                    $parentCatalog = $currentCatalog->getParentCatalog();
                    if ($currentCatalog->deleteCatalog())
                    {
                        $this->redirect('/admin/catalog/list/' . $page->pk()
                                . ':' . $parentCatalog->pk());
                    }
                }
                catch (ORM_Validation_Exception $exc)
                {
                    $errors = $exc->errors('models');
                }
            }
        }

        $title   = "Удаление каталога";
        $content = View::factory('admin/catalog/deletecatalog', array(
                    'page'           => $page,
                    'currentCatalog' => $currentCatalog,
                    'errors'         => $errors,
                ));
        Manager_Content::Instance()->setContent($content)->setTitle($title);
    }

    public function action_moveUpCatalog()
    {
        /* @var $page Model_Page */
        /* @var $currentCatalog Model_Catalog */
        list($page, $currentCatalog) = $this->initPageCatalog();

        if ($currentCatalog->moveUpCatalog())
        {
            $this->redirect('/admin/catalog/list/' . $page->pk()
                                . ':' . $currentCatalog->getParentCatalog()->pk());
        }
        else
        {
            throw new Kohana_Exception("Невозможно переместить каталог");
        }

    }

    public function action_moveDownCatalog()
    {
        /* @var $page Model_Page */
        /* @var $currentCatalog Model_Catalog */
        list($page, $currentCatalog) = $this->initPageCatalog();

        if ($currentCatalog->moveDownCatalog())
        {
            $this->redirect('/admin/catalog/list/' . $page->pk()
                                . ':' . $currentCatalog->getParentCatalog()->pk());
        }
        else
        {
            throw new Kohana_Exception("Невозможно переместить каталог");
        }
    }

    /**
     * Использовать так:
     * <pre>
     * list($page, $currentCatalog) = $this->initPageCatalog();
     * </pre>
     *
     * @return array(
     *  Model_Page,
     *  Model_Catalog
     * );
     */
    private function initPageCatalog()
    {
        $param = $this->request->param('id');
        $param = explode(':', $param);

        $page_id    = $param[0];
        $catalog_id = $param[1];

        $page           = new Model_Page($page_id);
        $currentCatalog = new Model_Catalog($catalog_id);

        return array($page, $currentCatalog);
    }

}