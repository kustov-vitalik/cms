<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Config_Item_AvailableValue_Empty implements Config_Item_AvailableValue_Interface {

    protected $configItem;
    protected $value;

    public function getConfigItem()
    {
        return $this->configItem;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setConfigItem(\Config_Item_Interface $configItem)
    {
        $this->configItem = $configItem;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

}