<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Config extends ORM implements Config_Interface {

    protected $_table_name    = 'config';
    protected $_primary_key   = 'config_id';
    protected $_table_columns = array(
        'config_id'   => NULL,
        'name'        => NULL,
        'title'       => NULL,
        'description' => NULL,
        'type'        => NULL,
        'enable'      => NULL,
    );
    protected $_has_many      = array(
        'configItemsModel' => array(
            'model'       => 'Config_Item',
            'foreign_key' => 'config_id',
        ),
        'modulesModel'     => array(
            'model'       => 'Module',
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
            'title' => array(
                array('not_empty'),
                array('min_length', array(':value', 4)),
                array('max_length', array(':value', 255)),
            ),
        );
    }

    public function labels()
    {
        return array(
            'title' => 'Название группы настроек',
            'name'  => 'Системное имя группы настроек',
        );
    }

    /**
     * Получить настройку с именем $name
     * @param string $name
     * @return Model_Config_Item
     */
    public function getItem($name)
    {

        return $this->getItems()->getByName($name);
    }

    /**
     * Получить значение настройки с именем $name
     * @param string $name
     * @return string
     */
    public function getItemValueByItemName($name)
    {
        return $this->getItem($name)->getValue();
    }

    /**
     * Получить тип группы настроек
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Получить название группы настроек
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Получить системное имя настроек
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Создать группу настроек
     * @param Config_Interface $config
     * @return boolean
     * @throws Exception
     */
    public function createConfig(Config_Interface $config)
    {
        $this->_db->begin();

        try
        {

            $this->setName($config->getName())
                    ->setTitle($config->getTitle())
                    ->setType($config->getType())
                    ->setDescription($config->getDescription());

            if ($config->isEnable())
                $this->doEnable();
            else
                $this->doDisable();

            $this->save();

            if (!$config->getItems()->isEmpty())
            {
                $iterator = $config->getItems()->getIterator();
                $iterator->rewind();
                while ($iterator->valid())
                {

                    $item = $iterator->current();

                    if ($item instanceof Config_Item_Interface)
                    {
                        $configItem = new Model_Config_Item();
                        $item->setConfig($this);
                        $configItem->saveConfigItem($item);
                    }
                    $iterator->next();
                }
            }





            $this->_db->commit();
            return TRUE;
        }
        catch (Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    /**
     * Сохранить настройки из массива
     * @param array $data
     * @return boolean
     * @throws Database_Exception
     */
    public function saveConfigs(array $data)
    {
        $this->_db->begin();

        try
        {

            if (isset($data['enable']))
            {
                $this->doEnable();
                unset($data['enable']);
            }
            else
            {
                $this->doDisable();
            }

            $this->save();

            $it = $this->getItems()->getIterator();
            $it->rewind();
            while ($it->valid())
            {
                $item = $it->current();
                if ($item instanceof Model_Config_Item)
                {
                    if (isset($data[$item->getName()]))
                    {
                        $item->setValue($data[$item->getName()])->save();
                    }
                }

                $it->next();
            }

            $this->_db->commit();
            return TRUE;
        }
        catch (Database_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    /**
     * Удалить группу настроек
     * @return boolean
     * @throws ORM_Validation_Exception
     */
    public function removeConfig()
    {
        $this->_db->begin();
        try
        {

            $it = $this->getItems()->getIterator();
            $it->rewind();
            while ($it->valid())
            {
                $item = $it->current();

                if ($item instanceof Model_Config_Item)
                {
                    if (!$item->removeConfigItem())
                    {
                        throw new Kohana_Exception('Config_Item do not deleted');
                    }
                }

                $it->next();
            }

            $this->delete();

            $this->_db->commit();
            return TRUE;
        }
        catch (Kohana_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    /**
     * Добавить настройку к группе настроек
     *
     * Массив $configItem должен иметь след. вид:
     *
     * <pre>
     * $configItem = array(
     *      'name'  => 'системное имя настройки'
     *      'title' => 'название настройки'
     *      'type'  => 'тип настройки'
     *      'value' => 'значение настройки'
     *      'description' => 'значение настройки'
     * );
     * </pre>
     *
     * @param array $configItem
     * @return boolean
     * @throws ORM_Validation_Exception
     */
    public function addNewConfigItem(array $configItem)
    {
        $this->_db->begin();

        try
        {
            $item = new Model_Config_Item();
            $item->values($configItem)
                    ->save();

            $this->_db->commit();
            return TRUE;
        }
        catch (Kohana_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
            return FALSE;
        }
    }

    private $itemsCollection;

    /**
     * Получить коллекцию настроек
     * @return Model_Config_Item_Collection
     */
    public function getItems()
    {

        if ($this->itemsCollection == NULL)
        {
            $this->itemsCollection = CollectionFactory::create('Model_Config_Item');

            foreach ($this->configItemsModel->find_all() as $item)
            {
                $this->itemsCollection->add($item);
            }
        }


        return $this->itemsCollection;
    }

    public function isEnable()
    {
        return ($this->get('enable') == 1) ? TRUE : FALSE;
    }

    public function doDisable()
    {
        return $this->set('enable', 0);
    }

    public function doEnable()
    {
        return $this->set('enable', 1);
    }

    public function getDescription()
    {
        return $this->get('description');
    }

    public function setDescription($description)
    {
        return $this->set('description', $description);
    }

    public function setItems(\Collection_Interface $items)
    {
        $this->itemsCollection = $items;
        return $this;
    }

    public function setName($name)
    {
        return $this->set('name', $name);
    }

    public function setTitle($title)
    {
        return $this->set('title', $title);
    }

    public function setType($type)
    {
        $this->set('type', $type);
        return $this;
    }

}