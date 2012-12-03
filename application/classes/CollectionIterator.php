<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CollectionIterator implements Iterator {

    private $position = 0;
    private $collection = array();


    public function __construct(array $collection)
    {
        $this->position = 0;
        $this->collection = $collection;
    }

    public function current()
    {
        return $this->collection[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position ++;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return $this->position < count($this->collection);
    }

}