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
        'sequence'   => NULL,
        'page_id'    => NULL,
    );
    protected $_has_many      = array(
    );
    protected $_belongs_to    = array(
        'catalogModel' => array(
            'model'       => 'Catalog',
            'foreign_key' => 'catalog_id',
        ),
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

    /**
     * Получить порядок
     * @return int
     */
    public function getSequence()
    {
        return $this->get('sequence');
    }

    /**
     * Установить порядок
     * @param int $sequence
     * @return Model_Good
     */
    public function setSequence($sequence)
    {
        return $this->set('sequence', $sequence);
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

    public function createGood(array $data)
    {
        $this->_db->begin();
        try
        {
            $this->values($data);
            $this->setName(Text::translitForURL($this->getTitle()));
            $this->setSequence($this->getNextSequence());

            if ($this->catalog_id == NULL)
            {
                $this->catalog_id = NULL;
            }

            $this->save();


            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

    public function saveGood(array $data)
    {
        $this->_db->begin();
        try
        {
            $this->values($data);
            $this->setName(Text::translitForURL($this->getTitle()));
            $this->save();


            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

    public function moveUp()
    {
        if ($this->move('up'))
        {
            return TRUE;
        }
    }

    public function moveDown()
    {
        if ($this->move('down'))
        {
            return TRUE;
        }
    }

    public function getNextSequence()
    {
        $seq = DB::select(array(DB::expr('MAX(sequence)'), 'max'))
                ->from($this->_table_name)
                ->where('catalog_id', '=', $this->catalog_id)
                ->execute();
        return $seq[0]['max'] + 1;
    }

    private function move($status = 'up')
    {
        $this->_db->begin();
        try
        {
            $params = array();
            switch ($status)
            {
                case 'up':
                    $params = array(
                        'operator' => '<',
                        'order'    => 'DESC'
                    );
                    break;
                case 'down':
                    $params = array(
                        'operator' => '>',
                        'order'    => 'ASC'
                    );
                    break;
            }

            $otherGood = ORM::factory('Good')
                    ->where('catalog_id', '=', $this->catalog_id)
                    ->and_where('sequence', $params['operator'], $this->getSequence())
                    ->order_by('sequence', $params['order'])
                    ->limit(1)
                    ->find();

            if (!$otherGood->loaded())
            {
                throw new Kohana_Exception('Товар не может быть перемещен');
            }

            $tempSeq = $this->getSequence();
            $this->setSequence($otherGood->getSequence());
            $otherGood->setSequence($tempSeq);

            $otherGood->save();
            $this->save();

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