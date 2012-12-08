<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Kohana_EventManager {

    private static $events = array();

    /**
     *
     * @param Event $event
     */
    public static function add(Event $event)
    {
        self::$events[$event->getName()] = $event;
    }

    /**
     *
     * @param Event $event
     */
    public static function remove(Event $event)
    {
        unset(self::$events[self::get($event->getName())->getName()]);
    }

    /**
     *
     * @param type $name
     */
    public static function run($name)
    {
        try
        {
            self::get($name)->notify();
        }
        catch (Event_NotFoundException $exc)
        {
            Kohana::$log->add(Log::NOTICE, $exc->getMessage());
        }
    }

    /**
     * Получить событие по имени
     * @param string $name
     * @return Event
     * @throws Event_NotFoundException
     */
    public static function get($name)
    {
        if (isset(self::$events[$name]) and self::$events[$name] instanceof Event)
        {
            return self::$events[$name];
        }
        else
        {
            throw new Event_NotFoundException("Event ':event' not found", array(
        ':event' => $name
            ));
        }
    }

}