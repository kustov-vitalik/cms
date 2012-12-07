<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Event
 *
 * @author Виталий
 */
class Kohana_Event {

    private $name;
    private $sender;
    private $param;
    private $handlers;

    /**
     * Фабричный метод для событий
     * @param type $name
     * @param type $sender
     * @param array $param
     * @return \Event
     */
    public static function factory($name, $sender, array $param = NULL)
    {
        return new Event($name, $sender, $param);
    }

    /**
     * Сигнал наступления события
     * @param type $name
     */
    public static function run($name)
    {
        EventManager::run($name);
    }

    public function __construct($name, $sender, array $param = NULL)
    {
        $this->name     = $name;
        $this->sender   = $sender;
        $this->param    = $param;
        $this->handlers = new SplObjectStorage();
        EventManager::add($this);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function getParam()
    {
        return $this->param;
    }

    /**
     *
     * @param EventHandler $handler
     * @return Event
     */
    public function addHandler(EventHandler $handler)
    {
        $this->handlers->attach($handler);
        return $this;
    }

    /**
     *
     * @param EventHandler $handler
     * @return Event
     */
    public function removeHandler(EventHandler $handler)
    {
        $this->handlers->detach($handler);
        return $this;
    }

    public function notify()
    {
        foreach ($this->handlers as $handler)
        {
            $handler->update($this);
        }
    }

}