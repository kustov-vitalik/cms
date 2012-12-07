<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Site {

    protected $pages       = NULL;
    protected $currentPage = NULL;
    protected $config      = array();
    private static $_instance   = NULL;

    private function __construct()
    {

        $this->config = Kohana::$config->load('site');

        $url = Manager_URL::Instance()->getPageURL();
        $this->currentPage = new Model_Page(array('url' => $url));
        $this->currentPage->setThisCurrent()->optimize();

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
        return $this->config;
    }

}

function ____($name)
{
    return Manager_PageMap::Instance()->getContentsForPosition($name);
}