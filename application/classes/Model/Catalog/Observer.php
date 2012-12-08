<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Catalog_Observer implements SplObserver {

    public function update(\SplSubject $subject)
    {
        echo $subject->getName();
    }

}