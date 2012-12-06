<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Manager_URL {

    private $moduleName, $control, $act, $param;
    private $url;
    private static $_instance = NULL;

    private function __construct()
    {
        $this->moduleName = Request::initial()->param('mod');
        $this->control    = Request::initial()->param('control');
        $this->act        = Request::initial()->param('act');
        $this->param      = Request::initial()->param('param');
    }

    private function __clone()
    {

    }

    public function getPageURL()
    {
        return $this->getModuleName();
    }

    public function getURL()
    {
        if ($this->url == NULL)
        {

            if ($this->getModuleName() == NULL)
            {
                $this->url = NULL;
            }
            else
            {
                if ($this->getModuleName() != NULL and $this->getControl() == NULL)
                {
                    $this->url = $this->getModuleName();
                }
                else
                {
                    if ($this->getModuleName() != NULL and $this->getControl() != NULL and $this->getAct() == NULL)
                    {
                        $this->url = $this->getModuleName()
                                . '/' . $this->getControl();
                    }
                    else
                    {
                        if ($this->getModuleName() != NULL and $this->getControl() != NULL and $this->getAct() != NULL and $this->getParam() == NULL)
                        {
                            $this->url = $this->getModuleName()
                                    . '/' . $this->getControl()
                                    . '/' . $this->getAct();
                        }
                        else
                        {
                            if ($this->getModuleName() != NULL and $this->getControl() != NULL and $this->getAct() != NULL and $this->getParam() != NULL)
                            {
                                $this->url = $this->getModuleName()
                                        . '/' . $this->getControl()
                                        . '/' . $this->getAct()
                                        . '/' . $this->getParam();
                            }
                        }
                    }
                }
            }
        }
        return $this->url;
    }

    /**
     *
     * @param Request $request
     * @return Manager_URL
     */
    public static function Instance()
    {
        if (self::$_instance == NULL)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getModuleName()
    {
        return $this->moduleName;
    }

    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
    }

    public function getControl()
    {
        return $this->control;
    }

    public function setControl($control)
    {
        $this->control = $control;
    }

    public function getAct()
    {
        return $this->act;
    }

    public function setAct($act)
    {
        $this->act = $act;
    }

    public function getParam()
    {
        return $this->param;
    }

    public function setParam($param)
    {
        $this->param = $param;
    }

}