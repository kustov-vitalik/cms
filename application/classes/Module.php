<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Module {

    private $module;

    /**
     *
     * @param string $name
     * @return \Module
     */
    public static function factory(Model_Module $module)
    {
        $moduleName = 'Module_' . ucfirst(strtolower($module->getName()));
        return new $moduleName($module);
    }

    protected function __construct(Model_Module $module)
    {
        $this->module = $module;
    }

    abstract public function render();
    abstract public function getSanitizedModels();

    /**
     * Получить страницу модуля
     * @return Model_Page
     */
    public function getPage()
    {
        return $this->getModel()->getPage();
    }

    /**
     * Получить модель модуля
     * @return Model_Module
     */
    public function getModel()
    {
        return $this->module;
    }

    /**
     * Получить конфиг
     * @return Config_Interface
     */
    public function getConfig()
    {
        return $this->getModel()->getConfigPublic();
    }

    public function getTitle()
    {
        return $this->getModel()->getTitle();
    }

    public function getName()
    {
        return $this->getModel()->getName();
    }

    public function sanitize()
    {
        return $this->getModel()->sanitize($this->getSanitizedModels());
    }

}