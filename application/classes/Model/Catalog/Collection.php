<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Catalog_Collection extends Collection {

    public function dropAllCatalogs()
    {
        if ($this->isEmpty())
        {
            return TRUE;
        }

        $it = $this->getIterator();
        $it->rewind();
        while ($it->valid())
        {
            /* @var $catalog Model_Catalog */
            $catalog = $it->current();

            $catalog->getGoods()->dropAllGoods();
            $catalog->getChildrenCatalogs()->dropAllCatalogs();
            $catalog->dropCatalog();

            $it->next();
        }
    }

}