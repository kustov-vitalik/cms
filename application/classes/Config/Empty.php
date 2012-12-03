<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Config_Empty implements Config_Interface {

    protected $configItems;
    protected $enable;
    protected $name;
    protected $title;
    protected $description;
    protected $type;


    public function doDisable()
    {
        $this->enable = 0;
        return $this;
    }

    public function doEnable()
    {
        $this->enable = 1;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @return Collection
     */
    public function getItems()
    {
        return $this->configItems;
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

    public function isEnable()
    {
        return ($this->enable == 1) ? TRUE : FALSE;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setItems(Collection_Interface $items)
    {
        $this->configItems = $items;
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

}