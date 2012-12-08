<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Model_Pages_Page_Handler extends EventHandler {


    public function update(\Event $event)
    {
        echo $event->getSender();
    }

}