<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Catalog extends ORM_Searchable {

    protected $_table_name    = 'catalogs';
    protected $_primary_key   = 'catalog_id';
    protected $_table_columns = array(
        'catalog_id'        => NULL,
        'name'              => NULL,
        'title'             => NULL,
        'parent_catalog_id' => NULL,
        'page_id'           => NULL,
    );
    protected $_has_many      = array(
        'childrenCatalogsModel' => array(
            'model'       => 'Catalog',
            'foreign_key' => 'parent_catalog_id',
        ),
        'goodsModel'            => array(
            'model'       => 'Good',
            'foreign_key' => 'catalog_id',
        ),
    );
    protected $_belongs_to    = array(
        'pageModel' => array(
            'model'       => 'Page',
            'foreign_key' => 'page_id',
        ),
    );

    public function rules()
    {
        return array(
            'title' => array(
                array('not_empty'),
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
            ),
            'name'  => array(
                array('not_empty'),
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
            ),
        );
    }

    public function labels()
    {
        return array(
            'title' => 'Название каталога',
        );
    }

    public function get_indexable_fields()
    {
        $fields = array();

        $fields[] = new Search_Field('good_id', Searchable::UNINDEXED);
        $fields[] = new Search_Field('title', Searchable::KEYWORD);

        return $fields;
    }

    /**
     * Получить название каталога
     * @return string
     */
    public function getTitle()
    {
        if ($this->title == NULL)
        {
            $this->setTitle('ROOT');
        }
        return $this->get('title');
    }

    /**
     * Установить название каталога
     * @param string $title
     * @return Model_Catalog
     */
    public function setTitle($title)
    {
        return $this->set('title', $title);
    }

    /**
     * Получить системное имя каталога
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * Установить системное имя каталога
     * @param string $name
     * @return Model_Catalog
     */
    public function setName($name)
    {
        return $this->set('name', $name);
    }

    private $childrenCatalogs;

    /**
     * Получить список подкаталогов
     * @return Model_Catalog_Collection
     */
    public function getChildrenCatalogs()
    {
        if ($this->childrenCatalogs == NULL)
        {
            $this->childrenCatalogs = CollectionFactory::create('Model_Catalog');

            $childrenCatalogs = $this->childrenCatalogsModel
                    ->where('page_id', '=', $this->page_id)
                    ->find_all();

            foreach ($childrenCatalogs as $cat)
            {
                $this->childrenCatalogs->add($cat);
            }
        }

        return $this->childrenCatalogs;
    }

    private $parentCatalog;

    /**
     * Получить родительский каталог
     * @return Model_Catalog
     */
    public function getParentCatalog()
    {
        if ($this->parentCatalog == NULL)
        {
            $parentCatalog       = new Model_Catalog($this->parent_catalog_id);
            $parentCatalog->set('page_id', $this->page_id);
            $this->parentCatalog = $parentCatalog;
        }
        return $this->parentCatalog;
    }

    private $goods;

    /**
     * Получить товары для каталога
     * @return Model_Good_Collection
     */
    public function getGoods()
    {
        if ($this->goods == NULL)
        {
            $this->goods = CollectionFactory::create('Model_Good');

            $goods = $this->goodsModel->find_all();
            foreach ($goods as $good)
            {
                $this->goods->add($good);
            }
        }

        return $this->goods;
    }

    private $page;

    /**
     * Получить страницу каталога
     * @return Model_Page
     */
    public function getPage()
    {
        if ($this->page == NULL)
        {
            if ($this->pageModel->loaded())
            {
                $this->page = $this->pageModel;
            }
            else
            {
                $this->page = $this->pageModel->find();
            }
        }
        return $this->page;
    }

    /**
     * Получить подкаталоги для каталога
     * @param Model_Page $page
     * @param type $catalog_id
     * @return Collection
     */
    public static function getCatalogs(Model_Page $page, $catalog_id)
    {
        $catalogs = CollectionFactory::create('Model_Catalog');

        $cats = ORM::factory('Catalog')
                ->where('page_id', '=', $page->pk());

        if ($catalog_id == NULL)
        {
            $cats = $cats->and_where('parent_catalog_id', 'IS', NULL);
        }
        else
        {
            $cats = $cats->and_where('parent_catalog_id', '=', $catalog_id);
        }

        $cats = $cats->find_all();

        foreach ($cats as $cat)
        {
            $catalogs->add($cat);
        }

        return $catalogs;
    }

    /**
     * Создать новый каталог
     * @param array $data
     * @return boolean
     * @throws Exception
     */
    public function createCatalog(array $data)
    {
        $this->_db->begin();
        try
        {
            $catalog = new Model_Catalog();
            $catalog->values($data);
            $catalog->setName(Text::translitForURL($catalog->getTitle()));
            if ($data['parent_catalog_id'] == NULL)
            {
                $catalog->parent_catalog_id = NULL;
            }
            $catalog->save();
            Search::instance()->add($catalog);
            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

    /**
     * Сохранить каталог
     * @param array $data
     * @return boolean
     * @throws Exception
     */
    public function saveCatalog(array $data)
    {
        $this->_db->begin();
        try
        {
            $this->values($data);
            $this->setName(Text::translitForURL($this->getTitle()));

            $this->save();
            Search::instance()->update($this);
            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

    public function deleteCatalog()
    {
        $this->_db->begin();
        try
        {
            $this->getGoods()->dropAllGoods();
            $this->getChildrenCatalogs()->dropAllCatalogs();
            $this->dropCatalog();
            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

    public function dropCatalog()
    {
        $this->_db->begin();

        try
        {
            Search::instance()->remove($this);
            $this->delete();
            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

}