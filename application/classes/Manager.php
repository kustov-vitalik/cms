<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Manager {

    private $managerURL, $managerContent;
    private static $_instance = NULL;

    private function __construct() {

    }

    private function __clone() {

    }

    /**
     *
     * @return Manager
     */
    public static function Instance() {
        if (self::$_instance == NULL) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     *
     * @return Manager_Content
     */
    public function getManagerContent() {
        if ($this->managerContent == NULL) {
            $this->managerContent = Manager_Content::Instance();
        }
        return $this->managerContent;
    }


    /**
     *
     * @return Manager_URL
     */
    public function getManagerURL() {
        if ($this->managerURL == NULL) {
            $this->managerURL = Manager_URL::Instance();
        }
        return $this->managerURL;
    }

}