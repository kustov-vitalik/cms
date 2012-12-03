<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class CollectionFactory {

    /**
     * Создаёт коллекцию заданного типа.
     *
     * @param string $type  Тип коллекции
     * @return Collection
     */
    public static function create($type)
    {
        $class = $type . '_Collection';
        self::__create_class($class);
        $obj   = new $class($type);
        return $obj;
    }

    /**
     * Создаёт класс с именем $class
     *
     * @param string $class  Имя класса
     * @return void
     */
    private static function __create_class($class)
    {
        if (!class_exists($class))
        {
            eval('class ' . $class . ' extends Collection { }');
        }
    }

}