<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Config_Surrogat_Widget extends Model_Config_Surrogat {

    private $defaultPosition;

    public function __construct($configType, $configName)
    {
        parent::__construct($configType, $configName);

        $config = Kohana::$config->load($configType)->get($configName);

        $this->defaultPosition = $config['defaultPosition'];
    }

    public function setDefaultPosition($defaultPosition)
    {
        $this->defaultPosition = $defaultPosition;
        return $this;
    }

    public function getDefaultPosition()
    {
        return $this->defaultPosition;
    }



}