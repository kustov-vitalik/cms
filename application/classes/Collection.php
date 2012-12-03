<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Collection implements Collection_Interface {

    private $type;
    private $collection = array();
    private $iterators  = array();

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function count()
    {
        return count($this->collection);
    }

    /**
     *
     * @return Iterator
     */
    public function getIterator()
    {
        if (!isset($this->iterators[$this->type]))
        {
            $this->iterators[$this->type] = new ArrayIterator($this->collection);
        }
        return $this->iterators[$this->type];
    }

    /**
     * Проверяет тип объекта.
     * Препятствует добавлению в коллекцию объектов `чужого` типа.
     *
     * @param object $object  Объект для проверки
     * @return void
     * @throws Exception
     */
    private function check_type(&$object)
    {

        if (get_class($object) != $this->type)
        {
            throw new Exception('Объект типа `' . get_class($object)
            . '` не может быть добавлен в коллекцию объектов типа `' . $this->type . '`');
        }
    }

    /**
     * Добавляет в коллекцию объекты, переданные в аргументах.
     *
     * @param object(s)  Объекты
     * @return \Collection
     */
    public function add()
    {
        $args = func_get_args();
        foreach ($args as $object)
        {
            $this->check_type($object);
            $this->collection[] = $object;
        }
        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Удаляет из коллекции объекты, переданные в аргументах.
     *
     * @param object(s)  Объекты
     * @return Collection
     */
    public function remove()
    {
        $args = func_get_args();
        foreach ($args as $object)
        {
            unset($this->collection[array_search($object, $this->collection)]);
        }
        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Очищает коллекцию.
     *
     * @return Collection
     */
    public function clear()
    {
        $this->collection = array();
        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Выясняет, пуста ли коллекция.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->collection);
    }

}