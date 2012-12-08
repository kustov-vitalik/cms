<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Admin_Catalog extends Controller_Admin {

    public function before()
    {
        parent::before();
        $item = new BreadCrumbs_Item("Управление каталогами", '');
        $this->getBreadCrumbs()->addItem($item);
    }

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

        if ($currentCatalog->page_id == NULL)
        {
            $currentCatalog->page_id = $page->pk();
        }

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

    public function action_addGood()
    {
        /* @var $page Model_Page */
        /* @var $currentCatalog Model_Catalog */
        list($page, $currentCatalog) = $this->initPageCatalog();

        $data   = $errors = array();

        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();
            $good = new Model_Good();

            try
            {
                if ($good->createGood($data))
                {
                    $this->redirect('/admin/catalog/list/' . $page->pk() . ':' . $currentCatalog->pk());
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }


        $title = "Добавление товара в каталог '{$currentCatalog->getTitle()}'";

        $content = View::factory('admin/catalog/addgood', array(
                    'currentCatalog' => $currentCatalog,
                    'errors'         => $errors,
                    'data'           => $data,
                    'page'           => $page
                ));

        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle($title);
    }

    public function action_editGood()
    {
        $good   = new Model_Good($this->request->param('id'));
        $errors = $data   = array();

        if ($this->request->method() == Request::POST)
        {
            $data = $this->request->post();

            try
            {
                if ($good->saveGood($data))
                {
                    $this->redirect('/admin/catalog/list/' . $good->getCatalog()->getPage()->pk()
                            . ':' . $good->getCatalog()->pk());
                }
            }
            catch (ORM_Validation_Exception $exc)
            {
                $errors = $exc->errors('models');
            }
        }


        $title   = "Редактирование товара '{$good->getTitle()}'";
        $content = View::factory('admin/catalog/editgood', array(
                    'good'   => $good,
                    'errors' => $errors
                ));
        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle($title);
    }

    public function action_deleteGood()
    {
        $good   = new Model_Good($this->request->param('id'));
        $errors = array();

        if ($this->request->method() == Request::POST)
        {
            if (isset($_POST['no']))
            {
                $this->goBack();
            }

            if (isset($_POST['yes']))
            {
                try
                {
                    if ($good->dropGood())
                    {
                        $this->goBack();
                    }
                }
                catch (ORM_Validation_Exception $exc)
                {
                    $errors = $exc->errors('models');
                }
            }
        }

        $title   = "Удаление товара '{$good->getTitle()}'";
        $content = View::factory('admin/catalog/deletegood', array(
                    'good'   => $good,
                    'errors' => $errors
                ));
        Manager_Content::Instance()
                ->setContent($content)
                ->setTitle($title);
    }

    public function action_moveUpGood()
    {
        $good = new Model_Good($this->request->param('id'));

        if ($good->moveUp())
        {
            $this->redirect($this->request->referrer());
        }
    }

    public function action_moveDownGood()
    {
        $good = new Model_Good($this->request->param('id'));

        if ($good->moveDown())
        {
            $this->redirect($this->request->referrer());
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