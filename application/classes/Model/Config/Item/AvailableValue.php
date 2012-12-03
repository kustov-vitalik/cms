<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Config_Item_AvailableValue extends ORM implements Config_Item_AvailableValue_Interface {

    protected $_table_name    = 'config_item_available_value';
    protected $_primary_key   = 'config_item_available_value_id';
    protected $_table_columns = array(
        'config_item_available_value_id' => NULL,
        'config_item_id'                 => NULL,
        'value'                          => NULL,
    );
    protected $_belongs_to    = array(
        'configItemModel' => array(
            'model'       => 'Config_Item',
            'foreign_key' => 'config_item_id',
        ),
    );

    public function rules()
    {
        return array(
            'value'        => array(
            ),

        );
    }

    public function labels()
    {
        return array(
            'value'       => 'Значение настройки',
        );
    }

    private $configItem = NULL;

    public function getConfigItem()
    {
        if ($this->configItem == NULL)
        {
            $this->configItem = $this->configItemModel;
        }

        return $this->configItem;
    }

    /**
     *
     * @param \Config_Item_Interface $configItem
     * @return Model_Config_Item_AvailableValue
     */
    public function setConfigItem(\Config_Item_Interface $configItem)
    {
        return $this->set('config_item_id', $configItem->pk());
    }

    public function getValue()
    {
        return $this->get('value');
    }

    /**
     *
     * @param type $value
     * @return Model_Config_Item_AvailableValue
     */
    public function setValue($value)
    {
        return $this->set('value', $value);
    }

    public function saveAvaulableValue(Config_Item_AvailableValue_Interface $av)
    {
        $this->_db->begin();
        try
        {

            $this->setValue($av->getValue())
                    ->setConfigItem($av->getConfigItem())
                    ->save();

            $this->_db->commit();
        }
        catch (Database_Exception $exc)
        {
            $this->_db->rollback();
            throw $exc;
        }
    }

}