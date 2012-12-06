<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class BreadCrumbs {

    private $config;
    private $items;

    public function __construct($config = 'breadcrumbs')
    {
        $this->config = Kohana::$config->load($config);
        $this->items  = CollectionFactory::create('BreadCrumbs_Item');
    }

    /**
     * Добавить объект в крошки
     * @param BreadCrumbs_Item $item
     * @return \BreadCrumbs
     */
    public function addItem(BreadCrumbs_Item $item)
    {
        $this->items->add($item);
        return $this;
    }

    /**
     * Получить коллекцию
     * @return Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Получить настройки
     * @return Kohana_Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Рендеринг хлебных крошек
     * @return string
     */
    public function render()
    {
        $view = $this->config->get('view');
        $view = View::factory($view, array(
                    'breadCrumbs' => $this,
                ));
        return $view->render();
    }

    public function __toString()
    {
        return $this->render();
    }

}