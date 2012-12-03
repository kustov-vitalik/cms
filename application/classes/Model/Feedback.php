<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Feedback extends ORM {

    protected $_table_name    = 'feedbacks';
    protected $_primary_key   = 'feedback_id';
    protected $_table_columns = array(
        'feedback_id' => NULL,
        'name'        => NULL,
        'email'       => NULL,
        'theme'       => NULL,
        'text'        => NULL,
        'page_id'     => NULL,
    );
    protected $_has_many      = array(
        'items' => array(
            'model'       => 'config_item',
            'foreign_key' => 'config_id',
        ),
    );

    public function rules()
    {
        return array(
            'name'  => array(
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
                array('not_empty'),
            ),
            'email' => array(
                array('not_empty'),
                array('email'),
            ),
            'theme' => array(
                array('not_empty'),
                array('min_length', array(':value', 3)),
                array('max_length', array(':value', 255)),
            ),
            'text'  => array(
                array('not_empty'),
                array('min_length', array(':value', 12)),
            ),
        );
    }

    public function labels()
    {
        return array(
            'name'  => 'Ваше имя',
            'email' => 'Ваш Email',
            'theme' => 'Тема сообщения',
            'text'  => 'Текст сообщения',
        );
    }

    /**
     * Сохранить фидбэк
     * @param array $data
     * @return boolean
     * @throws ORM_Validation_Exception
     */
    public function saveFeedBack(array $data)
    {
        $this->_db->begin();
        try
        {
            $this->values($data);
            $this->save();
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


    public function getName()
    {
        return $this->get('name');
    }

}