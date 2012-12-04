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
        'parentCatalogModel' => array(
            'model'       => 'Catalog',
            'foreign_key' => 'parent_catalog_id',
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
            'name' => array(
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
     * @return type
     */
    public function getChildrenCatalogs()
    {
        if ($this->childrenCatalogs == NULL)
        {
            $this->childrenCatalogs = $this->childrenCatalogsModel->find_all();
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
            if ($this->parentCatalogModel->loaded())
            {
                $this->parentCatalog = $this->parentCatalogModel;
            }
            else
            {
                $this->parentCatalog = $this->parentCatalogModel->find();
            }
        }
        return $this->parentCatalog;
    }

}