<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Model_Config_Item_Collection extends Collection {

    public function getByName($name)
    {
        $iterator = $this->getIterator();

        while ($iterator->valid())
        {
            $item = $iterator->next();

            if ($item instanceof Config_Item_Interface)
            {
                if ($item->getName() == $name)
                {
                    return $item;
                }
            }

        }
    }

}