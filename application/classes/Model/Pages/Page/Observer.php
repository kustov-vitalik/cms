<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Pages_Page_Observer implements SplObserver {

    public function update(\SplSubject $subject)
    {
        echo call_user_func_array(array($subject, 'getText'), array());
    }

}