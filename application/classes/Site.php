<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Site {

    protected $pages       = NULL;
    protected $currentPage = NULL;
    protected $structure;
    protected $map;
    protected $config      = array();
    private static $_instance   = NULL;

    private function __construct()
    {

    }

    public function init()
    {
        $this->config      = Kohana::$config->load('site');
        $url               = Manager_URL::Instance()->getPageURL();
        $this->currentPage = new Model_Page(array('url' => $url));
        $this->currentPage->setThisCurrent()->optimize();

        $this->map['module'][] = $this->currentPage->getModule();

        /* @var $widget Model_Widget */
        foreach ($this->currentPage->getWidgets() as $widget)
            $this->map[$widget->getPosition()->getName()][$widget->getSequence()] = $widget;

        foreach ($this->map as $positionName => $entities)
        {
            $view = View::factory('position/index', array(
                        'entities' => $entities
                    ));

            $this->structure[$positionName] = $view->render();
        }
    }

    private function __clone()
    {

    }

    /**
     *
     * @return Site
     */
    public static function Instance()
    {
        if (self::$_instance == NULL)
        {
            self::$_instance = new Site();
        }
        return self::$_instance;
    }

    /**
     *
     * @return Model_Page
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getPages()
    {

        if ($this->pages == NULL)
        {
            $this->pages = ORM::factory('page')
                    ->where('in_menu', '=', 1)
                    ->order_by('sequence', 'ASC')
                    ->find_all();

            foreach ($this->pages as $page)
            {
                if ($page instanceof Model_Page)
                {
                    if ($page->pk() == $this->getCurrentPage()->pk())
                    {
                        $page->setThisCurrent();
                        break;
                    }
                }
            }
        }


        return $this->pages;
    }

    /**
     *
     * @return Config_Group
     */
    public function getConfig()
    {
        if ($this->config == NULL)
        {
            $this->config = Kohana::$config->load('site');
        }
        return $this->config;
    }

    public function getStructure()
    {
        return $this->structure;
    }

    public function getContentsForPosition($position)
    {
        if (isset($this->structure[$position]))
        {
            return $this->structure[$position];
        }
    }

}

function ____($name)
{
    return Site::Instance()->getContentsForPosition($name);
}