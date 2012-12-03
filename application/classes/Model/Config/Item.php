<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Config_Item extends ORM implements Config_Item_Interface {

    protected $_table_name    = 'config_item';
    protected $_primary_key   = 'config_item_id';
    protected $_table_columns = array(
        'config_item_id' => NULL,
        'config_id'      => NULL,
        'name'           => NULL,
        'title'          => NULL,
        'description'    => NULL,
        'value'          => NULL,
        'type'           => NULL,
    );
    protected $_belongs_to    = array(
        'configModel' => array(
            'model'       => 'Config',
            'foreign_key' => 'config_id',
        ),
    );
    protected $_has_many      = array(
        'availableValuesModel' => array(
            'model'       => 'Config_Item_AvailableValue',
            'foreign_key' => 'config_item_id'
        )
    );

    public function rules()
    {
        return array(
            'name'        => array(
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
                array('not_empty'),
            ),
            'title'       => array(
                array('not_empty'),
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
            ),
            'type'        => array(
                array('not_empty'),
            ),
            'description' => array(
            //array('not_empty'),
            ),
            'value'       => array(
            //array('not_empty'),
            ),
            'config_id'   => array(
                array('not_empty'),
                array('not_zero'),
            ),
        );
    }

    public function labels()
    {
        return array(
            'title'       => 'Название настройки',
            'name'        => 'Системное имя настройки',
            'value'       => 'Значение настройки',
            'config_id'   => 'Группа настроек',
            'type'        => 'Тип настройки',
            'description' => 'Описание настройки',
        );
    }

    public function getValue()
    {
        return $this->get('value');
    }

    public function getTitle()
    {
        return $this->get('title');
    }

    public function getName()
    {
        return $this->get('name');
    }

    public function getType()
    {
        return $this->get('type');
    }

    public function setValue($val)
    {

        $this->set('value', $val);
        return $this;
    }

    private $availableValues;

    public function getAvailableValues()
    {
        if ($this->availableValues == NULL)
        {

            $this->availableValues = CollectionFactory::create('Model_Config_Item_AvailableValue');

            $avVals = $this->availableValuesModel->find_all();

            foreach ($avVals as $avVal)
            {
                $this->availableValues->add($avVal);
            }
        }

        return $this->availableValues;
    }

    public function getConfig()
    {
        if ($this->loaded())
        {
            return $this->configModel;
        }
    }

    public function getDescription()
    {
        return $this->get('description');
    }

    public function setAvailableValues(\Collection_Interface $availableValues)
    {
        $this->availableValues = $availableValues;
        return $this;
    }

    public function setConfig(\Config_Interface $config)
    {
        $this->config_id = $config->pk();
        return $this;
    }

    /**
     *
     * @param type $description
     * @return Model_Config_Item
     */
    public function setDescription($description)
    {
        return $this->set('description', $description);
    }

    /**
     *
     * @param type $name
     * @return Model_Config_Item
     */
    public function setName($name)
    {
        return $this->set('name', $name);
    }

    /**
     *
     * @param type $title
     * @return Model_Config_Item
     */
    public function setTitle($title)
    {
        return $this->set('title', $title);
    }

    /**
     *
     * @param type $type
     * @return Model_Config_Item
     */
    public function setType($type)
    {
        return $this->set('type', $type);
    }

    public function saveConfigItem(Config_Item_Interface $item)
    {
        $this->_db->begin();

        try
        {

            $this->setConfig($item->getConfig())
                    ->setName($item->getName())
                    ->setTitle($item->getTitle())
                    ->setDescription($item->getDescription())
                    ->setAvailableValues($item->getAvailableValues())
                    ->setValue($item->getValue())
                    ->setType($item->getType());

            $this->save();

            $iterator = $item->getAvailableValues()->getIterator();
            $iterator->rewind();
            while ($iterator->valid())
            {

                $av = $iterator->current();
                if ($av instanceof Config_Item_AvailableValue_Interface)
                {
                    $availableValue = new Model_Config_Item_AvailableValue();
                    $av->setConfigItem($this);


                    $availableValue->saveAvaulableValue($av);
                }

                $iterator->next();
            }

            $this->_db->commit();
        }
        catch (Database_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

    public function removeConfigItem()
    {
        $this->_db->begin();

        try
        {

            $it = $this->getAvailableValues()->getIterator();
            $it->rewind();
            while ($it->valid())
            {
                $avVal = $it->current();

                if ($avVal instanceof Model_Config_Item_AvailableValue)
                {
                    $avVal->delete();
                }

                $it->next();
            }

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