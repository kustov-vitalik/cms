<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Good_Collection extends Collection {

    public function dropAllGoods()
    {
        if ($this->isEmpty())
        {
            return TRUE;
        }

        $it = $this->getIterator();
        $it->rewind();
        while ($it->valid())
        {
            /* @var $good Model_Good */
            $good = $it->current();

            $good->dropGood();

            $it->next();
        }

        return TRUE;
    }

}