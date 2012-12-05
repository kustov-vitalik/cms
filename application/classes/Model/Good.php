<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Good extends ORM_Searchable {

    protected $_table_name    = 'goods';
    protected $_primary_key   = 'good_id';
    protected $_table_columns = array(
        'good_id'    => NULL,
        'name'       => NULL,
        'title'      => NULL,
        'catalog_id' => NULL,
    );
    protected $_has_many      = array(
    );
    protected $_belongs_to    = array(
        'catalogModel' => array(
            'model'       => 'Catalog',
            'foreign_key' => 'catalog_id',
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
     * Получить название товара
     * @return string
     */
    public function getTitle()
    {
        return $this->get('title');
    }

    /**
     * Установить название товара
     * @param string $title
     * @return Model_Good
     */
    public function setTitle($title)
    {
        return $this->set('title', $title);
    }

    /**
     * Получить системное имя товара
     * @return string
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * Установить системное имя товара
     * @param string $name
     * @return Model_Good
     */
    public function setName($name)
    {
        return $this->set('name', $name);
    }

    private $catalog;

    /**
     * Получить каталог товара
     * @return Model_Catalog
     */
    public function getCatalog()
    {
        if ($this->catalog == NULL)
        {
            if ($this->catalogModel->loaded())
            {
                $this->catalog = $this->catalogModel;
            }
            else
            {
                $this->catalog = $this->catalogModel->find();
            }
        }
        return $this->catalog;
    }

    /**
     * Удалить товар
     * @return boolean
     * @throws Exception
     */
    public function dropGood()
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