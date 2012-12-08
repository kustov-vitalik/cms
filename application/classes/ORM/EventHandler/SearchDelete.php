<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ORM_EventHandler_SearchDelete extends EventHandler {

    public function update(\Event $event)
    {
        Search::instance()->remove($event->getSender());
    }

}