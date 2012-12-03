<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Config_Item_Empty implements Config_Item_Interface {

    protected $config;
    protected $name;
    protected $title;
    protected $type;
    protected $value;
    protected $description;
    protected $availableValues;

    public function getAvailableValues()
    {
        return $this->availableValues;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setAvailableValues(Collection_Interface $availableValues)
    {
        $this->availableValues = $availableValues;
        return $this;
    }

    public function setConfig(\Config_Interface $config)
    {
        $this->config = $config;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

}