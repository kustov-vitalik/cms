<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_New extends ORM_Searchable {

    protected $_table_name    = 'news';
    protected $_primary_key   = 'new_id';
    protected $_table_columns = array(
        'new_id'   => NULL,
        'title'    => NULL,
        'announce' => NULL,
        'text'     => NULL,
        'date'     => NULL,
        'page_id'  => NULL,
    );

    public function rules()
    {
        return array(
            'announce' => array(
                array('not_empty'),
            ),
            'text'     => array(
                array('not_empty'),
            ),
            'title'    => array(
                array('not_empty'),
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
            ),
            'date'     => array(
                array('date'),
                array('not_empty'),
            ),
            'page_id'  => array(
                array('not_zero'),
                array('not_empty'),
            ),
        );
    }

    public function labels()
    {
        return array(
            'announce' => 'Анонс новости',
            'title'    => 'Название новости',
            'text'     => 'Текст новости',
            'date'     => 'Дата добаления новости',
        );
    }

    public function get_indexable_fields()
    {
        $fields = array();

        $fields[] = new Search_Field('new_id', Searchable::UNINDEXED);
        $fields[] = new Search_Field('title', Searchable::KEYWORD);
        $fields[] = new Search_Field('announce', Searchable::TEXT, Searchable::DECODE_HTML);
        $fields[] = new Search_Field('text', Searchable::TEXT, Searchable::DECODE_HTML);
        $fields[] = new Search_Field('date', Searchable::UNINDEXED);
        $fields[] = new Search_Field('page_id', Searchable::UNINDEXED);

        return $fields;
    }

    public function saveNew(array $data)
    {

        $this->_db->begin();

        try
        {

            $is_new = ($this->loaded()) ? FALSE : TRUE;

            $this->values($data);
            $this->save();
            $is_new ? Search::instance()->add($this) : Search::instance()->update($this);

            $this->_db->commit();
            return TRUE;
        }
        catch (ORM_Validation_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    public function deleteNew()
    {
        $this->_db->begin();

        try
        {
            Search::instance()->remove($this);
            $this->delete();
            $this->_db->commit();
            return TRUE;
        }
        catch (ORM_Validation_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

}