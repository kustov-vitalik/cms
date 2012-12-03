<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Manager_PageMap {

    private static $_instance = NULL;
    private $page;
    private $structure;
    private $map;

    private function __construct()
    {

        $acl = new Zend_Acl();


        $guest = new Zend_Acl_Role('guest');
        $login = new Zend_Acl_Role('login', $guest);
        $admin = new Zend_Acl_Role('admin', $login);

        $acl->addRole($admin)
                ->addRole($login)
                ->addRole($guest);



        $this->page = Site::Instance()->getCurrentPage();

        $this->map['module'][] = $this->page->getModule();

        /* @var $widget Model_Widget */
        foreach ($this->page->getWidgets() as $widget)
        {
            $this->map[$widget->getPosition()->getName()][$widget->getSequence()] = $widget;
        }

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
     * @return Manager_PageMap
     */
    public static function Instance()
    {
        if (self::$_instance == NULL)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
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