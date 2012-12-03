<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Controller_Widget extends Controller_Template
{

    public function before() {
        parent::before();

        if (Request::current()->is_initial()) {
            $this->auto_render = FALSE;
        }

    }

    /**
     * Получить конфигурационные параметры для виджета
     * @return array()
     */
    public function getParams()
    {
        return unserialize(urldecode($this->request->param('param')));
    }

    /**
     * Получить параметр с именем $name
     * @param string $name
     * @return mix
     */
    public function getParameterByName($name)
    {
        $params = $this->getParams();
        return $params[$name];
    }

}