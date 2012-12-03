<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Pages_Page extends ORM_Searchable {

    protected $_table_name    = 'pages_pages';
    protected $_primary_key   = 'page_page_id';
    protected $_table_columns = array(
        'page_page_id' => NULL,
        'title'        => NULL,
        'text'         => NULL,
        'page_id'      => NULL,
    );

    public function get_indexable_fields()
    {
        $fields = array();

        // Store the id but don't index it
        $fields[] = new Search_Field('page_page_id', Searchable::UNINDEXED);

        // Index
        $fields[] = new Search_Field('title', Searchable::TEXT);

        // Index
        $fields[] = new Search_Field('text', Searchable::TEXT, Searchable::DECODE_HTML);

        return $fields;
    }

    public function rules()
    {
        return array(
            'page_id' => array(
                array('not_empty'),
                array('not_zero'),
            ),
            'text'    => array(
                array('not_empty'),
            ),
            'title'   => array(
                array('not_empty'),
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
            ),
        );
    }

    public function labels()
    {
        return array(
            'text'    => 'Текст материала',
            'title'   => 'Заголовок материала',
            'page_id' => 'Страница материала',
        );
    }

    public function savePage(array $data)
    {
        $this->_db->begin();


        try
        {

            $new = ($this->loaded()) ? FALSE : TRUE;
            $this->values($data);
            $this->save();
            $new ? Search::instance()->add($this) : Search::instance()->update($this);

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

    public function getTitle()
    {
        return $this->get('title');
    }

    public function getText()
    {
        return $this->get('text');
    }

}